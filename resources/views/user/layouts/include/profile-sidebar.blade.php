<div class="panel panel-default">
    <div class="panel-heading">
        ตั้งค่าบัญชีผู้ใช้
    </div>
    <div class="panel-body">
        <ul class="list-unstyled">
            <li class="space-lg-2">
                
            </li>
            <li class="space-lg-2">
                <a href="{{ action('UserController@getProfile', \Auth::user()->user()->getID())}}">
                    ข้อมูลพื้นฐานและการติดต่อ
                </a>
            </li>
            <li class="space-lg-2">
                <a href="{{ action('UserController@getAddress', \Auth::user()->user()->getID())}}">
                    ที่อยู่สำหรับจัดส่ง
                </a>
            </li>
            <li class="space-lg-2">
                <a href="{{ action('UserController@getSecure', \Auth::user()->user()->getID())}}">
                    เปลี่ยนรหัสผ่าน
                </a>
            </li>
        </ul>
    </div>
</div>
