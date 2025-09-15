<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 公開APIなら true。認可が必要なら適宜実装
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required','integer','exists:products,id'],
            'quantity'   => ['required','integer','min:1'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => '商品ID',
            'quantity'   => '購入数',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => ':attributeは必須です。',
            'product_id.integer'  => ':attributeは数値で入力してください。',
            'product_id.exists'   => '指定された:attributeは存在しません。',
            'quantity.required'   => ':attributeは必須です。',
            'quantity.integer'    => ':attributeは数値で入力してください。',
            'quantity.min'        => ':attributeは1以上で入力してください。',
        ];
    }
}
