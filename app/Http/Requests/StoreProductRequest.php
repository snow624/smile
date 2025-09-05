<?php

// 商品登録と編集（商品登録、編集にバリデーションを追加して、オリジナルメッセージを表示）

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'company_id'   => ['required','exists:companies,id'],
            'product_name' => ['required','string','max:255'],
            'price'        => ['required','integer','min:0'],
            'stock'        => ['required','integer','min:0'],
            'comment'      => ['nullable','string','max:2000'],
            'image'        => ['nullable','image','max:5120'], // 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.required'   => 'メーカーを選択してください。',
            'company_id.exists'     => '選択したメーカーが存在しません。',
            'product_name.required' => '商品名は必須です。',
            'product_name.max'      => '商品名は:max文字以内で入力してください。',
            'price.required'        => '価格は必須です。',
            'price.integer'         => '価格は整数で入力してください。',
            'price.min'             => '価格は0以上で入力してください。',
            'stock.required'        => '在庫数は必須です。',
            'stock.integer'         => '在庫数は整数で入力してください。',
            'stock.min'             => '在庫数は0以上で入力してください。',
            'comment.max'           => 'コメントは:max文字以内で入力してください。',
            'image.image'           => '画像ファイルを選択してください。',
            'image.max'             => '画像は:maxKB以下でアップロードしてください。',
        ];
    }

    /** 項目名（:attribute の表示名を日本語化） */
    public function attributes(): array
    {
        return [
            'company_id'   => 'メーカー',
            'product_name' => '商品名',
            'price'        => '価格',
            'stock'        => '在庫数',
            'comment'      => 'コメント',
            'image'        => '商品画像',
        ];
    }
}


