<?php

namespace App\Livewire\Transfer;

use App\Models\Product;
use App\Models\Sale;
use App\Services\TelegramService;
use Anam\Phpcart\Cart;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{

    use LivewireAlert;

    public $search;

    #[Validate('required')]
    public $to_warehouse_id, $from_warehouse_id;

    public $date, $customer_id, $product_id, $quantity = [], $imei;

    public $products = [];

    public $product = [];

    public $currency = 1;

    public $price, $price_usd, $total, $total_usd;

    public $payments = [''];
    public $payment_amounts = [''];
    public $payment_methods = [''];

    public $installment_lists = [];
    public $first_payment, $percent, $month;
    public $is_installment = false;

    public function mount()
    {
        $this->date = date('Y-m-d H:i');

        $this->currency = getCurrencyRate();

        $this->customer_id = 1;
        $this->payment_methods[0] = 1;
        $this->payment_amounts[0] = 0;

        $cart = new Cart('transfer');

        foreach ($cart->getItems() as $item) {
            $this->quantity[$item->id] = $item->quantity;
        }
    }

    public function searchProduct()
    {

        $this->validate([
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $this->products = Product::where('name', 'like', '%' . $this->search . '%')
            ->whereHas('warehouses', function ($query) {
                $query->where('warehouse_id', $this->from_warehouse_id);
            })
            ->get();
    }

    public function addProduct($id)
    {
        $this->product_id = $id;

        $product = Product::find($id);

        if ($product->quantity($this->from_warehouse_id) < 1) {
            $this->alert('error', 'Товара в наличии недостаточно');
            return;
        }

        $cart = new Cart('transfer');

        $cart->add([
            'id' => $product->id,
            'image_url' => $product->image_url,
            'name' => $product->name,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        $this->quantity[$id] = 1;

        $this->search = '';
    }

    public function removeProduct($id)
    {
        $cart = new Cart('transfer');
        $cart->remove($id);
    }

    public function decreaseProduct($id)
    {
        $cart = new Cart('transfer');

        $cart_quantity = new Cart('transfer');
        $cart_quantity = $cart_quantity->get($id);

        if ($cart_quantity->quantity > 1) {
            $cart->updateQty($id, $cart_quantity->quantity - 1);
            $this->quantity[$id] = $cart_quantity->quantity - 1;
        }
    }

    public function increaseProduct($id)
    {
        $this->validate();
        $cart = new Cart('transfer');

        $cart_quantity = new Cart('transfer');
        $cart_quantity = $cart_quantity->get($id)->quantity;

        $product_quantity = Product::find($id)->quantity($this->from_warehouse_id);

        if ($cart_quantity + 1 > $product_quantity) {
            $this->alert('error', 'Товара в наличии недостаточно');
            return;
        }

        $cart->updateQty($id, $cart_quantity + 1);
        $this->quantity[$id] = $cart_quantity + 1;
    }

    public function changeQuantity($id)
    {
        $this->validate();

        if ($this->quantity[$id] < 1) {
            return;
        }

        // dd($this->quantity[$id]);

        $cart = new Cart('transfer');

        $product_quantity = Product::find($id)->quantity($this->from_warehouse_id);

        if ($this->quantity[$id] > $product_quantity) {
            $this->alert('error', 'Товара в наличии недостаточно ' . $product_quantity . ' шт');
            $this->quantity[$id] = $product_quantity;
            return;
        }

        $cart->updateQty($id, $this->quantity[$id]);
    }



    public function save()
    {
        $this->validate([
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id',
            'date' => 'required',
        ]);

        if ($this->from_warehouse_id == $this->to_warehouse_id) {
            $this->alert('error', 'Нельзя перемещать товары в одинаковые склады');
            return;
        }

        if (array_sum($this->payment_amounts) > 0) {
            $this->validate([
                'payment_methods' => 'required|array',
                'payment_methods.*' => 'required|exists:payment_methods,id',
            ]);
        }

        $cart = new Cart('transfer');

        try {

            DB::beginTransaction();

            $transfer = Transfer::create([
                'from_warehouse_id' => $this->from_warehouse_id,
                'to_warehouse_id' => $this->to_warehouse_id,
                'date' => $this->date,
                'description' => '',
            ]);

            foreach ($cart->getItems() as $item) {
                $product = Product::find($item->id);

                if ($product->quantity($this->from_warehouse_id) < $item->quantity) {
                    DB::rollBack();
                    $this->alert('error', $product->name . ' товара в наличии недостаточно');
                    return;
                }

                $transfer->items()->create([
                    'from_warehouse_id' => $this->from_warehouse_id,
                    'to_warehouse_id' => $this->to_warehouse_id,
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'date' => $this->date,
                    'description' => '',
                ]);

                $product->decrementQuantity($this->from_warehouse_id, $item->quantity);
                $product->incrementQuantity($this->to_warehouse_id, $item->quantity);
            }

            DB::commit();
            $cart->clear();
            return redirect()->route('transfers.index')->with('success', 'Перемещение успешно создано');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    // clear cart
    public function clearCart()
    {
        $cart = new Cart('transfer');
        $cart->clear();
        return redirect()->route('sales.create');
    }

    public function render()
    {

        $carts = new Cart('transfer');

        return view('livewire.transfer.create', compact('carts'));
    }
}
