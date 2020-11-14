<div id="modal-cart-item" class="item row">
    <div class="item-detail">
        @forelse($cart->items as $item)
            <div class="media">
                <div class="media-left">
                    <a href="{{ action('CampaignController@showCampaign', $item->campaign->url) }}">
                        <img class="media-object"
                             src="{{ action('CampaignController@getFile', [$item->campaign_id, $item->campaign->frontCover('image_front_small')] )}}">
                    </a>
                </div>
                <div class="media-body">
                    <p>
                        <span>
                            <a href="{{ action('CampaignController@showCampaign', $item->campaign->url) }}">
                                {{ $item->campaign->title }}
                            </a>
                        </span>
                    </p>
                    <p>
                        {{ $item->product->color->product->name  }} 
                        &nbsp;-&nbsp;
                        {{ $item->sku->color->color_name }} 
                        &nbsp;-&nbsp;
                        ไซส์ {{ $item->sku->size }}
                    </p>
                        <div class="row">
                            <div class="col-xs-4 col-sm-3">
                                <strong class="font-big">
                                    ฿{{ $item->product->sell_price }}
                                </strong>
                                &nbsp;X&nbsp;
                            </div>
                            <div class="col-xs-8 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-minus" type="button">-</button>
                                    </span>
                                    <input type="number" class="form-control item-qty no-padding add-color text-center height-25" data-item-id="{{ $item->id }}" value="{{ $item->qty }}" maxlength="5" min="1">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-plus" type="button">+</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <br>
                    <button type="button" class="pull-right remove-item " data-item-id="{{ $item->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                    

                   
                        
                    
                        
                    
                </div>
            </div>
        @empty
            <div class="media">ไม่มีสินค้า</div>
        @endforelse
    </div>
</div>
<div class="subtotal">
    <div class="col-md-12 text-right">
        <h3>
                รวม
            </span>
            <span id="total-text">
                &nbsp;{{ $cart->total() }}&nbsp;
            </span>
            <span class="baht">
                บาท
            </span>
        </h3>
    </div>
</div>