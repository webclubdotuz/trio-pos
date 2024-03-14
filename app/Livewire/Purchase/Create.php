<?php

namespace App\Livewire\Purchase;

use App\Models\Payment;
use App\Models\Product;
use Livewire\Component;
use App\Services\TelegramService;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Create extends Component
{
    use LivewireAlert;

    public $qty;
    public $price;
    public $contact_id;

    public $amount, $method;

    public $total = 0;


    public function addCart($product_id)
    {

        //validar $qty
        $this->validate([
            'qty' => 'required|numeric'
        ]);

        $product = Product::find($product_id);

        $cart = Cart::search(function ($cartItem, $rowId) use ($product_id) {
            return $cartItem->id === $product_id;
        })->first();

        if ($cart) {
            $cart->qty += $this->qty;
            $cart->qty_histories[] = $this->qty;
        } else {
            $cart = Cart::add($product->id, $product->name, $this->qty, $product->price);

            $cart->qty_histories = [$this->qty];
        }

        $this->reset('qty');
    }

    // updatePrice
    public function updatePrice($id)
    {
        $cart = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        })->first();

        $cart->price = $this->price;

        $this->reset('price');
    }


    // removeQtyHistory
    public function removeQtyHistory($id, $index)
    {
        //dd($id, $index);
        $cart = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        })->first();

        // delete qty history
        unset($cart->qty_histories[$index]);

        $cart->qty = array_sum($cart->qty_histories);
    }

    public function clearCart()
    {
        Cart::destroy();
    }

    public function removeCart($id)
    {
        $cart = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        })->first();

        Cart::remove($cart->rowId);
    }

    public function save()
    {
        $this->validate([
            'contact_id' => 'required|exists:contacts,id',
            // 'amount' => 'nullable|numeric|min:0'
        ]);

        if ($this->amount > 0) {
            $this->validate([
                'amount' => 'required|numeric|max:' . $this->total,
                'method' => 'required'
            ]);
        }

        $carts = Cart::content();

        if ($this->total < $this->amount) {
            $this->alert('warning', 'Недостаточно средств', [
                'position' =>  'center',
                'showConfirmButton' =>  true,
            ]);
            return;
        }

        DB::beginTransaction();

        if ($carts->count()) {

            try {
                $transaction = auth()->user()->transactions()->create([
                    'contact_id' => $this->contact_id,
                    'type' => 'purchase',
                    'total' => $this->total,
                    'payment_status' => 'debt',
                    'status' => 'completed',
                ]);

                if ($this->amount) {
                    Payment::create([
                        'contact_id' => $this->contact_id, // 'cash'
                        'transaction_id' => $transaction->id,
                        'user_id' => auth()->user()->id,
                        'method' => $this->method,
                        'amount' => $this->amount,
                        'description' => 'Оплата наличными',
                    ]);

                    if ($this->amount == $this->total) {
                        $transaction->update([
                            'payment_status' => 'paid',
                            'status' => 'completed',
                        ]);
                    } else {
                        $transaction->update([
                            'payment_status' => 'debt',
                            'status' => 'completed',
                        ]);
                    }
                }

                foreach ($carts as $cart) {
                    $transaction->purchases()->create([
                        'product_id' => $cart->id,
                        'user_id' => auth()->user()->id,
                        'quantity' => $cart->qty,
                        'price' => $cart->price,
                        'total' => $cart->subtotal(),
                    ]);
                }

                Cart::destroy();
                $this->reset();


                $this->alert('success', 'Успешно');

                $this->dispatch('refreshPurchases');
                DB::commit();

                // 📥Покупки
                // 🙎🏻‍♂️Поставщик: Хуршед (Самарканд)
                // 📱 Телефон: 910977788
                // 📦Продукт: Крахмал клей (Қазастан)
                // 🖇Количество: 250 кг
                // 💲Цена: 4700 Сум
                // 💰 Сумма: 3 500 000
                // ✅ Оплачено: 2 500 000
                // ❗️ Остаток: 1 000 000
                // 📅 Дата: 9 фев 2024 15:07
                // 👨‍💻 Сотрудник: Аббаз Дауленов

                $text = "📥Покупки\n";
                $text .= "🙎🏻‍♂️Поставщик: " . $transaction->contact->fullname . "\n";
                $text .= "📱 Телефон: " . $transaction->contact->phone . "\n";
                foreach ($transaction->purchases as $purchase) {
                    $text .= "📦Продукт: " . $purchase->product->name . "\n";
                    $text .= "🖇Количество: " . $purchase->quantity . " " . $purchase->product->unit . "\n";
                    $text .= "💲Цена: " . nf($purchase->price, 0, '', ' ') . " Сум\n";
                    $text .= "💰 Сумма: " . nf($purchase->total, 0, '', ' ') . "\n";
                    $text .= "____________________\n";
                }
                $text .= "💰 Общий сумма: " . nf($transaction->total, 0, '', ' ') . "\n";
                $text .= "✅ Оплачено: " . nf($transaction->payments->sum('amount'), 0, '', ' ') . "\n";
                $text .= "❗️ Остаток: " . nf($transaction->debt, 0) . "\n";
                $text .= "📅 Дата: " . $transaction->created_at->format('d M Y H:i') . "\n";
                $text .= "👨‍💻 Сотрудник: " . $transaction->user->fullname . "\n";

                TelegramService::sendChannel($text);

            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th);
            }
        } else {
            $this->alert('warning', 'Корзина пуста');
        }
    }


    public function render()
    {

        $carts = Cart::content();

        $this->total = 0;
        foreach ($carts as $cart) {
            $this->total += $cart->subtotal();
        }

        return view('livewire.purchase.create', compact('carts'));
    }
}
