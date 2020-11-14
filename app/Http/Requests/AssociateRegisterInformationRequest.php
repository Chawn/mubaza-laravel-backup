<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AssociateRegisterInformationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize ()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ()
    {
        return [
            'full_name' => 'required|min:6',
            'phone'     => 'required|min:10|unique:user_profiles,phone,' . \Auth::user()->user()->id . ',id',
            'username'  => 'required|alpha|unique:users,username,' . \Auth::user()->user()->id . ',id',
            'email'     => 'required|email|unique:users,email,' . \Auth::user()->user()->id . ',id',
            'address'   => 'required',
            'district'  => 'required',
            'province'  => 'required',
            'zipcode'   => 'required|numeric'
        ];
    }

    public function messages ()
    {
        return [
            'required'        => 'กรุณากรอกข้อมูล :attribute',
            'email'           => 'รูปแบบของอีเมลไๆม่ถูกต้อง',
            'username.alpha'  => 'นามปากกา ต้องตัวอักษรภาษาอังกฤษเท่านั้น',
            'zipcode.numeric' => 'รหัสไปรษณีย์ ต้องตัวเลขเท่านั้น',
            'username.unique' => 'นามปากกานี้มีอยู่ในระบบแล้ว',
            'phone.unique'    => 'หมายเลขโทรศัพท์มีอยู่ในระบบแล้ว',
            'phone.min'       => 'หมายเลขโทรศัพท์ต้องมีความยาวอย่างน้อย 10 ตัวอักษร',
            'email.unique'    => 'อีเมล์มีอยู่ในระบบแล้ว',
            'password.min'    => 'รหัสผ่านต้องมีความยาวไม่น้อยกว่า :min ตัวอักษร',
            'full_name.min'   => 'ชื่อ-นามสกุล ต้องมีความยาวไม่น้อยกว่า :min ตัวอักษร',
            'avatar.mimes'    => 'ประเภทของรูปโปรไฟล์ต้องเป็น JPG หรือ PNG เท่านั้น',
            'avatar.size'     => 'ขนาดของไฟล์ต้องไม่เกิน 2 mb'
        ];
    }
}
