<nav id="main-nav-two" class="navbar navbar-default navbar-static-top sub-nav-mg">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar2" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle secondary navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand visible-xs" href="#">Menu</a>
        </div>
        <div id="navbar2" class="navbar-collapse collapse">
           <ul class="nav navbar-nav navbar-header" role="menu">
                            
                            <li>
                                <a href="{{ action('UserController@getIndex', $user->id) }}" title="" class="font-big">
                                    <i class="fa fa-file-text-o"></i> รายการสั่งซื้อ
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('UserController@getWishlist', $user->id) }}" class="font-big">
                                    <i class="fa fa-heart"></i> 
                                    รายการที่ชื่นชอบ
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('UserController@getFollowing', $user->getID()) }}" class="font-big">
                                    <i class="fa fa-star"></i> 
                                    ครีเอเตอร์ที่ฉันติดตาม
                                </a>
                            </li>
                            <li>
                                <a href="" class="font-big">
                                    <i class="fa fa-credit-card"></i> วิธีการชำระเงิน
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('AssociateController@getSellReport') }}" class="font-big">
                                    <i class="fa fa-user"></i> 
                                    ตั้งค่าบัญชีผู้ใช้
                                </a>
                            </li>
                        </ul>
        </div>
    </div>
</nav>
 
        <div class="sidebar">
            <ul class="">
                <li>
                   <a href="{{ action('UserController@getIndex', $user->id) }}" title="">
                        <i class="fa fa-file-text-o"></i> รายการสั่งซื้อ
                    </a>
                </li>
                <li>
                    <a href="{{ action('UserController@getWishlist', $user->id) }}" title="">
                        <i class="fa fa-heart"></i> รายการที่ฉันชื่นชอบ
                    </a>
                </li>
                <li>
                
                    <a href="{{ action('UserController@getFollowing', $user->getID()) }}" title="">
                        <i class="fa fa-user"></i> ครีเอเตอร์ที่ฉันติดตาม
                    </a>
                </li>
                <li>
                    <a href="" title="">
                        <i class="fa fa-credit-card"></i> วิธีการชำระเงิน
                    </a>
                
                </li>
                <li>
                    <a href="{{ action('UserController@getProfile', $user->getID()) }}" title="">
                        <i class="fa fa-gear"></i> ตั้งค่าบัญชีผู้ใช้
                    </a>
                </li>
                <li>
                    <a href="" title="">
                        <i class="fa fa-home"></i> ที่อยู่สำหรับจัดส่ง
                    </a>
                </li>
            </ul>
        </div>
            <div class="list-group">
                    
            </div>
        </div>
        <div class="col-sm-9">
            <h3>ประวัติการสั่งซื้อ</h3>
        </div>
    </div>
</div>

<div id="user-header">
    <div id="other">
        <div id="in-other" class="container">
            @if(\Auth::user()->check())
                @if(\Auth::user()->user()->isOwner($user->id))
                    <a class="btn btn-default btn-other" href="{{ action('UserController@getProfile', $user->getID()) }}">
                            ตั้งค่าบัญชี
                        </a>
                @endif
            @endif
       </div>
    </div>

    <div id="box-profile">
        <div id="profile">
            <span class="profile-image target" style="background-image:url('{{ $user->avatar }}')"></span> >
        </div>
    </div>
    <div id="user-detail">
        <h3 class="user-title">
            {{ $user->option->show_full_name ? $user->full_name : $user->username }}
        </h3>
         {{-- TODO: show user detail --}}
        <p class="user-detail">
           {{ $user->detail }}
        </p>
    </div>
    <div id="social">
        <ul>
            @if(!is_null($user->profile->facebook))
            <li>
                <a href="{{ $user->profile->facebook }}" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
            @endif
            @if(!is_null($user->profile->twitter))
            <li>
                <a href="{{ $user->profile->twitter }}" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            @endif
            @if(!is_null($user->profile->line_qr))
            <li>
                <a data-target="#modal-qrcodeline" data-toggle="modal">
                    Line
                </a>
            </li>
            @endif
            @if(!is_null($user->profile->website))
            <li>
                <a href="{{ $user->profile->website }}" target="_blank">
                    <i class="fa fa-globe"></i>

                </a>
            </li>
            @endif
        </ul>
    </div>
    <div id="box-mobile-btn">
        @if(\Auth::user()->check())
                @if(\Auth::user()->user()->isOwner($user->id))
                    <a class="btn btn-default btn-other" href="{{ action('UserController@getProfile', $user->getID()) }}">
                            ตั้งค่าบัญชี
                        </a>
                        {{-- TODO:จำนวนผู้ชม --}}
                    <a class="btn-view btn-other">
                        <i class="fa fa-eye"></i>
                        {{ \App\ViewCount::count('user/' . $user->getID()) }}
                    </a>
                    {{-- TODO:ปุ่มแชร์ --}}
                    <div class="dropdown">
                        <a id="btn-shared" class="btn btn-default btn-other btn-share" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-share-square-o"></i>
                        </a>
                        <ul id="dropdown-share" class="dropdown-menu nav navbar-nav" aria-labelledby="btn-shared">
                            <li>
                                <a onclick="popUp=window.open('https://twitter.com/intent/tweet?original_referer={{ urlencode(url('user') . '/' . $user->url) }}&text={{ ($user->show_full_name) ? $user->full_name : $user->username }}&tw_p=tweetbutton&url={{ url('user') . '/' . $user->url }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false">
                                    <img src="{{asset('images/icon/twitter_30x30.png')}}">
                                    แชร์บนทวิตเตอร์
                                </a>
                            </li>
                            <li>
                                <a onclick="popUp=window.open('http://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('user') . '/' . $user->url) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false">
                                    <img src="{{asset('images/icon/facebook_30x30.png')}}">
                                    แชร์บนเฟซบุค
                                </a>
                            </li>
                            <li>
                                <a onclick="popUp=window.open('https://plus.google.com/share?url={{ urlencode(url('user') . '/' . $user->url) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false">
                                    <img src="{{asset('images/icon/googleplus_30x30.png')}}">
                                    แชร์บนกูเกิลพลัส
                                </a>
                            </li>
                            <li>
                                <a onclick="popUp=window.open('http://www.pinterest.com/pin/create/button/?url={{ url('user') . '/' . $user->url }}&media={{ $user->avatar }}&description={{ ($user->show_full_name) ? $user->full_name : $user->username }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                                class="btn-social" data-toggle="tooltip" title="แบ่งปันบนพินเทอเรส">
                                    <img src="{{asset('images/icon/pinterest_30x30.png')}}">
                                    แชร์บนพินเทอเรส
                                </a>
                            </li>
                            <li>
                                <a href="mailto:?subject={{ ($user->show_full_name) ? $user->full_name : $user->username }}&amp;body={{ urlencode(url('user') . '/' . $user->url) }}">
                                    <img src="{{asset('images/icon/email_30x30.png')}}">
                                    แชร์ด้วยอีเมล
                                </a>
                            </li>
                        </ul>
                    </div>
                @else
                <a id="" class="btn btn-default btn-other follow-btn"
                       data-url="{{ action('UserController@getSetUserSubscribe', [\Auth::user()->user()->id, $user->id]) }}"
                            {{ \Auth::user()->user()->isSubscribed($user->id) ? 'style=display:none;' : '' }}>
                    <i class="fa fa-star-o"></i>
                    ติดตาม
                </a>
                <a id="" class="btn btn-default btn-other followed un-follow"
                   data-url="{{ action('UserController@getSetUserSubscribe', [\Auth::user()->user()->id, $user->id]) }}"
                        {{ \Auth::user()->user()->isSubscribed($user->id) ? '' : 'style=display:none;' }}>
                        <i class="fa fa-star"></i>
                        กำลังติดตาม
                </a>
                {{-- TODO:จำนวนผู้ชม --}}
                <a class="btn-view btn-other">
                    <i class="fa fa-eye"></i>
                    {{ \App\ViewCount::count('user/' . $user->getID()) }}
                </a>
                {{-- TODO:ปุ่มแชร์ --}}
                <div class="dropdown">
                    <a id="btn-shared" class="btn btn-default btn-other btn-share" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-share-square-o"></i>
                    </a>
                    <ul id="dropdown-share" class="dropdown-menu nav navbar-nav" aria-labelledby="btn-shared">
                        <li>
                            <a onclick="popUp=window.open('https://twitter.com/intent/tweet?original_referer={{ urlencode(url('user') . '/' . $user->url) }}&text={{ ($user->show_full_name) ? $user->full_name : $user->username }}&tw_p=tweetbutton&url={{ url('user') . '/' . $user->url }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false">
                                <img src="{{asset('images/icon/twitter_30x30.png')}}">
                                แชร์บนทวิตเตอร์
                            </a>
                        </li>
                        <li>
                            <a onclick="popUp=window.open('http://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('user') . '/' . $user->url) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false">
                                <img src="{{asset('images/icon/facebook_30x30.png')}}">
                                แชร์บนเฟซบุค
                            </a>
                        </li>
                        <li>
                            <a onclick="popUp=window.open('https://plus.google.com/share?url={{ urlencode(url('user') . '/' . $user->url) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false">
                                <img src="{{asset('images/icon/googleplus_30x30.png')}}">
                                แชร์บนกูเกิลพลัส
                            </a>
                        </li>
                        <li>
                            <a onclick="popUp=window.open('http://www.pinterest.com/pin/create/button/?url={{ url('user') . '/' . $user->url }}&media={{ $user->avatar }}&description={{ ($user->show_full_name) ? $user->full_name : $user->username }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                            class="btn-social" data-toggle="tooltip" title="แบ่งปันบนพินเทอเรส">
                                <img src="{{asset('images/icon/pinterest_30x30.png')}}">
                                แชร์บนพินเทอเรส
                            </a>
                        </li>
                        <li>
                            <a href="mailto:?subject={{ ($user->show_full_name) ? $user->full_name : $user->username }}&amp;body={{ urlencode(url('user') . '/' . $user->url) }}">
                                <img src="{{asset('images/icon/email_30x30.png')}}">
                                แชร์ด้วยอีเมล
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="dropdown">
                    <a class="btn btn-default btn-other dropdown-toggle" id="report-user" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                        <i class="fa fa-ellipsis-h"></i>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="report-user">
                        <li role="presentation">
                            <a data-toggle="modal" data-target="#modal-report">รายงานปัญหา</a>
                        </li>
                    </ul>
                </div>
                @endif
        @else
            <a class="btn btn-default btn-other"
                   href="{{ url('user/login') }}?return={{ \Request::path() }}">
                <i class="fa fa-star-o"></i>
                ติดตาม
            </a>
            {{-- TODO:จำนวนผู้ชม --}}
            <a class="btn-view btn-other">
                <i class="fa fa-eye"></i>
                {{ \App\ViewCount::count('user/' . $user->getID()) }}
            </a>
            {{-- TODO:ปุ่มแชร์ --}}
            <div class="dropdown">
                <a id="btn-shared" class="btn btn-default btn-other btn-share" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-share-square-o"></i>
                </a>
                <ul id="dropdown-share" class="dropdown-menu nav navbar-nav" aria-labelledby="btn-shared">
                    <li>
                        <a onclick="popUp=window.open('https://twitter.com/intent/tweet?original_referer={{ urlencode(url('user') . '/' . $user->url) }}&text={{ ($user->show_full_name) ? $user->full_name : $user->username }}&tw_p=tweetbutton&url={{ url('user') . '/' . $user->url }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false">
                            <img src="{{asset('images/icon/twitter_30x30.png')}}">
                            แชร์บนทวิตเตอร์
                        </a>
                    </li>
                    <li>
                        <a onclick="popUp=window.open('http://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('user') . '/' . $user->url) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false">
                            <img src="{{asset('images/icon/facebook_30x30.png')}}">
                            แชร์บนเฟซบุค
                        </a>
                    </li>
                    <li>
                        <a onclick="popUp=window.open('https://plus.google.com/share?url={{ urlencode(url('user') . '/' . $user->url) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false">
                            <img src="{{asset('images/icon/googleplus_30x30.png')}}">
                            แชร์บนกูเกิลพลัส
                        </a>
                    </li>
                    <li>
                        <a onclick="popUp=window.open('http://www.pinterest.com/pin/create/button/?url={{ url('user') . '/' . $user->url }}&media={{ $user->avatar }}&description={{ ($user->show_full_name) ? $user->full_name : $user->username }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                        class="btn-social" data-toggle="tooltip" title="แบ่งปันบนพินเทอเรส">
                            <img src="{{asset('images/icon/pinterest_30x30.png')}}">
                            แชร์บนพินเทอเรส
                        </a>
                    </li>
                    <li>
                        <a href="mailto:?subject={{ ($user->show_full_name) ? $user->full_name : $user->username }}&amp;body={{ urlencode(url('user') . '/' . $user->url) }}">
                            <img src="{{asset('images/icon/email_30x30.png')}}">
                            แชร์ด้วยอีเมล
                        </a>
                    </li>
                </ul>
            </div>

            <div class="dropdown">
                <a class="btn btn-default btn-other dropdown-toggle" id="report-user" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                    <i class="fa fa-ellipsis-h"></i>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="report-user">
                    <li role="presentation">
                        <a href="{{ url('/user/login') }}?return={{ \Request::path() }}">รายงานปัญหา</a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
    <div id="about" class="sub-menu">
        <ul>
            @if(\Auth::user()->check())
                @if(\Auth::user()->user()->isOwner($user->id) || \Auth::user()->user()->role->name = config('constant.admin_role'))
                    <li id="u-buy" class="{{ \Request::is('user/*/order-history') || \Request::is('user/*/order-history') ? 'active' : '' }}">
                        <a href="{{ action('UserController@getOrderHistory', $user->getID()) }}">
                            <p class="count">{{ number_format(count($user->orders)) }}</p>
                            <p>ประวัติการซื้อ</p>
                        </a>
                    </li>
                    <li id="u-campaign" class="{{ \Request::is('user/*/campaign') || \Request::is('user/*/campaign') ? 'active' : '' }}">
                        <a href="{{ action('UserController@getCampaign', $user->getID()) }}">
                            <p class="count">{{ number_format(count($user->getSell())) }}</p>
                            <p>แคมเปญ</p>
                        </a>
                    </li>
                    <li id="u-following" class="{{ \Request::is('user/*/following' ) || \Request::is('user/*/following') ? 'active' : '' }}">
                        <a href="{{ action('UserController@getFollowing', $user->getID()) }}">
                            <p class="count">{{ count($user->followings()) }}</p>
                            <p>กำลังติดตาม</p>
                        </a>
                    </li>
                    <li id="u-favorite" class="{{ \Request::is('user/*/wishlist' ) ? 'active' : '' }}">
                        <a href="{{ action('UserController@getWishlist', $user->getID()) }}">
                            <p class="count">{{ count($user->favorites) }}</p>
                            <p>รายการที่ชอบ</p>
                        </a>
                    </li>
                @endif
            @endif

           @if(!\Auth::user()->check() || (\Auth::user()->user()->id != $user->id && !(\Auth::user()->user()->role->name == config('constant.admin_role'))) )
                <li class="{{ \Request::is('user/*/campaign')? 'active' : '' }}">
                    <a href="{{ action('UserController@getCampaign', $user->getID()) }}">
                        <p class="count">{{ number_format(count($user->getSell())) }}</p>
                        <p>งานออกแบบ</p>
                    </a>
                </li>
                <li class="{{ \Request::is('user/*/follower') ? 'active' : '' }}">
                    <a href="{{ action('UserController@getFollower', $user->getID()) }}">
                        <p class="count">{{ count($user->followers) }}</p>
                        <p>ผู้ติดตาม</p>
                    </a>
                </li>
                <li class="{{ \Request::is('user/*/following') ? 'active' : '' }}">
                    <a href="{{ action('UserController@getFollowing', $user->getID()) }}">
                        <p class="count">{{ count($user->followings()) }}</p>
                        <p>กำลังติดตาม</p>
                    </a>
                </li>
                <li class="{{ \Request::is('user/*/about' ) ? 'active' : '' }}">
                    <a href="{{ action('UserController@getAbout', $user->getID()) }}">
                        <p class="count">{{ number_format(count($user->favorites)) }}</p>
                        <p>เกี่ยวกับ</p>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>

<div id="modal-qrcodeline" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="qrcodeline" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-header">
            <h4 class="modal-title">QR Code ไลน์</h4>
        </div>
        <div class="modal-body">
            <img src="{{ url('/') . '/' . $user->profile->line_qr }}">
        </div>
        <div class="modal-footer">
            <a href="{{ action('UserController@getLineQR', $user->getID()) }}" class="btn btn-success">บันทึก QR Code</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>

    </div>
</div>
@if(\Auth::user()->check())
<div id="modal-report" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="report-user" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-header">
            <h4 class="modal-title">ช่วยให้เราเข้าใจสิ่งที่กำลังเกิดขึ้น</h4>
        </div>
        <div class="modal-body">
            <p class="text-bold">คุณต้องการแจ้งในเรื่องใด</p>
                <ul class="ul-report">
                    <li>
                        <input id="radio-content" type="radio" name="report_type_name" value="abuse">
                        <label for="radio-content">รายงานการโพสเนื้อหาที่ไม่เหมาะสม</label>
                    </li>
                    <li>
                        <input id="radio-copyright" type="radio" name="report_type_name" value="privacy">
                        <label for="radio-copyright">รายงานการละเมิดลิขสิทธิ์</label>
                    </li>
                    <li>
                        <input id="radio-other" type="radio" name="report_type_name" value="etc">
                        <label for="radio-other">รายงานเรื่องอื่นๆ</label>
                    </li>
                    <li>
                        <textarea name="detail" id="report-detail" maxlength="500" class="form-control" rows="3">

                        </textarea>
                    </li>
                </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="send-report-button"
                    data-token="{{ csrf_token() }}"
                    data-url="{{ action('HomeController@postReport', \Auth::user()->user()->id) }}"
                    data-user-id="{{ $user->id }}">ส่ง</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
    </div>
</div>
@endif