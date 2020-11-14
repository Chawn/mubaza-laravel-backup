<div style="padding-right: 0px;">
    <div class=" user-sub-account-menu">
        <div class="list-group">
            <a href="{{ action('UserController@getProfile', $user->getID()) }}" class="{{ \Request::is('user/*/profile') ? 'active' : '' }} list-group-item">ข้อมูลพื้นฐานและการติดต่อ</a>
            <a href="{{ action('UserController@getSecure', $user->getID()) }}" class="{{ \Request::is('user/*/secure') ? 'active' : '' }} list-group-item">ตั้งรหัสผ่าน</a>
            <a href="{{ action('UserController@getAddress', $user->getID()) }}" class="{{ \Request::is('user/*/address') ? 'active' : '' }} list-group-item">ที่อยู่ในการจัดส่ง</a>
        </div> 
    </div>
</div>
<div class="col-xs-12 user-sub-account-menu-mobile">
    <div class="sub-menu">
        <ul>
			<li class="{{ \Request::is('user/*/profile') ? 'active' : '' }}">
				<a href="{{ action('UserController@getProfile', $user->getID()) }}">ข้อมูลพื้นฐาน</a>
			</li>
            <li class="{{ \Request::is('user/*/secure') ? 'active' : '' }}">
                <a href="{{ action('UserController@getSecure', $user->getID()) }}">ตั้งรหัสผ่าน</a>
            </li>
			<li class="{{ \Request::is('user/*/address') ? 'active' : '' }}">
				<a href="{{ action('UserController@getAddress', $user->getID()) }}">ที่อยูในการจัดส่ง</a>
        	</li>
		</ul>
    </div>
		
</div>
