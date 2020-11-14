<div class="product-box">
    <a href="{{ action('CampaignController@showCampaign', $item->campaign->url) }}">
        <div class="product-img">
            <img src="{{ action('CampaignController@getFile', [$item->campaign_id, $item->campaign_product->getCover()]) }}">
        </div>
    </a>

    <div class="product-detail">
        <p class="text-left">
            SKU {{ str_pad($item->product_sku_id, 6, 0, STR_PAD_LEFT) }}
            <br>
        </p>
        <p class="text-left">{{ $item->sku->color->product->name }} </p>

        <p class="text-left">Color: {{ $item->sku->color->color_name }}</p>

        <p class="text-left">Size: {{ $item->sku->size }}
        </p>

        <p class="text-left">Qty: {{ $item->qty }}</p>
    </div>
</div>