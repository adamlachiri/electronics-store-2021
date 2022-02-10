@extends('inc/layout')

@section('content')

<!-- vars -->
@php
$banner_ads = App\Models\Ad::all();
@endphp

<!-- navbar -->
@include("inc/navbar")

<div class="bg-light">
    <div class="container-fluid py-5">
        <div class="row align-items-stretch">
            <!-- left section -->
            <div class="col-md-9 p-2">
                <!-- shopping cart -->
                <div class="bg-white p-5 h-100 border border-gray">
                    <!-- title -->
                    <h3 class="text-capitalize">your shopping cart</h3>
                    <hr class="my-4">

                    @if(count($cart_items) > 0)

                    <!-- cart items -->
                    <form id="cart-form" action="cart/confirm_cart" method="post">
                        @csrf
                        @foreach($cart_items as $cart_item)
                        <!-- cart_item -->
                        <div data-price="{{$cart_item->product->price}}" class="row flex-nowrap js-product">
                            <!-- image -->
                            <div class="col-5 col-md-3 d-center pr-5">
                                <a href="products/{{ $cart_item->product->id }}">
                                    <img src="storage/{{ $cart_item->product->main_image }}" class="img-fluid" style="max-height: 10rem" alt="">
                                </a>
                            </div>

                            <!-- infos -->
                            <div class="col pr-5">
                                <!-- name -->
                                <div>
                                    <a href="products/{{ $cart_item->product->id }}" class="hover-text-main">{{ $cart_item->product->name }}</a>
                                </div>
                                <hr>

                                <!-- unit price -->
                                <div class="text-capitalize d-md-none">
                                    <span class="pr-2">unit price :</span>
                                    <!-- current price -->
                                    <span class="font-weight-bold js-price">{{ $cart_item->product->price }}</span>
                                    <span class="pl-1">DH</span>
                                </div>

                                <!-- rating -->
                                <div class="pt-2 text-main">
                                    {{ stars($cart_item->product->rating) }}
                                    <span class="pl-2 text-info">{{ $cart_item->product->rating }}</span>
                                </div>

                                <!-- stock situation -->
                                {{ stock_situation($cart_item->product->stock) }}

                                <!-- coupon code -->
                                @if($cart_item->product->coupon_code)
                                <div class="py-1 d-flex align-items-center">
                                    <label class="text-success pr-2">Enter a coupon code for {{ $cart_item->product->coupon_reduction }}% reduction</label>

                                    <input type="password" class="border border-gray rounded" name="coupon_code_{{ $cart_item->product->id }}" value="{{ $cart_item->coupon_code }}" placeholder="">
                                </div>
                                @endif

                                <!-- options -->
                                <div class="d-flex align-items-center">
                                    <!-- quantity -->
                                    <span class="pr-3 border-right border-gray">
                                        <span class="pr-2">Quantity :</span>
                                        <select name="quantity_{{ $cart_item->product->id }}" class="border border-gray rounded bg-light py-1 js-quantity" style="width: 5rem" onchange=cart()>
                                            @foreach([1,2,3,4,5,6,7,8,9,10] as $number)
                                            <!-- get selected -->
                                            @php
                                            $selected = $number == $cart_item->quantity ? "selected" : "";
                                            @endphp

                                            @if($number <= $cart_item->product->stock)
                                                <option value="{{ $number }}" {{ $selected}}>{{ $number }}</option>
                                                @endif
                                                @endforeach
                                        </select>
                                    </span>


                                    <!-- delete link -->
                                    <span class="pl-3 text-info">
                                        <span data-id="{{ $cart_item->id }}" class="hover-opacity" onclick="
                                   const delete_form = document.getElementById('delete-form');
                                   delete_form.action = 'cart/' + this.dataset.id;
                                   delete_form.submit();
                                    ">delete</span>
                                    </span>

                                </div>
                            </div>

                            <!-- price -->
                            <div class="text-capitalize d-md-block">
                                <span class="pr-2">unit price :</span>
                                <!-- current price -->
                                <span class="h5 font-weight-bold js-price">{{ $cart_item->product->price }}</span>
                                <span class="pl-1">DH</span>
                            </div>

                        </div>
                        <hr>
                        @endforeach
                    </form>
                    @else
                    <h5 class="text-muted">Your cart is empty, try adding some products</h5>
                    @endif
                </div>
            </div>

            <!-- right section -->
            <div class="col-md-3 p-2">

                <div class="position-sticky" style="top: 3rem">
                    @if(count($cart_items) > 0)
                    <!-- total price -->
                    <div class="bg-white p-3 border border-gray rounded">
                        <!-- title -->
                        <h4 class="text-capitalize font-weight-bold">total price</h4>

                        <!-- total price -->
                        <div class="text-danger h5 font-weight-bold">
                            <span id="total-price" class="pr-1"></span>
                            <span>DH</span>
                        </div>

                        <!-- js -->
                        <script>
                            function cart() {
                                const products = document.getElementsByClassName('js-product');
                                let total = 0;
                                for (let i = 0; i < products.length; i++) {
                                    const product = products[i];
                                    const price = product.dataset.price;
                                    const quantity = product.getElementsByClassName("js-quantity")[0].value;
                                    const sub_total = parseFloat(price) * parseFloat(quantity);
                                    total += sub_total;
                                }
                                document.getElementById("total-price").textContent = total.toFixed(2);
                            }

                            cart();
                        </script>

                        <!-- checkout -->
                        <div class="pt-2">
                            <button class="btn btn-main w-100" onclick="
                            document.getElementById('cart-form').submit();
                            ">{{ Auth::user()->order_step ? "reproceed to payment" : "proceed to payment" }}</button>
                        </div>

                    </div>
                    @endif

                    <!-- ad -->
                    <div class="pt-5">
                        {{card_ad($advertised_product)}}
                    </div>

                </div>
            </div>
        </div>

        <!-- before you proceed -->
        <div class="py-2">
            <h6 class="text-capitalize">before you buy</h6>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime minima error quo est. Fugit dolorum iure aut quasi eligendi eius voluptatem doloremque qui, repellendus porro asperiores? Beatae velit itaque nisi.</p>
        </div>

        <!-- banner ad  -->
        {{banner_ad( \App\Models\Ad::all()[2])}}
    </div>

    <!-- delete form -->
    <form id="delete-form" action="" method="post" class="d-none">
        @csrf
        @method("delete")
    </form>


    @endsection