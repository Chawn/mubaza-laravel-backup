<div class="panel panel-default">
    
    
    <div class="panel-body">
        <div class="text-center">
            <p>
                <span class="profile-circle profile-circle-lg" >
                    <span class="profile-image" style="background-image:url('{{ asset(Auth::user()->user()->avatar) }}')"></span>
                </span>
                
            </p>
            <h4 >
                {{ Auth::user()->user()->full_name }}
                
            </h4>
            @if(Auth::user()->user()->email!="")
                <p>{{ Auth::user()->user()->email }}</p>
            @endif
        </div>
        <hr>
        <ul class="list-unstyled">
            <li class="space-lg-2">
                
            </li>
            <li class="space-lg-2">
                <a href="{{ action('UserController@getProfile', \Auth::user()->user()->getID())}}">
                    ตั้งค่าบัญชีผู้ใช้
                </a>
            </li>
            <li class="space-lg-2">
                <a href="{{ action('UserController@getLogout', \Auth::user()->user()->getID())}}">
                    ออกจากระบบ
                </a>
            </li>
        </ul>
    </div>
</div>
