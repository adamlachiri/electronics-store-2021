@extends('inc/layout')

@section('content')

<!-- navbar -->
@include("inc/navbar")

<section class="container-fluid">
    <div class="row flex-nowrap">
        <!-- admin sidebar -->
        @include("inc/profile_sidebar")

        <!-- page -->
        <div class="p-5 col">
            <form action="profile/change_password" method="post" class="border border-gray bg-white p-5">
                @csrf

                <!-- old password -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize required">current password</label>
                    <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror focus-shadow-main" placeholder="enter your current password">
                    <!-- error -->
                    @error("old_password")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>


                <!-- new password -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize required">new password</label>
                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror focus-shadow-main" placeholder="at least 6 characters">
                    <!-- error -->
                    @error("new_password")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- confirmed password -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize required">re enter password</label>
                    <input type="password" name="confirmed_password" class="form-control @error('confirmed_password') is-invalid @enderror focus-shadow-main" placeholder="confirm your password">
                    <!-- error -->
                    @error("confirmed_password")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>



                <!-- submit section -->
                <div class="pt-3">
                    <!-- submit -->
                    <button type="submit" class="btn btn-main text-dark mr-5">change your password</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection