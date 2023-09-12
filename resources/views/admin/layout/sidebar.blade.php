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
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Add</a></li>
                    {{-- <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a></li> --}}
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Update</a>
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
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Add</a></li>
                    {{-- <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a></li> --}}
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Update</a>
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
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Add</a></li>
                    {{-- <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a>
                    </li> --}}
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Update</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
    <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
            aria-expanded="false">
            <div class="nav-profile-img">
                <img src="{{ asset('storage/user/' . Auth::user()->photo) }}" alt="img"
                    style="height: 50px; width: 50px;">
            </div>
            <div class="nav-profile-text">
                <p class="mb-3 text-white">{{ Auth::user()->name }}</p> <!-- Hiển thị tên người đang đăng nhập -->
            </div>
        </a>
        <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm"
            aria-labelledby="profileDropdown" data-x-placement="bottom-end">
            <div class="p-1 text-center">
                <img src="{{ asset('storage/user/' . Auth::user()->photo) }}" alt="img"
                    style="height: 100%; width: 100%;">
            </div>
            <div class="p-1">
                <a href="{{ route('changeInfor', Auth()->user()->id) }}" class="nav-link">
                    <i class="mdi mdi-account"></i>
                    <span class="menu-title">Change Information</span>
                </a>
                <a href="{{ route('show-change-password') }}" class="nav-link">
                    <i class="mdi mdi-lock"></i>
                    <span class="menu-title">Change Password</span>
                </a>
                <a href="{{ route('adminLogout') }}" class="nav-link">
                    <i class="mdi mdi-logout"></i>
                    <span class="menu-title">Log Out</span>
                </a>
            </div>
        </div>
    </li>
</nav>
