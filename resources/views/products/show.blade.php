@extends('layouts.app')

@section('title', '商品詳細')
@section('heading', '商品情報詳細画面')

@section('content')
    <table class="product-detail-table">
        <tr>
            <th>ID</th>
            <td>{{ $product->id }}</td>
        </tr>
        <tr>
            <th>商品画像</th>
            <td>
                @if ($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" width="100">
                @else
                    画像なし
                @endif
            </td>
        </tr>
        <tr>
            <th>商品名</th>
            <td>{{ $product->product_name }}</td>
        </tr>
        <tr>
            <th>価格</th>
            <td>¥{{ number_format($product->price) }}</td>
        </tr>
        <tr>
            <th>在庫数</th>
            <td>{{ $product->stock }}</td>
        </tr>
        <tr>
            <th>メーカー</th>
            <td>{{ $product->maker_name }}</td>
        </tr>
        <tr>
            <th>コメント</th>
            <td>{{ $product->comment }}</td>
        </tr>
    </table>

    <div class="btn-area">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-detail">編集</a>
        <a href="{{ route('products.index') }}" class="btn btn-back">一覧に戻る</a>
    </div>
@endsection
