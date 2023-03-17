<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Operation\BaseRequest;
use App\Models\User;
use App\Operation\Requests\LoginRequest;
use App\Operation\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use BaseRequest;

    public function getAll()
    {
        $user = User::all();
        return response()->json($user, 200);
    }
    public function getDeletedUser()
    {
        $user = User::where('is_delete', true)->get();
        return response()->json($user, 200);
    }

    public function register(RegisterRequest $request)
    {
        if ($request->isUserExists()) {
            return response()->json($request->failure(422, ['Email Already Exists!']), 422);
        }
        $request['password'] = Hash::make($request['password']);
        $request['is_active'] = false;
        $request['is_delete'] = false;
        $user = User::create($request->all());
        $token = $request->createToken($user);
        return response()->json($request->success($user, $token), 200);
    }

    public function login(LoginRequest $request)
    {
     //   return response()->json($request->findUser(), $request->findUser()['code']);
        return $request->findUser();
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        if ($user == null) {
            return response()->json($this->failure(422, ['User Not Found!']), 422);
        }
        if ($user->is_delete == 1) {
            return response()->json($this->failure(422, ['User Not Found!']), 422);
        }
        $user->is_delete = 1;
        $user->save();
        return response()->json($this->deleteResponse(['User deleted successful']), 200);
    }

    public function restore($id)
    {
        $user = User::where('id', $id)->first();
        if ($user == null) {
            return response()->json($this->failure(422, ['User Not Found!']), 422);
        }
        if ($user->is_delete == 1) {
            $user->is_delete = 0;
            $user->save();
            return response()->json($this->success('user',$user), 200);
        }
        return response()->json($this->failure(422, ['User Already deleted!']), 422);
    }

    public function update()
    {
        
    }


    public function uploadFile(Request $request)
    {
        $result =$request->file('file')->store('apiDocs');
        return response()->json($result, 200);
    }


}