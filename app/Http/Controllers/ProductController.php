<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\History;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // prepare data
        $data = [];

        // get products
        $products = Product::all();

        // set rules
        $rules = [
            "name" => ["nullable", "string", "max:255"],
            "category_id" => ["nullable", "string", "max:255"],
            "max_price" => ["nullable", "string", "max:255"],
            "rating" => ["nullable", "string", "max:255"],
            "ranking" => ["nullable", "string", "max:255"],
        ];

        // validation
        $validator = Validator::make($request->all(), $rules);

        // if fails
        if ($validator->fails()) {
            return redirect()->back();
        }
        $validator = $validator->validate();

        // prepare query
        $query = DB::table("products");


        // filter name
        if (isset($validator["name"])) {
            $query = $query->where("name", "like", "%" . $validator["name"] . "%");
        }

        // filter category
        if (isset($validator["category_id"])) {
            $query = $query->where("category_id", "=", $validator["category_id"]);
        }

        // filter rating
        if (isset($validator["rating"])) {
            $query = $query->where("rating", ">=", (int)$validator["rating"]);
        }

        // filter max original_price
        if (isset($validator["max_price"])) {
            $query = $query->where("original_price", "<=", (int)$validator["max_price"]);
        }

        // filter ranking
        if (isset($validator["ranking"])) {
            $value = explode(" ", $validator["ranking"])[0];
            $type = explode(" ", $validator["ranking"])[1];
            $query = $query->orderBy($value, $type);
        }

        // get products
        $products = $query->paginate(12);

        // insert data
        $data["products"] = $products;
        $request->flash();

        // serve
        return view("products/index", $data);
    }


    public function create()
    {
        // prepare data
        $data = [];

        // get categories
        $data["categories"] = Category::all();

        // serve
        return view("products/create", $data);
    }


    public function store(Request $request)
    {
        // prepare data 
        $data = [];

        // input rules
        $rules = [
            "name" => ["required", "string", "max:255", "unique:Products"],
            "category_id" => ["required", "string"],
            "original_price" => ["required", "string", "min:1"],
            "stock" => ["required", "string", "min:1"],
            "main_image" => ["required",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"],
            "image_1" => ["nullable",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"],
            "image_2" => ["nullable",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"],
            "video" => ["nullable", "string", "max:255", "unique:Products"],
            "promotion" => ["nullable", "string", "min:1", "max:80"],
            "guarantee" => ["nullable", "string", "max:255"],
            "coupon_code" => ["nullable", "required_with:coupon_reduction", "string", "min:6"],
            "coupon_reduction" => ["nullable", "required_with:coupon_code", "string", "min:1", "max:80"]
        ];

        // validation
        $validator = Validator::make($request->all(), $rules);

        // if fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $validator = $validator->validate();

        // handle promotion
        $original_price = (int)$validator["original_price"] - 0.01;
        $price = isset($validator["promotion"]) ? $original_price * (1 - $validator["promotion"] / 100) :  $original_price;

        // insert prices
        $data["price"] = number_format((float)$price, 2, '.', '');
        $data["original_price"] = $original_price;

        // store required
        $inputs = ["name", "category_id", "stock"];
        foreach ($inputs as $input) {
            $data[$input] = $validator[$input];
        }

        // store unrequired
        $inputs = ["guarantee", "video", "promotion", "coupon_code", "coupon_reduction"];
        foreach ($inputs as $input) {
            if (isset($validator[$input])) {
                $data[$input] = $validator[$input];
            }
        }

        // store images
        $images = ["main_image", "image_1", "image_2"];
        foreach ($images as $image) {
            if (isset($validator[$image])) {
                $data[$image] = $validator[$image]->store("products", "public");
            }
        }


        // store product
        Product::create($data);

        // redirect
        return redirect("/products/create")->with("success", "the product have been added");
    }

    public function show(Request $request, $id)
    {
        // validation
        $validator = Validator::make($request->all(), ["ranking" => ["nullable", "string"]]);
        if ($validator->fails()) {
            return send_error("stop trying");
        }
        $data = $validator->validate();

        // get product
        $product = Product::findOrFail($id);

        // insert data
        $data["product"] = $product;

        // store history
        if (Auth::check()) {
            if (History::where("user_id", "=", Auth::id())->where("product_id", "=", $id)->exists()) {
                History::where("user_id", "=", Auth::id())->where("product_id", "=", $id)->delete();
            }
            $new_history = [
                "user_id" => Auth::id(),
                "product_id" => $id
            ];
            History::create($new_history);
        }

        // get reviews
        $query = Review::where("product_id", "=", $id);

        // get ranking
        $data["ranking"] = isset($data["ranking"]) ? $data["ranking"] : "rating desc";


        // insert data
        $value = explode(" ", $data["ranking"])[0];
        $type = explode(" ", $data["ranking"])[1];
        $query = $query->orderBy($value, $type);
        $data["reviews"] = $query->paginate(10);


        // serve
        return view("products/show", $data);
    }

    public function edit($id)
    {
        // prepare data 
        $data = [];

        // insert data
        $data["product"] = Product::findOrFail($id);
        $data["categories"] = Category::all();

        // serve
        return view("products/edit", $data);
    }


    public function update(Request $request, $id)
    {
        // prepare data 
        $data = [];

        // get original product
        $product = Product::findOrFail($id);

        // input rules
        $rules = [
            "name" => ["required", "string", "max:255", "unique:Products,name," . $product->id],
            "category_id" => ["required", "string"],
            "original_price" => ["required", "string", "min:1"],
            "stock" => ["required", "string", "min:1"],
            "main_image" => ["nullable",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"],
            "image_1" => ["nullable",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"],
            "image_2" => ["nullable",  "image", "mimes:jpeg,jpg,webp,png", "max:2048"],
            "video" => ["nullable", "string", "max:255", "unique:Products,video," . $product->id],
            "promotion" => ["nullable", "string", "min:1", "max:80"],
            "guarantee" => ["nullable", "string", "max:255"],
            "coupon_code" => ["nullable", "required_with:coupon_reduction", "string", "min:6"],
            "coupon_reduction" => ["nullable", "required_with:coupon_code", "string", "min:1", "max:80"]
        ];

        // validation
        $validator = Validator::make($request->all(), $rules);

        // if fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $validator = $validator->validate();

        // handle promotion
        $original_price = (int)$validator["original_price"] - 0.01;
        $price = $original_price;
        if ($product->promotion) {
            $price = $original_price * (1 - $product->promotion / 100);
        }
        if (isset($validator["promotion"])) {
            $price = $original_price * (1 - $validator["promotion"] / 100);
        }


        // insert prices
        $data["price"] = number_format((float)$price, 2, '.', '');
        $data["original_price"] = $original_price;

        // store required
        $inputs = ["name", "category_id", "stock"];
        foreach ($inputs as $input) {
            $data[$input] = $validator[$input];
        }

        // store unrequired
        $inputs = ["guarantee", "video", "promotion", "coupon_code", "coupon_reduction"];
        foreach ($inputs as $input) {
            if (isset($validator[$input])) {
                $data[$input] = $validator[$input];
            }
        }

        // update images
        $images = ["main_image", "image_1", "image_2"];
        foreach ($images as $image) {
            if (isset($validator[$image])) {
                // delete old image
                if (Storage::disk('public')->exists($product[$image])) {
                    Storage::disk('public')->delete($product[$image]);
                }

                // store new image
                $data[$image] = $validator[$image]->store("products", "public");
            }
        }

        // update product
        $product->update($data);

        // redirect
        return redirect("/products/" . $product->id . "/edit")->with("success", "the product have been updated");
    }


    public function destroy(Product $product)
    {
        //
    }
}
