<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function store(PurchaseRequest $request): JsonResponse
    {
        $productId = (int)$request->product_id;
        $qty       = (int)$request->quantity;

        try {
            $result = DB::transaction(function () use ($productId, $qty) {
                $product = Product::lockForUpdate()->find($productId);
                if (!$product) {
                    return ['status' => 404, 'body' => ['message' => '商品が見つかりません。']];
                }

                $updated = Product::where('id', $productId)
                    ->where('stock', '>=', $qty)
                    ->decrement('stock', $qty);

                if ($updated === 0) {
                    return ['status' => 409, 'body' => ['message' => '在庫が不足しています。購入できません。']];
                }

                $sale = Sale::create([
                    'product_id' => $productId,
                    'quantity'   => $qty,
                    'unit_price' => $product->price,
                    'amount'     => $product->price * $qty,
                ]);

                return ['status' => 201, 'body' => [
                    'message' => '購入が完了しました。',
                    'sale_id' => $sale->id,
                ]];
            });

            return response()->json($result['body'], $result['status']);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['message' => 'サーバーエラーが発生しました。'], 500);
        }
    }
}
