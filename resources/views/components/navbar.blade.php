<header class="navbar navbar-expand-md d-print-none bg-white p-3 border-bottom shadow-none">
    <div class="container-xl d-flex align-items-center justify-content-between gap-3">
        <!-- BEGIN NAVBAR LOGO -->
        <a href="{{ route('home') }}" aria-label="Tabler" class="navbar-brand navbar-brand-autodark me-2 d-flex align-items-center">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1cWzAkEdbaCzFQvp6GoJdo2JnNoIYuIibKIpaxoOTvQ&s=10"
                class="navbar-brand-image me-2" alt="Logo">
            Books
        </a>

        @if (Auth::check() && Auth::user()->role == 'admin')
            <ul class="navbar-nav mx-auto">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.book-categories.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.book-categories.index') }}" class="nav-link">Kategori Buku</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.subscription-packages.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.subscription-packages.index') }}" class="nav-link">Paket Langganan</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.books.index') }}" class="nav-link">Buku</a>
                </li>
            </ul>
        @else
            <!-- Search & Filter Area -->
            <div class="d-flex align-items-center flex-grow-1 gap-3 mx-lg-4">
                <!-- Dropdown Kategori -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2 rounded-3 px-3 py-2 text-dark bg-white border"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: #cbd5e1 !important; font-weight: 500;">
                        Kategori
                    </button>
                    <div class="dropdown-menu dropdown-menu-card p-3 shadow-sm" style="min-width: 480px; border-radius: 12px;">
                        <div class="row g-2">
                            @foreach ($navbarCategories as $category)
                                <div class="col-4">
                                    <div class="card py-1 border shadow-none" style="border-radius: 8px;">
                                        <a href="{{ route('category.books', $category->id) }}" class="text-decoration-none">
                                            <div class="card-body p-2 text-center text-dark small fw-medium">{{ $category->name }}</div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form method="GET" action="{{ route('search') }}" class="flex-grow-1 d-flex align-items-center m-0 position-relative">
                    <input type="text" value="{{ request('q') }}" name="q"
                           class="form-control rounded-pill pe-5 ps-3 py-2 border"
                           style="border-color: #cbd5e1; background-color: #ffffff; font-size: 14px;"
                           placeholder="Cari judul, produk, buku, penulis..." />
                    <button type="submit" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary border-0 p-0 me-3" style="text-decoration: none;">
                        <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8; font-size: 16px;"></i>
                    </button>
                </form>

                <!-- Icon Keranjang -->
                <div class="px-1 d-flex align-items-center">
                    <a href="{{ route('carts') }}" class="text-dark fs-3 text-decoration-none" title="Keranjang">
                        <i class="fa-solid fa-cart-shopping" style="color: #1e293b;"></i>
                    </a>
                </div>
            </div>
        @endif

        <div class="navbar-nav flex-row ms-auto align-items-center gap-3">
            @if (Auth::check())
                <a href="{{ route('profile') }}" class="position-relative d-inline-flex align-items-center text-decoration-none" title="Profil {{ Auth::user()->name }}">
                    <span class="avatar avatar-md rounded-circle text-dark fw-bold"
                          style="background-color: #e2e8f0; width: 42px; height: 42px; font-size: 15px; letter-spacing: 0.5px; color: #475569 !important;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </span>
                    <span class="position-absolute bg-success rounded-circle border border-white"
                          style="width: 11px; height: 11px; bottom: 1px; right: 1px;"></span>
                </a>
                <a href="{{ route('logout') }}" class="btn btn-danger px-3 py-2 fw-medium text-white shadow-none" style="background-color: #dc3545; border-radius: 8px;">
                    Logout
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary px-3 py-2 fw-medium" style="border-radius: 8px;">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary px-3 py-2 fw-medium" style="border-radius: 8px;">Register</a>
            @endif
        </div>
    </div>
</header>
