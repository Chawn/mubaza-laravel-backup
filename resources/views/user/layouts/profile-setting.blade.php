@include('user.layouts.include.head')
<body class="grey">
<div class="container-fulid">
    @include('layouts.include.header')
    @include('user.layouts.include.subnav')

    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('user.layouts.include.profile-sidebar')
                </div>
                <div class="col-sm-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $title }}
                        </div>
                        <div class="panel-body">
                            @include('backend.layouts.include.alert')
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
       
@include('layouts.include.footer')
@yield('script-footer')
</body>
</html>
