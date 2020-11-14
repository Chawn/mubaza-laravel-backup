<?php namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AssociateRegisterRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|min:6',
            'phone' => 'required|unique:user_profiles,phone,'.\Auth::user()->user()->id . ',id' ,
            'username' => 'required|unique:users,username,'.\Auth::user()->user()->id . ',id',
            'email' => 'required|email|unique:users,email,' .\Auth::user()->user()->id . ',id',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages() {
        return [
            'required'    => 'กรุณากรอกข้อมูล :attribute',
            'email'    => 'รูปแบบของอีเมลไๆม่ถูกต้อง',
            'username.unique' => 'นามปากกานี้มีอยู่ในระบบแล้ว',
            'phone.unique' => 'หมายเลขโทรศัพท์มีอยู่ในระบบแล้ว',
            'email.unique' => 'อีเมล์มีอยู่ในระบบแล้ว',
            'confirmed'      => 'รหัสผ่านไม่ตรงกัน',
            'password.min'      => 'รหัสผ่านต้องมีความยาวไม่น้อยกว่า :min ตัวอักษร',
            'full_name.min'      => 'ชื่อ-นามสกุล ต้องมีความยาวไม่น้อยกว่า :min ตัวอักษร',
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

}