<?php

namespace App\Http\Controllers;

use App\Coupons;
use App\Http\Requests\CouponRequest;
use App\redeem_coupons;
use Illuminate\Http\Request;

use App\Http\Requests;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $coupons = Coupons::orderBy('id', 'dsc')->paginate(20);
        return view('backend.coupon.index', [
            'title' => 'คูปองส่วนลดทั้งหมด',
            'coupons' => $coupons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupons/coupon_add', ['id' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Coupons::$insertRules);

        if (isset($request->id))
            $coupon = Coupons::find($request->id);
        else
            $coupon = new Coupons;

        $coupon->coupon_name = $request->coupon_name;
        $coupon->coupon_detail = $request->coupon_detail;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->coupon_discount_number = $request->coupon_discount_number;
        $coupon->coupon_discount_type = $request->coupon_discount_type;
        $coupon->coupon_condition_at_least_price_flag = isset($request->coupon_condition_at_least_price_flag) ? 'yes' : 'no';
        $coupon->coupon_condition_end_date_flag = isset($request->coupon_condition_end_date_flag) ? 'yes' : 'no';
        $coupon->coupon_condition_max_use_per_user_flag = isset($request->coupon_condition_max_use_per_user_flag) ? 'yes' : 'no';
        $coupon->coupon_condition_max_user_flag = isset($request->coupon_condition_max_user_flag) ? 'yes' : 'no';
        $coupon->coupon_condition_at_least_price = $request->coupon_condition_at_least_price;
        $coupon->coupon_condition_end_date = $request->coupon_condition_end_date;
        $coupon->coupon_condition_max_use_per_user = $request->coupon_condition_max_use_per_user;
        $coupon->coupon_condition_max_user = $request->coupon_condition_max_user;
        $coupon->status = $request->status;
        $coupon->save();
        return redirect('coupon/');
    }

    public function postStore(CouponRequest $request)
    {
        if (isset($request->id))
            $coupon = Coupons::find($request->id);
        else
            $coupon = new Coupons;

        $coupon->coupon_name = $request->coupon_name;
        $coupon->coupon_detail = $request->coupon_detail;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->coupon_discount_number = $request->coupon_discount_number;
        $coupon->coupon_discount_type = $request->coupon_discount_type;
        $coupon->coupon_condition_at_least_price_flag = isset($request->coupon_condition_at_least_price_flag) ? 'yes' : 'no';
        $coupon->coupon_condition_end_date_flag = isset($request->coupon_condition_end_date_flag) ? 'yes' : 'no';
        $coupon->coupon_condition_max_use_per_user_flag = isset($request->coupon_condition_max_use_per_user_flag) ? 'yes' : 'no';
        $coupon->coupon_condition_max_user_flag = isset($request->coupon_condition_max_user_flag) ? 'yes' : 'no';
        $coupon->coupon_condition_at_least_price = $request->coupon_condition_at_least_price;
        $coupon->coupon_condition_end_date = \Carbon::createFromFormat('d/m/Y H:i', $request->coupon_condition_end_date);
        $coupon->coupon_condition_max_use_per_user = $request->coupon_condition_max_use_per_user;
        $coupon->coupon_condition_max_user = $request->coupon_condition_max_user;
        $coupon->status = $request->status;
        $coupon->save();

        if(!$coupon) {
            return redirect()->back()->withErrors(['ไม่สามารถบันทึกข้อมูลได้']);
        }

        return redirect()->action('CouponsController@getIndex');
    }

    public function getDetail($id)
    {
        $coupon = Coupons::find($id);
        $redeemCoupons = $coupon->redeemed()->orderBy('id', 'dsc')->paginate(20);

        return view('backend.coupon.view', ['title' => 'รายละเอียดคูปอง', 'coupon' => $coupon, 'redeemCoupons' => $redeemCoupons]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id)
    {
        $coupon = Coupons::find($id);
        return view('backend.coupon.edit', ['title' => 'แก้ไข้รายละเอียดคูปอง', 'coupon' => $coupon]);
    }

    public function getDelete ($id)
    {
        $coupon = Coupons::find($id);

        if(!$coupon) {
            return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลคูปอง']);
        }

        if(!$coupon->delete()) {
            return response()->json(['success' => false, 'message' => 'ไม่สามารถลบข้อมูลได้']);
        }

        return response()->json(['success' => true, 'message' => 'ลบคูปองเรียบร้อยแล้ว']);
    }
    /*
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupons::find($id);
        return view('coupons/coupon_add', ['id' => $id, 'coupon' => $coupon]);
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
        return 'coupon/update/' . $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupons::find($id);
        $coupon->delete();
        return redirect('coupon/');
    }

    public function couponList()
    {
        $coupons = Coupons::getAll();
        return view('coupons/coupon_list', ['coupons' => $coupons]);
    }

    public function couponDetail($id)
    {
        $coupon = Coupons::find($id);
        $redeemCoupons = redeem_coupons::findByCouponId($id);

        return view('coupons/coupon_detail', ['id' => $id, 'coupon' => $coupon, 'redeemCoupons' => $redeemCoupons]);
    }
}
