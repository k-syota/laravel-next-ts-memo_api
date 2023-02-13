<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * ログイン
     * @param LoginRequest $request
     * @return JsonResource
     */
    public function login(LoginRequest $request)
    {
        // // ログイン成功時
        // if (Auth::attempt($request->all())) {
        //     $request->session()->regenerate();
        //     return new UserResource(Auth::user());
        // }

        // // ログイン失敗時のエラーメッセージ
        // throw ValidationException::withMessages([
        //     'loginFailed' => 'IDまたはパスワードが間違っています。'
        // ]);

        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided email or password is incorrect'
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        return new UserResource(Auth::user());
        // return response(compact('user', 'token'));
    }
}
