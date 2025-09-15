@forelse($products as $product)
    <tr data-row-id="{{ $product->id }}">
        <td>{{ $product->id }}</td>
        <td>
            @if ($product->image_path)
                <img class="thumb" src="{{ asset('storage/' . $product->image_path) }}" alt="">
            @else
                -
            @endif
        </td>
        <td>{{ $product->product_name }}</td>
        <td>¥{{ number_format($product->price) }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ optional($product->company)->company_name }}</td>
        <td class="cell-actions">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-2">編集</a>
            <button type="button" class="btn btn-3 btn-delete" data-id="{{ $product->id }}">削除</button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7">商品がありません。</td>
    </tr>
@endforelse
