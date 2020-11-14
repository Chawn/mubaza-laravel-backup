<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/3/2015 AD
 * Time: 14:51
 */

namespace app\Lib\Ggseven\Backend;

use App\Admin;
use App\Affiliate;
use App\Lib\Ggseven\OrderListenerInterface;
use App\NotificationType;
use App\Order;
use App\PaymentStatus;

class BackendService
{
    private $affiliate_model;
    protected $order_model;
    protected $payment_status_model;
    protected $admin_model;

    public function __construct (Affiliate $affiliate_model,
                                 Order $order_model,
                                 PaymentStatus $payment_status_model,
                                 Admin $admin_model)
    {
        $this->affiliate_model = $affiliate_model;
        $this->order_model = $order_model;
        $this->payment_status_model = $payment_status_model;
        $this->admin_model = $admin_model;
    }

    public function paymentUpdateCount ()
    {
        return $this->order_model->paymentApprove()->count('id');
    }

    public function waitProduceCount ()
    {
        return $this->order_model->paid()->waitingProduce()->count('id');
    }

    public function producingCount ()
    {
        return $this->order_model->paid()->producing()->count('id');
    }

    public function waitTransportCount ()
    {
        return $this->order_model->paid()->shipping()->count('id');
    }

    public function getAdmin ($keyword = '')
    {
        $admins = $this->admin_model->orderBy('id', 'dsc');

        if ( $keyword != '' ) {
            $admins = $admins->where('id', $keyword)
                ->orWhere('full_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                ->orWhere('username', 'LIKE', '%' . $keyword . '%');
        }

        return $admins;
    }

    public function setAdminStatus ($admin_id, $status_name)
    {
        $admin = $this->admin_model->where('id', $admin_id)->first();

        if ( !$admin ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลผู้ดูแลระบบ' ]);
        }
    }

    public function cancelProduce ($order_id, OrderListenerInterface $listener)
    {
        try {
            \DB::beginTransaction();
            $order = Order::where('payment_status_id', PaymentStatus::paid()->id)
                ->where('id', $order_id)->first();

            if ( !$order ) {
                return $listener->onOrderNotFound();
            }

            if ( !$order->cancel('ยกเลิกการผลิต') ) {
                return $listener->onUpdateOrderFail('ไม่สามารถบันทึกข้อมูลได้');
            }
            \NotificationService::create(
                $order->user->id,
                NotificationType::USER,
                'การสั่งซื้อถูกยกเลิกการผลิตสินค้า',
                action('UserController@getShowOrder', [ $order->user->getID(), $order->id ]
                ));

            \DB::commit();
            return $listener->onUpdateOrderComplete('ยกเลิกการผลิตเรียบร้อยแล้ว');
        } catch ( \Exception $ex ) {
            \DB::rollback();
            return $listener->onUpdateOrderFail('ไม่สามารถบันทึกข้อมูลได้ : ' . $ex->getMessage());
        }
    }

    public function getTransferableAffiliate ()
    {

    }
}