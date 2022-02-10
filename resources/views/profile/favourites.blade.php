@extends('inc/layout')

@section('content')

<!-- vars -->
@php
$favourites = Auth::user()->favourites;
@endphp

<!-- navbar -->
@include("inc/navbar")

<section class="container-fluid">
    <div class="row flex-nowrap">
        <!-- admin sidebar -->
        @include("inc/profile_sidebar")

        <!-- page -->
        <div class="p-5 text-dark col">
            <div class="p-5 border border-gray bg-white">

                <!-- title -->
                <h4>your favourites</h4>
                <hr class="mt-2">

                <!-- favourites -->
                @if(count($favourites) > 0)

                @foreach($favourites as $favourite)
                <!-- favourite -->
                <div class="mt-5 border border-gray rounded row position-relative align-items-center">
                    <!-- image -->
                    <div class="col-lg-3 col-md-5 col-sm-6 d-center p-3">
                        <img src="storage/{{ $favourite->product->main_image }}" class="img-fluid" style="max-height: 10rem" alt="">
                    </div>

                    <!-- infos -->
                    <div class="col-lg-9 col-md-7 col-sm-6 p-3">
                        <!-- name -->
                        <div>
                            <a href="products/{{ $favourite->product->id }}" class="hover-text-main-dark">{{ $favourite->product->name }}</a>
                        </div>

                        <!-- rating -->
                        <div class="pt-2 text-main">
                            {{ stars($favourite->product->rating) }}
                            <span class="pl-1 text-info">{{ $favourite->product->rating }}</span>
                        </div>

                        <!-- price & cart option -->
                        <div class="pt-2 d-flex align-items-center justify-content-between">
                            <!-- price -->
                            @php
                            $price = explode('.' ,$favourite->product->price);
                            $price_int = $price[0];
                            $price_dec = $price[1];
                            @endphp
                            <div class="d-flex flex-wrap align-items-end text-nowrap">
                                <!-- current price -->
                                <span class="pr-4">
                                    <span class="h4 font-weight-bold">{{$price_int}}</span>
                                    <span>.{{$price_dec}}</span>
                                    <span class="pl-1">DH</span>
                                </span>

                                <!-- if promotion -->
                                @if($favourite->product->promotion)
                                <span class="text-muted text-line-through">
                                    {{ $favourite->product->original_price }}
                                    DH
                                </span>
                                @endif
                            </div>
                        </div>


                    </div>

                    <!-- remove option -->
                    <div class="position-absolute top-0 right-0 p-2 hover-opacity text-muted" onclick="
                    this.getElementsByClassName('js-delete-form')[0].classList.toggle('d-none');">
                        <div class=" position-relative">
                            <i class="fas fa-ellipsis-v fa-lg"></i>
                            <!-- remove form -->
                            <form action="favourites/{{ $favourite->id }}" method="post" class="js-delete-form d-none position-absolute bg-white py-1 px-2 shadow-sm rounded" style="top: 100%">
                                @csrf
                                @method('delete')
                                <button type="submit">remove</button>
                            </form>
                        </div>
                    </div>

                </div>
                @endforeach

                <!-- no favourites found -->
                @else
                <h5 class="text-muted text-center pt-5">
                    You don't have any favourite products yet
                </h5>
                @endif
            </div>
        </div>


    </div>
</section>
@endsection