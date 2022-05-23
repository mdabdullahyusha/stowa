<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    function account() {
        return view('frontend.account');
    }
    function customerlogout(Request $request){
        Auth::guard('customerlogin')->logout();
        return redirect('/register');
    }
}
