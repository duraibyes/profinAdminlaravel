<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanCategory;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function getLoanCategoryList(Request $request)
    {
        $data = LoanCategory::where('status', 'active')->get();
        return response()->json(['data' => $data] );
    }

    public function getLoanCategoryInfo($slug)
    {
        info( ' slug', [$slug]);
        $info = LoanCategory::where('slug', $slug)->first();
        return response()->json(['info' => $info] );
    }

    public function SubmitLoanInformation(Request $request) {
        info( 'request all ', $request->all());
        info('aith', [auth()->id()]);
        $loanCategoryId = $request->id;
        $profession_name = $request->profession ? ($request->profession === 'doctor' ? 'Doctor' : $request->profession_name ) : null;
        $profession_qualification = $request->profession_qualification ? ($request->profession_qualification === 'others' ? $request->profession_name : $request->profession_qualification ) : null;

        $ins = [
            'user_id' => auth()->id(),
            'loan_category_id' => $loanCategoryId,
            'company_type' => $request->company_type ?? null,
            'company_name' => $request->company ?? null,
            'year_of_establishment' => $request->yearEstablish ?? null,
            'annual_term_over' => $request->annualTerm ?? null,
            'profession_name' => $profession_name,
            'profession_qualification' => $profession_qualification ?? null,
            'no_of_years_profession' => $request->no_of_years_profession ?? null,
            'employer_name' => $request->employer_name ?? null,
            'monthly_salary_range' => $request->monthly_salary_range ?? null,
            'have_other_loans' => $request->have_other_loans ?? 'no',
            'other_loan_emi' => '',
            'other_loan_emi_amount' => $request->other_loan_emi_amount ?? null,
            'employment_type' => $request->employer_name ? 'salaried' : ($request->employment_type ?? null),
            'monthly_salary' => $request->monthly_salary ?? 0,
            'total_work_experience' => $request->total_work_experience ?? null,
            'property_type' => $request->property_type ? ($request->property_type === 'others' ? ($request->otherProperty ?? null): $request->property_type) : null,
            'machinery_type' => $request->machinery_type ?? null,
            'loan_amount' => $request->loanAmount,
            'name' => $request->name,
            'email_id' => $request->email,
            'contact_no' => $request->mobileNo,
            'whatsapp_no' => $request->whatsappNo,
            'alternative_no' => $request->alterNo,
            'secured' => $request->secured ?? null,
            'status' => 'new',
            // 'mail_sent' => '',
        ];

        Loan::create($ins);
        return response()->json(['error' => 0, 'message' => 'Request Has Been sent, Our Customer care will contact.'] );
    }
}
