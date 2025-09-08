@extends('layouts.app')

@section('title', '商品編集')
@section('heading', '商品編集画面')

@section('content')
 @if ($errors->any())
  <div class="alert alert-danger" role="alert">
    <ul class="alert-list">
      @foreach ($errors->all() as $error)
        <li class="alert-item">{{ $error }}</li>
      @endforeach
    </ul>
  </div>
 @endif
 
    <div class="product-edit">
    <form class="form" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  {{-- フォーム上部でエラー一覧 --}}
  @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      <ul class="alert-list">
        @foreach ($errors->all() as $error)
          <li class="alert-item">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="form-row">
    <label class="form-label">商品情報ID：{{ $product->id }}</label>
  </div>

  <div class="form-row">
    <label for="image" class="form-label">商品画像</label>
    <div>
      @if ($product->image_path)
        <img class="thumb-large" src="{{ asset('storage/' . $product->image_path) }}" alt="">
      @endif
      <input id="image" class="form-input" type="file" name="image" accept="image/*">
      @error('image')
        <div class="input-error">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="form-row">
    <label for="product_name" class="form-label">商品名</label>
    <input id="product_name" class="form-input" type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}">
    @error('product_name')
      <div class="input-error">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-row">
    <label for="company_id" class="form-label">メーカー名</label>
    <select id="company_id" name="company_id" class="form-select">
      <option value="">メーカーを選択</option>
      @foreach($companies as $company)
        <option value="{{ $company->id }}" {{ (string)old('company_id', $product->company_id) === (string)$company->id ? 'selected' : '' }}>
          {{ $company->company_name }}
        </option>
      @endforeach
    </select>
    @error('company_id')
      <div class="input-error">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-row">
    <label for="price" class="form-label">価格</label>
    <input id="price" class="form-input" type="number" name="price" value="{{ old('price', $product->price) }}">
    @error('price')
      <div class="input-error">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-row">
    <label for="stock" class="form-label">在庫数</label>
    <input id="stock" class="form-input" type="number" name="stock" value="{{ old('stock', $product->stock) }}">
    @error('stock')
      <div class="input-error">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-row">
    <label for="comment" class="form-label">コメント</label>
    <textarea id="comment" class="form-textarea" name="comment" rows="3">{{ old('comment', $product->comment) }}</textarea>
    @error('comment')
      <div class="input-error">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-detail">更新</button>
    <a href="{{ route('products.index') }}" class="btn btn-back">戻る</a>
  </div>
</form>

    </div>
@endsection
