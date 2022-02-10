<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavouriteController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth");
    }


    public function index()
    {
        // serve
        return view("profile/favourites");
    }

    public function store(Request $request)
    {
        // prepare data
        $data = [];
        $user_id = Auth::user()->id;

        // validate input
        $validator = Validator::make($request->all(), [
            "product_id" => ["required", "string", "max:255"],
        ]);
        if ($validator->fails()) {
            return abort(404);
        }
        $validator = $validator->validate();

        // get product id
        $product_id = $validator["product_id"];

        // check if duplicate
        if (Favourite::where("user_id", "=", $user_id)->where("product_id", "=", $product_id)->exists()) {
            return abort(404);
        }

        // insert data
        $data["product_id"] = $product_id;
        $data["user_id"] = $user_id;

        // store 
        Favourite::create($data);

        // redirect
        return redirect()->back()->with("success", "the product have been added to your favourites");
    }

    public function destroy($id)
    {
        // get favourite
        $favourite = Favourite::findOrFail($id);

        // check if belongs to user
        if ($favourite->user_id != Auth::id()) {
            return abort(403);
        }

        // update
        $favourite->delete();

        // if success
        return Redirect()->back();
    }
}
