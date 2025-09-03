<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // productsテーブルから maker_name カラムを削除
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'maker_name')) {
                $table->dropColumn('maker_name');
            }
        });

        // companiesテーブルを作成
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // maker_nameカラムを復元
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'maker_name')) {
                $table->string('maker_name')->nullable();
            }
        });

        // companiesテーブルを削除
        Schema::dropIfExists('companies');
    }
};
