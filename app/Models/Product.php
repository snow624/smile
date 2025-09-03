<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // app/Models/Product.php
public function scopeKeyword($q, ?string $kw) {
    if (!empty($kw)) $q->where('product_name', 'like', "%{$kw}%");
}
public function scopeCompany($q, ?int $companyId) {
    if (!empty($companyId)) $q->where('company_id', $companyId);
}

}

