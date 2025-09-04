<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['company_name','street_address','representative_name'];

    /** プルダウン用（名前順） */
    public static function options()
    {
        return static::orderBy('company_name')->get(['id','company_name']);
    }
}
