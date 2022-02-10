<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function __construct()
    {
        return $this->middleware("auth");
    }

    public function index()
    {
        // check order step
        $this->check_order_step(1);

        // serve
        return view("order/index");
    }

    public function confirm_password(Request $request)
    {
        // check order step
        $this->check_order_step(1);

        // validation rules
        $rules = [
            "password" => ["required"]
        ];

        // validation
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $validated = $validator->validate();

        // check user password
        if (!Hash::check($validated["password"], Auth::user()->password)) {
            return redirect()->back()->withErrors(["password" => "wrong user password"]);
        }

        // change step
        Auth::user()->current_order->update(["step" => 2]);

        // redirect
        return redirect("/order/shipping_address_form");
    }


    public function shipping_address_form()
    {
        // check order step
        $this->check_order_step(2);

        // serve
        return view("order/shipping_address_form");
    }

    public function shipping_address(Request $request)
    {
        // check order step
        $this->check_order_step(2);

        // set rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'min:11'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string']
        ];

        // validation
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data = $validator->validate();

        // check city
        $cities = ["tanger", "rabat", "casablanca", "fes", "meknes", "tetouan", "agadir", "other"];
        if (!in_array($data["city"], $cities)) {
            return send_error("enter the right city please");
        }

        // store infos
        $data["user_id"] = Auth::id();
        $data["step"] = 3;

        // update step
        Auth::user()->current_order->update($data);

        // serve
        return redirect("order/payment_method_form");
    }


    public function payment_method_form()
    {
        // check order step
        $this->check_order_step(3);

        // get total price
        $total_price = 0;
        foreach (Auth::user()->cart_items as $cart_item) {
            // subtotal
            $subtotal = (float)$cart_item->product->price  * $cart_item->quantity;

            // check coupon code
            if ($cart_item->product->coupon_code && $cart_item->coupon_code === $cart_item->product->coupon_code) {
                $subtotal *= (1 - ($cart_item->product->coupon_reduction / 100));
            }

            // add subtotal
            $total_price += $subtotal;
        }
        $total_price = number_format($total_price, 2, ',', ' ');

        // update total price of order
        Auth::user()->current_order->update(["total_price" => $total_price]);

        // serve
        return view("order/payment_method_form");
    }


    public function payment_method(Request $request)
    {
        // check order step
        $this->check_order_step(3);

        // set rules
        $rules = [
            "payment_method" => ["required", "string", "max:255"]
        ];

        // validation
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data = $validator->validate();

        // check payment method
        $payment_methods = [
            "credit card", "img",
            "pay on delivery",
            "paypal",
        ];
        if (!in_array($data["payment_method"], $payment_methods)) {
            return send_error("Enter the right payment method");
        }

        // create orders items
        foreach (Auth::user()->cart_items as $cart_item) {
            $order_item = [];
            $order_item["order_id"] = Auth::user()->current_order->id;
            $order_item["product_id"] = $cart_item->product_id;
            $order_item["quantity"] = $cart_item->quantity;
            $order_item["unit_price"] = $cart_item->product->price;
            $order_item["user_id"] = Auth::id();

            // create order item
            Order_item::create($order_item);

            // destroy cart item
            $cart_item->delete();
        }

        // insert step
        $data["step"] = 4;

        // update the order
        Auth::user()->current_order->update($data);

        // redirect
        return redirect("/order/confirmation");
    }


    public function confirmation()
    {
        // check order step
        $this->check_order_step(4);

        // finish order
        Auth::user()->current_order->update(["step" => 5]);

        // serve
        return view("order/confirmation");
    }

    public function check_order_step($step)
    {
        if (!Auth::user()->current_order || Auth::user()->current_order->step != $step) {
            return abort(404);
        }
    }
}
