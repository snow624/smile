<!DOCTYPE html>
<html lang="ja">

<!-- layouts.app という共通レイアウトを使う宣言 -->
@extends('layouts.app')
<!-- ページの <title> に「」が入る -->
@section('title', '')
<!-- レイアウト側で @yield('heading') を呼び出すと「画面」が表示される -->
@section('heading', '商品一覧画面')

<!-- ここからがページの中身 -->
@section('content')
<!-- 検索フォーム -->
    <form method="GET" action="{{ route('products.index') }}" >
        <input type="text" class=keyword name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">
        <!-- value="{{ request('keyword') }}" で、検索後も入力値を保持 -->

        <!-- メーカー名のプルダウン -->
        <select name="maker_name" class=keyword>
            <option value="">メーカー名</option>
            <!-- $products の中から maker_name を取り出して .unique() で重複削除。選択中のメーカーは selected が付く -->
            @foreach($products->pluck('maker_name')->unique() as $maker)
                <option value="{{ $maker }}" {{ request('maker_name') == $maker ? 'selected' : '' }}>{{ $maker }}</option>
            @endforeach
        </select>
<!-- 検索ボタン -->
        <button type="submit" class="btn btn-1">検索</button>
    </form>

    <!-- $products が空ならメッセージ表示。商品があれば次のテーブル部分を表示 -->
    @if ($products->isEmpty())
        <p>商品がありません。</p>
    @else
    <!-- ヘッダー行は固定。 -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>
                    <th><!-- products.create ルート（商品新規登録画面）に移動 -->
                    <a href="{{ route('products.create') }}" class="btn btn-new">＋ 新規登録</a></th>
                </tr>
            </thead>
            <tbody>
              @foreach ($products as $index => $product)
              <!-- id が奇数の場合に is-odd クラスが付き -->
              <tr class=is-odd"{{ $product->id % 2 === 1 ? 'is-odd' : '' }}">
                  <td>{{ $product->id }}</td>
                  <td>
                  <!-- 商品画像があれば表示、なければ - -->
                    @if ($product->image_path)
                      <img class="thumb" src="{{ asset('storage/' . $product->image_path) }}" alt="">
                    @else
                   -
                    @endif
                  </td>

                        <!-- 商品名、価格、在庫数、メーカー名を表示 -->
                        <td>{{ $product->product_name }}</td>
                        <td>¥{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->maker_name }}</td>
                        <td>
                            
                            <div class=btn-flex>
                                <!-- 詳細ボタン -->
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-2 btn-detail">詳細</a>
                                <!-- 削除ボタン -->
                            <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-3 btn-delete" onclick="return confirm('削除しますか？')">削除</button>
                            </form>
                        </div>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Laravelのページネーションリンクを自動生成 -->
        {{ $products->links() }}
    @endif
@endsection
</body>
</html>

