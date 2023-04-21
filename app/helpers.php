<?php

use App\Helpers\AccessGuard;
use App\Models\Master\Customer;
use App\Models\Order;
use App\Models\Product\Product;
use App\Models\SmsTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

if (!function_exists('gSetting')) {
    function gSetting($column)
    {
        $info = \DB::table('global_settings')->first();
        if (isset($info) && !empty($info)) {
            return $info->$column ?? '';
        } else {
            return false;
        }
    }
}

if (!function_exists('errorArrays')) {
    function errorArrays($errors)
    {
        return array_map(function ($err) {
            return '<div>' . str_replace(',', '', $err) . '</div>';
        }, $errors);
    }
}

function sendMuseeSms($sms_type, $details)
{
    $info                   = SmsTemplate::where('sms_type', $sms_type)->first();

    if (isset($info) && !empty($info)) {

        $templateMessage    = $info->template_content;
        $templateMessage    = str_replace("{", "", addslashes($templateMessage));
        $templateMessage    = str_replace("}", "", $templateMessage);

        extract($details);

        eval("\$templateMessage = \"$templateMessage\";");

        $templateMessage = str_replace("\'", "", $templateMessage);

        $params             = array(
            'entityid' => $info->peid_no,
            'tempid' => $info->tdlt_no,
            'sid'   => urlencode(current(explode(",", $info->header)))
        );

        sendSMS($mobile_no, $templateMessage, $params);
    }
}

function sendSMS($numbers, $msg, $params)
{

    extract($params);
    $uid = "museemusical";
    $pwd = urlencode("18870");
    // $entityid = "1001409933589317661";
    // $tempid = "1607100000000238808";
    $sid = urlencode("MUSEEM");

    $message = rawurlencode($msg);
    $numbers = implode(',', $numbers);
    $dtTime = date('m-d-Y h:i:s A');
    $data = "&uid=" . $uid . "&pwd=" . $pwd . "&mobile=" . $numbers . "&msg=" . $message . "&sid=" . $sid . "&type=0" . "&dtTimeNow=" . $dtTime . "&entityid=" . $entityid . "&tempid=" . $tempid;
    // dd( $data );
    $ch = curl_init("http://smsintegra.com/api/smsapi.aspx?");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    // echo $response;
    curl_close($ch);
    return $response;
}

if (!function_exists('access')) {
    function access()
    {
        return new AccessGuard();
    }
}

if (!function_exists('getAmountExclusiveTax')) {
    function getAmountExclusiveTax($productAmount, $gstPercentage)
    {

        $basePrice      = $productAmount ?? 0;
        $gstAmount      = 0;
        if ((int)$gstPercentage > 0) {
            $gstAmount = $productAmount - ($productAmount * (100 / (100 + $gstPercentage)));
            $basePrice = $productAmount - $gstAmount;
        }

        return array('basePrice' => round($basePrice), 'gstAmount' => round($gstAmount), 'tax_percentage' => $gstPercentage);
    }
}

if (!function_exists('getAmountInclusiveTax')) {
    function getAmountInclusiveTax($productAmount, $gstPercentage)
    {
        // GST = (Original Cost * GST rate%) / 100
        $mrpPrice      = $productAmount ?? 0;
        $gstAmount      = 0;
        if ((int)$gstPercentage > 0) {
            $gstAmount = ($productAmount * $gstPercentage) / 100;
            $mrpPrice = $productAmount + $gstAmount;
        }

        return array('mrpPrice' => $mrpPrice, 'gstAmount' => $gstAmount, 'tax_percentage' => $gstPercentage);
    }
}

if (!function_exists('generateProductSku')) {
    function generateProductSku($brand, $sku = '')
    {
        $countNumber    = '0000';
        if (empty($sku)) {
            $sku = 'MM-' . date('m') . '-' . strtoupper($brand) . '-' . $countNumber;
        }


        $checkProduct = Product::where('sku', $sku)->orderBy('id', 'desc')->first();
        if (isset($checkProduct) && !empty($checkProduct)) {
            $old_no = $checkProduct->sku;
            $old_no = explode("-", $old_no);

            $end = end($old_no);
            $old_no = (int)$end + 1;

            if ((4 - strlen($old_no)) > 0) {
                $new_no = '';
                for ($i = 0; $i < (4 - strlen($old_no)); $i++) {
                    $new_no .= '0';
                }
                $ord = $new_no . $old_no;

                $sku =  'MM-' . date('m') . '-' . strtoupper($brand) . '-' . $ord;
            }
        }
        return $sku;
    }
}

if (!function_exists('getCustomerNo')) {
    function getCustomerNo()
    {

        $countNumber    = '000001';
        $customer_no    = 'GBS' . $countNumber;

        $checkCustomer  = Customer::orderBy('id', 'desc')->first();

        if (isset($checkCustomer) && !empty($checkCustomer)) {
            $old_no = $checkCustomer->customer_no;
            $end = substr($old_no, 3);

            $old_no = (int)$end + 1;

            if ((6 - strlen($old_no)) > 0) {
                $new_no = '';
                for ($i = 0; $i < (6 - strlen($old_no)); $i++) {
                    $new_no .= '0';
                }
                $ord = $new_no . $old_no;

                $customer_no =  'gbs' . $ord;
            }
        }
        return $customer_no;
    }
}

if (!function_exists('getOrderNo')) {
    function getOrderNo()
    {

        $countNumber    = '000001';
        $order_no    = 'MM-ORD-' . $countNumber;

        $checkCustomer  = Order::orderBy('id', 'desc')->first();

        if (isset($checkCustomer) && !empty($checkCustomer)) {
            $old_no = $checkCustomer->order_no;
            $old_no = explode("-", $old_no);
            $end = end($old_no);
            $old_no = $end + 1;

            if ((6 - strlen($old_no)) > 0) {
                $new_no = '';
                for ($i = 0; $i < (6 - strlen($old_no)); $i++) {
                    $new_no .= '0';
                }
                $ord = $new_no . $old_no;

                $order_no =  'MM-ORD-' . $ord;
            }
        }

        return $order_no;
    }
}

if (!function_exists('percentage')) {
    function percentage($amount, $percent)
    {
        return $amount - ($amount * ($percent / 100));
    }
}

if (!function_exists('percentageAmountOnly')) {
    function percentageAmountOnly($amount, $percent)
    {
        return ($amount * ($percent / 100));
    }
}

if (!function_exists('getSaleProductPrices')) {
    function getSaleProductPrices($productsObjects, $couponsInfo)
    {

        $strike_rate    = 0;
        $price          = $productsObjects->price;
        $today          = date('Y-m-d');
        /****
         * 1.check product discount is applied via product add/edit
         * 2.check overall discount is applied for product category
         */
        $has_discount       = 'no';
        #condition 1:
        if ($today >= $productsObjects->sale_start_date && $today <= $productsObjects->sale_end_date) {
            $strike_rate    = $productsObjects->price;
            $price          = $productsObjects->sale_price;
            $has_discount       = 'yes';
        }

        #condition 2:
        if ($couponsInfo->quantity > $couponsInfo->used_quantity) {

            #check product amount greater than minimum order value
            if ($couponsInfo->minimum_order_value <= $price) {
                #then do percentage or fixed amount discount
                switch ($couponsInfo->calculate_type) {
                    case 'percentage':
                        $strike_rate    = $price;
                        $price          = percentage($price, $couponsInfo->calculate_value);
                        $has_discount   = 'yes';
                        break;
                    case 'fixed_amount':
                        $strike_rate    = $price;
                        $price          = $price - $couponsInfo->calculate_value;
                        $has_discount   = 'yes';
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }

        return array('strike_rate' => $strike_rate, 'price' => $price, 'has_discount' => $has_discount);
    }
}

function getProductApiData($product_data)
{

    $category               = $product_data->productCategory;
    $pro                    = [];
    $pro['id']              = $product_data->id;
    $pro['product_name']    = $product_data->product_name;
    $pro['category_name']   = $category->name ?? '';
    $pro['brand_name']      = $product_data->productBrand->brand_name ?? '';
    $pro['hsn_code']        = $product_data->hsn_code;
    $pro['product_url']     = $product_data->product_url;
    $pro['sku']             = $product_data->sku;
    $pro['has_video_shopping'] = $product_data->has_video_shopping;
    $pro['stock_status']    = $product_data->stock_status;
    $pro['is_featured']     = $product_data->is_featured;
    $pro['is_best_selling'] = $product_data->is_best_selling;
    $pro['is_new']          = $product_data->is_new;
    $pro['price']           = $product_data->mrp;
    $pro['strike_price']    = $product_data->strike_price;
    $pro['save_price']      = $product_data->strike_price - $product_data->mrp;
    $pro['discount_percentage'] = abs($product_data->discount_percentage);
    $pro['image']           = $product_data->base_image;
    $pro['max_quantity']    = $product_data->quantity;

    $imagePath              = $product_data->base_image;

    if (!Storage::exists($imagePath)) {
        $path               = asset('userImage/no_Image.jpg');
    } else {
        $url                = Storage::url($imagePath);
        $path               = asset($url);
    }

    $pro['image']                   = $path;

    $pro['description']             = $product_data->description;
    // $pro['technical_information']   = $product_data->technical_information;
    // $pro['feature_information']     = $product_data->feature_information;
    // $pro['specification']           = $product_data->specification;
    // $pro['gallery']                 = $product_data->productImages;

    if (isset($product_data->productImages) && !empty($product_data->productImages)) {
        foreach ($product_data->productImages as $att) {

            $gallery_url            = Storage::url($att->gallery_path);
            $path                   = asset($gallery_url);

            $pro['gallery'][] = $path;
        }
    }

    $pro['attributes']              = $product_data->productAttributes;
    $related_arr                    = [];
    if (isset($product_data->productRelated) && !empty($product_data->productRelated)) {
        foreach ($product_data->productRelated as $related) {

            $productInfo            = Product::find($related->to_product_id);
            $category               = $productInfo->productCategory;
            $salePrices1            = getProductPrice($productInfo);

            $tmp2                    = [];
            $tmp2['id']              = $productInfo->id;
            $tmp2['product_name']    = $productInfo->product_name;
            $tmp2['category_name']   = $category->name ?? '';
            $tmp2['brand_name']      = $productInfo->productBrand->brand_name ?? '';
            $tmp2['hsn_code']        = $productInfo->hsn_code;
            $tmp2['product_url']     = $productInfo->product_url;
            $tmp2['sku']             = $productInfo->sku;
            $tmp2['has_video_shopping'] = $productInfo->has_video_shopping;
            $tmp2['stock_status']    = $productInfo->stock_status;
            $tmp2['is_featured']     = $productInfo->is_featured;
            $tmp2['is_best_selling'] = $productInfo->is_best_selling;
            $tmp2['is_new']          = $productInfo->is_new;
            $tmp2['sale_prices']     = $salePrices1;
            $tmp2['mrp_price']       = $productInfo->price;
            $tmp2['image']           = $productInfo->base_image;

            $imagePath              = $productInfo->base_image;

            if (!Storage::exists($imagePath)) {
                $path               = asset('assets/logo/no-img-1.jpg');
            } else {
                $url                = Storage::url($imagePath);
                $path               = asset($url);
            }

            $tmp2['image']           = $path;
            $related_arr[]          = $tmp2;
        }
    }
    $pro['related_products']    = $related_arr;
    $pro['meta'] = $product_data->productMeta;

    return $pro;
}

if (!function_exists('getProductPrice')) {
    function getProductPrice($productsObjects)
    {

        $strike_rate            = 0;
        $price                  = $productsObjects->mrp;
        $today                  = date('Y-m-d');
        /****
         * 1.check product discount is applied via product add/edit
         * 2.check overall discount is applied for product category
         */
        $discount               = [];
        $overall_discount_percentage = 0;
        $has_discount           = 'no';

        #condition 1:
        if ($today >= $productsObjects->sale_start_date && $today <= $productsObjects->sale_end_date) {

            $strike_rate        = $productsObjects->mrp;
            $price              = $productsObjects->sale_price;
            $has_discount       = 'yes';
            if ($productsObjects->productDiscount->discount_type == 'percentage') {
                $overall_discount_percentage += $productsObjects->productDiscount->discount_value;
            }
            $discount[]         = array('discount_type' => $productsObjects->productDiscount->discount_type, 'discount_value' => $productsObjects->productDiscount->discount_value, 'discount_name' => '');
        }

        #condition 2:
        $getDiscountDetails     = \DB::table('coupon_categories')
            ->select('product_categories.name', 'coupons.*')
            ->join('coupons', 'coupons.id', '=', 'coupon_categories.coupon_id')
            ->join('product_categories', 'product_categories.id', '=', 'coupon_categories.category_id')
            ->join('products', function ($join) {
                $join->on('products.category_id', '=', 'product_categories.id');
                $join->orOn('products.category_id', '=', 'product_categories.parent_id');
            })
            ->where('coupons.status', 'published')
            ->where('is_discount_on', 'yes')
            ->whereDate('coupons.start_date', '<=', date('Y-m-d'))
            ->whereDate('coupons.end_date', '>=', date('Y-m-d'))
            ->where('products.id', $productsObjects->id)
            ->orderBy('coupons.order_by', 'asc')
            ->get();

        $coupon_used            = [];

        if (isset($getDiscountDetails) && !empty($getDiscountDetails)) {
            foreach ($getDiscountDetails as $items) {

                // if( $items->quantity > $items->used_quantity ) {

                #check product amount greater than minimum order value
                if ($items->minimum_order_value <= $price) {
                    #then do percentage or fixed amount discount
                    $tmp['coupon_details']  = $items;

                    switch ($items->calculate_type) {

                        case 'percentage':
                            $strike_rate    = $price;
                            $tmp['discount_amount'] = percentageAmountOnly($price, $items->calculate_value);
                            $price          = percentage($price, $items->calculate_value);
                            $discount[]         = array('discount_type' => $items->calculate_type, 'discount_value' => $items->calculate_value, 'discount_name' => $items->coupon_name);
                            $overall_discount_percentage += $items->calculate_value;
                            $has_discount   = 'yes';
                            break;
                        case 'fixed_amount':
                            $strike_rate    = $price;
                            $tmp['discount_amount'] = $items->calculate_value;
                            $discount[]         = array('discount_type' => $items->calculate_type, 'discount_value' => $items->calculate_value, 'discount_name' => $items->coupon_name);
                            $price          = $price - $items->calculate_value;
                            $has_discount   = 'yes';
                            break;
                        default:

                            break;
                    }
                    $coupon_used[]          = $tmp;
                }
                // }
            }
        }

        #condition 3:
        $getDiscountCollection  = \DB::table('coupon_product_collection')
            ->select('coupons.*', 'product_collections.collection_name')
            ->join('coupons', 'coupons.id', '=', 'coupon_product_collection.coupon_id')
            ->join('product_collections', 'product_collections.id', '=', 'coupon_product_collection.product_collection_id')
            ->join('product_collections_products', 'product_collections_products.product_collection_id', '=', 'coupon_product_collection.product_collection_id')
            ->join('products', 'products.id', '=', 'product_collections_products.product_id')
            ->where('coupons.status', 'published')
            ->where('is_discount_on', 'yes')
            ->where('coupons.from_coupon', 'product_collection')
            ->whereDate('coupons.start_date', '<=', date('Y-m-d'))
            ->whereDate('coupons.end_date', '>=', date('Y-m-d'))
            ->where('products.id', $productsObjects->id)
            ->orderBy('coupons.order_by', 'asc')
            ->get();

        if (isset($getDiscountCollection) && !empty($getDiscountCollection)) {
            foreach ($getDiscountCollection as $items) {

                #check product amount greater than minimum order value
                if ($items->minimum_order_value <= $price) {
                    #then do percentage or fixed amount discount
                    $tmp['coupon_details']  = $items;

                    switch ($items->calculate_type) {

                        case 'percentage':
                            $strike_rate    = $price;
                            $tmp['discount_amount'] = percentageAmountOnly($price, $items->calculate_value);
                            $price          = percentage($price, $items->calculate_value);
                            $discount[]     = array('discount_type' => $items->calculate_type, 'discount_value' => $items->calculate_value, 'discount_name' => $items->coupon_name);
                            $overall_discount_percentage += $items->calculate_value;
                            $has_discount   = 'yes';
                            break;
                        case 'fixed_amount':
                            $strike_rate    = $price;
                            $tmp['discount_amount'] = $items->calculate_value;
                            $discount[]     = array('discount_type' => $items->calculate_type, 'discount_value' => $items->calculate_value, 'discount_name' => $items->coupon_name);
                            $price          = $price - $items->calculate_value;
                            $has_discount   = 'yes';
                            break;
                        default:

                            break;
                    }
                    $coupon_used[]          = $tmp;
                }
            }
        }

        $coupon_used['strike_rate']     = number_format($strike_rate, 2);
        $coupon_used['price']           = number_format($price, 2);
        $coupon_used['price_original']  = $price;
        $coupon_used['discount']        = $discount;
        $coupon_used['overall_discount_percentage'] = $overall_discount_percentage;

        return $coupon_used;
    }
}

function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

function getDiscountPercentage($mop, $mrp)
{
    return round((($mop / $mrp) * 100) - 100);
}
