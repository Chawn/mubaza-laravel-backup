<div class="col-sm-12">
    <nav class="navbar navbar-design-step navbar-default navbar-static-top">
        <ul class="nav navbar-nav">
            <li id="nav-1" class="nav-step {{ $step == 1 ? 'active' : '' }}">
                <a href="javascript:void(0)">
                    <strong>1. เข้าสู่ระบบ <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
            <li id="nav-2" class="nav-step {{ $step == 2 ? 'active' : '' }}">
                <a href="javascript:void(0)">
                    <strong>2. กรอกรายละเอียด <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
            {{--<li id="nav-2" class="nav-step {{ $step >= 3 ? 'active' : '' }}">--}}
                {{--<a href="javascript:void(0)">--}}
                    {{--<strong>3. ยืนยันตัวตน <i class="fa fa-chevron-right"></i></strong>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li id="nav-3" class="nav-step {{ $step == 3 ? 'active' : '' }}">
                <a href="javascript:void(0)">
                    <strong>3. สำเร็จ <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
        </ul>
    </nav>
</div>