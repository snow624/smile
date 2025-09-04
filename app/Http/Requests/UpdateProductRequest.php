<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends StoreProductRequest
{
    // そのまま継承でOK。商品名のユニーク制約等が必要ならここで上書き。
}

