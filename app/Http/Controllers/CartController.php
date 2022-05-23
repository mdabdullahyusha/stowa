<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Laravel\Ui\Presets\React;

class CartController extends Controller
{

    function cart(){
        $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart', [
            'carts'=>$carts,
        ]);
    }

    function cart_update(Request $request){
        foreach($request->quantity as $cart_id=>$quantity){
            Cart::find($cart_id)->update([
                'quantity'=>$quantity,
            ]);
        }
        return back();
    }

    function cart_insert(Request $request) {
        Cart::insert([
            'user_id'=>Auth::guard('customerlogin')->id(),
            'product_id'=> $request->product_id,
            'color_id'=> $request->color_id,
            'size_id'=> $request->size_id,
            'quantity'=> $request->quantity,
            'created_at'=> Carbon::now(),
        ]);
        return back()->with('cart', 'Cart Added Successfully!');
    }
    function cart_delete($cart_id){
        Cart::find($cart_id)->delete();
        return back();
    }

}
