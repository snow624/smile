<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'quantity'   => ['nullable','integer','min:1'],
        ]);
        $qty = $data['quantity'] ?? 1;

        try {
            $result = DB::transaction(function() use ($data,$qty){
                // 排他制御（FOR UPDATE）
                $product = Product::lockForUpdate()->find($data['product_id']);

                if ($product->stock < $qty) {
                    return ['ok'=>false, 'code'=>422, 'message'=>'在庫が不足しています。'];
                }

                // 売上
                $sale = Sale::create([
                    'product_id' => $product->id,
                ]);

                // 在庫減算
                $product->decrement('stock', $qty);

                return ['ok'=>true, 'sale_id'=>$sale->id, 'stock'=>$product->fresh()->stock];
            });

            if(!$result['ok']){
                return response()->json(['message'=>$result['message']], $result['code']);
            }

            return response()->json([
                'sale_id'   => $result['sale_id'],
                'new_stock' => $result['stock'],
            ], 200);

        } catch (\Throwable $e) {
            report($e);
            return response()->json(['message'=>'購入処理に失敗しました。'], 500);
        }
    }
}

