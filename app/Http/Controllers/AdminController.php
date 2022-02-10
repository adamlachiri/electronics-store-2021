<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware("admin");
    }

    public function security()
    {
        return view("admin/security");
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
            "old_password" => ["required", "string"],
            "new_password" => ["required", "string", "min:6"],
            "confirmed_password" => ["required", "string", "same:new_password"]
        ];

        // validation
        $validator = Validator::make($data, $rules);

        // check admin password
        $admin_password = Auth::user()->password;
        if (!Hash::check($data["old_password"], $admin_password)) {
            return redirect()->back()->withErrors(["old_password" => "wrong admin password"]);
        }

        // check other validations
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // change the password
        $admin = User::findOrFail(Auth::id());
        $admin->update(["password" => Hash::make($data["new_password"])]);

        // redirect
        return redirect("/admin");
    }

    public function products(Request $request)
    {

        // prepare data
        $data = [];

        if (isset($request->all()["name"])) {
            // get name
            $name = $request->all()["name"];

            // rules
            $rules =  ["name" => ["required", "string"]];

            // validation
            $validator = Validator::make($request->all(), $rules);

            // if fails
            if ($validator->fails()) {
                return redirect()->back();
            }

            // get products
            $data["products"] = Product::where("name", "like", "%$name%")->get();
        }

        // serve
        return view("admin/products", $data);
    }

    public function create_fake_data()
    {
        // preapre data
        $data = [];

        // get all products
        $Products = Product::all();

        // fake data
        $guarantees = [null, 6, 12, 24];

        // loop
        foreach ($Products as $product) {
            $data["rating"] = rand(rand(100, 500), 500) / 100;
            $data["total_sells"] = rand(50, 250);
            $data["stock"] = rand(0, 50);
            $data["total_reviews"] = rand(10, $data["total_sells"]);
            $data["guarantee"] = $guarantees[rand(0, 3)];

            // if promotion
            if (rand(0, 1) === 1) {
                $data["promotion"] = rand(3, 30);

                $data["price"] = (float)(1 - $data["promotion"] / 100) * (float)($product->original_price);
                $data["price"] = number_format($data["price"], 2, ".", "");
            } else {
                $data["promotion"] = null;
                $data["price"] = $product->original_price;
            }

            // update
            $product->update($data);
        }

        // redirect
        return redirect("/");
    }
}
