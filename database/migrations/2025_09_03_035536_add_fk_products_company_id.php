<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_fk_products_company_id.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Schema::table('products', function (Blueprint $table) {
        //     // すでに外部キーが無い前提で追加
        //     if (!Schema::hasColumn('products', 'company_id')) {
        //         $table->unsignedBigInteger('company_id')->after('id');
        //     }
        //     $table->foreign('company_id')
        //           ->references('id')->on('companies')
        //           ->onDelete('cascade'); // 会社削除時に商品も削除したい場合
        // });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            // $table->dropColumn('company_id'); // 列自体を消したいなら有効化
        });
    }
};
