
@extends('layouts.app')

@section('title', 'ユーザーログイン画面')
@section('heading', 'ユーザーログイン画面')

@section('content')
 <div class="auth">
    <form class="form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-row">
            <label for="email" class="form-label">メールアドレス</label>
            <input id="email" class="form-input" type="email" name="email" placeholder="アドレス" required>
        </div>

        <div class="form-row">
            <label for="password" class="form-label">パスワード</label>
            <input id="password" class="form-input" type="password" name="password" placeholder="パスワード" required>
        </div>

        <div class="form-actions">
            <a href="{{ route('register') }}" class="btn btn-secondary">新規登録</a>
            <button type="submit" class="btn btn-primary">ログイン</button>
        </div>
    </form>
 </div>
@endsection

