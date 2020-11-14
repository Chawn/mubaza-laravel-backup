<section id="latest-view">
    <div class="container container-mobile">
        <div class="wrapper wrapper-white wrapper-content">
            <h4>
                <strong>
                    สินค้าที่เข้าชมล่าสุด
                </strong>
            </h4>
            <div class="row">
                <div class="col-xs-12">
                    <div class="lastview_slider row">
                        @foreach($campaigns as $campaign)
                            <div class="slide ">
                                @include('layouts.include.product-box-2',['campaign'=> $campaign])
                            </div>
                            
                        @endforeach
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>