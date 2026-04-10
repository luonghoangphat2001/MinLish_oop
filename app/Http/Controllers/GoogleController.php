<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Tìm user theo email, nếu không có thì tạo mới
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(24)),
                ]
            );

            // Đăng nhập user và duy trì session (remember = true)
            Auth::login($user, true);

            return redirect()->route('dashboard')->with('success', 'Chào mừng mày quay lại!');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Có lỗi rồi mày ơi: ' . $e->getMessage());
        }
    }
}
