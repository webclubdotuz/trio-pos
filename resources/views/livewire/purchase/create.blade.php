<div class="row g-1">

	<div class="col-12 mb-3">
		@foreach(getNoShopProducts() as $product)
			<div class="dropdown d-inline-block m-1">
				<button class="btn btn-sm btn btn-outline-dark" type="button" data-bs-toggle="dropdown">
					<i class="bx bx-cart"></i>
					{{ $product->name }} ({{ nf($product->quantity) }})
				</button>
				<div class="dropdown-menu p-2">
					<input type="number" class="form-control" placeholder="{{ $product->unit }}" wire:model="qty" step="any" wire:keydown.enter="addCart({{ $product->id }})">
					<button class="btn btn-sm btn btn-primary mt-2" wire:click="addCart({{ $product->id }})">
						Добавить
					</button>
				</div>
			</div>

		@endforeach
	</div>

	<div wire:loading class="col-12">
		<div class="spinner-border text-primary" role="status">
			<span class="visually-hidden">Loading...</span>
		</div>

	</div>


	<div class="col-12 table">
		<table class="table table-sm table-bordered">
			<thead>
				<tr>
					<th>Товар</th>
					<th>Кол-во</th>
					<th>Цена</th>
					<th>Сумма</th>
					<th>
						<a wire:click="clearCart()" href="#" class="text-danger" wire:confirm="Действительно хотите очистить корзину?">
							<i class="bx bx-trash"></i>
						</a>
					</th>
				</tr>
			</thead>

			<tbody>
				@foreach($carts as $cart)
					<tr>
						<td>{{ $cart->name }}</td>
						<td class="position-relative w-25">
							{{ $cart->qty }} {{ App\Models\Product::find($cart->id)->unit }}
						</td>
						<td>
							{{ nf($cart->price) }}
							<a data-bs-toggle="dropdown">
								<i class="bx bx-edit text-primary"></i>
							</a>
							<div class="dropdown-menu p-2">
								<form wire:submit.prevent="updatePrice({{ $cart->id }})">
									<input type="number" class="form-control" placeholder="Цена" value="{{ $cart->price }}" wire:model="price">
									<button class="btn btn-sm btn btn-primary mt-2" type="submit">
										Cохранить
									</button>
								</form>
							</div>
						</td>
						<td>{{ nf($cart->subtotal) }}</td>
						<td>
							<div wire:click="removeCart({{ $cart->id }})">
								<i class="bx bx-trash text-danger"></i>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="5" class="position-relative">
							@foreach($cart->qty_histories as $key => $qty_history)
								<div class="badge bg-primary">
									{{ $qty_history }} <span class="bx bx-x" wire:click="removeQtyHistory({{ $cart->id }}, {{ $key }})"></span>
								</div>
							@endforeach
						</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3">Итого</th>
					<th colspan="2">{{ nf($total) }}</th>
				</tr>
		</table>
	</div>

	<div class="col-md-4">
		<label for="contact_id" class="form-label">Поставщик</label>
		<select wire:model.live="contact_id" class="form-select">
			<option value="">Выберите поставщика</option>
			@foreach(getContacts(['supplier', 'both']) as $contact)
				<option value="{{ $contact->id }}">{{ $contact->fullname }}</option>
			@endforeach
		</select>
		@error('contact_id') <span class="text-danger">{{ $message }}</span> @enderror
	</div>

    @if($contact_id)
    <div class="col-md-4">
		<label for="amount" class="form-label">Сумма</label>
		<input type="number" class="form-control" wire:model.live.debounce.500ms="amount">
		@error('amount') <span class="text-danger">{{ $message }}</span> @enderror
	</div>

    <div class="col-md-4">
		<label for="method" class="form-label">Метод оплаты</label>
		<select wire:model.live="method" class="form-select">
            <option value="">Выберите метод оплаты</option>
            @foreach(methods() as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        @error('method') <span class="text-danger">{{ $message }}</span> @enderror
	</div>


    @else
        <?php $amount = $total; ?>
    @endif

    <div class="col-12">
        <p>
            Заказ на сумму: <b>{{ nf($total) }}</b> <br>
            Оплачено: <b>{{ nf($amount) }}</b> <br>
            Долг: <b class="text-danger">{{ nf($total - $amount) }}</b>
        </p>
    </div>

	<div class="col-md-12" @if(!$contact_id) style="display: none" @endif>
		<button class="btn btn-sm btn-primary" wire:click="save()">
			<i class="bx bx-save"></i>
			Сохранить
		</button>
	</div>
</div>
