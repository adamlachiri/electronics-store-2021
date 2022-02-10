@extends("inc/layout")

@section("content")

<!-- vars -->
@php
$categories = \App\Models\Category::limit(4)->get();
@endphp

<!-- navbar -->
@include("inc/navbar")

<!-- header -->
<header>
    <!-- carousel fade -->
    <section class="js-carousel-lg">
        <!-- slider -->
        <div class="js-slider">

            <!-- phones & tablets -->
            <a href="products?category_id=10" class="d-block pl-5 js-item bg-cover bg-bottom bg-no-repeat" style="background-image: url('storage/ads/header3.png'); height: 20rem">
                <div class="w-50 h-100 pl-5 d-center text-josefin font-weight-bold">
                    <h2 class="text-uppercase">phones & tablets</h2>
                </div>
            </a>

            <!-- gaming -->
            <a href="products?category_id=8" class="d-block pl-5 js-item bg-cover bg-bottom bg-no-repeat" style="background-image: url('storage/ads/header1.png'); height: 20rem">
                <div class="w-50 h-100 pl-5 d-center text-josefin font-weight-bold">
                    <h2 class="text-uppercase">for gamers</h2>
                </div>
            </a>
            <!-- computers & accessories -->
            <a href="products?category_id=11" class="d-block pl-5 js-item bg-cover bg-bottom bg-no-repeat" style="background-image: url('storage/ads/header2.png'); height: 20rem">
                <div class="w-50 h-100 pl-5 d-center text-josefin font-weight-bold">
                    <h2 class="text-uppercase">computers & accessories</h2>
                </div>
            </a>
            <!-- phones & tablets -->
            <a href="products?category_id=10" class="d-block pl-5 js-item bg-cover bg-bottom bg-no-repeat" style="background-image: url('storage/ads/header3.png'); height: 20rem">
                <div class="w-50 h-100 pl-5 d-center text-josefin font-weight-bold">
                    <h2 class="text-uppercase">phones & tablets</h2>
                </div>
            </a>

            <!-- gaming -->
            <a href="products?category_id=8" class="d-block pl-5 js-item bg-cover bg-bottom bg-no-repeat" style="background-image: url('storage/ads/header1.png'); height: 20rem">
                <div class="w-50 h-100 pl-5 d-center text-josefin font-weight-bold">
                    <h2 class="text-uppercase">for gamers</h2>
                </div>
            </a>
        </div>

        <!-- next & prev -->
        <div class="position-absolute bottom-0 left-0 right-0 pb-2 d-flex align-items-center">
            <!-- prev -->
            <i class="fas fa-chevron-left fa-2x py-2 px-4 bg-light border border-gray js-prev hover-opacity"></i>
            <!-- next -->
            <i class="fas fa-chevron-right fa-2x py-2 px-4 bg-light border border-gray js-next hover-opacity"></i>
        </div>

        <!-- pagination -->
        <div class="js-pagination-container d-none">
            <div class="js-pagination-btn bg-light" style="height:0.7rem; width:3rem"></div>
            <div class="js-pagination-btn" style="height:0.7rem; width:3rem"></div>
            <div class="js-pagination-btn" style="height:0.7rem; width:3rem"></div>
        </div>
    </section>
</header>


<!-- categories container -->
<div class="container-fluid pt-5">
    <!-- section categories -->
    <section class="row text-capitalize">
        @foreach($categories as $category)
        <div class="col-6 col-lg-3 p-2">
            <div class="bg-white border border-gray px-3">
                <!-- title -->
                <div class="py-3">
                    <h5 class="font-weight-bold">{{ $category->name }}</h5>
                </div>

                <!-- image -->
                <a href="products?category_id={{ $category->id }}" class="d-center mt-2" style="height: 20rem;">
                    <img src="storage/{{ $category->random_product->main_image }}" class="img-fluid" alt="">
                </a>

                <!-- link -->
                <div class="py-2">
                    <a href="products?category_id={{ $category->id }}" class="text-info">explore</a>
                </div>
            </div>
        </div>
        @endforeach
    </section>
</div>

<!-- container fluid -->
<div class="container-fluid py-5">

    @auth
    @php
    $histories = App\Models\History::where("user_id", "=", Auth::id())->limit(10)->orderBy("created_at", "desc")->get()
    @endphp

    @if(count($histories) > 0)
    <!-- history recomendation -->
    <section class="bg-white p-3 my-2">

        <!-- title -->
        <h4 class="pr-5">Latest products you visited</h4>

        <!-- carousel -->
        <div class="js-carousel ease-out-fast pt-5">

            <!-- slider container -->
            <div class="js-slider-container">

                <!-- prev btn -->
                <div class="js-btn-container position-absolute left-0 top-0 bottom-0 z-2">
                    <i class="fas fa-chevron-left fa-2x js-prev py-5 px-2 bg-white border border-gray hover-opacity"></i>
                </div>

                <!-- items -->
                <div class="js-slider">
                    @foreach($histories as $history)
                    <a href="products/{{ $history->product->id }}">
                        <img src="storage/{{ $history->product->main_image }}" height=150 width=auto class="mx-3" alt="" title="{{ $history->product->name }}">
                    </a>

                    @endforeach
                </div>

                <!-- next btn -->
                <div class="js-btn-container position-absolute right-0 top-0 bottom-0">
                    <i class="fas fa-chevron-right fa-2x js-next py-5 px-2 bg-white border border-gray hover-opacity"></i>
                </div>
            </div>

            <!-- carousel scrollbar -->
            <div class="js-scrollbar-container mt-3" style="height: 0.7rem;">
                <div class="js-scrollbar bg-gray border border-gray rounded right-0 left-0 "></div>
            </div>
        </div>

    </section>
    @endif

    @endauth

    <!-- section best deals -->
    <section class="bg-white p-3 my-2">
        <!-- title -->
        <div class="d-flex align-items-center text-capitalize">
            <h4 class="pr-5">best deals of the week</h4>
            <a href="products?ranking=promotion desc" class="text-info hover-text-underline">see more</a>
        </div>
        <!-- carousel -->
        {{ carousel(\App\Models\Product::orderBy("promotion", "desc")->limit(15)->get()) }}
    </section>

    <!-- ad 1 -->
    {{banner_ad( \App\Models\Ad::find(12))}}

    <!-- section best rating -->
    <section class="bg-white p-3 my-2">
        <!-- title -->
        <div class="d-flex align-items-center text-capitalize">
            <h4 class="pr-5">top rated products</h4>
            <a href="products?ranking=rating desc" class="text-info hover-text-underline">see more</a>
        </div>

        <!-- carousel -->
        {{ carousel(\App\Models\Product::orderBy("rating", "desc")->limit(15)->get()) }}
    </section>

    <!-- ad 2 -->
    {{banner_ad( \App\Models\Ad::find(11))}}

    <!-- section under 100 -->
    <section class="bg-white p-3 my-2">

        <!-- title -->
        <div class="d-flex align-items-center text-capitalize">
            <h4 class="pr-5">under 100 DH products</h4>
            <a href="products?max_price=100" class="text-info hover-text-underline">see more</a>
        </div>

        <!-- carousel -->
        {{ carousel(\App\Models\Product::where("price", "<", "100" )->limit(15)->get()) }}

    </section>

    <!-- section sign in -->
    @guest
    <section class="pt-5">
        <!-- title -->
        <h4 class="text-center">Sign in for better experience !!</h4>

        <!-- sign in -->
        <div class="text-center pt-3">
            <a href="login" class="btn btn-main w-25">sign in</a>
        </div>

        <!-- sign up -->
        <div class="text-center pt-2">
            <a href="register" class="text-info hover-text-underline">I don't have an account</a>
        </div>

    </section>
    @endguest
</div>

<!-- back to top -->
<a href="#" class="d-block bg-dark hover-opacity text-light text-center py-3">Back to top</a>

@endsection