@extends('layouts.app')

@section('title', '商品編集')
@section('heading', '商品編集画面')

@section('content')
    <div class="product-edit">
        <form class="form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <label class="form-label">商品情報ID：{{ $product->id }}</label>
            </div>
            <div class="form-row">
                <label class="form-label">商品画像：</label>
                <div>
                    @if ($product->image_path)
                        <img class="thumb-large" src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像">
                    @endif
                    <input class="form-input" type="file" name="image" accept="image/*">
                </div>
            </div>

            <div class="form-row">
                <label for="product_name" class="form-label">商品名：</label>
                <input id="product_name" class="form-input" type="text" name="product_name"
                       value="{{ old('product_name', $product->product_name) }}" required>
            </div>

            <div class="form-row">
                <label for="maker_name" class="form-label">メーカー名：</label>
                <input id="maker_name" class="form-input" type="text" name="maker_name"
                       value="{{ old('maker_name', $product->maker_name) }}" required>
            </div>

            <div class="form-row">
                <label for="price" class="form-label">価格：</label>
                <input id="price" class="form-input" type="number" name="price"
                       value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-row">
                <label for="stock" class="form-label">在庫数：</label>
                <input id="stock" class="form-input" type="number" name="stock"
                       value="{{ old('stock', $product->stock) }}" required>
            </div>

            <div class="form-row">
                <label for="comment" class="form-label">コメント：</label>
                <textarea id="comment" class="form-textarea" name="comment" rows="3">{{ old('comment', $product->comment) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-detail">更新</button>
                <a href="{{ route('products.index') }}" class="btn btn-back" role="button">戻る</a>
            </div>
        </form>
    </div>
@endsection
