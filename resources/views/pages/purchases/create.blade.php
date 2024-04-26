@extends('layouts.main')
@push('css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <x-breadcrumb :title="'Покупка'">
        <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-list-ul"></i>
            Список покупок
        </a>
    </x-breadcrumb>

    <form class="row" action="{{ route('purchases.store') }}" method="post">
        @csrf
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="date">Дата</label>
                            <input type="datetime-local" class="form-control" id="date" name="date" value="{{ date('Y-m-d H:i') }}" required max="{{ date('Y-m-d H:i') }}" min="{{ date('Y-m-d H:i', strtotime('-1 month')) }}">
                        </div>
                        <div class="col-4 form-group">
                            <label for="supplier_id">Поставщик</label>
                            <select class="form-control select2" id="supplier_id" name="supplier_id" required>
                                <option value="">Выберите поставщика</option>
                                @foreach (getSuppliers() as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 form-group">
                            <label for="warehouse_id">Склад</label>
                            <select class="form-control select2" id="warehouse_id" name="warehouse_id" required>
                                <option value="">Выберите склад</option>
                                @foreach (getWarehouses() as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="purchase-item-div">
                            <div class="row purchase-item-clone">
                                <div class="col-md-3 form-group">
                                    <label for="product_id_0">Продукт</label>
                                    <select name="items[][product_id]" id="product_id_0" class="form-select select2" required onchange="productChange.call(this)">
                                        <option value="">Выберите продукт</option>
                                        @foreach (getProducts() as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label for="quantity_0">Количество</label>
                                    <input type="number" name="items[][quantity]" id="quantity_0" class="form-control" required min="1" step="any" onchange="calc()" value="1">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="price_0">Цена</label>
                                    <div class="input-group">
                                        <input type="text" name="items[][in_price_usd]" id="in_price_usd_0" class="form-control money" required oninput="currencyConvert.call(this)">
                                        <span class="input-group-text">USD</span>
                                        <input type="text" name="items[][in_price]" id="in_price_0" class="form-control money" required oninput="currencyConvert.call(this)">
                                        <span class="input-group-text">Сум</span>
                                    </div>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="total_0">Сумма</label>
                                    <div class="input-group">
                                        <input type="text" name="items[][total_usd]" id="total_usd_0" class="form-control money" required oninput="currencyConvert.call(this)">
                                        <span class="input-group-text">USD</span>
                                        <input type="text" name="items[][total]" id="total_0" class="form-control money" required oninput="currencyConvert.call(this)">
                                        <span class="input-group-text">Сум</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="price_0">Цена продажи</label>
                                    <div class="input-group">
                                        <input type="text" name="items[][price_usd]" id="price_usd_0" class="form-control money" required oninput="currencyConvert.call(this)">
                                        <span class="input-group-text">USD</span>
                                        <input type="text" name="items[][price]" id="price_0" class="form-control money" required oninput="currencyConvert.call(this)">
                                        <span class="input-group-text">Сум</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="installment_price_usd">Цена продажи в рассрочку</label>
                                    <div class="input-group">
                                        <input type="text" name="items[][installment_price_usd]" id="installment_price_usd_0" class="form-control money" required oninput="currencyConvert.call(this)">
                                        <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                        <input type="text" name="items[][installment_price]" id="installment_price_0" class="form-control money" required oninput="currencyConvert.call(this)">
                                        <span class="input-group-text">UZS</i></span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <a type="button" class="text-danger purchase-item-remove float-end"><i class="bx bx-trash"></i> Удалить</a> <br>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <a type="button" id="add-purchase-item" onclick="return false;" class="text-primary float-start">
                                <i class="bx bx-plus"></i> Добавить продукт
                            </a>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="description">Описание</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label>Итого</label>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><span id="total_usd">0</span> USD</td>
                                        <td><span id="total">0</span> UZS</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary float-end">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/cloneData.js') }}"></script>

    <script>
        $('a#add-purchase-item').cloneData({
            mainContainerId: 'purchase-item-div', // Main container Should be ID
            cloneContainer: 'purchase-item-clone', // Which you want to clone
            removeButtonClass: 'purchase-item-remove', // Remove button for remove cloned HTML
            removeConfirm: true, // default true confirm before delete clone item
            removeConfirmMessage: 'Вы уверены что хотите удалить?', // confirm message
            minLimit: 1, // Default 1 set minimum clone HTML required
            maxLimit: 35, // Default unlimited or set maximum limit of clone HTML
            append: '<div>Hi i am appended</div>', // Set extra HTML append to clone HTML
            excludeHTML: ".exclude", // remove HTML from cloned HTML
            defaultRender: 1, // Default 1 render clone HTML
            init: function() {
                $('.select2').select2();
            },
            beforeRender: function() {
            },
            afterRender: function() {
                $('#quantity_' + this.index).val(1);
            },
            afterRemove: function() {
                $('.select2').select2();
            },
            beforeRemove: function() {
            }
        });

    </script>


    <script>
        let currency = {{ getCurrencyRate() }};

        function currencyConvert() {

            let value = $(this).val();
            let id = $(this).attr('id');
            let usd = id.includes('usd');

            console.log(value, id, usd);

            if (usd) {
                let result = value * currency;
                let target = id.replace('_usd', '');
                $(`#${target}`).val(result);
            } else {
                let result = value / currency;
                let splits = id.split('_');
                let target = `${splits[0]}_usd_${splits[1]}`;
                $(`#${target}`).val(result);
            }
        }

        function moneyInput() {
            $(".money").inputmask({
                alias: "numeric",
                groupSeparator: " ",
                autoGroup: true,
                digits: 0,
                digitsOptional: false,
                prefix: '',
                placeholder: "",
                rightAlign: false,
                autoUnmask: true,
                removeMaskOnSubmit: true,
                unmaskAsNumber: true
            });
        }

        // form on change event
        $(document).on('change', 'input', function() {
            calc();
        });

        function calc() {
            let length = $('#purchase-item-div').find('.purchase-item-clone').length;

            let total = 0;
            let total_usd = 0;

            for (let i = 0; i < length; i++) {
                let quantity = parseFloat($(`#quantity_${i}`).val());
                let price = parseFloat($(`#in_price_${i}`).val());
                let total_ = quantity * price;
                $(`#total_${i}`).val(total_);

                let price_usd = parseFloat($(`#in_price_usd_${i}`).val());
                let total_usd_ = quantity * price_usd;
                $(`#total_usd_${i}`).val(total_usd_);

                total += total_;
                total_usd += total_usd_;

                $(`#total`).text(nf(total));
                $(`#total_usd`).text(nf(total_usd));

            }
        }

        function nf(number) {
            if (number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            }
        }

        function productChange() {
            let id = $(this).val();
            let index = $(this).attr('id').split('_')[2];
            let price = 0;
            let price_usd = 0;
            $.ajax({
                url: `/api/products/${id}`,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    in_price = response.in_price_usd * currency;
                    in_price_usd = response.in_price_usd;

                    price = response.price_usd * currency;
                    price_usd = response.price_usd;

                    installment_price = response.installment_price_usd * currency;
                    installment_price_usd = response.installment_price_usd;

                    $(`#in_price_${index}`).val(in_price);
                    $(`#in_price_usd_${index}`).val(in_price_usd);

                    $(`#price_${index}`).val(price);
                    $(`#price_usd_${index}`).val(price_usd);

                    $(`#installment_price_${index}`).val(installment_price);
                    $(`#installment_price_usd_${index}`).val(installment_price_usd);




                    calc();
                }
            });
        }
    </script>
@endpush
