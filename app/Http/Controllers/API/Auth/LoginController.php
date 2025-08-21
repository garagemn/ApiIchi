<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Login\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        $credentials = ['phone' => trim($request->get('phone')), 'password' => trim($request->get('password'))];
        if(!$token = JWTAuth::attempt($credentials)) {
            return $this->sendError('Нэвтрэх нэр болон нууц үг буруу байна', '', 401);
        }

        JWTAuth::setToken($token);
        JWTAuth::invalidate(JWTAuth::getToken());

        $token = JWTAuth::fromUser(auth()->user());

        $user = Auth::user();
        $success['name'] = $user->name;
        $success['email'] = $user->email;
        $success['phone'] = $user->phone;
        $success['fcm'] = $user->device?->fcm;
        $success['token'] = $token;
        $success['expirein'] = JWTAuth::factory()->getTTL() * 60;
        return $this->sendResponse($success, 'Амжилттай нэвтэрлээ');
    }
}
