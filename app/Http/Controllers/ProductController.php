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

// store/update のシグネチャを差し替え済み（上のBのサンプル参照）
// $request->validated() でOK


// 「ProductController というクラスを作って、Controller という親クラスの機能を引き継ぐ」という。extends→意味継承
class ProductController extends Controller
{
    // 一覧
    public function index(Request $request)
    {
        $products = Product::with('company')
            ->filter($request->only('keyword','company_id'))
            ->paginate(10)
            ->withQueryString();

        $companies = Company::options();

        return view('products.index', compact('products','companies'));
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

// MEMO

// public function は、「このクラスの中に、みんなが呼び出せる動きを作りますよ」 という宣言。public はアクセス修飾子（外部からアクセスできる）。

// | メソッド    | 役割          |
// | ------- | ----------- |
// | index   | 一覧を出す       |
// | create  | 新規作成フォームを出す |
// | store   | 新規商品を登録     |
// | show    | 商品の詳細ページ    |
// | edit    | 編集フォームを出す   |
// | update  | 商品を更新       |
// | destroy | 商品を削除       |

// Laravelでは以下の名前のルールがある
// index() = 一覧表示
// create() = 新規作成画面表示
// store() = 新規保存
// edit() = 編集画面表示
// update() = 更新処理
// destroy() = 削除処理

