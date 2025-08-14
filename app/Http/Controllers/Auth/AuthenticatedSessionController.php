<?php

// AuthenticatedSessionController.phpはログイン・ログアウトの処理をまとめたコントローラー

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

// Controller という親のクラスを継承（extends）
class AuthenticatedSessionController extends Controller
{
    // ログイン画面を表示（auth/login.blade.phpを呼び出す）
    public function create(): View
    {
        return view('auth.login');
    }

    // ログインボタンが押されたときの処理
    public function store(Request $request): RedirectResponse
    {
        // 入力されたメールとパスワードをチェック（空じゃないか、形式は正しいか）
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Auth::attempt() で、データベースのユーザー情報と一致するか確認。
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // 一致したらセッション（ログイン状態）を新しく作り直す→/products に移動する（商品一覧ページへ）
            return redirect()->route('products.index');
        }

        // 一致しなければ認証に失敗しましたとエラーを出して、メール入力欄だけ残したまま元の画面に戻る。
        return back()->withErrors([
            'email' => '認証に失敗しました。',
        ])->onlyInput('email');
    }

    // ログアウトボタンが押されたときの処理
    public function destroy(Request $request): RedirectResponse
    {
        // ログイン状態を解除する（logout()）
        Auth::guard('web')->logout();

        // セッション情報を完全に破棄
        $request->session()->invalidate();
        // CSRFトークンも新しく作り直す（安全のため）
        $request->session()->regenerateToken();

        // ログイン画面へ戻す
        return redirect('/login');
    }
}
