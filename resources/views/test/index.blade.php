@extends('inc/layout')

@section('content')

<!-- vars -->
@php
$categories = App\Models\Category::all();
$cart_products = [];
foreach(App\Models\Cart::where("user_id", "=", Auth::id())->get() as $cart_item) {
array_push( $cart_products, $cart_item->product);
}
@endphp

<!-- section sorting bar -->
<section class="px-5 py-1 border-bottom border-gray d-flex align-items-center bg-white justify-content-between">
    <!-- text -->
    <span>
        @if($products->total() > 0)
        <span>{{ $products->firstItem() }}</span>
        -
        <span>{{ $products->lastItem() }}</span>
        from
        <span>{{ $products->total() }}</span>
        results
        @endif
    </span>

    <!-- sorting -->
    <div class="d-flex align-items-center">
        <span class="pr-1">order by : </span>
        <select form="products-form" name="ranking" class="p-1 border border-gray bg-light rounded js-submit-onchange" data-id="products-form">
            @php
            $options = [
            ["span" => "rating", "value" => "rating desc"],
            ["span" => "best deals", "value" => "promotion desc"],
            ["span" => "price low to high", "value" => "price asc"],
            ["span" => "price high to low", "value" => "price desc"],
            ["span" => "top sells", "value" => "total_sells desc"]
            ]
            @endphp

            @foreach($options as $option)
            @php $selected = old("ranking") == $option["value"] ? "selected" : "" @endphp
            <option value="{{ $option['value'] }}" {{ $selected }}>{{ $option['span'] }}</option>
            @endforeach
        </select>
    </div>

</section>

<!-- section container -->
<section class="container-fluid bg-white">
    <div class="row">
        <!-- section sidebar -->
        <section class="col-2">
            <div class="sticky-top">
                @include("inc/products_sidebar")
            </div>
        </section>


        <!-- section products list -->
        <section class="col">
            @if(count($products) > 0)
            <div class="row align-items-stretch">
                @foreach($products as $product)
                <!-- vars -->
                @php
                $price = explode('.' ,$product->price);
                $price_int = $price[0];
                $price_dec = $price[1];
                @endphp

                <!-- product -->
                <div class="col-sm-6 col-md-4 col-lg-3 p-3 border border-gray position-relative">

                    <!-- promotion -->
                    @if($product->promotion)
                    <div class="position-absolute bg-success text-white top-0 right-0 font-weight-bold py-1 px-3 h5">
                        -
                        <span> {{ $product->promotion }} </span>
                        %
                    </div>
                    @endif

                    <!-- image -->
                    <a href="/products/{{ $product->id }}" class="d-center" style="height:15rem">
                        <img src="/storage/{{ $product->main_image }}" class="img-fluid">
                    </a>

                    <!-- name -->
                    <a href="/products/{{ $product->id }}" class="d-block hover-text-main-dark h6 pt-4" title="{{ $product->name }}">
                        {{text_dots($product->name)}}
                    </a>

                    <!-- rating -->
                    <div class="d-flex align-items-center">
                        @if($product->rating)
                        <a href="#" class="text-main mr-2">{{ stars($product->rating) }}</a>
                        <span class="text-info">{{ $product->total_reviews }}</span>
                        @endif
                    </div>


                    <!-- price -->
                    <div class="pt-2">
                        <!-- current price -->
                        <span class="pr-4">
                            <span class="h3 font-weight-bold">{{$price_int}}</span>
                            <span class="h6">.{{$price_dec}}</span>
                            <span class="pl-1 h6">DH</span>
                        </span>

                        <!-- if promotion -->
                        @if($product->promotion)
                        <span class="text-muted text-line-through">
                            {{ $product->original_price }}
                            DH
                        </span>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>


            <!-- products pagination -->
            <div class="d-center pt-5">
                {{ $products->links() }}
            </div>

            <!-- no products found -->
            @else
            <h5 class="text-muted pt-5 text-center">Sorry, no products were found ...</h5>
            @endif
        </section>

        <!-- section cart -->
        @if(count($cart_products))
        <section class="col-1">
            <div class="sticky-top">
                <!-- title -->
                <div class="pt-2 text-center">
                    <a href="/cart" class="text-info hover-text-underline">
                        Your Cart
                    </a>
                </div>
                <hr class="my-2">

                <!-- carousel -->
                <div style="height: 70vh">
                    {{ carousel_vertical($cart_products) }}
                </div>
            </div>
        </section>
        @endif

    </div>
</section>
@endsection