<?php

namespace App\Operation;

/**
 *  This trait to run the authorize after a valid validation
 */

trait BaseRequest
{
//     public function createToken($user)
//     {
//    //     $user->tokens()->delete();
//         $token = $user->createToken($user->email);
//         //$user->token =  $token;
//         return $token->plainTextToken;
//     }
    
    // public function success($key, $value, $message = 'success')
    // {
    //     return [
    //         'success' => true,
    //         'status' => 200,
    //         'message' => $message,
    //         $key => $value,
    //     ];
    // }

    public function failed($status = 404, $errors = [])
    {
        return [
            'success' => false,
            'status' => $status,
            'message' => 'failed',
            'errors' => $errors,
        ];
    }

    public function failure($code = 404, $errors = [])
    {
        return [
            'success' => false,
            'code' => $code,
            'errors' => $errors,
        ];
    }

    public function deleteResponse($errors = [])
    {
        return [
            'success' => true,
            'code' => 200,
            'errors' => $errors,
        ];
    }

}