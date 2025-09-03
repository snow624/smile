<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_columns_to_companies_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('street_address')->nullable()->after('company_name');
            $table->string('representative_name')->nullable()->after('street_address');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['street_address', 'representative_name']);
        });
    }
};
