<?php

// 「ProductController.php」商品の管理をする人（係員） みたいな存在。商品の一覧・登録・編集・削除などを全部担当

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Company;

// 「ProductController というクラスを作って、Controller という親クラスの機能を引き継ぐ」という。extends→意味継承
class ProductController extends Controller
{
    // 商品一覧ページを表示
    public function index(Request $request)
{
    // 商品データを取ってくるために準備（Product::query()）
    $query = Product::query()->with('company');// 会社を同時読み込み

    // 検索ワードがあれば商品名で絞り込み
    if ($request->filled('keyword')) {
        $query->where('product_name', 'like', '%'.$request->keyword.'%');
    }

    // メーカー名があればさらに絞り込み
    if ($request->filled('company_id')) {
        $query->where('company_id', $request->company_id);
    }
    // 1ページに10件だけ表示（ページ送り付き）
    $products = $query->paginate(10)->withQueryString();

    // products.index というビューに結果を渡す
    $companies = Company::orderBy('company_name')->get();

    return view('products.index', compact('products', 'companies'));
}

    // 新規作成画面を表示
    // 新しい商品を登録するための入力フォームを表示するだけ。データはまだ触らない
    public function create()
    {
        $companies = Company::orderBy('company_name')->get();
    return view('products.create', compact('companies'));
    }    

    // 登録処理を行う
    public function store(Request $request)
    {
        // 入力チェック（必須項目や数値チェック）
        $validated = $request->validate([
            'company_id'   => ['required','exists:companies,id'],
            'product_name' => ['required','string'],
            'price'        => ['required','integer'],
            'stock'        => ['required','integer'],
            'comment'      => ['nullable','string'],
            'image'        => ['nullable','image'],
        ]);
        

        // 画像があれば保存（storage/app/public/images）
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image_path'] = $path;
        }

        // 新しい商品をデータベースに登録
        Product::create($validated);

        // 登録後、一覧ページへ移動
        return redirect()->route('products.index');
    }

    // 商品詳細ページ（特定の商品1つだけを詳しく見るページ）
    // $product はURLから自動で取ってきてくれる（Laravelのルートモデルバインディング）
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
        
    // 編集画面の表示（既存の商品を編集するためのフォームを表示）
public function edit(Product $product)
{
    $companies = Company::orderBy('company_name')->get();
    return view('products.edit', compact('product','companies'));
}

// 更新処理
public function update(Request $request, Product $product)
{
    // 入力チェック
    $validated = $request->validate([
        'company_id'   => ['required','exists:companies,id'],
        'product_name' => ['required','string'],
        'price'        => ['required','integer'],
        'stock'        => ['required','integer'],
        'comment'      => ['nullable','string'],
        'image'        => ['nullable','image'],
    ]);
    

    // 新しい画像があれば保存して差し替え
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('images', 'public');
        $validated['image_path'] = $path;
    }

    // データベースの商品情報を更新
    $product->update($validated);

    // 成功メッセージを一覧ページに渡す
    return redirect()->route('products.index')->with('success', '商品を更新しました');
}

// 削除処理
public function destroy(Product $product)
{
    // $product を削除
    $product->delete();

    // 削除後、一覧ページへ（メッセージ付きで戻る）
    return redirect()->route('products.index')->with('success', '商品を削除しました');
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

