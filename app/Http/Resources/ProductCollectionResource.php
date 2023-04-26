<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCollectionResource extends JsonResource
{
    public function toArray($request)
    {
        $imagePath              = $this->image;
        $bannerImagePath        = 'productCollection/'.$this->id.'/'.$this->image;
        $url                    = Storage::url($bannerImagePath);
        $path                   = asset($url);
      

        $childTmp                   = [];
        $tmp[ 'id' ]                = $this->id;
        $tmp[ 'collection_name' ]   = $this->collection_name;
        $tmp[ 'collection_slug' ]   = Str::slug($this->collection_name);
        $tmp[ 'image' ]             = $path;
        $tmp[ 'tag_line' ]          = $this->tag_line;
        $tmp[ 'order_by' ]          = $this->order_by;
        $tmp[ 'status' ]            = $this->status;
        $tmp[ 'deleted_at' ]        = $this->deleted_at;
        $tmp[ 'updated_at' ]        = $this->updated_at;
        $tmp[ 'show_home_page' ]    = $this->show_home_page;
        if( isset($this->collectionProducts) && !empty( $this->collectionProducts )) {
            foreach ($this->collectionProducts as $items ) {
                $category = $items->product->productCategory;
                // dd( $category->id );
                // $salePrices             = getProductPrice( $items->product );

                $pro                    = [];
                $pro['id']              = $items->product->id;
                $pro['product_name']    = $items->product->product_name;
                $pro['category_name']   = $category->name ?? '';
                $pro['hsn_code']        = $items->product->hsn_code;
                $pro['product_url']     = $items->product->product_url;
                $pro['sku']             = $items->product->sku;
                $pro['stock_status']    = $items->product->stock_status;
                $pro['is_featured']     = $items->product->is_featured;
                $pro['is_best_selling'] = $items->product->is_best_selling;
                $pro['is_new']          = $items->product->is_new;
                $pro['price']           = $items->product->mrp;
                $pro['strike_price']    = $items->product->strike_price;
                $pro['thumbnail']       = $items->product->base_image;

                $imagePath              = $items->product->base_image;

                if(!Storage::exists( $imagePath)) {
                    $path               = asset('assets/logo/no_Image.jpg');
                } else {
                    $url                = Storage::url($imagePath);
                    $path               = asset($url);
                }

                $pro['thumbnail']           = $path;

                $tmp['products'][]      = $pro; 
            }
        }

        return $tmp;
    }
}
