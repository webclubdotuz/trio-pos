<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mobile-search-icon">
                        <a class="btn btn-primary btn-sm m-1" href="{{ route('sales.create') }}">
                            <i class='bx bx-shopping-bag'></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn btn-success btn-sm m-1" type="button" id="triggerId" data-bs-toggle="dropdown">
                                <i class='bx bx-trending-up'></i>{{ nf(getCurrencyRate()) }} UZS
                            </button>
                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                <form action="{{ route('settings.update', 'currency') }}" method="post" class="p-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" class="form-control money" name="value" value="{{ getCurrencyRate() }}" min="1" required>
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">
                                        Сохранить
                                    </button>
                                </form>
                            </div>
                        </div>

                    </li>
                </ul>
            </div>
            @auth
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="/assets/images/avatar.png" class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ Auth::user()->fullname }}</p>
                        <p class="designattion mb-0">{{ Auth::user()->roles?->first()?->name }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('users.my-profile') }}"><i class="bx bx-user"></i><span>Profile</span></a></li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class='bx bx-log-out-circle'></i><span>Выход</span></a></li>
                </ul>
            </div>
            @endauth
        </nav>
    </div>
</header>
