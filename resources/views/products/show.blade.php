@extends('inc/layout')

@section('content')

<!-- vars -->
@php
$in_cart = App\Models\Cart::where("user_id", "=", Auth::id())->where("product_id", "=", $product->id)->exists();
$in_favourite = App\Models\Favourite::where("user_id", "=", Auth::id())->where("product_id", "=", $product->id)->exists();
$same_category = App\Models\Product::where("category_id", "=", $product->category_id)->where("id", "!=", $product->id)->orderBy("rating", "desc")->limit(10)->get();
$advertised_product_0 = $same_category[0];
$advertised_product_1 = $same_category[1];
@endphp

<!-- navbar -->
@include("inc/navbar")

<section class="container-fluid bg-white">
    <!-- infos bar -->
    <p class="text-muted">> {{ $product->category->name }}</p>

    <!-- section product -->
    <section class="row">
        <!-- section image -->
        <section class="p-3 col-10 mx-auto col-lg-4 col-md-6">
            <!-- images list -->
            @php
            $list = ["main_image", "image_1", "image_2"]
            @endphp
            <div class="d-flex align-items-center">
                @foreach($list as $image)
                @if($product[$image])
                <div data-src={{ $product[$image] }} class="hover-shadow-main border border-gray m-1 d-center" style="width:3rem; height:2rem" onmouseover="
                document.getElementById('main-image').src = 'storage/' + this.dataset.src;
                ">
                    <img src="storage/{{ $product[$image] }}" class="img-fluid" alt="">
                </div>
                @endif
                @endforeach
            </div>

            <!-- main image -->
            <div class="d-center pt-2 position-relative" style="height:30rem">

                <!-- img -->
                <img id="main-image" src="storage/{{$product->main_image}}" class="img-fluid cursor-pointer" alt="" onclick="
                document.getElementById('zoomed-image-container').classList.remove('d-none');
                document.getElementById('zoomed-image').src = this.src;
                " title="click to expand">

                <!-- promotion -->
                @if($product->promotion)
                <div class="position-absolute bg-success text-white top-0 right-0 py-1 px-3">
                    Save
                    <span> {{ $product->promotion }} </span>
                    %
                </div>
                @endif
            </div>

            <!-- text -->
            <p class="text-muted pt-2 text-center">
                Click on the image to expand
            </p>
        </section>

        <!-- section infos -->
        <section class="p-3 col-lg-5 col-md-6">
            <!-- title -->
            <h4>{{ $product->name }}</h4>

            <!-- store link -->
            <a href="#" class="text-info hover-text-underline">Visit product store site</a>

            <!-- stock situation -->
            <h5>{{ stock_situation($product->stock) }}</h5>

            <!-- coupon code -->
            @if($product->coupon_reduction)
            <h6 class="text-success">With coupon code for a {{ $product->coupon_reduction }}% reduction</h6>
            @endif

            <!-- guarantee -->
            @if($product->guarantee)
            <h6 class="text-capitalize">
                {{$product->guarantee}} months guarantee
            </h6>
            @endif

            <!-- rating -->
            <div class="d-flex align-items-center">
                <a href="#" class="text-main mr-2">{{ stars($product->rating) }}</a>
                <span class="text-info"> from {{ $product->total_reviews }} reviewers</span>
            </div>

            <!-- price -->
            @php
            $price = explode('.' ,$product->price);
            $price_int = $price[0];
            $price_dec = $price[1];
            @endphp
            <div>
                <!-- current price -->
                <span class="pr-4">
                    <span class="h4 font-weight-bold">{{$price_int}}</span>
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
            <hr>

            <!-- description -->
            <div>
                <h5 class="font-weight-bold">About the product</h5>
                <ul class="list-square pl-3">
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia sapiente perferendis fuga totam delectus laudantium voluptate debitis reprehenderit, eum sint!</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. A temporibus numquam distinctio in! Sed rem distinctio libero adipisci quaerat iure saepe a aut facere doloremque.</li>
                    <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Veniam praesentium nulla provident ipsam quod temporibus.</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea, sunt! Facere, dicta. Labore magnam similique ex, odit deserunt nihil incidunt in earum sapiente suscipit odio officiis quae sequi, eaque voluptate voluptatem? Eius.</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat.</li>
                </ul>
            </div>


            <!-- video -->
            @if($product->video)
            <div class="pt-2">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ $product->video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            @endif

        </section>

        <!-- section btns -->
        <section class="col-lg-3">

            @if(!$in_cart || !$in_favourite)
            <!-- btns -->
            <div class="p-2">
                <div class="p-3 border border-gray rounded">
                    <!-- price -->
                    <div class="pb-2 font-weight-bold">
                        <span class="pr-2">Unit Price :</span>
                        <span class="text-danger">{{ $product->price }} DH</span>
                    </div>

                    <!-- add to cart -->
                    @if(!$in_cart && $product->stock > 0)
                    <form action="cart" method="post">
                        @csrf

                        <!-- hidden infos -->
                        <input type="text" name="product_id" class="d-none" value="{{ $product->id }}">

                        <!-- coupon code -->
                        @if($product->coupon_code)
                        <div class="pb-2">
                            <input type="password" class="border border-gray rounded w-100" name="coupon_code" placeholder="Enter a coupon code">
                        </div>
                        @endif

                        <!-- quantity & submit -->
                        <div>
                            <!-- quantity -->
                            <div>
                                <span class="pr-2">Qty :</span>
                                <select name="quantity" class="border border-gray rounded bg-light py-1">
                                    @foreach([1,2,3,4,5,6,7,8,9,10] as $number)

                                    @if($number <= $product->stock)
                                        <option value="{{ $number }}">{{ $number }}</option>
                                        @endif
                                        @endforeach
                                </select>
                            </div>

                            <!-- submit -->
                            <div class="pt-2">
                                <button class="btn btn-main btn-sm w-100">
                                    <i class="fas fa-plus pr-1"></i>
                                    <span>add to cart</span>
                                </button>
                            </div>
                        </div>



                    </form>
                    @endif


                    <!-- admin btn -->
                    @admin
                    <div class="pt-2">
                        <a href="products/{{ $product->id }}/edit" class="w-100 btn btn-main btn-sm">
                            edit product
                        </a>
                    </div>

                    <!-- advertise -->
                    <div class="pt-2">
                        <a href="ads?product_id={{ $product->id }}" class="w-100 btn btn-main btn-sm">
                            advertise
                        </a>
                    </div>
                    @endadmin

                    <hr>

                    <!-- add to favourites -->
                    @if(!$in_favourite)
                    <form method="post" action="favourites">
                        @csrf
                        <input type="text" name="product_id" class="d-none" value="{{ $product->id }}">
                        <button type="submit" class="w-100 btn btn-gray btn-sm">
                            <span>add to favourites</span>
                        </button>
                    </form>
                    @endif

                </div>
            </div>

            @endif

            <!-- ad -->
            <div class="p-2">
                {{ card_ad($advertised_product_0) }}
            </div>

        </section>
    </section>

    <!-- seperation -->
    <hr>

    <!-- review product -->
    @if(App\Models\Order_item::where("user_id", "=", Auth::id())->where("product_id", "=", $product->id)->exists())
    <section class="pt-2 container-fluid">
        <div class="row justify-content-center">
            @if(App\Models\Review::where("user_id", "=", Auth::id())->where("product_id", "=", $product->id)->exists())

            <!-- vars -->
            @php
            $review = App\Models\Review::where("user_id", "=", Auth::id())->where("product_id", "=", $product->id)->first();
            @endphp

            <!-- edit review -->
            <form action="reviews/{{ $review->id }}" method="post" class="col-md-6">
                @csrf
                @method("put")

                <!-- title -->
                <h4 class="text-capitalize">edit review</h4>

                <!-- rating -->
                <div class="form-group pt-5">
                    <fieldset class="border border-gray rounded p-2">
                        <legend class="h6 text-muted px-2">Rerate the product</legend>
                        <div class="d-center text-main text-shadow">
                            @foreach([1,2,3,4,5] as $rating)
                            <label data-rating="{{ $rating }}" class="mx-2 cursor-pointer" onclick="
                        rating(this.dataset.rating);
                        ">
                                <input type="radio" name="rating" value="{{ $rating }}" class="d-none">
                                <i data-rating="{{ $rating }}" id="star-{{ $rating }}" class="far fa-star fa-lg"></i>
                            </label>
                            @endforeach
                        </div>
                    </fieldset>
                    <!-- error -->
                    @error("rating")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror

                    <!-- js -->
                    <script>
                        function rating(num) {
                            const stars = ["star-1", "star-2", "star-3", "star-4", "star-5"];
                            for (let i = 0; i < stars.length; i++) {
                                // html
                                let star = document.getElementById(stars[i]);
                                let rating = star.dataset.rating;

                                // exe
                                if (num >= rating) {
                                    star.classList.remove("far");
                                    star.classList.add("fas");
                                } else {
                                    star.classList.remove("fas");
                                    star.classList.add("far");
                                }
                            }
                        }
                    </script>
                </div>

                <!-- comment -->
                <div class="form-group">
                    <textarea name="comment" class="form-control" rows="3" placeholder="Leave a comment">{{ $review->comment}}</textarea>
                    <!-- error -->
                    @error("comment")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>


                <!-- btns -->
                <div class="pt-2 d-flex align-items-center justify-content-between">
                    <button type="submit" class="btn btn-main">edit your review</button>
                </div>
            </form>

            @else
            <!-- create review -->
            <form action="reviews" method="post" class="col-md-6">
                @csrf

                <!-- title -->
                <h4 class="text-capitalize">review the product</h4>
                <hr>

                <!-- hidden infos -->
                <input type="text" name="product_id" value="{{ $product->id }}" class="d-none">

                <!-- rating -->
                <div class="form-group">
                    <fieldset class="border border-gray rounded p-2">
                        <legend class="h6 text-muted px-2">Rate the product</legend>
                        <div class="d-center text-main text-shadow">
                            @foreach([1,2,3,4,5] as $rating)
                            <label data-rating="{{ $rating }}" class="mx-2 cursor-pointer" onclick="
                        rating(this.dataset.rating);
                        ">
                                <input type="radio" name="rating" value="{{ $rating }}" class="d-none">
                                <i data-rating="{{ $rating }}" id="star-{{ $rating }}" class="far fa-star fa-lg"></i>
                            </label>
                            @endforeach
                        </div>
                    </fieldset>
                    <!-- error -->
                    @error("rating")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror

                    <!-- js -->
                    <script>
                        function rating(num) {
                            const stars = ["star-1", "star-2", "star-3", "star-4", "star-5"];
                            for (let i = 0; i < stars.length; i++) {
                                // html
                                let star = document.getElementById(stars[i]);
                                let rating = star.dataset.rating;

                                // exe
                                if (num >= rating) {
                                    star.classList.remove("far");
                                    star.classList.add("fas");
                                } else {
                                    star.classList.remove("fas");
                                    star.classList.add("far");
                                }
                            }
                        }
                    </script>
                </div>

                <!-- comment -->
                <div class="form-group">
                    <textarea name="comment" class="form-control" rows="3" placeholder="Leave a comment"></textarea>
                    <!-- error -->
                    @error("comment")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>


                <!-- btns -->
                <div class="pt-2 d-flex align-items-center justify-content-between">
                    <button type="submit" class="btn btn-main">post review</button>
                </div>
            </form>
            @endif
        </div>

    </section>
    <hr>
    @endif



    <!-- section reviews -->
    <section class="container-fluid">
        <!-- header -->
        <div class="d-flex align-items-center justify-content-between">
            <!-- title -->
            <h4 class="text-capitalize">reviews</h4>

            <!-- sorting -->
            <form id="reviews-form" action="" method="get" class="d-flex align-items-center">
                @csrf

                <select form="reviews-form" name="ranking" class="p-1 border border-gray bg-light rounded" onchange="
                document.getElementById('reviews-form').submit();
                ">
                    <!-- vars -->
                    @php
                    $options = [
                    ["span" => "high to low rating", "value" => "rating desc"],
                    ["span" => "low to high rating", "value" => "rating asc"],
                    ]
                    @endphp

                    <option disabled selected>sort by ...</option>
                    @foreach($options as $option)
                    @php
                    $selected = $ranking == $option["value"] ? "selected" : ""
                    @endphp
                    <option value="{{ $option['value'] }}" {{ $selected }}>{{ $option['span'] }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- reviews & ad -->
        <section class="pt-5 row">
            <!-- reviews -->
            <div class="col pr-5">
                @if(count($reviews) > 0)
                @foreach($reviews as $review)
                <!-- review -->
                <div class="py-2">

                    <div class="d-flex align-items-center">
                        <!-- profile image -->
                        <div class="circle border border-gray bg-cover bg-center bg-no-repeat" style="width: 3rem; background-image: url('storage/{{ $review->user->profile->image }}')"></div>

                        <!-- username -->
                        <span class="pl-2 font-weight-bold text-capitalize">{{ $review->user->name}}</span>
                    </div>

                    <!-- rating -->
                    <div class="pt-1 text-main">
                        {{ stars($review->rating) }}
                        <span class="pl-2 text-info">Verified purchase</span>
                    </div>

                    <!-- comment -->
                    <p class="pt-2">
                        {{ $review->comment }}
                    </p>

                </div>
                @endforeach
                @else
                <h5 class="text-muted">
                    No posted reviews so far ...
                </h5>
                @endif
            </div>

            <!-- ad -->
            <div class="col-lg-3 col-md-4 d-md-block">
                {{ card_ad($advertised_product_1) }}
            </div>
        </section>


        <!-- reviews pagination -->
        <div class="pt-5">
            {{ $reviews->links() }}
        </div>

    </section>

    <!-- separation -->
    <hr>

    <!-- section same category -->
    <section class="container-fluid pb-5">
        <!-- title -->
        <div class="d-flex align-items-center text-capitalize">
            <h4 class="pr-5">same category</h4>
            <a href="products?category_id={{ $product->category_id }}" class="text-info hover-text-underline">see more</a>
        </div>

        <!-- carousel -->
        {{carousel($same_category)}}

    </section>
</section>

<!-- section zoomed image -->
<section id="zoomed-image-container" class="fixed-full d-none d-center h-100 p-5 bg-white z-5">

    <!-- close btn -->
    <button class="p-2 text-muted hover-opacity position-fixed top-0 right-0" onclick="document.getElementById('zoomed-image-container').classList.add('d-none')">
        <i class="fas fa-compress fa-2x"></i>
    </button>

    <!-- zoomed image -->
    <img id="zoomed-image" src="" class="img-fluid" alt="">

</section>



@endsection