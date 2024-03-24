<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">{{ config('app.name') }}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="/">
                <div class="parent-icon"><i class='bx bx-home'></i>
                </div>
                <div class="menu-title">Главная</div>
            </a>
        </li>

        @if(hasRoles(['admin','manager']))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='lni lni-users'></i>
                </div>
                <div class="menu-title">Контакты</div>
            </a>
            <ul>
                <li><a href="{{ route('customers.index') }}"><i class="lni lni-users"></i> Клиенты</a></li>
                <li><a href="{{ route('suppliers.index') }}"><i class="lni lni-users"></i> Поставщики</a></li>
            </ul>
        </li>
        @endif
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='lni lni-dropbox-original'></i>
                </div>
                <div class="menu-title">Продукты</div>
            </a>
            <ul>
                <li><a href="{{ route('products.index') }}"><i class="lni lni-bricks"></i>Продукты</a></li>
                <li><a href="{{ route('categories.index') }}"><i class="lni lni-bricks"></i>Категории</a></li>
                <li><a href="{{ route('brands.index') }}"><i class="lni lni-bricks"></i>Бренды</a></li>
                <li><a href="{{ route('warehouses.index') }}"><i class="lni lni-dropbox-original"></i>Склады</a></li>
            </ul>
        </li>
        @if(hasRoles(['admin','manager','salesman']))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-minus-circle'></i>
                </div>
                <div class="menu-title">Расходы</div>
            </a>
            <ul>
                <li><a href="{{ route('expenses.create') }}"><i class="bx bx-plus"></i> Добавить расход</a></li>
                <li><a href="{{ route('expenses.index') }}"><i class="bx bx-list-plus"></i> Список расходов</a></li>
                <li><a href="{{ route('expense-categories.index') }}"><i class="bx bx-list-plus"></i> Расходные категории</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-down-arrow-circle'></i>
                </div>
                <div class="menu-title">Покупки</div>
            </a>
            <ul>
                <li><a href="{{ route('purchases.index') }}"><i class="bx bx-list-plus"></i> Список покупок</a></li>
                <li><a href="{{ route('purchases.create') }}"><i class="bx bx-plus"></i> Добавить покупку</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-up-arrow-circle'></i></div>
                <div class="menu-title">Продажи</div>
            </a>
            <ul>
                <li><a href="{{ route('sales.index') }}"><i class="bx bx-list-plus"></i> Список продаж</a></li>
                <li><a href="{{ route('sales.create') }}"><i class="bx bx-plus"></i> Добавить продажу</a></li>
            </ul>
        </li>
        @endif

        @if(hasRoles(['admin']))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-chart'></i>
                </div>
                <div class="menu-title">Отчеты</div>
            </a>
            <ul>
                <li><a href="{{ route('reports.sale-report-user') }}"><i class="bx bx-user"></i> Продажник</a></li>
                <li><a href="{{ route('reports.installment-report-debt') }}"><i class="bx bx-chart"></i> Рассрочки</a></li>
                <li><a href="{{ route('reports.customer-report') }}"><i class="bx bx-chart"></i> Клиенты</a></li>
                <li><a href="{{ route('reports.product-report-sale') }}"><i class="bx bx-chart"></i> Продукты</a></li>
                <li><a href="{{ route('reports.expense') }}"><i class="bx bx-chart"></i> Расходы</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cog'></i>
                </div>
                <div class="menu-title">Администрирование</div>
            </a>
            <ul>
                <li><a href="{{ route('users.index') }}"><i class="bx bx-user"></i> Пользователи</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cog'></i>
                </div>
                <div class="menu-title">Настройки</div>
            </a>
            <ul>
                <li><a href="{{ route('payment-methods.index') }}"><i class="bx bx-list-plus"></i> Способы оплаты</a></li>
                <li><a href="{{ route('finds.index') }}"><i class="bx bx-list-plus"></i> Источники</a></li>
            </ul>
        </li>
        @endif
    </ul>
    <!--end navigation-->
</div>
