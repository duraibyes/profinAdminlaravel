<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Mail\DynamicMail;
use App\Mail\OrderMail;
use App\Models\GlobalSettings;
use App\Models\Master\EmailTemplate;
use App\Models\Master\OrderStatus;
use App\Models\Order;
use App\Models\OrderHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use Image;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::selectRaw('gbs_payments.order_id,gbs_payments.payment_no,gbs_payments.status as payment_status,gbs_orders.*,sum(gbs_order_products.quantity) as order_quantity')
                ->join('order_products', 'order_products.order_id', '=', 'orders.id')
                ->join('payments', 'payments.order_id', '=', 'orders.id')
                ->groupBy('orders.id')->orderBy('orders.id', 'desc');
            $filter_subCategory   = '';
            $status = $request->get('status');
            $keywords = $request->get('search')['value'];
            $datatables =  DataTables::of($data)
                ->filter(function ($query) use ($keywords, $status, $filter_subCategory) {
                    if ($status) {
                        return $query->where('orders.status', 'like', $status);
                    }
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where('orders.billing_name', 'like', "%{$keywords}%")
                            ->orWhere('orders.billing_email', 'like', "%{$keywords}%")
                            ->orWhere('orders.billing_mobile_no', 'like', "%{$keywords}%")
                            ->orWhere('orders.billing_address_line1', 'like', "%{$keywords}%")
                            ->orWhere('orders.billing_state', 'like', "%{$keywords}%")
                            ->orWhere('orders.status', 'like', "%{$keywords}%")
                            ->orWhereDate("orders.created_at", $date);
                    }
                })
                ->addIndexColumn()
                ->editColumn('billing_info', function ($row) {
                    $billing_info = '';
                    $billing_info .= '<div class="font-weight-bold">' . $row['billing_name'] . '</div>';
                    $billing_info .= '<div class="">' . $row['billing_email'] . ',' . $row['billing_mobile_no'] . '</div>';
                    $billing_info .= '<div class="">' . $row['billing_address_line1'] . '</div>';
                    $billing_info .= '<div class="">' . $row['billing_city'] . ','  . $row['billing_state'] . '-'  . $row['billing_post_code'] .  '</div>';

                    return $billing_info;
                })

                ->editColumn('payment_status', function ($row) {
                    return ucwords($row->payment_status);
                })
                ->editColumn('order_status', function ($row) {
                    return ucwords($row->status);
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })

                ->addColumn('action', function ($row) {
                    $view_btn = '<a href="javascript:void(0)" onclick="return viewOrder(' . $row->id . ')" class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-eye"></i>
                </a>';

                    $view_btn .= '<a href="javascript:void(0)" onclick="return openOrderStatusModal(' . $row->id . ')" class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                <i class="fa fa-edit"></i>
                            </a>';

                    $view_btn .= '<a target="_blank" href="' . asset('storage/invoice_order/' . $row->order_no . '.pdf') . '" tooltip="Download Invoice"  class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px" > 
                                    <i class="fa fa-download"></i>
                                </a>';

                    return $view_btn;
                })
                ->rawColumns(['action', 'status', 'billing_info', 'payment_status', 'order_status', 'created_at']);
            return $datatables->make(true);
        }
        $breadCrum = array('Order');
        $title      = 'Order';
        return view('platform.order.index', compact('title', 'breadCrum'));
    }

    public function orderView(Request $request)
    {
        $order_id = $request->id;
        $order_info = Order::find($order_id);
        $modal_title        = 'View Order';
        $globalInfo = GlobalSettings::first();
        $view_order = view('platform.invoice.view_invoice', compact('order_info', 'globalInfo'));
        return view('platform.order.view_modal', compact('view_order', 'modal_title'));
    }

    public function openOrderStatusModal(Request $request)
    {

        $order_id = $request->id;
        $order_status_id = $request->order_status_id;
        $modal_title        = 'Update Order Status';

        $info = Order::find($order_id);
        $order_status_info = OrderStatus::where('status', 'published')->get();

        return view('platform.order.order_status_modal', compact('info', 'order_status_info'));
    }

    public function changeOrderStatus(Request $request)
    {
        $id             = $request->id;
        $validator      = Validator::make($request->all(), [
            'order_status_id' => 'required|string',
            'description' => 'required|string',
        ]);
        if ($validator->passes()) {

            $info = Order::find($id);
            $info->notification_status = 'yes';          
            $info->order_status_id = $request->order_status_id;

            switch ($request->order_status_id) {
                case '1':
                    $action = 'Order Initiated';
                    $info->status = 'pending';
                    break;

                case '2':
                    $action = 'Order Placed';
                    $info->status = 'placed';
                    break;

                case '3':
                    $action = 'Order Cancelled';
                    $info->status = 'cancelled';
                    break;

                case '4':
                    $action = 'Order Shipped';
                    $otp = generateOtp();

                    /****
                     * 1.send email for order placed
                     * 2.send sms for notification
                     */
                    #generate invoice
                    $globalInfo = GlobalSettings::first();

                    #send mail
                    $emailTemplate = EmailTemplate::select('email_templates.*')
                        ->join('sub_categories', 'sub_categories.id', '=', 'email_templates.type_id')
                        ->where('sub_categories.slug', 'order-shipped')->first();

                    $globalInfo = GlobalSettings::first();

                    $extract = array(
                        'name' => $info->billing_name,
                        'regards' => $globalInfo->site_name,
                        'company_website' => '',
                        'company_mobile_no' => $globalInfo->site_mobile_no,
                        'company_address' => $globalInfo->address,
                        'customer_login_url' => env('WEBSITE_LOGIN_URL'),
                        'order_no' => $info->order_no
                    );
                    $templateMessage = $emailTemplate->message;
                    $templateMessage = str_replace("{", "", addslashes($templateMessage));
                    $templateMessage = str_replace("}", "", $templateMessage);
                    extract($extract);
                    eval("\$templateMessage = \"$templateMessage\";");

                    $title = $emailTemplate->title;
                    $title = str_replace("{", "", addslashes($title));
                    $title = str_replace("}", "", $title);
                    eval("\$title = \"$title\";");

                    $send_mail = new DynamicMail($templateMessage, $title);
                    // return $send_mail->render();
                    Mail::to($info->billing_email)->send($send_mail);

                    #send sms for notification
                    $sms_params = array(
                        'name' => $info->billing_name,
                        'order_no' => $info->order_no,
                        'otp' => $otp,
                        'mobile_no' => [$info->billing_mobile_no]
                    );

                    sendGBSSms('order_shipping', $sms_params);

                    $info->status = 'shipped';
                    $info->delivery_otp = $otp;

                    break;

                case '5':
                    $otp = $request->otp;
                    if( $otp ){
                        if( $info->delivery_otp != $otp ){

                            $message = ['OTP is not matched'];
                            return response()->json(['error' => '1', 'message' => $message]);
                        }
                    }
                    $action = 'Order Delivered';
                    $info->status = 'delivered';
                    /**
                     * upload image
                     */
                    if ($request->hasFile('delivery_document')) {

                        $imagName               = time() . '_' . $request->delivery_document->getClientOriginalName();
                        $directory              = 'orderDocument/' . $info->order_no . '/document';
                        Storage::deleteDirectory('public/' . $directory);

                        if (!is_dir(storage_path("app/public/orderDocument/" . $info->order_no . "/document"))) {
                            mkdir(storage_path("app/public/orderDocument/" . $info->order_no . "/document"), 0775, true);
                        }

                        $thumbnailPath          = 'public/orderDocument/' . $info->order_no . '/document/' . $imagName;
                        
                        $path = Storage::put($thumbnailPath, file_get_contents($request->delivery_document));
                        
                        $info->delivery_document = $thumbnailPath;
                    }
                    $info->otp_verified_by = auth()->user()->id;
                    $info->otp_verified_at = date('Y-m-d H:i:s');

                    #send mail
                    $emailTemplate = EmailTemplate::select('email_templates.*')
                        ->join('sub_categories', 'sub_categories.id', '=', 'email_templates.type_id')
                        ->where('sub_categories.slug', 'order-delivered')->first();

                    $globalInfo = GlobalSettings::first();
                    
                    $extract = array(
                        'name' => $info->billing_name,
                        'regards' => $globalInfo->site_name,
                        'company_website' => '',
                        'company_mobile_no' => $globalInfo->site_mobile_no,
                        'company_address' => $globalInfo->address,
                        'dynamic_content' => '',
                        'customer_login_url' => env('WEBSITE_LOGIN_URL'),
                        'order_id' => $info->order_no
                    );
                    $templateMessage = $emailTemplate->message;
                    $templateMessage = str_replace("{", "", addslashes($templateMessage));
                    $templateMessage = str_replace("}", "", $templateMessage);
                    extract($extract);
                    eval("\$templateMessage = \"$templateMessage\";");

                    $title = $emailTemplate->title;
                    $title = str_replace("{", "", addslashes($title));
                    $title = str_replace("}", "", $title);
                    eval("\$title = \"$title\";");

                    $filePath = 'storage/orderDocument/' . $info->order_no . '/document/' . $imagName;
                    $send_mail = new OrderMail($templateMessage, $title, $filePath);
                    // return $send_mail->render();
                    Mail::to($info->billing_email)->send($send_mail);

                    #send sms for notification
                    $sms_params = array(
                        'name' => $info->billing_name,
                        'order_no' => $info->order_no,
                        'tracking_url' => env('WEBSITE_LOGIN_URL'),
                        'mobile_no' => [$info->billing_mobile_no]
                    );
                    sendGBSSms('delivery_sms', $sms_params);

                    break;

                default:
                    # code...
                    break;
            }


            $info->update();

            $ins['order_id']     = $request->id;
            $ins['action']       = $action;
            $ins['description']  = $request->description;

            OrderHistory::create($ins);
            $message    = (isset($id) && !empty($id)) ? 'Updated Successfully' : 'Added successfully';
            $error = 0;
        } else {
            $error      = 1;
            $message    = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function export()
    {
        return Excel::download(new OrderExport, 'orders.xlsx');
    }
    public function orderCountGolbal()
    {
        $data = Order::selectRaw('gbs_payments.order_id,gbs_payments.payment_no,gbs_payments.status as payment_status,gbs_orders.*,sum(gbs_order_products.quantity) as order_quantity')
        ->join('order_products', 'order_products.order_id', '=', 'orders.id')
        ->join('payments', 'payments.order_id', '=', 'orders.id')->where('orders.notification_status','no')
        ->groupBy('orders.id')->get();
        $order_count=count($data);
        return $order_count;
    }

}
