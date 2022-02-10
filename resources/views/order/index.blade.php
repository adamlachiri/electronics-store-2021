@extends('inc/layout')

@section('content')
<div class="bg-white vh-100">

    @include("order/order_steps")

    <section class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <!-- title -->
                <h5 class="text-capitalize">password confirmation</h5>
                <hr>
                <!-- form -->
                <form action="order/confirm_password" method="post" class="bg-white pt-3">
                    @csrf

                    <!-- old password -->
                    <div class="form-group">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror focus-shadow-main" placeholder="Enter your password">
                        <!-- error -->
                        @error("password")
                        <div class="text-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <!-- submit section -->
                    <div class="pt-3">
                        <!-- submit -->
                        <button type="submit" class="btn btn-main text-dark mr-5">confirm your password</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>



@endsection