<nav id="nav-filter" class="navbar navbar-primary">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <ul class="nav navbar-nav ">
                    <li>
                        <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="padding-left:0;">
                            หมวดหมู่ <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach(\App\CampaignCategory::active()->get() as $category)
                            <li><a href="{{ url('/search',  $category->name)}}">{{ $category->detail }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="active ">
                        <a href="#">
                            มาใหม่
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            แนะนำ
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            ขายดี
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <ul class="nav navbar-nav pull-right">
                    <li class="">
                        <p class="nav-title">
                            แท็กยอดนิยม:
                        </p>
                    </li>
                    <li class="">
                        <a href="#">
                            หมี
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            หัวใจ
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            เสื้อคู่
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            ความรัก
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>