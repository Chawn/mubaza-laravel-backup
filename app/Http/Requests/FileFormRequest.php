<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class FileFormRequest extends Request {

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
			'file' => 'required|mimes:jpeg,eps,png|max:5120'
		];
	}

    public function messages()
    {
        return [
            'file.mimes' => 'อนุญาติเฉพาะไฟลรูปภาพแบบ JPG และ PNG เท่านั้น'
        ];
    }

}
