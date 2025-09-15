
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PurchaseController;


Route::post('/purchase', [PurchaseController::class, 'store']);
