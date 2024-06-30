<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Loan extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'loan_category_id',
        'company_type',
        'company_name',
        'year_of_establishment',
        'annual_term_over',
        'profession_name',
        'profession_qualification',
        'no_of_years_profession',
        'employer_name',
        'monthly_salary_range',
        'have_other_loans',
        'other_loan_emi',
        'other_loan_emi_amount',
        'employment_type',
        'monthly_salary',
        'total_work_experience',
        'property_type',
        'machinery_type',
        'loan_amount',
        'name',
        'email_id',
        'contact_no',
        'whatsapp_no',
        'alternative_no',
        'status',
        'secured',
        'mail_sent'
    ];

    protected $appends = ['createdDate'];
    
    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d/m/Y h:i A');
    }

    public function loanCategory()
    {
        return $this->belongsTo(LoanCategory::class, 'loan_category_id');
    }
}
