<?php

namespace App\Http\Controllers;

use App\orders;
use App\redeem_coupons;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coupons;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkoutOrder(Request $request)
    {
        $msg = '';
        $totalPrice = 10000;
        $userId = 1;

        if ($request->isMethod('post')) {
            $couponCode = $request->couponCode;
            $totalPrice = $request->totalPrice;
            $userId = $request->userId;

            $coupon = Coupons::checkCode($couponCode, $userId, $totalPrice);

            if (count($coupon) > 0) {
                // correct code
                $msg = 'correct code';

                $discount = $coupon[0]->coupon_discount_number;
                $discount_type = $coupon[0]->coupon_discount_type;

                $netPrice = 0;
                if ($discount_type == 'price') {
                    // discount price
                    if ($discount > $totalPrice) {
                        $discount = $totalPrice;
                    }
                    $netPrice = $totalPrice - $discount;
                    $discount .= ' บาท';
                } else {
                    // discount percent
                    $discountPrice = ($discount * $totalPrice / 100);
                    if ($discountPrice > $totalPrice) {
                        $discountPrice = $totalPrice;
                    }
                    $netPrice = $totalPrice - $discountPrice;
                    $discount .= '%';
                }
            } else {
                // wrong code
                $msg = 'Wrong code';
            }


        }

        return view('checkout/checkout_order', [
                'discount' => @$discount,
                'discount_type' => @$discount_type,
                'totalPrice' => $totalPrice,
                'netPrice' => @$netPrice,
                'couponCode' => @$couponCode,
                'msg' => $msg,
                'userId' => $userId]
        );
    }

    public function checkoutSubmit(Request $request)
    {
        $couponCode = $request->couponCode;
        $userId = $request->userId;
        $totalPrice = $request->totalPrice;

        $coupon = false;
        if ($couponCode != '')
            $coupon = Coupons::checkCode($couponCode, $userId, $totalPrice);

        $subTotal = 0;
        $before_discount_price_total = $totalPrice;
        $couponDiscountTotal = 0;
        $netPriceTotal = $totalPrice;
        $shippingCost = 0;
        $orderStatusId = 1;
        $orderPriduceStatusId = 1;
        $shippingTypeId = 1;
        $paymentTypeId = 1;
        $paymentStatusId = 1;

        if (count($coupon) > 0 && $coupon) {
            // with coupon
            $coupon = $coupon[0];


            if ($coupon->coupon_discount_type == 'price') {
                // discount price
                $discount = $coupon->coupon_discount_number;
                if ($discount > $totalPrice) {
                    $discount = $totalPrice;
                }
                $netPriceTotal = $totalPrice - $discount;
                $couponDiscountTotal = $discount;
            } else {
                // discount percent
                $discountPrice = ($coupon->coupon_discount_number * $totalPrice / 100);
                if ($discountPrice > $totalPrice) {
                    $discountPrice = $totalPrice;
                }
                $netPriceTotal = $totalPrice - $discountPrice;
                $couponDiscountTotal = $discountPrice;
            }

            // save summary order
            $order = orders::recordOrder(
                $subTotal,
                $netPriceTotal,
                $before_discount_price_total,
                $coupon->id,
                $couponDiscountTotal,
                $shippingCost,
                $userId,
                $orderStatusId,
                $orderPriduceStatusId,
                $shippingTypeId,
                $paymentStatusId,
                $paymentTypeId
            );

            // save using the coupon
            if ($order) {
                redeem_coupons::useCoupon($coupon->id, $userId, $order->id, 'success', $request->ip());
            }
        } else {
            // without coupon
            $order = orders::recordOrder(
                $subTotal,
                $netPriceTotal,
                $before_discount_price_total,
                null,
                $couponDiscountTotal,
                $shippingCost,
                $userId,
                $orderStatusId,
                $orderPriduceStatusId,
                $shippingTypeId,
                $paymentStatusId,
                $paymentTypeId
            );
        }

        return redirect('checkout/success/order/' . $order->id);
    }

    public function checkoutSuccess($id)
    {
        $order = orders::find($id);
        return view('checkout/checkout_success', ['id' => $id, 'order' => $order]);
    }
}
