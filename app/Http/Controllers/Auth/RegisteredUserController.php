<?php
// RegisteredUserController.phpはユーザー新規登録のためのコントローラー

// namespace（名前空間）このクラスはどこのフォルダにいるかを示す
namespace App\Http\Controllers\Auth;
// use は「住所を短縮して呼び出す」→ 以降は Auth::login() など短く書ける。
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
// RedirectResponse → 別のページへ移動（リダイレクト）する時の型宣言
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// Auth → ログインやログアウトを操作する
use Illuminate\Support\Facades\Auth;
// Hash → パスワードを暗号化する
use Illuminate\Support\Facades\Hash;
// Rules → パスワードのルール（長さや文字種など）を定義する
use Illuminate\Validation\Rules;
// View → 画面（Bladeテンプレート）を返すときの型宣言に使う
use Illuminate\View\View; 

// Controller を継承（extends）。ユーザーを新しく登録するための処理
class RegisteredUserController extends Controller
{
    // 登録画面を見せる（create()）。ユーザーが /register にアクセスしたとき新規登録ページを表示
    public function create(): View
    {
        return view('auth.register'); 
    }
    
    // store()（登録処理）
public function store(Request $request): RedirectResponse
{
    // 入力チェックを行う
    $request->validate([
        // name は必須、文字列、255文字以内
        'name' => 'required|string|max:255',
        // email は必須、メール形式、255文字以内、すでに登録済みでない
        'email' => 'required|string|email|max:255|unique:users',
        // password は必須、確認入力（password_confirmationと一致）、パスワード規定に沿う
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // 新しいユーザーをDBに保存
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        // パスワードは Hash::make() で暗号化して保存（生パスワードは絶対に保存しない）
        'password' => Hash::make($request->password),
    ]);

    // 新しいユーザーが登録された」というイベントを発生させる
    event(new Registered($user));

    // 登録直後に自動ログインさせる
    Auth::login($user); 

    // 登録完了後に商品一覧ページへ移動
    return redirect('/products'); 
}

}
