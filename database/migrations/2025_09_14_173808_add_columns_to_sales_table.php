<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'quantity')) {
                $table->unsignedInteger('quantity')->after('product_id');
            }
            if (!Schema::hasColumn('sales', 'unit_price')) {
                $table->unsignedInteger('unit_price')->after('quantity');
            }
            if (!Schema::hasColumn('sales', 'amount')) {
                $table->unsignedInteger('amount')->after('unit_price');
            }
        });
    }

    public function down(): void {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['quantity','unit_price','amount']);
        });
    }
};
