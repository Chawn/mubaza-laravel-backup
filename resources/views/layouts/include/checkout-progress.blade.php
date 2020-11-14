<h3>สั่งซื้อสินค้า</h3>
<nav id="creat-mainnav" class="navbar navbar-design-step navbar-default navbar-static-top">
    <ul class="nav navbar-nav">
        <li id="nav-1" class="nav-step ">
            <a href="#">
                <strong>1. เลือกสินค้า <i class="fa fa-chevron-right"></i></strong>
            </a>
        </li>
        <li id="nav-2" class="nav-step {{ ($step=='checkout') ? 'active' : '' }}">
            <a href="#">
                <strong>2. บันทึกข้อมูลการจัดส่ง <i class="fa fa-chevron-right"></i></strong>
            </a>
        </li>
        <li id="nav-3" class="nav-step {{ ($step=='confirm') ? 'active' : '' }}">
            <a href="#">
                <strong>3. ยืนยันข้อมูล <i class="fa fa-chevron-right"></i></strong>
            </a>
        </li>
        <li id="nav-4" class="nav-step {{ ($step=='complete') ? 'active' : '' }}">
            <a href="#">
                <strong>4. สำเร็จ <i class="fa fa-chevron-right"></i></strong>
            </a>
        </li>
    </ul>
</nav>