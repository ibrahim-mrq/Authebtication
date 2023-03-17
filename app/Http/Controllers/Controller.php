<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function success($key, $value, $message = 'success')
    {
        return [
            'success' => true,
            'status' => 200,
            'message' => $message,
            $key => $value,
        ];
    }

    public function failed($status = 404, $errors = [])
    {
        return [
            'success' => false,
            'status' => $status,
            'message' => 'failed',
            'errors' => $errors,
        ];
    }

}
