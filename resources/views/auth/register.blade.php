@extends('inc/layout')

@section('content')

<!-- navbar -->
@include("inc/navbar")

<section class="container-fluid">
    <div class="row justify-content-center py-5">
        <form action="register" method="post" class="border border-gray col-10 col-sm-8 col-d-6 col-lg-4 bg-white p-5">
            @csrf
            <!-- title -->
            <h3 class="text-capitalize">create account</h3>

            <!-- seperation -->
            <hr class="my-3">

            <!-- name -->
            <div class="form-group">
                <label class="font-weight-bold required">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror focus-shadow-main" aria-describedby="nameHelp" placeholder="Enter your name">
                <!-- error -->
                @error("name")
                <div class="text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{$message}}
                </div>
                @enderror
            </div>

            <!-- email -->
            <div class="form-group">
                <label class="font-weight-bold required">Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror focus-shadow-main" aria-describedby="emailHelp" placeholder="Enter your email">
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
                <label class="font-weight-bold required">password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror focus-shadow-main" aria-describedby="passwordHelp" placeholder="at least 6 characters">
                <!-- error -->
                @error("password")
                <div class="text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{$message}}
                </div>
                @enderror
            </div>



            <!-- confirm password -->
            <div class="form-group">
                <label class="font-weight-bold required">confirm your password</label>
                <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror focus-shadow-main" aria-describedby="passwordHelp">
                <!-- error -->
                @error("password_confirmation")
                <div class="text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{$message}}
                </div>
                @enderror
            </div>



            <!-- agree -->
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="agree">
                <label class="form-check-label">I have read and agreed on the terms</label>
            </div>

            <!-- submit -->
            <div class="d-flex align-items-center justify-content-between pt-3">
                <!-- submit btn -->
                <button type="submit" class="btn btn-main text-dark mr-5">register</button>

                <!-- login option -->
                <a href="login" class="text-primary">
                    Already have an account
                </a>
            </div>

        </form>
    </div>

</section>
@endsection