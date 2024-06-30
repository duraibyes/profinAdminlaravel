<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $title = "Loans";
        
        if ($request->ajax()) {
            $data = Loan::with('loanCategory');
            $status = $request->get('status');
            $keywords = $request->get('search')['value'];
            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($keywords, $status) {
                    if ($status) {
                        return $query->where('loans.status', '=', "$status");
                    }
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where('loans.name', 'like', "%{$keywords}%")->orWhere('loans.email_id', 'like', "%{$keywords}%")->orWhere('loans.contact_no', 'like', "%{$keywords}%")->orWhere('loans.company_name', 'like', "%{$keywords}%")->orWhere("loans.employer_name",'like', "%{$keywords}%")->orWhereDate("loans.created_at", $date);
                    }
                })
                ->addIndexColumn()
               
                ->editColumn('status', function ($row) {
                    $statusOptions = [
                        'new' => 'New',
                        'interested' => 'Interested',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed'
                    ];
                    $status = '<select class="form-select" onChange="commonChangeStatus(' . $row->id . ', this.value, \'loans\')">';
                    foreach ($statusOptions as $value => $label) {
                        $selected = $row->status === $value ? 'selected' : '';
                        $status .= "<option value='{$value}' {$selected}>{$label}</option>";
                    }
                    $status .= '</select>';
                    return $status;
                })
               
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('loan_category', function($row) {
                    return $row->loanCategory->name ?? '';
                })

                ->addColumn('action', function ($row) {               
                    $del_btn = '<a href="javascript:void(0);" onclick="return commonDelete(' . $row->id . ', \'loans\')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $del_btn;
                })
                ->rawColumns(['action', 'status', 'icon', 'loan_category']);
            return $datatables->make(true);
        }
        $breadCrum  = array('Loans');
        $title      = 'Loans';
        return view('platform.loans.index', compact('breadCrum', 'title'));
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = Loan::find($id);
        $info->delete();
        return response()->json(['message'=>"Successfully deleted Loans!",'status'=>1]);
    }

    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = Loan::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message'=>"You changed the Loan status!",'status'=>1]);

    }

}
