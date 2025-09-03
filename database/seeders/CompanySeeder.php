<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $names = ['Coca-Cola', 'サントリー', 'キリン', 'アサヒ'];
    foreach ($names as $name) {
        \App\Models\Company::firstOrCreate(['company_name' => $name]);
    }
}

}
