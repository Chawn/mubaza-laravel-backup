<?php
namespace App\Lib\Ggseven;

use App\Affiliate;
use App\CampaignStatus;
use App\CommissionStatus;
use App\MonthlyCommission;
use App\MonthlyCommissionStatus;
use App\NotificationType;
use App\OrderItem;
use App\Payout;
use App\PayoutStatus;
use App\ReturnItem;
use App\User;
use Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class CommissionService
{
    private $order_item_model;
    private $user_model;
    private $affiliate_model;
    private $monthly_commission_model;
    private $monthly_commission_status_model;
    private $payout_model;
    private $return_item_model;

    public function __construct (OrderItem $order_item_model,
                                 User $user_model,
                                 MonthlyCommission $monthly_commission_model,
                                 MonthlyCommissionStatus $monthly_commission_status_model,
                                 Payout $payout_model, ReturnItem $return_item_model,
                                 Affiliate $affiliate_model)
    {
        $this->order_item_model = $order_item_model;
        $this->user_model = $user_model;
        $this->affiliate_model = $affiliate_model;
        $this->monthly_commission_model = $monthly_commission_model;
        $this->monthly_commission_status_model = $monthly_commission_status_model;
        $this->payout_model = $payout_model;
        $this->return_item_model = $return_item_model;
    }

    public function all ()
    {
        return $this->order_item_model->affiliateCommission();
    }

    public function updateMinimumCommission ($affiliate_id, $amount)
    {
        $affiliate = $this->affiliate_model->whereId($affiliate_id)->first();

        if ( !$affiliate ) {
            return false;
        }

        $affiliate->minimum_commission = $amount;

        if ( !$affiliate->save() ) {
            return false;
        }

        return true;
    }

    public function allApprovedItem (User $user, $start, $end)
    {
        $user_id = $user->id;
        $affiliate_id = $user->affiliate->id;

        $items = OrderItem::where(function ($query) use ($user_id, $affiliate_id, $start, $end) {
            $query->whereHas('campaign', function ($in_query) use ($user_id) {
                $in_query->where('user_id', $user_id);
            });
            $query->orWhere(function ($in_query) use ($affiliate_id, $start, $end) {
                $in_query->where('affiliate_id', $affiliate_id);
            });
        });


        $items = $items->approvedRange($start, $end)->orderBy('campaign_id');

        return $items;
    }

    public function sumAffiliateQty (Affiliate $affiliate, $start, $end)
    {
        return $this->order_item_model->sumAffiliateQty($affiliate->id, $start, $end);
    }

    public function sumAffiliateSell (Affiliate $affiliate, $start, $end)
    {
        return $this->order_item_model->sumAffiliateSell($affiliate->id, $start, $end);
    }

    public function sumAffiliateCommission (Affiliate $affiliate, $start, $end)
    {
        return $this->order_item_model->sumAffiliateCommission($affiliate->id, $start, $end);
    }

    public function sumCreatorQty (User $user, $start, $end)
    {
        $campaign_ids = $user->campaigns()->active()->get([ 'id' ])->toArray();
        return $this->order_item_model->sumCreatorQty($campaign_ids, $start, $end);
    }

    public function sumCreatorSell (User $user, $start, $end)
    {
        $campaign_ids = $user->campaigns()->active()->get([ 'id' ])->toArray();
        return $this->order_item_model->sumCreatorSell($campaign_ids, $start, $end);
    }

    public function sumCreatorCommission (User $user, $start, $end)
    {
        $campaign_ids = $user->campaigns()->active()->get([ 'id' ])->toArray();
        return $this->order_item_model->sumCreatorCommission($campaign_ids, $start, $end);
    }

    public function sumCommission (User $user, $start, $end)
    {
        $affiliate_commission = $this->sumAffiliateCommission($user->affiliate, $start, $end);
        $creator_commission = $this->sumCreatorCommission($user, $start, $end);
        return $affiliate_commission + $creator_commission;
    }

    public function totalPendingCommission (User $user)
    {
        return $user->monthly_commissions()->approved()->sum('total');
    }

    public function totalPendingAffiliateCommission (User $user)
    {
        return $user->monthly_commissions()->approved()->sum('creator_commission');
    }

    public function totalPendingCreatorCommission (User $user)
    {
        return $user->monthly_commissions()->approved()->sum('creator_commission');
    }

    public function commissionDetail (User $user, $start, $end)
    {
        $items = $this->allApprovedItem($user, $start, $end);
        $total_affiliate_commission = $this->sumAffiliateCommission($user->affiliate, $start, $end);
        $total_creator_commission = $this->sumCreatorCommission($user, $start, $end);
        return [
            'items'                      => $items->get(),
            'total_affiliate_commission' => $total_affiliate_commission,
            'total_creator_commission'   => $total_creator_commission
        ];
    }

    public function userReadyApprove ($keyword = '')
    {
        $current_month = \Carbon::now()->startOfMonth()->startOfDay();
        $commission_start = \Carbon::now()->subMonth()->startOfMonth()->startOfDay();
        $monthly_commissions = $this->monthly_commission_model->where('start', $commission_start)->get([ 'user_id' ]);
        $except_user_ids = array_flatten($monthly_commissions->toArray());
        $users = $this->user_model->whereHas('affiliate', function ($query) {
            $query->where('active', true);
        })
            ->where('created_at', '<', $current_month)
            ->whereNotIn('id', $except_user_ids);

        if($keyword != '') {
            $users = $users->where(function($query) use($keyword) {
                $query->where('full_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('username', 'LIKE', '%' . $keyword . '%');
            });
        }

        return $users;
    }

    public function monthlyCommissionReadyApprove ()
    {
        $users = $this->userReadyApprove();
        $users = $users->paginate->filter(function ($user) {
            return $user->monthly_commissions->count() <= 0;
        });
        return $users;
    }

    public function monthlyCommissionApproved ($keyword = '')
    {
        $monthly_commissions = $this->monthly_commission_model->orderBy('id', 'dsc');

        if($keyword != '') {
            $monthly_commissions = $monthly_commissions->whereHas('user', function($query) use($keyword) {
                $query->where(function($query2) use($keyword) {
                    $query2->where('full_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('username', 'LIKE', '%' . $keyword . '%');
                });
            });
        }

        return $monthly_commissions;
    }
    public function monthlyCommissionDetail ($user_id, $monthly_commission_id, UserListenerInterface $listener)
    {
        $user = $this->user_model->whereId($user_id)->first();

        if ( !$user ) {
            return $listener->onUserNotFound();
        }

        $monthly_commission = null;
        $start = null;
        $end = null;

        if ( $monthly_commission_id != '' ) {
            $monthly_commission = $this->monthly_commission_model->whereId($monthly_commission_id)->first();
            if ( !$monthly_commission ) {
                view()->share('title', 'ไม่พบหน้าที่ต้องการ');
                abort(404);
            }
            $start = $monthly_commission->start;
            $end = $monthly_commission->end;
        } else {
            $start = \Carbon::now()->subMonth()->startOfMonth()->startOfDay();
            $end = \Carbon::now()->subMonth()->endOfMonth()->endOfDay();
        }

        $order_items = $this->allApprovedItem($user, $start, $end);
        return [ 'order_items' => $order_items->get(), 'user' => $user, 'start' => $start, 'end' => $end ];
    }

    public function createMonthlyCommission ($start, $end)
    {
        $users = $this->userReadyApprove()->get();
        try {
            \DB::beginTransaction();

            foreach ( $users as $index => $user ) {
                $monthly_commission = new MonthlyCommission([
                    'total'                        => $this->sumCommission($user, $start, $end),
                    'start'                        => $start,
                    'end'                          => $end,
                    'monthly_commission_status_id' => $this->monthly_commission_status_model->approved()->first()->id,
                    'affiliate_qty'                => $this->sumAffiliateQty($user->affiliate, $start, $end),
                    'affiliate_sell'               => $this->sumAffiliateSell($user->affiliate, $start, $end),
                    'affiliate_commission'         => $this->sumAffiliateCommission($user->affiliate, $start, $end),
                    'creator_qty'                  => $this->sumCreatorQty($user, $start, $end),
                    'creator_sell'                 => $this->sumCreatorSell($user, $start, $end),
                    'creator_commission'           => $this->sumCreatorCommission($user, $start, $end)
                ]);
                $user->monthly_commissions()->save($monthly_commission);
            }

            \DB::commit();
            return true;
        } catch ( Exception $ex ) {
            \DB::rollback();
            abort(500);
        }
    }

    public function getApprovedMonthlyCommission ()
    {
        return $this->monthly_commission_model->approved()->orderBy('id', 'start');
    }

    public function payoutApproving ($keyword = '')
    {
        $monthly_commissions = \DB::table('monthly_commissions')
            ->leftJoin('affiliates', 'monthly_commissions.user_id', '=', 'affiliates.user_id')
            ->select(\DB::raw('monthly_commissions.user_id, affiliates.minimum_commission'))
            ->havingRaw('SUM(total) > affiliates.minimum_commission')
            ->groupBy('monthly_commissions.user_id')
            ->where('monthly_commission_status_id', MonthlyCommissionStatus::approved()->first()->id);
        $user_ids = array_pluck($monthly_commissions->get(), 'user_id');

        $users = $this->user_model->whereIn('id', $user_ids);
        if($keyword != '') {
            $users = $users->where(function($query) use($keyword) {
                $query->where('full_name', 'LIKE', '%' . $keyword . '%')->orWhere('email', $keyword)->orWhere('username', $keyword);
            });
        }

        return $users;
    }

    public function payoutApproved ($keyword = '')
    {
        $payouts = $this->payout_model->with('user')->approved()->orderBy('id');
        if($keyword != '') {
            $payouts = $payouts->whereHas('user', function($query) use($keyword) {
                $query->where('full_name', 'LIKE', '%' . $keyword . '%')->orWhere('email', $keyword)->orWhere('username', $keyword);
            });
        }
        return $payouts;
    }

    public function payoutPaid ($keyword = '')
    {
        $payouts = $this->payout_model->with('user')->paid()->orderBy('id');

        if($keyword != '') {
            $payouts = $payouts->whereHas('user', function($query) use($keyword) {
                $query->where('full_name', 'LIKE', '%' . $keyword . '%')->orWhere('email', $keyword)->orWhere('username', $keyword);
            });
        }
        return $payouts;
    }

    public function createPayout ($user_id, UserListenerInterface $listener)
    {
        $user = $this->user_model->where('id', $user_id)->first();

        if ( !$user ) {
            $listener->onUserNotFound();
        }
        $monthly_commissions = $user->monthly_commissions()->approved()->get();
        if ( $user->monthly_commission )

            \DB::beginTransaction();
        try {
            $start = $monthly_commissions->first()->start;
            $end = $monthly_commissions->last()->end;
            $return_commission = $this->sumReturnItem($user, $start, $end);
            $total_commission = $this->totalPendingCommission($user);
            $payout = $this->payout_model->create([
                'user_id'          => $user->id,
                'total'            => $total_commission,
                'return_total'     => $return_commission[ 'total' ],
                'start'            => $start,
                'end'              => $end,
                'payout_status_id' => PayoutStatus::approved()->first()->id
            ]);

            if ( !$payout->monthly_commissions()->saveMany($user->monthly_commissions()->approved()->get()) ) {
                throw new Exception();
            }

            $payout->monthly_commissions()->update([
                'monthly_commission_status_id' => $this->monthly_commission_status_model->pending()->first()->id
            ]);
            if ( !$payout->save() ) {
                throw new Exception();
            }
            \DB::commit();

            return redirect()->action('BackendController@getCommissionApproved')->with([ 'message' => 'บันทึกข้อมูลการจ่ายเงินเรียบร้อย' ]);
        } catch ( Exception $ex ) {
            \DB::rollback();
            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' ]);
        }
    }

    public function updatePayoutTransferData ($payout_id, $data)
    {
        $payout = $this->payout_model->whereId($payout_id)->first();

        if ( !$payout ) {
            view()->share('title', 'ไม่พบหน้าที่ต้องการ');
            abort(404);
        }
        $data[ 'pay_on' ] = \Carbon::createFromFormat('d/m/Y H:i', $data[ 'pay_on' ]);
        \DB::beginTransaction();
        try {
            $payout->update($data);
            $payout->status()->associate(PayoutStatus::paid()->first());
            $payout->monthly_commissions()->update([ 'monthly_commission_status_id' => MonthlyCommissionStatus::paid()->first()->id ]);

            $payout->save();

            \NotificationService::create(
                $payout->user->id,
                NotificationType::ASSOCIATE,
                'คุณได้รับการจ่ายเงินส่วนแบ่งแล้วเป็นจำนวนเงิน ' . number_format($payout->pay_total, 2),
                action('AssociateController@getCurrentCommission')
            );
            \DB::commit();

            return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
        } catch ( Exception $ex ) {
            \DB::rollback();
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้ : ' . $ex->getMessage() ]);
        }
    }

    public function resetPayoutTransferData ($payout_id)
    {
        $payout = $this->payout_model->whereId($payout_id)->first();

        if ( !$payout ) {
            view()->share('title', 'ไม่พบหน้าที่ต้องการ');
            abort(404);
        }

        \DB::beginTransaction();

        try {
            $payout->update([
                'pay_total'         => null,
                'transfer_fee'      => null,
                'from_bank'         => null,
                'bank_id'           => null,
                'bank_name'         => null,
                'bank_account_name' => null,
                'pay_on'            => null,
            ]);

            $payout->status()->associate(PayoutStatus::approved()->first());
            $payout->monthly_commissions()->update([ 'monthly_commission_status_id' => MonthlyCommissionStatus::pending()->first()->id ]);
            if ( !$payout->save() ) {
                \DB::rollback();
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
            }
            \DB::commit();
            return redirect()->back()->with([ 'message' => 'ยกเลิกข้อมูลการโอนเงินเรียบร้อยแล้ว' ]);
        } catch ( Exception $ex ) {
            \DB::rollback();
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }
    }

    public function allReturnItem (User $user, $start = null, $end = null)
    {
        $user_id = $user->id;
        $affiliate_id = $user->affiliate;

        $return_items = $this->return_item_model->whereHas('order_item', function ($query) use ($user_id, $affiliate_id) {
            $query->where(function ($query) use ($user_id, $affiliate_id) {
                $query->whereHas('campaign', function ($in_query) use ($user_id) {
                    $in_query->where('user_id', $user_id);
                });
                $query->orWhere(function ($in_query) use ($affiliate_id) {
                    $in_query->where('affiliate_id', $affiliate_id);
                });
            });
        })->whereBetween('created_at', [ $start, $end ]);
        return $return_items;
    }

    public function sumReturnItem (User $user, $start, $end)
    {
        $return_items = $this->allReturnItem($user, $start, $end);
        $order_item_ids = array_flatten($return_items->get([ 'order_item_id' ])->toArray());
        $campaign_ids = $user->campaigns()->active()->get([ 'id' ])->toArray();
        $affiliate_commission = $this->order_item_model->sumAffiliateCommission($user->affiliate->id, $start, $end, $order_item_ids);
        $creator_commission = $this->order_item_model->sumCreatorCommission($campaign_ids, $start, $end, $order_item_ids);

        return [
            'affiliate_commission' => $affiliate_commission,
            'creator_commission'   => $affiliate_commission,
            'total'                => $creator_commission + $affiliate_commission,
        ];
    }

    public function affiliateProfitByDate ($affiliate_id, $select_start = null, $select_end = null)
    {
        $affiliate = Affiliate::find($affiliate_id);

        if ( !$affiliate ) {
            return false;
        }

        $start = \Carbon::now()->subMonth()->firstOfMonth();
        $end = \Carbon::now()->lastOfMonth()->endOfDay();
        if ( $select_start != null && $select_end != null ) {
            if ( \Request::get('start') == \Request::get('end') ) {
                $start = \Carbon::createFromFormat('d/m/Y', \Request::get('start'))->startOfDay();
                $end = \Carbon::createFromFormat('d/m/Y', \Request::get('end'))->endOfDay();
            } else {
                $start = \Carbon::createFromFormat('d/m/Y', \Request::get('start'))->startOfDay();
                $end = \Carbon::createFromFormat('d/m/Y', \Request::get('end'))->endOfDay();
            }
        }
        $items = [ ];
        $diff_day = $start->diffInDays($end);
        $campaign_status_approve_id = CommissionStatus::approved()->first()->id;
        for ( $i = 0; $i <= $diff_day; $i++ ) {
            $range_start = \Carbon::createFromFormat('d/m/Y', $start->format('d/m/Y'))->startOfDay();
            $range_end = \Carbon::createFromFormat('d/m/Y', $start->format('d/m/Y'))->endOfDay();

            $order_items = $affiliate->order_items()->range($campaign_status_approve_id, $range_start, $range_end)->get();

            if ( !isset($item[ $start->timestamp ]) ) {
                $items[ $start->format('d/m/Y') ] = 0;
            }
            foreach ( $order_items as $order_item ) {
                $items[ $start->format('d/m/Y') ] += $order_item->affiliate_commission;
            }
            $start->addDay();
        }
        return $items;
    }
}