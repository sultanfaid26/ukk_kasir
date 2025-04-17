<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
            <span>Produk</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pembelian.*') ? 'active' : '' }}" href="{{ route('pembelian.index') }}">
            <span>Pembelian</span></a>
    </li>

    @if(auth()->check() && auth()->user()->isAdmin())
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                <span>User</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Logout Button -->
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-left text-white w-100" style="text-decoration: none;">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Logout
            </button>
        </form>
    </li>

</ul>
