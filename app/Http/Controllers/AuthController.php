<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 驗證請求的資料
        $request->validate([
            'name' => [
                'required',
                'string',
                'not_regex:/[!@#$%^&*(),.?":{}|<>]/'
            ],
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/^[A-Z][a-zA-Z0-9]*$/',
                'not_regex:/[!@#$%^&*(),.?":{}|<>]/'
            ]
        ]);

        // 創建新用戶
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // 生成 JWT
        $token = JWTAuth::fromUser($user);

        return response()->json(['message' => 'User registered successfully', 'token' => $token]);
    }

    public function login(Request $request)
    {
        // 實現登入邏輯，生成 JWT
        $credentials = $request->only('email', 'password');

        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json(compact('token'));
        }
        
        return response()->json(['error' => 'Unauthorized'], 401);
        
    }

    public function logout(Request $request)
{
    try {
        // 驗證請求中是否包含有效的令牌
        $token = JWTAuth::parseToken()->authenticate();

        // 如果令牌驗證通過，加進黑名單，使其失效
        if ($token) {
            JWTAuth::parseToken()->invalidate();
            return response()->json(['message' => 'Successfully logged out']);
        } else {
            // 如果令牌無效，返回錯誤訊息
            return response()->json(['error' => 'Invalid token'], 401);
        }
    } catch (\Exception $e) {
        // 處理可能的異常，例如令牌無效等
        return response()->json(['error' => 'Unable to logout'], 500);
    }
}
}