<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'image_path',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /** 検索条件 */
    public function scopeFilter(Builder $q, array $p): Builder
{
    $p = array_merge([
        'keyword'   => null,
        'company_id'=> null,
        'price_min' => null,
        'price_max' => null,
        'stock_min' => null,
        'stock_max' => null,
    ], $p);

    if ($p['keyword'] !== null && $p['keyword'] !== '') {
        $q->where('product_name', 'like', '%'.$p['keyword'].'%');
    }
    if ($p['company_id'] !== null && $p['company_id'] !== '') {
        $q->where('company_id', $p['company_id']);
    }

    // 価格レンジ
    if ($p['price_min'] !== null && $p['price_min'] !== '') {
        $q->where('price', '>=', (int)$p['price_min']);
    }
    if ($p['price_max'] !== null && $p['price_max'] !== '') {
        $q->where('price', '<=', (int)$p['price_max']);
    }

    // 在庫レンジ
    if ($p['stock_min'] !== null && $p['stock_min'] !== '') {
        $q->where('stock', '>=', (int)$p['stock_min']);
    }
    if ($p['stock_max'] !== null && $p['stock_max'] !== '') {
        $q->where('stock', '<=', (int)$p['stock_max']);
    }

    return $q;
}
    /** ソート（初期値は id の昇順） */
    public function scopeOrderForList(Builder $q, ?string $sort, ?string $dir): Builder
    {
        $sortable = ['id','product_name','price','stock'];
        $sort = in_array($sort, $sortable, true) ? $sort : 'id';
        $dir  = in_array($dir, ['asc','desc'], true) ? $dir : 'asc'; // デフォルトは昇順
        return $q->orderBy($sort, $dir);
    }
    public function sales()
{
    return $this->hasMany(Sale::class);
}

}
