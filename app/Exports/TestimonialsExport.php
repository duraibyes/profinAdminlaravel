<?php

namespace App\Exports;


use App\Models\Testimonials;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class TestimonialsExport implements FromView
{
    public function view(): View
    {
        $list = Testimonials::select('testimonials.*','users.name as users_name',DB::raw(" IF(testimonials.status = 2, 'Inactive', 'Active') as user_status"))->join('users', 'users.id', '=', 'testimonials.added_by')->get();
        // dd($list);
        return view('platform.exports.testimonials.excel', compact('list'));
    }
}
