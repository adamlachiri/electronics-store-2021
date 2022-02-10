@extends('inc/layout')

@section('content')
<div class="bg-white vh-100">

    @include("order/order_steps")

    <section class="container py-5">
        <div class="row">
            <!-- page -->
            <div class="col-md-6">
                <!-- title -->
                <h3 class="text-capitalize">shipping address</h3>
                <hr>

                <!-- form -->
                <form action="order/shipping_address" method="post">
                    @csrf

                    <!-- name -->
                    <div class="form-group">
                        <label class="font-weight-bold text-capitalize required">name</label>
                        <input type="text" name="name" value="{{ old('name') ? old('name') : Auth::user()->name }}" class="form-control @error('name') is-invalid  @enderror">
                        @error("name")
                        <div class="text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <!-- phone -->
                    <div class="form-group">
                        <label class="font-weight-bold text-capitalize required">phone</label>
                        <div class="d-flex align-items-stretch">
                            <div class="bg-light d-center px-3 border border-gray rounded">+212</div>
                            <input type="text" name="phone" value="{{ old('phone') ? old('phone') : Auth::user()->profile->phone }}" class="@error('phone') is-invalid  @enderror flex-grow form-control">
                        </div>
                        @error("phone")
                        <div class="text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <!-- city -->
                    <div class="form-group">
                        <label class="font-weight-bold text-capitalize required">city</label>
                        <select class="form-control text-capitalize" name="city">
                            <option selected disabled>pick your city</option>
                            @php
                            $cities = ["tanger", "rabat", "casablanca", "fes", "meknes", "tetouan", "agadir", "other"];
                            @endphp

                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                        @error("city")
                        <div class="text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{$message}}
                        </div>
                        @enderror
                    </div>


                    <!-- shipping address -->
                    <div class="form-group">
                        <label class="font-weight-bold text-capitalize required">shipping address</label>
                        <input type="text" name="address" value="{{ old('address') ? old('address') : Auth::user()->profile->address }}" class="form-control @error('address') is-invalid  @enderror" placeholder="We will deliver the products you buy to this address">
                        @error("address")
                        <div class="text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <!-- submit -->
                    <div class="d-flex align-items-center justify-content-between pt-3">
                        <!-- submit btn -->
                        <button type="submit" class="btn btn-main text-capitalize text-dark">confirm shipping address</button>
                    </div>

                </form>
            </div>
        </div>

    </section>

</div>
@endsection