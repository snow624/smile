@extends('layouts.app')
@section('title', '商品一覧')
@section('heading', '商品一覧画面')

@section('content')
    <form id="search-form" class="search" method="GET" action="{{ route('products.index') }}"
        data-search-url="{{ route('products.search') }}">

        <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}" class="form-label">

        <select name="company_id" class="form-label">
            <option value="">メーカーを選択</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}"
                    {{ (string) request('company_id') === (string) $company->id ? 'selected' : '' }}>
                    {{ $company->company_name }}
                </option>
            @endforeach
        </select>

        {{-- 価格範囲 --}}
        <input type="number" name="price_min" placeholder="価格(下限)" value="{{ request('price_min') }}">
        <input type="number" name="price_max" placeholder="価格(上限)" value="{{ request('price_max') }}">
        <br>
        {{-- 在庫範囲 --}}
        <input type="number" name="stock_min" placeholder="在庫(下限)" value="{{ request('stock_min') }}">
        <input type="number" name="stock_max" placeholder="在庫(上限)" value="{{ request('stock_max') }}">


        {{-- ソート保持（初期は id/asc） --}}
        <input type="hidden" name="sort" value="{{ request('sort', 'id') }}">
        <input type="hidden" name="dir" value="{{ request('dir', 'asc') }}">

        <button type="submit" class="btn btn-1">検索</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th><button type="button" class="th-sort" data-sort="id">ID</button></th>
                <th>商品画像</th>
                <th><button type="button" class="th-sort" data-sort="product_name">商品名</button></th>
                <th><button type="button" class="th-sort" data-sort="price">価格</button></th>
                <th><button type="button" class="th-sort" data-sort="stock">在庫数</button></th>
                <th>メーカー名</th>
                <th><a href="{{ route('products.create') }}" class="btn btn-new">＋ 新規登録</a></th>
            </tr>
        </thead>
        <tbody id="list-body">
            @include('products.partials.table', ['products' => $products])
        </tbody>
    </table>

    <div id="paginator">
        {{ $products->links() }}
    </div>
@endsection
