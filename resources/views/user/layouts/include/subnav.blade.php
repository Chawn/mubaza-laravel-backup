<div class="subnav navbar navbar-primary">
    <div class="container">
        <div class="navbar-header">
            <button id="btn-subnav-collapse" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#subnav-collapse" aria-expanded="false">
                {{$title}}
                <span><i class="fa fa-angle-down"></i></span>
            </button>
        </div>
                    
        <div id="subnav-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav" role="menu">
                <li>
                    <a aria-selected="{{ ($current_route=='index' ? 'true' : 'false') }}" class="subnav-item" href="{{ action('UserController@getIndex', \Auth::user()->user()->getID()) }}">
                        <i class="fa fa-dashboard"></i> แดชบอร์ด</a>
                </li>
                <li>
                    <a aria-selected="{{ ($current_route=='order-history' ? 'true' : 'false') }}" class="subnav-item" href="{{ action('UserController@getOrderHistory', \Auth::user()->user()->getID()) }}">
                        <i class="fa fa-file-text-o"></i> ประวัติการสั่งซื้อ</a>
                </li>
                <li>
                    <a aria-selected="{{ ($current_route=='user-notify' ? 'true' : 'false') }}" class="subnav-item" href="{{ action('UserController@getNotify', \Auth::user()->user()->getID()) }}">
                        <i class="fa fa-envelope-o"></i> ข้อความแจ้งเตือน</a>
                </li>
                <li>
                    <a aria-selected="{{ ($current_route=='wishlist' ? 'true' : 'false') }}" class="subnav-item" href="{{ action('UserController@getWishlist', \Auth::user()->user()->getID()) }}">
                        <i class="fa fa-heart-o"></i> 
                        รายการที่ชื่นชอบ
                    </a>
                </li>
                <li>
                    <a aria-selected="{{ ($current_route=='following' ? 'true' : 'false') }}" class="subnav-item" href="{{ action('UserController@getFollowing', \Auth::user()->user()->getID()) }}">
                        <i class="fa fa-star-o"></i> 
                        ครีเอเตอร์ที่ฉันติดตาม
                    </a>
                </li>
                <li>            
                    <a aria-selected="{{ ($current_route=='profile' ? 'true' : 'false') }}" class="subnav-item" href="{{ action('UserController@getProfile', \Auth::user()->user()->getID())}}">
                        <i class="fa fa-cog"></i> บัญชีผู้ใช้

                    </a>
                                
                    <!--
                    <a aria-selected="{{ ($current_route=='profile' ? 'true' : 'false') }}" class="subnav-item" href="{{ action('UserController@getProfile', \Auth::user()->user()->getID())}}">
                        <i class="fa fa-user"></i> ตั้งค่าบัญชีผู้ใช้
                    </a>
                    -->
                </li>
            </ul>
        </div>
            
    </div>
</div>