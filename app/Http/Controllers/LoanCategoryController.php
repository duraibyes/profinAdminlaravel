<?php

namespace App\Http\Controllers;

use App\Models\LoanCategory;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;

class LoanCategoryController extends Controller
{
    public function index(Request $request)
    {
        $title = "Loan Category";
        
        if ($request->ajax()) {
            $data = LoanCategory::select('*');
            $status = $request->get('status');
            $keywords = $request->get('search')['value'];
            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($keywords, $status) {
                    if ($status) {
                        return $query->where('loan_categories.status', '=', "$status");
                    }
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where('loan_categories.name', 'like', "%{$keywords}%")->orWhereDate("loan_categories.created_at", $date);
                    }
                })
                ->addIndexColumn()
               
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-'.(($row->status == 'active') ? 'success': 'danger').'" tooltip="Click to '.(($row->status == 'active') ? 'Active' : 'Inactive').'" onclick="return commonChangeStatus(' . $row->id . ',\''.(($row->status == 'active') ? 'inactive': 'active').'\', \'loan-category\')">'.ucfirst($row->status).'</a>';
                    return $status;
                })
                ->editColumn('icon', function ($row) {
                    if ($row->icon) {
                        
                        // print_r( $url );
                        $brandLogoPath = 'category/'.$row->icon;
                        $url = Storage::url($brandLogoPath);
                        $path = asset($url);
                        $brand_logo = '<div class="symbol symbol-45px me-5"><img src="' . $path . '" alt="" /><div>';
                    } else {
                        $path = asset('userImage/no_Image.png');
                        $brand_logo = '<div class="symbol symbol-45px me-5"><img src="' . $path . '" alt="" /><div>';
                    }
                    return $brand_logo;
                })
               
               

                ->addColumn('action', function ($row) {
                    $edit_btn = '<a href="javascript:void(0);" onclick="return  openForm(\'loan-category\',' . $row->id . ')" class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="return commonDelete(' . $row->id . ', \'loan-category\')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status', 'icon']);
            return $datatables->make(true);
        }
        $breadCrum  = array('Loan Categories');
        $title      = 'Loan Categories';
        return view('platform.loan-category.index', compact('breadCrum', 'title'));
    }

    public function modalAddEdit(Request $request)
    {

        $id                 = $request->id;
        $from               = $request->from;
        $info               = '';
        $modal_title        = 'Add Loan Category';
        if (isset($id) && !empty($id)) {
            $info           = LoanCategory::find($id);
            $modal_title    = 'Update Loan Category';
        }
        return view('platform.loan-category.add_edit_modal', compact('info', 'modal_title', 'from'));
    }

    public function saveForm(Request $request,$id = null)
    {
        
        $id             = $request->id;
        $validator      = Validator::make($request->all(), [
                                'category_name' => 'required|string|unique:loan_categories,name,' . $id . ',id,deleted_at,NULL',
                                'category_icon' => 'mimes:jpeg,png,jpg,svg|max:150',
                            ]);
        $category_id    = '';

        if ($validator->passes()) {
 
            $ins['name']          = $request->category_name;
            $ins['description']   = $request->description;
            $ins['created_by']    = Auth::id();
            $ins['slug']          = Str::slug($request->category_name);
            if($request->status == "1")
            {
                $ins['status']          = 'active';
            } else {
                $ins['status']          = 'inactive';
            }
           
            $error                  = 0;
            $info                   = LoanCategory::updateOrCreate(['id' => $id], $ins);
            $category_id               = $info->id;
            if ($request->hasFile('category_icon')) {

                $file                   = $request->file('category_icon');
                $imageName              = uniqid().$file->getClientOriginalName();
                $directoryPath          = storage_path("app/public/category");
                if (!is_dir($directoryPath)) {
                    mkdir($directoryPath, 0775, true);
                }
                // Image::make($file)->save(storage_path('app/' . $option6Path)); 
                $file->move($directoryPath, $imageName);
                $info->icon       = $imageName;
                $info->update();

            }

            $message                    = (isset($id) && !empty($id)) ? 'Updated Successfully' : 'Added successfully';

        } else {

            $error                      = 1;
            $message                    = $validator->errors()->all();

        }
        return response()->json(['error' => $error, 'message' => $message, 'category_id' => $category_id]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = LoanCategory::find($id);
        $info->delete();
        return response()->json(['message'=>"Successfully deleted Loan Category!",'status'=>1]);
    }

    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = LoanCategory::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message'=>"You changed the Loan Category status!",'status'=>1]);

    }
}
