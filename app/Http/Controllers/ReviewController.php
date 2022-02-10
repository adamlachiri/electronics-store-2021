<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    public function __construct()
    {
        return $this->middleware("auth");
    }

    public function store(Request $request)
    {
        // set rules
        $rules = [
            "rating" => ["required", "integer", "min:1", "max:5"],
            "comment" => ["nullable", "string", "max:1000"],
            "product_id" => ["required", "integer"]
        ];

        // validation
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data = $validator->validate();

        // check if product is reviewed already
        if (Review::where("user_id", "=", Auth::id())->where("product_id", "=", $data["product_id"])->exists()) {
            return send_error("this product has already been reviewed by you");
        }

        // add user id
        $data["user_id"] = Auth::id();

        // create the review
        Review::create($data);

        // redirect
        return send_success("product successfully reviewed");
    }

    public function update(Request $request, $id)
    {

        // get the review
        $review = Review::findOrFail($id);

        // set rules
        $rules = [
            "rating" => ["required", "integer", "min:1", "max:5"],
            "comment" => ["nullable", "string", "max:1000"],
        ];

        // validation
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data = $validator->validate();

        // update the review
        $review->update($data);

        // redirect
        return send_success("product review updated");
    }
}
