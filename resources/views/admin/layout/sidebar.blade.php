<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if (Auth::user()->role == 1)
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#admin-manager" aria-expanded="false"
                    aria-controls="admin-manager">
                    <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                    <span class="menu-title">Admin Manager</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="admin-manager">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('user-add') }}">Add</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('user-list') }}">List</a></li>
                        {{-- <li class="nav-item"> <a class="nav-link" href="{{ route('user-list') }}">Edit</a>
                        </li> --}}
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#category-manager" aria-expanded="false"
                aria-controls="category-manager">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Category Manager</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="category-manager">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('category-add') }}">Add</a></li>
                    {{-- <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a></li> --}}
                    <li class="nav-item"> <a class="nav-link" href="{{ route('category-list') }}">List</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#product-manager" aria-expanded="false"
                aria-controls="product-manager">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Product Manager</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="product-manager">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('product-add') }}">Add</a></li>
                    {{-- <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a></li> --}}
                    <li class="nav-item"> <a class="nav-link" href="{{ route('product-list') }}">List</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#customer-manager" aria-expanded="false"
                aria-controls="customer-manager">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Customer Manager</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="customer-manager">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('customer-add') }}">Add</a></li>
                    {{-- <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a></li> --}}
                    <li class="nav-item"> <a class="nav-link" href="{{ route('customer-list') }}">List</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#order-manager" aria-expanded="false"
                aria-controls="order-manager">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Order Manager</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="order-manager">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('order-add') }}">Add</a></li>
                    {{-- <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a>
                    </li> --}}
                    <li class="nav-item"> <a class="nav-link" href="{{ route('order-list') }}">List</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
    <li class="list-unstyled dropdown">
        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="mdi mdi-settings"></i> <!-- Thêm biểu tượng Setting vào đây -->
            Settings
        </a>
        <ul class="dropdown-menu">
            <h3 class="text-center">{{ Auth::user()->name }}</h3>

            <!-- Các mục dropdown menu -->
            <li class="list-unstyled">
                <a class="dropdown-item" href="{{ route('changeInfor') }}">
                    <i class="mdi mdi-account"></i>
                    Change Information
                </a>
            </li>
            <li class="list-unstyled">
                <a class="dropdown-item" href="{{ route('show-change-password') }}">
                    <i class="mdi mdi-lock"></i>
                    Change Password
                </a>
            </li>
            <li class="list-unstyled">
                <a class="dropdown-item" href="{{ route('adminLogout') }}">
                    <i class="mdi mdi-logout"></i>
                    Log Out
                </a>
            </li>
        </ul>
    </li>

</nav>
