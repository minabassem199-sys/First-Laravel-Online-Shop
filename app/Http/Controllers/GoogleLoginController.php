<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    // دالة لتوجيه المستخدم إلى جوجل
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // دالة لمعالجة المعلومات العائدة من جوجل
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // ابحث عن المستخدم في قاعدة البيانات، إذا لم يكن موجوداً قم بإنشاء حساب جديد له
            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt('123') // يمكنك وضع كلمة مرور عشوائية
            ]);

            // سجل دخول المستخدم
            Auth::login($user);

            // أعد توجيهه إلى الصفحة الرئيسية
            return redirect('/products');

        } catch (\Exception $e) {
            // يمكنك معالجة أي خطأ هنا
            return redirect('/login')->with('error', 'Something went wrong!');
        }
    }
}
