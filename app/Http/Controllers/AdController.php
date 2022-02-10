<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{

    public function __construct()
    {
        return $this->middleware("admin");
    }


    public function index(Request $request)
    {
        // prepare data
        $data = [];

        // store data
        $data["product_id"] = $request->product_id;
        $data["ads"] = Ad::all();

        // serve
        return view("admin/ads", $data);
    }

    public function store(Request $request)
    {
        // prepare data
        $data = [];

        // validate input
        $validator = Validator::make($request->all(), [
            "type" => ["required", "string", "max:255"],
            "image" => ["required",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"],
            "product_id" => ["required",  "string", "max:255", "unique:ads"]
        ]);

        // if fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data = $validator->validate();

        // store data
        $data["image"] = $data["image"]->store("ads", "public");

        // store
        Ad::create($data);

        // redirect
        return Redirect()->back()->with("success", "the ad have been created with success");
    }

    public function update(Request $request, $id)
    {
        // prepare data
        $data = [];

        // validate input
        $validator = Validator::make($request->all(), [
            "new_product_id" => ["nullable", "string", "max:50", "regex:/^[a-z&\s]+$/i"],
            "new_image" => ["nullable",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"],
            "new_type" => ["nullable",  "string", "max:255"]
        ]);

        // if fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with(["show_edit_container" => true, "edit_id" => $id]);
        }
        $data = $validator->validate();

        // get ad
        $ad = Ad::findOrFail($id);

        // update image
        if (isset($validator["new_image"])) {
            // delete old image
            delete_file($ad["image"]);

            // store new image
            $data["image"] = $data["new_image"]->store("ads", "public");
        }

        // update ad
        $ad->update($data);

        // if success
        return Redirect()->back()->with("success", "the ad have been updated");
    }


    public function destroy($id)
    {
        // get ad
        $ad = Ad::findOrFail($id);

        // update
        delete_file($ad->image);
        $ad->delete();

        // if success
        return Redirect()->back()->with("success", "the ad have been removed");
    }
}
