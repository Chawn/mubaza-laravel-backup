<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/9/2015 AD
 * Time: 09:24
 */

namespace App\Lib\Ggseven;

use App\Order;
use App\OrderTracking;
use App\OrderTrackingType;

class OrderTrackingService
{
    private $order_model;
    private $order_tracking_model;
    private $order_tracking_type_model;

    public function __construct (Order $order_model, OrderTracking $order_tracking_model,
                                 OrderTrackingType $order_tracking_type_model)
    {
        $this->order_model = $order_model;
        $this->order_tracking_model = $order_tracking_model;
        $this->order_tracking_type_model = $order_tracking_type_model;
    }

    public function createOpen (Order $order)
    {
        return $this->addOrderTracking($order, 'open');
    }

    public function createUpdatePayment (Order $order)
    {
        return $this->addOrderTracking($order, 'updated-payment');
    }

    public function createPaid (Order $order)
    {
        return $this->addOrderTracking($order, 'paid');
    }

    public function createProducing (Order $order)
    {
        return $this->addOrderTracking($order, 'producing');
    }

    public function createProduced (Order $order)
    {
        return $this->addOrderTracking($order, 'produced');
    }

    public function createShipped (Order $order, $tracking_code)
    {
        return $this->addOrderTracking($order, 'shipped', $tracking_code);
    }

    public function createReceived (Order $order)
    {
        return $this->addOrderTracking($order, 'received');
    }

    public function createCancelByUser (Order $order)
    {
        return $this->addOrderTracking($order, 'cancel_by_user');
    }

    public function addOrderTracking (Order $order, $tracking_type_name, $detail = '')
    {
        $order_tracking = new OrderTracking([
            'order_tracking_type_id' => $this->order_tracking_type_model->type($tracking_type_name)->first()->id,
            'detail'                 => $detail
        ]);

        if ( !$order->trackings()->save($order_tracking) ) {
            return null;
        }

        return $order_tracking;
    }
}