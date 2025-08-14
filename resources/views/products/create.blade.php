@extends('layouts.app')

@section('title', '商品新規登録')
@section('heading', '商品新規登録画面')

@section('content')
    {{-- バリデーションエラー表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="alert-list">
                @foreach ($errors->all() as $error)
                    <li class="alert-item">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <label for="product_name" class="form-label">
                商品名 <span class="required">*</span>
            </label>
            <input
                id="product_name"
                class="form-input"
                type="text"
                name="product_name"
                value="{{ old('product_name') }}"
                required
            >
        </div>

        <div class="form-row">
            <label for="maker_name" class="form-label">
                メーカー名 <span class="required">*</span>
            </label>
            <select id="maker_name" class="form-select" name="maker_name" required>
                <option value="">▼</option>
                <option value="Coca-Cola" {{ old('maker_name') === 'Coca-Cola' ? 'selected' : '' }}>Coca-Cola</option>
                <option value="サントリー" {{ old('maker_name') === 'サントリー' ? 'selected' : '' }}>サントリー</option>
                <option value="キリン" {{ old('maker_name') === 'キリン' ? 'selected' : '' }}>キリン</option>
            </select>
        </div>

        <div class="form-row">
            <label for="price" class="form-label">
                価格 <span class="required">*</span>
            </label>
            <input
                id="price"
                class="form-input"
                type="number"
                name="price"
                value="{{ old('price') }}"
                required
            >
        </div>

        <div class="form-row">
            <label for="stock" class="form-label">
                在庫数 <span class="required">*</span>
            </label>
            <input
                id="stock"
                class="form-input"
                type="number"
                name="stock"
                value="{{ old('stock') }}"
                required
            >
        </div>

        <div class="form-row">
            <label for="comment" class="form-label">コメント</label>
            <textarea
                id="comment"
                class="form-textarea"
                name="comment"
                rows="3"
            >{{ old('comment') }}</textarea>
        </div>

        <div class="form-row">
            <label for="image" class="form-label">商品画像</label>
            <input
                id="image"
                class="form-input"
                type="file"
                name="image"
                accept="image/*"
            >
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">新規登録</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary" role="button">戻る</a>
        </div>
    </form>
@endsection
