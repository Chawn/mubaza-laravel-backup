<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminFormRequest extends Request
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
        if($this->has('id')) {
            return [
                'full_name' => 'required|min:6',
                'email' => 'required|email|unique:admins,email,' . $this->get('id') . ',id',
                'password' => 'required_with:change_password|min:6',
            ];
        }

        return [
            'full_name' => 'required|min:6',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
        ];
    }

    public function messages() {
        return [
            'required'    => 'กรุณากรอกข้อมูล :attribute',
            'email'    => 'รูปแบบของอีเมลไๆม่ถูกต้อง',
            'email.unique' => 'อีเมล์มีอยู่ในระบบแล้ว',
            'password.min'      => 'รหัสผ่านต้องมีความยาวไม่น้อยกว่า :min ตัวอักษร',
            'full_name.min'      => 'ชื่อ-นามสกุล ต้องมีความยาวไม่น้อยกว่า :min ตัวอักษร',
        ];
    }
}
