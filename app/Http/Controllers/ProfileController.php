<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function profile() {
        return view('admin.profile.profile');
    }
    function name_change(Request $request) {
        User::find(Auth::id())->update([
            'name'=>$request->name,
        ]);
        return back()->with('success', 'Name Edited Success!');
    }

    function password_change(Request $request) {
        $request->validate([
            'old_password'=>'required',
            'password'=> ['required',Password::min(8)->letters()->mixedCase(),'confirmed'],
            'password_confirmation'=>'required',
        ],[
            'old_password.required'=>'Ager Password De!',
            'password.required'=>'Password De!',
            'password_confirmation.required'=>'Abar New Password De!',
            'password.confirmed'=>'Password Mil Koira Abar De!',
        ]);

        if(Hash::check($request->old_password, Auth::user()->password))  {
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('success', 'Password Changed Success');
        }
        else {
            return back()->with('wrong_pass', 'Batpari Bad Den');
        }
    }

    function profile_photo(Request $request) {
        $profile_photo = $request->profile_photo;

        if(Auth::user()->profile_photo != 'default.png') {
            // $path = public_path('uploads/profile'. Auth::user()->profile_photo);
            // unlink($path);

            $extension = $profile_photo->getClientOriginalExtension();
            $profile_photo_name = Auth::id(). '.'.$extension;

            Image::make($profile_photo)->save(public_path('/uploads/profile/'.$profile_photo_name));

            User::find(Auth::id())->update([
                'profile_photo'=>$profile_photo_name,
            ]);
            return back()->with('success', 'PP Changed');
        }
        else {
            $extension = $profile_photo->getClientOriginalExtension();
            $profile_photo_name = Auth::id(). '.'.$extension;

            Image::make($profile_photo)->save(public_path('/uploads/profile/'.$profile_photo_name));

            User::find(Auth::id())->update([
                'profile_photo'=>$profile_photo_name,
            ]);
            return back()->with('success', 'PP Changed');
        }
    }
}
