@include('user.layouts.include.head')
<body class="grey">
<div class="container-fulid">
    @include('layouts.include.header')
    @include('user.layouts.include.subnav')

    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('user.layouts.include.dashboard-sidebar')
                </div>
                <div class="col-sm-9">
                    @yield('content')
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
               
        
@include('layouts.include.footer')
@yield('script-footer')
</body>
</html>
