<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/9/2015 AD
 * Time: 09:24
 */

namespace App\Lib\Ggseven;

use App\NotificationType;
use App\Order;
use App\OrderStatus;
use App\Payment;
use App\PaymentStatus;
use App\ReturnOrder;

class OrderService
{
    private $order_model;
    private $payment_model;
    private $payment_status_model;
    private $order_status_model;
    private $return_order_model;
    public function __construct (Order $order_model,
                                 Payment $payment_model,
                                 PaymentStatus $payment_status_model,
                                 OrderStatus $order_status_model, ReturnOrder $return_order_model)
    {
        $this->order_model = $order_model;
        $this->payment_model = $payment_model;
        $this->payment_status_model = $payment_status_model;
        $this->order_status_model = $order_status_model;
        $this->return_order_model = $return_order_model;
    }

    public function cancelPayment ($payment_id, OrderListenerInterface $listener)
    {
        $payment = $this->payment_model->with('order')->where('id', $payment_id)->active()->first();

        if ( !$payment ) {
            return $listener->onOrderNotFound();
        }

        if ( !$payment->cancel() ) {
            return $listener->onUpdatePaymentFail('ไม่สามารถบันทึกข้อมูลได้');
        }

        return $listener->onUpdatePaymentComplete('ยกเลิกการแจ้งชำระเงินเรียบร้อยแล้ว');
    }

    /**
     * @param                        $payment_id
     * @param OrderListenerInterface $listener
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetTransferPayment ($payment_id, OrderListenerInterface $listener)
    {
        $payment = $this->payment_model->with('order')->whereId($payment_id)->active()->first();

        if ( !$payment ) {
            return $listener->onOrderNotFound();
        }

        if ( !$payment->order->reset(true) ) {
            return $listener->onUpdatePaymentFail('ไม่สามารถบันทึกข้อมูลได้');
        }

        return $listener->onUpdatePaymentComplete('รีเซ็ตการแจ้งชำระเงินเรียบร้อยแล้ว');
    }

    public function confirmPayment ($payment_id, OrderListenerInterface $listener)
    {
        $payment = $this->payment_model->with('order')->whereId($payment_id)->active()->first();

        if ( !$payment ) {
            return $listener->onOrderNotFound();
        }

        if ( !$payment->order->setPaid(true) ) {
            return $listener->onUpdatePaymentFail('ไม่สามารถบันทึกข้อมูลได้');
        }

        if( !\OrderTrackingService::createPaid($payment->order)) {
            return $listener->onUpdatePaymentFail('ไม่สามารถบันทึกข้อมูลได้');
        }

        return $listener->onUpdatePaymentComplete('ยืนยันการแจ้งชำระเงินเรียบร้อยแล้ว');
    }

    public function cancel ($order_id, OrderListenerInterface $listener)
    {
        $order = $this->order_model->find($order_id);

        if( !$order ) {
            return $listener->onOrderNotFound();
        }

        if( !$order->cancel('ผู้ใช้งานยกเลิก') ) {
            return redirect()->back()->withErrors(['ไม่สามารถยกเลิกได้']);
        }

        if( !\OrderTrackingService::createCancelByUser($order) ) {
            return $listener->onUpdatePaymentFail('ไม่สามารถบันทึกข้อมูลได้');
        }

        \NotificationService::create(
            $order->user->id,
            NotificationType::USER,
            'การสั่งซื้อถูกยกเลิกโดยผู้ใช้งาน',
            action('UserController@getShowOrder', [ $order->user->getID(), $order->id ]
            ));

        return redirect()->back()->with(['message' => 'ยกเลิกการสั่งซื้อเสร็จเรียบร้อย'] );
    }

    public function getPayment ($status_ids = [], $keyword = '')
    {
        $payments = \DB::table('payments')
            ->leftJoin('orders', 'payments.order_id', '=', 'orders.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('payment_statuses', 'orders.payment_status_id', '=', 'payment_statuses.id')
            ->whereIn('orders.payment_status_id', $status_ids)
            ->where('payments.is_active', true);

        if ( $keyword != '' ) {
            $payments = $payments->where('orders.id', $keyword)->orWhere('users.full_name', 'LIKE', '%' . $keyword . '%');
        }

        $payments = $payments->orderBy('orders.payment_status_id')
            ->orderBy('payments.created_at', 'desc');
        $payments = $payments->select([
            'payments.id',
            'payments.total',
            'payments.to_bank',
            'payments.created_at',
            'payments.order_id',
            'orders.user_id',
            'users.full_name',
            'payment_statuses.name',
            'payment_statuses.detail',
        ]);

        return $payments;
    }

    /**
     * Make return order data
     * @param                        $order_id
     * @param                        $data
     * @param OrderListenerInterface $listener
     * @return mixed
     */
    public function returnOrder ($order_id, $data, OrderListenerInterface $listener)
    {
        try {
            \DB::beginTransaction();

            $order = $this->order_model->where('id', $order_id)->first();

            if ( !$order ) {
                return $listener->onOrderNotFound();
            }

            $data[ 'transferred_on' ] = \Carbon::createFromFormat('d/m/Y H:i', $data[ 'transferred_on' ]);

            $order->status()->associate($this->order_status_model->cancel()->first());
            $order->remark = 'ยกเลิกการสั่งซื้อและคืนเงิน';

            if ( $order->return_order ) {
                $this->return_order_model->update($data);
            } else {
                $this->return_order_model->create($data);
            }

            $order->createReturnItem();

            $order->save();

            \DB::commit();
            return $listener->onReturnOrderComplete('บันทึกข้อมูลการยกเลิกและคืนเงินเรียบร้อย');
        } catch ( \Exception $ex ) {
            \DB::rollback();
            return $listener->onReturnOrderFail('ไม่สามารถบันทึกข้อมูลได้ : ' . $ex->getMessage());
        }
    }

    /**
     * Get shipped orders
     * @param string $keyword
     * @return \Illuminate\Database\Query\Builder;
     */
    public function getShipped ($keyword = '')
    {
        $orders = $this->order_model
            ->where('payment_status_id', $this->payment_status_model->paid()->id)
            ->where('order_status_id', $this->order_status_model->status(OrderStatus::SHIPPED)->id);

        if($keyword != '') {
            $orders = $orders->whereHas('shipping_address', function($query) use($keyword) {
                $query->where('full_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('tracking_code', $keyword)
                    ->orWhere('phone', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('province', 'LIKE', '%' . $keyword . '%');
            });
        }

        $orders = $orders->orderBy('updated_at', 'desc');

        return $orders;
    }

    public function nearestPayment ($payment_id)
    {
        $payment = $this->payment_model->where('id', $payment_id)->first();

        if(!$payment) {
            return null;
        }

        $start = $payment->pay_on->subMinutes(5);
        $end = $payment->pay_on->addMinutes(5);

        $pay_min = $payment->total - 10;
        $pay_max = $payment->total + 10;

        $payments = $this->payment_model
            ->whereBetween('pay_on', [$start, $end])
            ->whereBetween('total', [$pay_min, $pay_max])
            ->active()
            ->where('id', '<>', $payment_id)
            ->get();

        return $payments;
    }

    /**
     * Get waiting to produce orders
     * @return \Illuminate\Database\Query\Builder
     */
    public function waitingProduce ()
    {
        return $this->order_model->has('shipping_address')->paid()->waitingProduce();
    }

    /**
     * Get producing status orders.
     * @return \Illuminate\Database\Query\Builder
     */
    public function producing ()
    {
        return $this->order_model->has('shipping_address')->paid()->producing();
    }
    /**
     * Get shipping status orders.
     * @return \Illuminate\Database\Query\Builder
     */
    public function shipping ()
    {
        return $this->order_model->has('shipping_address')->paid()->shipping();
    }

    /**
     * @param $order_id
     * @return array
     */
    public function prepareShirt ($order_id)
    {
        $order_items = \DB::table('order_items')
            ->leftJoin('product_skus', 'product_skus.id', '=', 'order_items.product_sku_id')
            ->leftJoin('product_colors', 'product_colors.id', '=', 'product_skus.product_color_id')
            ->rightJoin('products', 'products.id', '=', 'product_colors.product_id')
            ->whereIn('order_id', array_flatten($order_id))
            ->select([
                'product_colors.id',
                'product_colors.product_id',
                'products.name',
                'product_colors.color_name',
                'product_skus.size',
                'order_items.qty'
            ])
            ->get();

        $data = [ ];
        foreach ( $order_items as $item ) {
            if ( isset($data[ $item->product_id ][ 'colors' ][ $item->id ][ $item->size ]) ) {
                $data[ $item->product_id ][ 'colors' ][ $item->id ][ $item->size ] += $item->qty;
            } else {
                $data[ $item->product_id ][ 'colors' ][ $item->id ][ 'color_name' ] = $item->color_name;
                $data[ $item->product_id ][ 'product_name' ] = $item->name;
                $data[ $item->product_id ][ 'colors' ][ $item->id ][ $item->size ] = $item->qty;
            }
        }

        return $data;
    }
}