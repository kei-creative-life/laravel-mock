<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showSigninForm()
    {
        return view('signin');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ユーザー作成後、自動的にログイン
        $token = bin2hex(random_bytes(32));
        Cookie::queue('auth_token', $token, 60); // 60分間有効なクッキー

        return redirect()->route('dashboard')->with('success', 'アカウントが作成されました。');
    }

    // login メソッドを更新（データベースでの認証）
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $user = User::where('email', $credentials['email'])->first();
        
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = bin2hex(random_bytes(32));
            Cookie::queue('auth_token', $token, 60); // 60分間有効なクッキー
            return redirect()->route('dashboard');
        }
        
        return back()->withErrors(['email' => '認証情報が無効です。']);
    }

    public function dashboard()
    {
        if (!Cookie::has('auth_token')) {
            return redirect()->route('login');
        }
        return view('dashboard');
    }
}
