<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware("admin");
    }


    public function index()
    {
        // prepare data
        $data = [];

        // get categories
        $data["categories"] = Category::all();

        // serve
        return view("admin/categories", $data);
    }


    public function update(Request $request, $id)
    {
        // prepare data
        $data = [];

        // validate input
        $validator = Validator::make($request->all(), [
            "new_name" => ["required", "string", "max:50", "regex:/^[a-z&\s]+$/i"],
            "new_image" => ["nullable",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"]
        ]);

        // if fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with(["show_edit_container" => true, "edit_id" => $id]);
        }
        $validator = $validator->validate();

        // get category
        $category = Category::findOrFail($id);

        // store name
        $data["name"] = $validator["new_name"];

        // update image
        if (isset($validator["new_image"])) {
            // delete old image
            if (Storage::disk('public')->exists($category["image"])) {
                Storage::disk('public')->delete($category["image"]);
            }

            // store new image
            $data["image"] = $validator["new_image"]->store("categories", "public");
        }

        // update category
        $category->update($data);

        // if success
        return Redirect()->back()->with("success", "the category have been updated");
    }

    public function store(Request $request)
    {
        // prepare data
        $data = [];

        // validate input
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "max:50", "unique:categories", "regex:/^[a-z&\s]+$/i"],
            "image" => ["required",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"],
        ]);

        // if fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $validator = $validator->validate();

        // store data
        $data["image"] = $validator["image"]->store("categories", "public");
        $data["name"] = $validator["name"];

        // store
        Category::create($data);

        // redirect
        return Redirect()->back()->with("success", "the category have been created");
    }


    public function destroy($id)
    {
        // get category
        $category = Category::findOrFail($id);

        // update
        $category->delete();

        // if success
        return Redirect()->back()->with("success", "the category have been deleted");
    }
}
