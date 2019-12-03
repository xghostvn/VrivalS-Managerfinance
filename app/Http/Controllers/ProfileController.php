<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //


    public function index()
    {
        return view("profile");
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => ["required", "string", "max:255"],
            "password" => ["required", "string", "min:8", "confirmed"],
        ]);
        if($validation->fails())
        {
            return redirect("profile")->withErrors($validation);
        }else {
            $id = Auth::id();
            $name = $request->input("name");
            $password = $request->input("password");
            $user = User::find($id);
            $user->name = $name;
            $user->password = Hash::make($password);
            $user->save();
            return redirect("profile")->with("status", "Profile update ! .");

        }


    }

}
