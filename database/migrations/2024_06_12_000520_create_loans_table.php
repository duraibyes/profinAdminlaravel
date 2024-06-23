<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('loan_category_id');
            $table->foreign('loan_category_id')->references('id')->on('loan_categories');
            $table->string('company_type')->nullable()->comment('hospital, diagnostic_center,manufacture,service,trading, other');
            $table->string('company_name')->nullable();
            $table->bigInteger('year_of_establishment')->nullable();
            $table->string('annual_term_over')->nullable()->comment('less than 1cr,1 to 3cr, 3 cr and above');
            $table->string('profession_name')->nullable();
            $table->string('profession_qualification')->nullable();
            $table->string('no_of_years_profession')->nullable()->comment('less than 5 year, 5 years and above');
            $table->string('employer_name')->nullable();
            $table->string('monthly_salary_range')->nullable()->comment('less than 30k,30k to 50k, 50k and above');
            $table->enum('have_other_loans', ['yes', 'no'])->nullable();
            $table->string('other_loan_emi')->nullable();
            $table->decimal('other_loan_emi_amount')->nullable();
            $table->string('employment_type')->nullable()->comment('salaried or self_employed');
            $table->decimal('monthly_salary')->nullable();
            $table->string('total_work_experience')->nullable();
            $table->string('property_type')->nullable()->comment('residential, commercial, industrial');
            $table->string('machinery_type')->nullable();
            $table->decimal('loan_amount', 12,2);
            $table->string('name');
            $table->string('email_id')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('alternative_no')->nullable();
            $table->string('status')->default('new')->comment('new,interested,cancelled,completed');
            $table->string('secured')->nullable()->comment('yes, no');
            $table->timestamp('mail_sent')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
