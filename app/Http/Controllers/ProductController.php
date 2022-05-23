<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\ProductThumbnail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    function index() {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $products = Product::all();
        return view('admin.product.index',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'products'=>$products,
        ]);
    }

    function getCategory(Request $request) {
        // echo $request->category_id;
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        $str_to_send = '<option>-- Select Subcategory --</option>';
        foreach ($subcategories as $subcategory) {
            $str_to_send .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $str_to_send;
    }

    function insert(Request $request) {
        $product_id  = Product::insertGetId([
            'category_id'=> $request->category_id,
            'subcategory_id'=> $request->subcategory_id,
            'product_name'=> $request->product_name,
            'product_price'=> $request->product_price,
            'product_discount'=> $request->product_discount,
            'after_discount'=> ($request->product_price - ($request->product_price * $request->product_discount/100)),
            'brand'=> $request->brand,
            'description'=> $request->description,
            'short_description'=> $request->short_description,
            'created_at'=>Carbon::now(),
        ]);
        // return back();

        $product_preview_image = $request->product_preview;
        $product_preview_image_extension = $product_preview_image->getClientOriginalExtension();
        $preview_file_name = $product_id.'.'.$product_preview_image_extension;

        Image::make($product_preview_image)->resize(680, 680)->save(public_path('uploads/product/preview/'. $preview_file_name));

        Product::find($product_id)->update([
            'preview'=>$preview_file_name,
        ]);

        $loop =1;

        $product_thumbnails_image = $request->product_thumbnails;
        foreach($product_thumbnails_image as $thumbnail) {
            $product_thumbnails_image_extension = $thumbnail->getClientOriginalExtension();
            $thumbnail_file_name = $product_id . '-' . $loop . '.' . $product_thumbnails_image_extension;
            Image::make($thumbnail)->resize(680, 680)->save(public_path('uploads/product/thumbnails/'. $thumbnail_file_name));

            ProductThumbnail::insert([
                'product_id'=>$product_id,
                'product_thumbnails'=>$thumbnail_file_name,
                'created_at'=>Carbon::now(),
            ]);

            $loop++;
        }
        return back();
    }
    function delete($product_id){
        $inventoriesDelete = Inventory::where('product_id', $product_id)->get();
        foreach ($inventoriesDelete as $inventoryDelete) {
            $inventoryDelete->delete();
        }
        Product::find($product_id)->delete();
        return back();
    }
}
