<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_price'); // 当時の価格
            $table->unsignedInteger('amount');     // unit_price * quantity
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sales');
    }
};
