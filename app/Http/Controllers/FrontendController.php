<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inventory;

class FrontendController extends Controller
{
    function index() {
        $all_product = Product::take(6)->orderBy('id', 'DESC')->get();
        $new_arrival = Product::latest()->take(4)->orderBy('id', 'DESC')->get();
        $all_categories = Category::all();
        return view('frontend.index',[
            'all_product'=>$all_product,
            'all_categories'=>$all_categories,
            'new_arrival'=>$new_arrival,

        ]);
    }
    function product_details($product_id) {
        $product_info = Product::find($product_id);
        $related_product = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_id)->get();
        $available_colors = Inventory::where('product_id', $product_id)->groupBy('color_id')->selectRaw('sum(color_id) as sum, color_id')->get();
        return view('frontend.product_details',[
            'product_info'=> $product_info,
            'related_product'=> $related_product,
            'available_colors'=> $available_colors,
        ]);
    }
    function getSize(Request $request) {
        $available_size = Inventory::where('product_id',$request->product_id)->where('color_id', $request->color_id)->get();
        $str_to_send = '<option data-display="- Please select -">Choose A Option</option>';
        foreach ($available_size as $size) {
            $str_to_send .= '<option value="'.$size->size_id.'">'.$size->rel_to_size->size_name.'</option>';
        }
        echo $str_to_send;
    }
}
