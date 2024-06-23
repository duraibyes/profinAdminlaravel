<?php

namespace Database\Seeders;

use App\Models\LoanCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LoanCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LoanCategory::updateOrCreate(['slug' => Str::slug('Business Loan')], ['name' => 'Business Loan', 'slug' => Str::slug('Business Loan'), 'created_by' => 1, 'status' => 'active']);
        LoanCategory::updateOrCreate(['slug' => Str::slug('Professional Loan')], ['name' => 'Professional Loan', 'slug' => Str::slug('Professional Loan'), 'created_by' => 1, 'status' => 'active']);
        LoanCategory::updateOrCreate(['slug' => Str::slug('Personal Loan')], ['name' => 'Personal Loan', 'slug' => Str::slug('Personal Loan'), 'created_by' => 1, 'status' => 'active']);
        LoanCategory::updateOrCreate(['slug' => Str::slug('Home Loan')], ['name' => 'Home Loan', 'slug' => Str::slug('Home Loan'), 'created_by' => 1, 'status' => 'active']);
        LoanCategory::updateOrCreate(['slug' => Str::slug('Mortgage Loan')], ['name' => 'Mortgage Loan', 'slug' => Str::slug('Mortgage Loan'), 'created_by' => 1, 'status' => 'active']);
        LoanCategory::updateOrCreate(['slug' => Str::slug('Medical Equipment Loan')], ['name' => 'Medical Equipment Loan', 'slug' => Str::slug('Medical Equipment Loan'), 'created_by' => 1, 'status' => 'active']);
        LoanCategory::updateOrCreate(['slug' => Str::slug('Industry Machinery Loan')], ['name' => 'Industry Machinery Loan', 'slug' => Str::slug('Industry Machinery Loan'), 'created_by' => 1, 'status' => 'active']);
        LoanCategory::updateOrCreate(['slug' => Str::slug('SME Loan')], ['name' => 'SME Loan', 'slug' => Str::slug('SME Loan'), 'created_by' => 1, 'status' => 'active']);
    }
}
