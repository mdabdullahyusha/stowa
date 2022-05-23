<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    function coupon() {
        $coupons = Coupon::all();
        return view('admin.coupon.index',[
            'coupons'=>$coupons,
        ]);
    }
    function coupon_insert(Request $request) {
        Coupon::insert([
            'coupon_code'=> $request->coupon_code,
            'discount'=> $request->discount,
            'validity'=> $request->validity,
            'created_at'=> Carbon::now(),
        ]);
        return back();
    }
    function coupon_delete($coupon_id) {
        Coupon::find($coupon_id)->delete();
        return back();
    }
}
