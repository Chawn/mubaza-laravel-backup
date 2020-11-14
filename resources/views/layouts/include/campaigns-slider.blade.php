<section id="latest-view">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>
                            <strong>{{ $title }}</strong>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                            <div class="campaigns-slider">
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
    </div>
</section>
