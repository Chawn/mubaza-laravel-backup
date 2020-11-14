<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;
    public $dates = [ 'produced_at', 'approved_at' ];
    public $fillable = [
        'qty',
        'size',
        'order_id',
        'campaign_product_id',
        'price',
        'campaign_id',
        'affiliate_id',
        'click_stat_id',
        'affiliate_rate',
        'commission_status_id',
        'approved_at'
    ];

    public function scopeCommissionApproved ($query)
    {
        return $query->where('commission_status_id', CommissionStatus::approved()->first()->id);
    }

    public function scopeHasAffiliate ($query)
    {
        return $query->whereNotNull('affiliate_id');
    }

    public function scopeOwnDesign ($query, $user_id)
    {
        return $query->whereHas('campaign_product', function ($q) use ($user_id) {
            $q->whereHas('campaign', function ($q2) use ($user_id) {
                $q2->where('user_id', $user_id);
            });
        });
    }

    public function scopeOwnAffiliate ($query, $affiliate_id)
    {
        return $query->where('affiliate_id', $affiliate_id);
    }

    public function scopeDateRange ($query, $range_date)
    {
        return $query->whereHas('order', function ($q_order) use ($range_date) {
            $q_order->where('payment_status_id', PaymentStatus::paid()->id);
            $q_order->whereHas('payment', function ($q_payment) use ($range_date) {
                $q_payment->whereBetween('created_at', $range_date);
            });
        });
    }

    public function scopeApprovedRange ($query, $start, $end)
    {
        return $query->commissionApproved()->whereBetween('approved_at', [ $start, $end ]);
    }

    public function scopeRange ($query, $status_id, $start, $end)
    {
        return $query->whereBetween('approved_at', [ $start, $end ])->where('commission_status_id', $status_id);
    }

    public function scopeAffiliateId ($query, $affiliate_id)
    {
        return $query->where('affiliate_id', $affiliate_id);
    }

    public function sumAffiliateCommission ($affiliate_id, $start, $end, $only = [])
    {
        if(count($only) >0) {
            return $this->approvedRange($start, $end)
                ->affiliateId($affiliate_id)
                ->whereIn('id', $only)
                ->sum('affiliate_commission');
        } else {
            return $this->approvedRange($start, $end)
                ->affiliateId($affiliate_id)
                ->sum('affiliate_commission');
        }
    }

    public function sumAffiliateQty ($affiliate_id, $start, $end)
    {
        return $this->approvedRange($start, $end)
            ->affiliateId($affiliate_id)
            ->sum('qty');
    }

    public function sumAffiliateSell ($affiliate_id, $start, $end)
    {
        return $this->approvedRange($start, $end)
            ->affiliateId($affiliate_id)
            ->sum('price');
    }

    public function sumCreatorCommission ($campaign_ids, $start, $end, $only = [])
    {
        if(count($only) >0) {
            return $this->approvedRange($start, $end)
                ->whereIn('campaign_id', $campaign_ids)
                ->whereIn('id', $only)
                ->sum('creator_commission');
        } else {
            return $this->approvedRange($start, $end)
                ->whereIn('campaign_id', $campaign_ids)
                ->sum('creator_commission');
        }
    }
    public function sumCreatorQty ($campaign_ids, $start, $end)
    {
        return $this->approvedRange($start, $end)
            ->whereIn('campaign_id', $campaign_ids)
            ->sum('qty');
    }

    public function sumCreatorSell ($campaign_ids, $start, $end)
    {
        return $this->approvedRange($start, $end)
            ->whereIn('campaign_id', $campaign_ids)
            ->sum('price');
    }


    public function commission ()
    {
        return $this->hasOne('App\Commission');
    }

    public function total ()
    {
        return $this->qty * $this->price;
    }

    public function affiliateCommission ($affiliate_id)
    {
        if ( $this->affiliate_rate == 0 ) {
            return 0;
        }

        if($this->affiliate_id != $affiliate_id) {
            return 0;
        }

        return (($this->price * $this->affiliate_rate) / 100) * $this->qty;
    }

    public function creatorCommission ($user_id)
    {
        if($this->campaign->user_id != $user_id) {
            return 0;
        }

        return (($this->price * $this->creator_rate) / 100) * $this->qty;
    }

    public function return_item ()
    {
        return $this->hasOne(ReturnItem::class);
    }
    public function order ()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function affiliate ()
    {
        return $this->belongsTo('App\Affiliate', 'affiliate_id');
    }

    public function click_stat ()
    {
        return $this->belongsTo('App\ClickStat', 'click_stat_id');
    }

    public function commission_status ()
    {
        return $this->belongsTo('App\CommissionStatus', 'commission_status_id');
    }

    public function campaign ()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id');
    }

    public function campaign_product ()
    {
        return $this->belongsTo('App\CampaignProduct', 'campaign_product_id');
    }

    public function sku ()
    {
        return $this->belongsTo('App\ProductSku', 'product_sku_id');
    }
}
