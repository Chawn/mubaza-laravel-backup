<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CouponRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_name' => 'required|max:255',
            'coupon_detail' => 'required',
            'coupon_code' => 'required',
            'coupon_discount_number' => 'required|numeric',
            'coupon_discount_type' => 'required',
            'coupon_condition_at_least_price' => 'required_with:coupon_condition_at_least_price_flag|numeric',
            'coupon_condition_end_date' => 'required_with:coupon_condition_end_date_flag',
            'coupon_condition_max_use_per_user' => 'required_with:coupon_condition_max_use_per_user_flag|numeric',
            'coupon_condition_max_user' => 'required_with:coupon_condition_max_user_flag|numeric',
            'status' => 'required'
        ];
    }

    public function messages ()
    {
        return [
            'coupon_name.required' => 'ต้องกรอกชื่อคูปอง',
            'coupon_detail.required' => 'ต้องกรอกรายละเอียด',
            'coupon_code.required' => 'ต้องกรอกรหัสคูปอง',
            'coupon_discount_number.required' => 'ต้องกรอกจำนวนส่วนลด',
            'coupon_discount_number.numeric' => 'จำนวนส่วนลดต้องเป็นตัวเลข',
            'coupon_discount_type.required' => 'ต้องกรอกเลือกประเภทส่วนลด',
            'status.required' => 'ต้องเลือกสถานะ',
            'coupon_condition_at_least_price.required_with' => 'ต้องกรอกราคาขั้นต่ำ',
            'coupon_condition_max_use_per_user.required_with' => 'ต้องกรอกจำนวนการใช้งานของผู้ใช้',
            'coupon_condition_max_user.required_with' => 'ต้องกรอกจำนวนสูงสุดในการใช้งาน',
            'coupon_condition_at_least_price.numeric' => 'ราคาขั้นต่ำต้องเป็นตัวเลข',
            'coupon_condition_max_use_per_user.numeric' => 'จำนวนการใช้งานของผู้ใช้ต้องเป็นตัวเลข',
            'coupon_condition_max_user.numeric' => 'จำนวนสูงสุดในการใช้งานต้องเป็นตัวเลข',
        ];
    }
}
