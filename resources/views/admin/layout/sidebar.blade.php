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
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                    aria-controls="ui-basic">
                    <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                    <span class="menu-title">Admin User 1</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('user-add') }}">Add</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('user-list') }}">List</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('user-list') }}">Edit</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="menu-user">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Admin User</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu-user">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Add</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Update</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Admin User</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Add</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Update</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Admin User</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Add</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Update</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Admin User</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Add</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Edit</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Update</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item sidebar-user-actions">
            <div class="sidebar-user-menu">
                <a href="#" class="nav-link"><i class="mdi mdi-settings menu-icon"></i>
                    <span class="menu-title">Settings</span>
                </a>
                <ul class="sub-menu" id="settings-sub-menu">
                    <li class="nav-item">
                        <a href="{{ route('changeInfor') }}" class="nav-link">
                            <span class="menu-title">Change Information</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('show-change-password') }}" class="nav-link">
                            <span class="menu-title">Change Password</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('adminLogout') }}" class="nav-link">
                            <span class="menu-title">Log Out</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <script>
            var subMenu = document.getElementById('settings-sub-menu');
            var menuItem = document.querySelector('.nav-item.sidebar-user-actions');

            // Ẩn sub-menu ban đầu
            subMenu.style.display = 'none';

            // Hiển thị sub-menu khi rê chuột vào menuItem
            menuItem.addEventListener('mouseenter', function() {
                subMenu.style.display = 'block';
            });

            // Ẩn sub-menu khi di chuột ra khỏi menuItem
            menuItem.addEventListener('mouseleave', function() {
                subMenu.style.display = 'none';
            });
        </script>
    </ul>
</nav>
