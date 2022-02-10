@extends('inc/layout')

@section('content')

<!-- navbar -->
@include('inc/navbar')

<section class="container-fluid">
    <div class="row">
        <!-- admin sidebar -->
        @include("inc/admin_sidebar")

        <!-- page -->
        <div class="p-5 col">
            <form action="products" method="post" enctype="multipart/form-data" class="border border-gray p-5  bg-white">
                @csrf

                <!-- name -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize required">product name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror focus-shadow-main" aria-describedby="nameHelp">
                    <!-- error -->
                    @error("name")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- category -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize required">category</label>
                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option disabled selected>pick a category ... </option>
                        @foreach($categories as $category)
                        <option class="text-capitalize" value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <!-- error -->
                    @error("category_id")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- original price -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize required">original price (DH)</label>
                    <input type="number" min=1 name="original_price" value="{{ old('original_price') }}" class="form-control @error('original_price') is-invalid @enderror focus-shadow-main" aria-describedby="original_priceHelp">
                    <!-- error -->
                    @error("original_price")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- stock -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize required">stock</label>
                    <input type="number" min=1 name="stock" value="{{ old('stock') }}" class="form-control @error('stock') is-invalid @enderror focus-shadow-main" aria-describedby="stockHelp">
                    <!-- error -->
                    @error("stock")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- images section -->
                <div class="row justify-content-between">
                    <!-- main image -->
                    <div class="form-group col-md-3">
                        <label class="font-weight-bold text-capitalize required">main image</label>
                        <input type="file" name="main_image" class="form-control @error('main_image') is-invalid @enderror focus-shadow-main" aria-describedby="main_imageHelp">
                        <!-- error -->
                        @error("main_image")
                        <div class="text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <!-- image 1 -->
                    <div class="form-group col-md-3">
                        <label class="font-weight-bold text-capitalize optional">image 1</label>
                        <input type="file" name="image_1" class="form-control @error('image_1') is-invalid @enderror focus-shadow-main" aria-describedby="image_1Help">
                        <!-- error -->
                        @error("image_1")
                        <div class="text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <!-- image 2 -->
                    <div class="form-group col-md-3">
                        <label class="font-weight-bold text-capitalize optional">image 2</label>
                        <input type="file" name="image_2" class="form-control @error('image_2') is-invalid @enderror focus-shadow-main" aria-describedby="image_2Help">
                        <!-- error -->
                        @error("image_2")
                        <div class="text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- video -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize optional">video source</label>
                    <input type="text" name="video" value="{{ old('video') }}" class="form-control @error('video') is-invalid @enderror focus-shadow-main" aria-describedby="videoHelp">
                    <!-- error -->
                    @error("video")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- promotion -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize optional">promotion (%)</label>
                    <input type="number" min=1 max=90 name="promotion" value="{{ old('promotion') }}" class="form-control @error('promotion') is-invalid @enderror focus-shadow-main" aria-describedby="promotionHelp">
                    <!-- error -->
                    @error("promotion")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- guarantee -->
                <div class="form-group text-capitalize">
                    <label class="font-weight-bold optional">guarantee</label>
                    <select name="guarantee" class="form-control @error('guarantee') is-invalid @enderror">
                        <option disabled selected>pick a guarantee period ... </option>
                        @php
                        $guarantees = ["6", "12", "24"];
                        @endphp
                        @foreach($guarantees as $guarantee)
                        <option class="text-capitalize" value="{{ $guarantee }}">{{ $guarantee }} months</option>
                        @endforeach
                    </select>
                    <!-- error -->
                    @error("guarantee")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- coupon section -->
                <fieldset class="border border-gray rounded p-2">
                    <legend class="h6 text-muted px-2">Optional</legend>
                    <div class="row justify-content-between">
                        <!-- coupon code -->
                        <div class="form-group col-md-5">
                            <label class="font-weight-bold text-capitalize">coupon code</label>
                            <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" class="form-control @error('coupon_code') is-invalid @enderror focus-shadow-main" aria-describedby="coupon_codeHelp" placeholder="at least 6 characters">
                            <!-- error -->
                            @error("coupon_code")
                            <div class="text-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        <!-- coupon reduction -->
                        <div class="form-group col-md-5">
                            <label class="font-weight-bold text-capitalize">coupon reduction (%)</label>
                            <input type="number" min=1 max=90 name="coupon_reduction" value="{{ old('coupon_reduction') }}" class="form-control @error('coupon_reduction') is-invalid @enderror focus-shadow-main" aria-describedby="coupon_reductionHelp">
                            <!-- error -->
                            @error("coupon_reduction")
                            <div class="text-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <!-- submit -->
                <div class="d-flex align-items-center justify-content-between pt-3">
                    <!-- submit btn -->
                    <button type="submit" class="btn btn-main text-capitalize text-dark">add product</button>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection