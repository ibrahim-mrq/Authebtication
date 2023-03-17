<?php

namespace App\Operation\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Operation\BaseRequest;
use App\Traits\BaseTrait;

class LoginRequest extends FormRequest
{
    use BaseRequest, BaseTrait;

    // public function success($user, $token)
    // {
    //     return [
    //         'success' => true,
    //         'code' => 200,
    //         'user' => $user,
    //         'token' => $token,
    //     ];
    // }

    public function findUser()
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            if (Hash::check($this->password, $user->password)) {
                $user->tokens()->delete();
                $token = $user->createToken($user->email)->plainTextToken;
                $response['user'] = $user;
                $response['token'] = $token;
                return $this->returnSuccess($response);
            } else {
                $response = $this->failure(422, ['password not matching!']);
                return $response;
            }
        }
        $response = $this->failure(404, ['User not found!']);
        return $response;
    }

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    { // abort(403, 'not_verified');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
}