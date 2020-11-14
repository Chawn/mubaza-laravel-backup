<?php

namespace App;

use Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Affiliate extends Model
{
    use SoftDeletes;

    public $fillable = [
        'user_id', 'active', 'minimum_commission', 'associate_status_id'
    ];

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return int
     */
    public function getTotalAffiliateItemQuantity (Carbon $start = null, Carbon $end = null)
    {
        $items = OrderItem::where('affiliate_id', $this->id)->commissionApproved();

        if ( $start != null && $end != null ) {
            $items = $items->whereBetween('approved_at', [ $start, $end ]);
        }

        $items = $items->get();
        $total_approved = 0;
        foreach ( $items as $item ) {
            $total_approved += $item->qty;
        }

        return $total_approved;
    }

    /**
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return int
     */
    public function getTotalAffiliateItemSell (Carbon $start = null, Carbon $end = null)
    {
        $items = OrderItem::where('affiliate_id', $this->id)->commissionApproved();

        if ( $start != null && $end != null ) {
            $items = $items->whereBetween('approved_at', [ $start, $end ]);
        }

        $items = $items->get();
        $total_sell = 0;
        foreach ( $items as $item ) {
            $total_sell += $item->total();
        }

        return $total_sell;
    }

    /**
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return int
     */
    public function getTotalAffiliateCommission (Carbon $start = null, Carbon $end = null)
    {
        $items = OrderItem::where('affiliate_id', $this->id)->commissionApproved();
        if ( $start != null && $end != null ) {
            $items = $items->whereBetween('approved_at', [ $start, $end ]);
        }

        $items = $items->get();

        $total_commission = 0;

        foreach ( $items as $item ) {
            $total_commission += $item->affiliateCommission($this->id);
        }

        return $total_commission;
    }

    public function getAllSell ($start, $end)
    {
        $user_id = $this->user->id;
        $affiliate_id = $this->id;

        $items = OrderItem::where(function ($qu) use ($user_id, $affiliate_id, $start, $end) {
            $qu->whereHas('campaign', function ($q2) use ($user_id) {
                $q2->where('user_id', $user_id);
            });
            $qu->orWhere(function ($q3) use ($affiliate_id, $start, $end) {
                $q3->where('affiliate_id', $affiliate_id);
            });
        });


        $items = $items->approvedRange($start, $end)->orderBy('campaign_id')->get();

        return $items;
    }

    public function getTotalDesignByMe ()
    {
        return OrderItem::with('campaign_product')->ownDesign($this->user->id);
    }

    public function getTotalDesignCommission (Carbon $start = null, Carbon $end = null)
    {
        $items = $this->getTotalDesignByMe();

        if ( $start != null && $end != null ) {
            $items = $items->whereBetween('approved_at', [ $start, $end ]);
        }

        $items = $items->get();
        $total_creator_commission = 0;

        foreach ( $items as $item ) {
            $total_creator_commission += $item->creator_commission;
        }

        return $total_creator_commission;
    }

    public function getTotalDesignItemQuantity (Carbon $start = null, Carbon $end = null)
    {
        $items = $this->getTotalDesignByMe();

        if ( $start != null && $end != null ) {
            $items = $items->whereBetween('approved_at', [ $start, $end ]);
        }

        $items = $items->get();
        $total_design_qty = 0;

        foreach ( $items as $item ) {
            $total_design_qty += $item->qty;
        }

        return $total_design_qty;
    }

    public function getTotalDesignItemSell (Carbon $start = null, Carbon $end = null)
    {
        $items = $this->getTotalDesignByMe();

        if ( $start != null && $end != null ) {
            $items = $items->whereBetween('approved_at', [ $start, $end ]);
        }

        $items = $items->get();
        $total_design_sell = 0;

        foreach ( $items as $item ) {
            $total_design_sell += $item->total();
        }

        return $total_design_sell;
    }

    /**
     * Get current commission rate (Percent)
     *
     * @return mixed
     */
    public function getCurrentRate ()
    {
        return config('constant.affiliate_rate');
    }

    public function setBan ()
    {
        $this->status()->associate(AssociateStatus::banned()->first());
        return $this->save();
    }

    public function setActive ()
    {
        $this->status()->associate(AssociateStatus::active()->first());
        return $this->save();
    }

    public function setDisable ()
    {
        $this->status()->associate(AssociateStatus::disable()->first());
        return $this->save();
    }

    /* Scope */

    public function scopeActive ($query)
    {
        return $query->where('active', true);
    }

    /* End scope */

    /* Related model */

    public function status ()
    {
        return $this->belongsTo(AssociateStatus::class, 'associate_status_id');
    }

    public function order_items ()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function click_stats ()
    {
        return $this->hasMany(ClickStat::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* End related model */
}
