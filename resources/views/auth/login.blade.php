@extends('inc/layout')

@section('content')

<!-- navbar -->
@include("inc/navbar")

<section class="container-fluid">
    <div class="row justify-content-center py-5">
        <form action="login" method="post" class="border border-gray col-10 col-sm-8 col-d-6 col-lg-4 bg-white p-5">
            @csrf
            <!-- title -->
            <h3 class="text-capitalize">sign in</h3>
            <p class="text-muted">use the placeholder identifiers to connect</p>

            <!-- seperation -->
            <hr class="my-3">

            <!-- email -->
            <div class="form-group">
                <label class="font-weight-bold">Email address</label>
                <input value="guest@gmail.com" type="email" name="email" class="form-control @error('email') is-invalid @enderror focus-shadow-main" aria-describedby="emailHelp" placeholder="Enter your email">
                <!-- error -->
                @error("email")
                <div class="text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{$message}}
                </div>
                @enderror
            </div>


            <!-- password -->
            <div class="form-group">
                <label class="font-weight-bold">password</label>
                <input value="123456" type="password" name="password" class="form-control @error('password') is-invalid @enderror focus-shadow-main" aria-describedby="passwordHelp">
                <!-- error -->
                @error("password")
                <div class="text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{$message}}
                </div>
                @enderror
            </div>


            <!-- remember -->
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label">remember me</label>
            </div>

            <!-- submit section -->
            <div class="d-flex align-items-center justify-content-between pt-3">
                <!-- submit -->
                <button type="submit" class="btn btn-main text-dark mr-5">login</button>

                <!-- register option -->
                <a href="register" class="text-primary">
                    Create an account
                </a>
            </div>
    </div>

    </form>
    </div>

</section>
@endsection