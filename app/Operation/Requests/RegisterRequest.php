<?php

namespace App\Operation\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Operation\BaseRequest;

class RegisterRequest extends FormRequest
{
    use BaseRequest;

    public function success($user, $token)
    {
        return [
            'success' => true,
            'code' => 200,
            'user' => $user,
            'token' => $token,
        ];
    }

    public function isUserExists()
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            return true;
        }
        return false;
    }

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
           // 'email' => ['required', 'email', 'unique:users'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],

            'identify' => ['required', 'integer'],
            'phone' => ['required', 'min:9'],
            'photo' => 'required',
            'device_type' => ['required', 'string'],
            'device_token' => ['required', 'string'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => ' الاسم  مطلوب',

            'email.required' => 'الايميل مطلوب',
            'email.unique' => 'الايميل موجود مسبقا',
            'email.email' => 'الايميل يجب ان يكون ايميل',

            'password.required' => 'كلمة المرور مطلوب',
            'password.min' => 'كلمة المرور اكبر من 6',

            'identify.required' => 'رقم الهوية مطلوب',
            'identify.integer' => 'رقم الهوية يجب ان يكون رقم',

            'date_of_birth.required' => 'تاريخ الميلاد  مطلوب',
        ];
    }
}