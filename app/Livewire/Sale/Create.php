<?php

namespace App\Livewire\Sale;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Transaction;
use App\Services\TelegramService;
use Anam\Phpcart\Cart;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{

    public $search, $customer_info;

    #[Validate('required')]
    public $warehouse_id;

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

    protected $listeners = ['refreshCustomer' => 'refreshCustomer', 'refreshSale' => '$refresh', 'setCustomer'];

    // setCustomer

    public function setCustomer($customer_id)
    {

        $customer = Customer::where('id', $customer_id)->first();

        $this->customer_id = $customer->id;
        $this->customer_info = $customer->full_name . ' (' . $customer->phone . ')';

    }

    public function mount()
    {
        $this->date = date('Y-m-d H:i');

        $this->currency = getCurrencyRate();

        $this->warehouse_id = auth()->user()->warehouse_id ?? 1;
        $this->customer_id = null;
        $this->payment_methods[0] = 1;
        $this->payment_amounts[0] = 0;

        $cart = new Cart();

        foreach ($cart->getItems() as $item) {
            $this->quantity[$item->id] = $item->quantity;
        }
    }

    public function searchProduct()
    {

        $this->validate([
            'warehouse_id' => 'required',
        ]);

        $this->products = Product::where('name', 'like', '%' . $this->search . '%')
            ->whereHas('warehouses', function ($query) {
                $query->where('warehouse_id', $this->warehouse_id);
            })
            ->get();
    }

    public function addProduct($id)
    {
        $this->product_id = $id;

        $product = Product::find($id);

        if ($product->quantity($this->warehouse_id) < 1) {
            flash('Товара в наличии недостаточно', 'error');
            return;
        }

        $cart = new Cart();

        $price = $product->price;
        $price_usd = $product->price_usd;

        $cart->add([
            'id' => $product->id,
            'image_url' => $product->image_url,
            'name' => $product->name,
            'price' => $price,
            'price_usd' => $price_usd,
            'total_usd' => 0,
            'quantity' => 1,
        ]);

        $this->quantity[$id] = 1;

        $this->search = '';

        if ($product->is_imei) {
            $this->editProduct($id);
        }
    }

    public function removeProduct($id)
    {
        $cart = new Cart();
        $cart->remove($id);
    }

    public function decreaseProduct($id)
    {
        $cart = new Cart();

        $cart_quantity = new Cart();
        $cart_quantity = $cart_quantity->get($id);

        if ($cart_quantity->quantity > 1) {
            $cart->updateQty($id, $cart_quantity->quantity - 1);
            $this->quantity[$id] = $cart_quantity->quantity - 1;
        }
    }

    public function increaseProduct($id)
    {
        $this->validate();
        $cart = new Cart();

        $cart_quantity = new Cart();
        $cart_quantity = $cart_quantity->get($id)->quantity;

        $product_quantity = Product::find($id)->quantity($this->warehouse_id);

        if ($cart_quantity + 1 > $product_quantity) {
            flash('Товара в наличии недостаточно ' . $product_quantity . ' шт', 'error');
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

        $cart = new Cart();

        $product_quantity = Product::find($id)->quantity($this->warehouse_id);

        if ($this->quantity[$id] > $product_quantity) {
            flash('Товара в наличии недостаточно ' . $product_quantity . ' шт', 'error');
            $this->quantity[$id] = $product_quantity;
            return;
        }

        $cart->updateQty($id, $this->quantity[$id]);
    }

    public function editProduct($id)
    {

        $this->product = Product::find($id);

        $cart = new Cart();
        $cart = $cart->get($id);

        $this->product_id = $this->product->id;
        $this->price = $cart->price;
        $this->price_usd = $cart->price_usd;
        try {
            $this->imei = $cart->imei;
        } catch (\Throwable $th) {
            $this->imei = '';
        }

        $this->dispatch('editProductOpenModal', $this->product);
    }

    public function updateProduct()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'price_usd' => 'required|numeric',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|min:1',
        ]);

        $cart = new Cart();

        $product = Product::find($this->product_id);

        if ($product->quantity($this->warehouse_id) < $this->quantity[$this->product_id]) {
            flash('Товара в наличии недостаточно', 'error');
            $this->quantity[$this->product_id] = $product->quantity($this->warehouse_id);
            return;
        }

        $cart->update([
            'id' => $this->product_id,
            'price' => $this->price,
            'price_usd' => $this->price_usd,
            'imei' => $this->imei,
            'quantity' => $this->quantity[$this->product_id],
        ]);

        $this->imei = '';


        $this->dispatch('editProductCloseModal');

        flash('Товар успешно обновлен', 'success');
    }

    public function priceToUsd()
    {
        if ($this->price) {
            $this->price_usd = $this->price / $this->currency;
        }
    }
    public function priceToUzs()
    {
        if ($this->price_usd) {
            $this->price = $this->price_usd * $this->currency;
        }
    }

    public function addPayment()
    {
        $this->payments[] = '';
        $this->payment_amounts[] = 0;
        $this->payment_methods[] = 1;
    }

    public function removePayment($index)
    {
        unset($this->payments[$index]);
        unset($this->payment_amounts[$index]);
        unset($this->payment_methods[$index]);
    }

    public function checkout()
    {
        $this->validate([
            'warehouse_id' => 'required',
            'customer_id' => 'required',
        ]);

        $cart = new Cart();

        if ($cart->getTotal() == 0) {
            flash('Корзина пуста', 'error');
            return;
        }

        $this->payment_amounts[0] = $cart->getTotal();

        $this->dispatch('checkoutOpenModal');
    }

    public function calculateInstallment()
    {
        $this->validate([
            'first_payment' => 'required|numeric|min:0',
            'percent' => 'required|numeric|min:0',
            'month' => 'required|numeric|min:0',
        ]);

        $this->installment_lists = [];

        $cart = new Cart();

        $total = $cart->getTotal();

        $newTotal = $total + ($total * $this->percent / 100);
        $total = $newTotal;
        $monthly_payment = intval(($total - $this->first_payment) / $this->month);

        $oneHundred = $monthly_payment % 1000;
        $pay = $monthly_payment - $oneHundred;

        if ($oneHundred < 0) {
            $pay += 1000;
        }


        $this->installment_lists[0] = [
            'date' => date('Y-m-d'),
            'amount' => $this->first_payment,
            'debt' => $newTotal - $this->first_payment,
        ];


        for ($i = 1; $i <= $this->month; $i++) {

            if ($i == $this->month) {
                $this->installment_lists[$i] = [
                    'date' => date('Y-m-d', strtotime('+' . $i . ' month')),
                    'amount' => $newTotal - $this->first_payment - $pay * ($i - 1),
                    'debt' => 0,
                ];

                break;
            }

            $this->installment_lists[$i] = [
                'date' => date('Y-m-d', strtotime('+' . $i . ' month')),
                'amount' => $pay,
                'debt' => $newTotal - $this->first_payment - $pay * $i,
            ];
        }
    }

    public function save()
    {
        $this->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required',
            'payments' => 'required|array',
            'payment_amounts' => 'required|array',
            'payment_amounts.*' => 'required|numeric|min:0',
        ]);

        if (array_sum($this->payment_amounts) > 0) {
            $this->validate([
                'payment_methods' => 'required|array',
                'payment_methods.*' => 'required|exists:payment_methods,id',
            ]);
        }

        $cart = new Cart();
        $total = $cart->getTotal();

        try {

            DB::beginTransaction();

            $sale = Sale::create([
                'invoice_number' => 'INV-' . time(),
                'warehouse_id' => $this->warehouse_id, // 'warehouse_id' => auth()->user()->warehouse_id ?? 1,
                'customer_id' => $this->customer_id,
                'user_id' => auth()->id(),
                'total' => $total,
                'total_usd' => $total / $this->currency,
                'currency_rate' => $this->currency,
                'payment_status' => 'debt',
                'date' => $this->date,
            ]);

            foreach ($cart->getItems() as $item) {
                $product = Product::find($item->id);

                if ($product->quantity($this->warehouse_id) < $item->quantity) {
                    DB::rollBack();
                    flash($product->name . ' товара в наличии недостаточно', 'error');
                    return;
                }

                $sale->sale_items()->create([
                    'product_id' => $item->id,
                    'warehouse_id' => $this->warehouse_id, // 'warehouse_id' => auth()->user()->warehouse_id ?? 1,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'price_usd' => $item->price_usd,
                    'total' => $item->price * $item->quantity,
                    'total_usd' => $item->price_usd * $item->quantity,
                    'currency_rate' => $this->currency,
                    'in_price' => $product->in_price,
                    'in_price_usd' => $product->in_price_usd,
                    'in_total' => $product->in_price * $item->quantity,
                    'in_total_usd' => $product->in_price_usd * $item->quantity,
                    // 'imei' => $item?->imei == '' ? null : $item?->imei,
                ]);

                $product->decrementQuantity($this->warehouse_id, $item->quantity);
            }

            if (array_sum($this->payment_amounts) > 0) {
                foreach ($this->payment_amounts as $key => $payment_amount) {
                    $sale->payments()->create([
                        'payment_method_id' => $this->payment_methods[$key],
                        'warehouse_id' => $this->warehouse_id, // 'warehouse_id' => auth()->user()->warehouse_id ?? 1,
                        'amount' => $payment_amount,
                        'customer_id' => $this->customer_id, // 'customer_id' => $sale->customer_id,
                        'user_id' => auth()->id(),
                        'currency_rate' => $this->currency,
                        'date' => date('Y-m-d H:i'),
                    ]);
                }
            }

            DB::commit();
            $cart->clear();
            return redirect()->route('sales.create')->with('success', 'Продажа успешно создана');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    // clear cart
    public function clearCart()
    {
        $cart = new Cart();
        $cart->clear();
        return redirect()->route('sales.create');
    }

    public function render()
    {

        $carts = new Cart();

        $payment_amount_summa = 0;
        foreach ($this->payment_amounts as $key => $payment_amount) {
            $payment_amount_summa += intval($payment_amount);
        }

        return view('livewire.sale.create', compact('carts', 'payment_amount_summa'));
    }
}
