<?php

namespace App\Traits;

trait BaseTrait
{
    public function getCurrentLanguage()
    {
        return app()->getLocale();
    }

    public function returnSuccess($data, $message = '')
    {
        $message = ($this->getCurrentLanguage() == "ar") ? 'نجاح' : 'success';
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    public function returnError($status = 404, $errors = [])
    {
        $message = ($this->getCurrentLanguage() == "ar") ? 'فشل' : 'failed';
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    public function createToken($user)
    {
        $token = $user->createToken($user->email);
        $user->token = $token;
        return $token->plainTextToken;
    }

    public function isExists($value)
    {
        if ($value) {
            return $value;
        }
        return null;
    }

    public function whereId($id)
    {
        return ['is_delete' => false, 'is_active' => true, 'id' => $id,];
    }

    public function whereName($name)
    {
        return ['is_delete' => false, 'is_active' => true, 'name' => $name,];
    }


}