<div id="modal-cart-item" class="item">
    <div class="item-detail">
        @forelse($cart->items as $item)
            <div class="media">
                <div class="media-left">
                    <a href="{{ action('CampaignController@showCampaign', $item->campaign->url) }}">
                        <img class="media-object"
                             src="{{ action('CampaignController@getFile', [$item->campaign_id, $item->campaign->frontCover()] )}}">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a
                                href="{{ action('CampaignController@showCampaign', $item->campaign->url) }}">{{ $item->campaign->title }}</a>
                    </h4>

                    <p>{{ $item->product->color->product->name  }}</p>
                    <h4 class="p-size"><span>ขนาด&nbsp;:&nbsp;</span>{{ $item->sku->size }}</h4>
                    <h4 class="p-price"><span>ราคา&nbsp;:&nbsp;</span>{{ $item->product->sell_price }}
                        <span>&nbsp;บาท</span></h4>

                    <div class="div-value">
                        <input type="number" class="form-control item-qty" data-item-id="{{ $item->id }}"
                               value="{{ $item->qty }}" min="1">
                    </div>
                    <div class="item-tools">
                        <a class="text-danger remove-item" data-item-id="{{ $item->id }}" href="javascript:void(0)"><i
                                    class="fa fa-trash-o"></i>ลบสินค้านี้</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="media">ไม่มีสินค้า</div>
        @endforelse
    </div>
</div>
<div class="subtotal">
    <div class="col-md-8 col-md-offset-4">
        <h3>จำนวน {{ $cart->totalQty() }}&nbsp;ชิ้น<span>รวม&nbsp;</span>{{ $cart->total() }}<span
                    class="baht">&nbsp;บาท</span></h3>
    </div>
</div>