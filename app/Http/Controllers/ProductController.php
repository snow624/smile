<?php

// 「ProductController.php」商品の管理をする人（係員） みたいな存在。商品の一覧・登録・編集・削除などを全部担当

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
{
    // デフォルトは id asc
    $sort = $request->input('sort', 'id');
    $dir  = $request->input('dir',  'asc');

    $products = Product::with('company')
        ->filter($request->all())
        ->orderForList($sort, $dir)
        ->paginate(10)
        ->withQueryString();

    $companies = Company::orderBy('company_name')->get();

    return view('products.index', compact('products','companies'));
}

/** 非同期検索（部分HTMLを返す） */
public function searchAjax(Request $request)
{

    $request->validate([
        'keyword'    => ['nullable','string'],
        'company_id' => ['nullable','integer'],
        'price_min'  => ['nullable','integer'],
        'price_max'  => ['nullable','integer'],
        'stock_min'  => ['nullable','integer'],
        'stock_max'  => ['nullable','integer'],
        'sort'       => ['nullable','string'],
        'dir'        => ['nullable','in:asc,desc'],
        'page'       => ['nullable','integer'],
    ]);
// 追加チェック
if ($request->filled('price_min') && $request->filled('price_max') && $request->price_min > $request->price_max) {
    return back()->withErrors(['price_min' => '価格の下限は上限以下である必要があります'])->withInput();
}
if ($request->filled('stock_min') && $request->filled('stock_max') && $request->stock_min > $request->stock_max) {
    return back()->withErrors(['stock_min' => '在庫の下限は上限以下である必要があります'])->withInput();
}
    // 許可するソート列のホワイトリスト
    $sortable = ['id','product_name','price','stock'];
    $sort = in_array($request->input('sort'), $sortable, true) ? $request->input('sort') : 'id';
    $dir  = $request->input('dir', 'asc'); // ★デフォルト昇順

    $q = Product::with('company')->filter($request->all())->orderForList($sort, $dir);

    $products = $q->paginate(10)->withQueryString();

    return response()->json([
        'rows'  => view('products.partials.table', compact('products'))->render(),
        'pager' => view('products.partials.pager', compact('products'))->render(),
    ]);
}

// AJAX用：テーブルだけ返す
public function search(Request $request)
{
    $products = Product::with('company')
        ->filter($request->all())
        ->orderForList($request->input('sort'), $request->input('dir'))
        ->paginate(10)
        ->withQueryString();

    // tbody だけ返す
    return view('products.partials.table', compact('products'))->render();
}


    // Ajax削除
    public function ajaxDestroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            return response()->json(['ok'=>true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return response()->json(['ok'=>false,'message'=>'削除に失敗しました。'], 500);
        }
    }

    // 新規作成フォーム
    public function create()
    {
        $companies = Company::options();
        return view('products.create', compact('companies'));
    }

    // 登録
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($request, &$data) {
                if ($request->hasFile('image')) {
                    $data['image_path'] = $request->file('image')->store('images', 'public');
                }
                Product::create($data);
            });

            return redirect()->route('products.index')->with('success', '商品を登録しました');
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors(['error' => '登録に失敗しました。時間をおいて再度お試しください。'])
                         ->withInput();
        }
    }

    // 詳細
    public function show(Product $product)
    {
        $product->load('company');
        return view('products.show', compact('product'));
    }

    // 編集フォーム
    public function edit(Product $product)
    {
        $companies = Company::options();
        return view('products.edit', compact('product','companies'));
    }

    // 更新
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($request, $product, &$data) {
                if ($request->hasFile('image')) {
                    // 古い画像を削除（存在すれば）
                    if ($product->image_path) {
                        Storage::disk('public')->delete($product->image_path);
                    }
                    $data['image_path'] = $request->file('image')->store('images', 'public');
                }
                $product->update($data);
            });

            return redirect()->route('products.index')->with('success', '商品を更新しました');
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors(['error' => '更新に失敗しました。'])->withInput();
        }
    }

    // 削除
    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                if ($product->image_path) {
                    Storage::disk('public')->delete($product->image_path);
                }
                $product->delete();
            });

            return redirect()->route('products.index')->with('success', '商品を削除しました');
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors(['error' => '削除に失敗しました。']);
        }
    }
}

