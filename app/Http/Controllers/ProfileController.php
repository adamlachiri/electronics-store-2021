<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    // middleware
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function security()
    {
        return view("/profile/security");
    }


    public function edit()
    {
        return view("/profile/edit");
    }



    public function orders($id)
    {
        return view("profile/orders");
    }

    public function payment_method($id)
    {
        dd($id);
    }


    public function update(Request $request)
    {
        // prepare data
        $user_data = [];
        $profile_data = [];

        // set rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            "image" => ["nullable", "image", "mimes:png,jpeg,jpg,webp", "max:2048"],
            'phone' => ['nullable', 'numeric', 'min:11'],
            'address' => ['nullable', 'string'],
        ];

        // validation
        $validator = Validator::make($request->all(), $rules);

        // if failed
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $validator = $validator->validate();

        // insert data
        $user_data["name"] = $validator["name"];
        $user_data["email"] = $validator["email"];
        $profile_data["phone"] = $validator["phone"];
        $profile_data["address"] = $validator["address"];

        // update image
        if (isset($validator["image"])) {
            $profile_data["image"] = $validator["image"]->store("users", "public");

            // delete old image
            $old_image = Auth::user()->profile->image;
            if ($old_image != "profile.jpg" && Storage::disk('public')->exists($old_image)) {
                Storage::disk('public')->delete($old_image);
            }
        }

        // update user
        $user = User::findOrFail(Auth::id());
        $user->update($user_data);
        $user->profile()->update($profile_data);

        // redirect 
        return redirect()->back()->with("success", "Your profile has been updated !");
    }

    public function change_password(Request $request)
    {
        // get input
        $input = $request->all();

        //  prepare data
        $data = [];
        $data["old_password"] = $input["old_password"];
        $data["new_password"] = $input["new_password"];
        $data["confirmed_password"] = $input["confirmed_password"];

        // validation rules
        $rules = [
            "old_password" => ["required"],
            "new_password" => ["required", "min:6"],
            "confirmed_password" => ["required", "same:new_password"]
        ];

        // validation
        $validator = Validator::make($data, $rules);

        // check other validations
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // check user password
        $user_password = Auth::user()->password;
        if (!Hash::check($data["old_password"], $user_password)) {
            return redirect()->back()->withErrors(["old_password" => "wrong user password"]);
        }

        // change the password
        $user = User::findOrFail(Auth::id());
        $user->update(["password" => Hash::make($data["new_password"])]);

        // redirect
        return redirect("/profile/" . Auth::id());
    }
}
