<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\step;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        // prepare data
        $data = [];

        // get card items
        $cart_items = Cart::where("user_id", "=", Auth::id())->get();

        // get sponsored product
        $query = DB::table("products");
        foreach ($cart_items as $cart_item) {
            $query = $query->where("id", "!=", $cart_item->product_id);
        }
        $advertised_product = $query->orderBy("rating", "desc")->get()->first();


        // store data
        $data["cart_items"] = $cart_items;
        $data["advertised_product"] = $advertised_product;

        // serve
        return view("cart/index", $data);
    }


    public function store(Request $request)
    {
        // destroy order
        $this->destroy_current_order();

        // prepare data
        $data = [];
        $user_id = Auth::user()->id;

        // set rules
        $rules = [
            "product_id" => ["required", "string", "max:255"],
            "quantity" => ["required", "string", "max:255"],
            "coupon_code" => ["nullable", "string", "max:255"],
        ];

        // validate input
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return send_error("wrong input");
        }
        $validated = $validator->validate();

        // get validated data
        $product_id = $validated["product_id"];
        $quantity = $validated["quantity"];
        $coupon_code = isset($validated["coupon_code"]) ? $validated["coupon_code"] : null;

        // check quantity
        if ($quantity > Product::findOrFail($product_id)->stock) {
            return send_error("Wrong quantity selected");
        }

        // check if duplicate
        if (Cart::where("user_id", "=", $user_id)->where("product_id", "=", $product_id)->exists()) {
            return send_error("Product already exist in cart");
        }

        // insert data
        $data["product_id"] = $product_id;
        $data["user_id"] = $user_id;
        $data["quantity"] = $quantity;
        $data["coupon_code"] = $coupon_code;

        // store 
        Cart::create($data);

        // redirect
        return send_success("The product have been added to your cart");
    }


    public function confirm_cart(Request $request)
    {
        // destroy order
        $this->destroy_current_order();

        // get cart products ids
        $cart_items = Auth::user()->cart_items;

        // set rules
        $rules = [];
        foreach ($cart_items as $cart_item) {
            $product_id = $cart_item->product_id;
            // set rules 
            $rules["quantity_" . $product_id] = ["required", "string", "max:255"];
            $rules["coupon_code_" . $product_id] = ["nullable", "string", "max:255"];
        }

        // validation
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return send_error("something went wrong");
        }
        $validated = $validator->validate();

        // loop and check database
        foreach ($cart_items as $cart_item) {
            $product_id = $cart_item->product_id;
            $quantity = $validated["quantity_" . $product_id];
            $coupon_code = isset($validated["coupon_code_" . $product_id]) ? $validated["coupon_code_" . $product_id] : null;

            // get product form database
            $stock = Product::findOrFail($product_id)["stock"];

            // check quantity
            if ((int)$quantity > (int)$stock) {
                return send_error("wrong quantity");
            }

            // update cart item
            $data = [];
            $data["quantity"] = $quantity;
            $data["coupon_code"] = $coupon_code;
            $cart_item->update($data);
        }

        // create new order
        Order::create(["user_id" => Auth::id(), "step" => 1]);

        // redirect
        return redirect("/order");
    }

    public function destroy($id)
    {
        // destroy order
        $this->destroy_current_order();

        // get cart item
        $cart_item = Cart::findOrFail($id);

        // check if belongs to user
        if ($cart_item->user_id != Auth::id()) {
            return abort(403);
        }

        // delete
        $cart_item->delete();

        // redirect
        return redirect()->back();
    }

    public function destroy_current_order()
    {
        if (Auth::user()->current_order) {
            Auth::user()->current_order->delete();
        }
    }
}
