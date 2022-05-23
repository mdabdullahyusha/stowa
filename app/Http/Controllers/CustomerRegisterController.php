<?php

namespace App\Http\Controllers;

use App\Models\CustomerLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerRegisterController extends Controller
{
    function customer_register(Request $request) {
        CustomerLogin::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'created_at'=> Carbon::now(),
        ]);
        return back();
    }
}
