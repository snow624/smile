@extends('layouts.app')

@section('title', '新規登録')
@section('heading', 'ユーザー新規登録')

@section('content')
    {{-- エラーメッセージ（共通デザイン） --}}
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="alert-list">
                @foreach ($errors->all() as $error)
                    <li class="alert-item">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="auth">
        <form class="form" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-row">
                <label for="name" class="form-label">名前 <span class="required">*</span></label>
                <input
                    id="name"
                    class="form-input"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                >
            </div>

            <div class="form-row">
                <label for="email" class="form-label">メールアドレス <span class="required">*</span></label>
                <input
                    id="email"
                    class="form-input"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                >
            </div>

            <div class="form-row">
                <label for="password" class="form-label">パスワード <span class="required">*</span></label>
                <input
                    id="password"
                    class="form-input"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                >
            </div>

            <div class="form-row">
                <label for="password_confirmation" class="form-label">パスワード（確認） <span class="required">*</span></label>
                <input
                    id="password_confirmation"
                    class="form-input"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                >
            </div>

            <div class="form-actions">
                <a href="{{ route('login') }}" class="btn btn-secondary">ログインに戻る</a>
                <button type="submit" class="btn btn-primary">新規登録</button>
            </div>
        </form>
    </div>
@endsection
