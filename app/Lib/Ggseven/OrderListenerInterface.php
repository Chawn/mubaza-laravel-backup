<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/9/2015 AD
 * Time: 15:54
 */

namespace App\Lib\Ggseven;


interface OrderListenerInterface
{
    public function onOrderNotFound();

    public function onUpdateOrderFail ($message);
    public function onUpdatePaymentComplete($message = '');
    public function onUpdateOrderComplete ($message);
    public function onCancelPaymentComplete($message = '');
    public function onResetPaymentComplete($message = '');
    public function onReturnOrderComplete ($message = '');
    public function onUpdatePaymentFail($message = '');
    public function onCancelPaymentFail($message = '');
    public function onResetPaymentFail($message = '');
    public function onReturnOrderFail($message = '');
}