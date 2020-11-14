<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('backend') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b> Dashboard</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span class="">&nbsp;Admin</span>
                    </a>
                </li>
                <li>
                    @if(\Auth::admin()->check())
                        <a href="{{ action('BackendController@getLogout') }}"><i class="fa fa-sign-in"></i> ออกจากระบบ</a>
                    @else
                        <a href="{{ action('BackendController@getLogin') }}"><i class="fa fa-sign-out"></i> เข้าสู่ระบบ</a>
                    @endif
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="{{ url('/') }}">
                        <i class="fa fa-home"></i> กลับหน้าแรก
                    </a>
                </li>
            </ul>
        </div>

    </nav>
</header>