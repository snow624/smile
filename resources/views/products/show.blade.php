@extends('layouts.app')

@section('title', '商品詳細')
@section('heading', '商品情報詳細画面')

@section('content')
<div class="form">
    <table>
        <tr class="form-row">
            <th class="form-label">ID</th>
            <td>{{ $product->id }}</td>
        </tr>
        <tr class="form-row">
            <th class="form-label">商品画像</th>
            <td>
                @if ($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" width="100">
                @else
                    画像なし
                @endif
            </td>
        </tr>
        <tr class="form-row">
            <th class="form-label">商品名</th>
            <td>{{ $product->product_name }}</td>
        </tr>
        <tr class="form-row">
            <th class="form-label">価格</th>
            <td>¥{{ number_format($product->price) }}</td>
        </tr>
        <tr class="form-row">
            <th class="form-label">在庫数</th>
            <td>{{ $product->stock }}</td>
        </tr>

        <tr class="form-row">
            <th class="form-label">メーカー</th>
            <td>{{ $product->company->company_name ?? 'メーカー未設定' }}</td>
       </tr>

        </tr>
        <tr class="form-row">
            <th class="form-label">コメント</th>
            <td>{{ $product->comment }}</td>
        </tr>
    </table>

    <div class="btn-area">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-detail">編集</a>
        <a href="{{ route('products.index') }}" class="btn btn-back">一覧に戻る</a>
    </div>
</div>
@endsection
