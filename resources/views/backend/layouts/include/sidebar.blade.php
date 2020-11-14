
<!-- Side menu-->
<section class="sidebar" style="height: auto;">
    <ul class="sidebar-menu">
        
        <li>
            <a class="" href="{{ action('BackendController@getIndex') }}">
            <i class="fa fa-home"></i>หน้าหลัก
            </a>
        </li>
        
        <li class="header">การขาย</li>
        <li>
            <a class="" href="{{ action('BackendController@getOrder') }}">
                <i class="fa fa-shopping-cart"></i>
                รายการสั่งซื้อ
            </a>
        </li>
        <li>
            <a class="" href="{{ action('BackendController@getPayment') }}">
                <i class="fa fa-bell-o"></i>
                การแจ้งชำระเงิน
                <small class="label label-danger pull-right">{{ $payment_update_count }}</small>
            </a>
        </li>
        <!--
        <li class="header">CRM</li>
        <li>
            <a href="{{url('backend-crm')}}">
                <i class="fa fa-file-text-o"></i>
                เมนูทั้งหมด
            </a>
        </li>
        <li>
            <a href="{{url('backend-customer')}}">
                <i class="fa fa-users"></i>
                ลูกค้า
            </a>
        </li>
        <li>
            <a href="{{url('backend-quotation')}}">
                <i class="fa fa-file-text-o"></i>
                ใบเสนอราคา
            </a>
        </li>
        -->
        <li class="header">การผลิต</li>
        <li>
            <a href="{{ action('BackendController@getWaitingProduce') }}">
                <i class="fa  fa-clock-o"></i>
                รอดำเนินการผลิต
                <small class="label label-danger pull-right">{{ $wait_produce_count > 0 ? $wait_produce_count : '' }}</small>
            </a>
        </li>
        <li>
            <a class="active" href="{{ action('BackendController@getProducing') }}">
                <i class="glyphicon glyphicon-hourglass"></i>
                กำลังผลิต
                <small class="label label-default pull-right">{{ $producing_count > 0 ? $producing_count : '' }}</small>
            </a>
        </li>
        {{-- <li>
            <a href="{{ action('BackendController@getProduced') }}">
                <i class="glyphicon glyphicon-ok text-green"></i>
                ผลิตเสร็จแล้ว
                <small class="label label-danger pull-right">12</small>
            </a>
        </li> --}}
        
        <li>
            <a href="{{ action('BackendController@getWaitingTransport') }}">
                <i class="fa fa-cubes"></i>
                รอดำเนินการจัดส่ง
                <small class="label label-danger pull-right">{{ $wait_transport_count > 0 ? $wait_transport_count : '' }}</small>
            </a>
        </li>
        <li>
            <a href="{{ action('BackendController@getTransport') }}">
                <i class="fa fa-truck"></i>
                ประวัติการจัดส่ง
            </a>
        </li>
        <li class="header">ตรวจสอบส่วนแบ่งประจำเดือน</li>
        <li>
            <a href="{{ action('BackendController@getMonthlyCommission') }}"><i class="fa fa-clock-o"></i>รอการตรวจสอบ</a>
        </li>
        <li>
            <a href="{{ action('BackendController@getMonthlyCommissionHistory') }}"><i class="fa fa-check"></i>ตรวจสอบแล้ว</a>
        </li>
        <li class="header">รอจ่ายส่วนแบ่ง</li>
        <li>
            <a class=""href="{{ action('BackendController@getCommission') }}">
                <i class="fa fa-clock-o"></i>
                รอการตรวจสอบ
           </a>
        </li>
        <li>
            <a class=""href="{{ action('BackendController@getCommissionApproved') }}">
                <i class="fa fa-check"></i>
                อนุมัติแล้ว รอโอนเงิน
           </a>
        </li>
        <li>
            <a class=""href="{{ action('BackendController@getCommissionHistory') }}">
                <i class="fa fa-credit-card"></i> 
                ประวัติการโอนเงิน
           </a>
        </li>
        <!--
        <li class="header">คลังสินค้า</li>
        <li>
            <a class=""href="{{ action('BackendController@getStock') }}">
                <i class="fa fa-cube"></i> 
                สินค้าคงคลัง
           </a>
        </li>
        <li>
            <a class=""href="{{ action('BackendController@getPurchase') }}">
                <i class="fa fa-file-o"></i> 
                รายการจัดซื้อ
           </a>
        </li>
        
        -->
        <li class="header">คูปองส่วนลด</li>
        <li>
            <a class="" href="{{ action('BackendController@getCoupon') }}">
                <i class="fa fa-ticket"></i>
                รายการคูปองทั้งหมด
            </a>
        </li>
        <li class="header">จัดการข้อมูล</li>
        <li>
            <a class="" href="{{ action('BackendController@getCampaign') }}">
                <i class="fa fa-shirtsinbulk"></i>
                แคมเปญ
            </a>
        </li>
        <li>
            <a class="fa" href="{{ action('BackendController@getProduct') }}">
                <img src="{{ asset('images/icon/icon-t-shirt.png') }}" width="16" alt="" style="opacity:0.7;">
                &nbsp;<span>สินค้า</span>
            </a>
        </li>
        <li>
            <a class="" href="{{ action('BackendController@getUsers') }}">
                <i class="fa fa-group"></i>
                ผู้ใช้
            </a>
        </li>
        <li>
            <a class="" href="{{ action('BackendController@getAdmin') }}">
                <i class="fa fa-lock"></i>
                ผู้ดูแลระบบ
            </a>
        </li>
        <li class="header">รายงาน</li>
        <li>
            <a class="" href="http://localhost/mubaza-laravel/public/backend-account-income">
                <i class="fa fa-pie-chart"></i> 
                รายงานการขาย
            </a>
        </li>
        <li>
            <a class="" href="{{ action('BackendController@getStatistic') }}">
                <i class="fa fa-line-chart"></i>
                สถิติ
            </a>
        </li>
    </ul>
</section>
<!-- End Side menu-->