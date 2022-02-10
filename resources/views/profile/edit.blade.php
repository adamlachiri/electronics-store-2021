@extends('inc/layout')

@section('content')

<!-- navbar -->
@include("inc/navbar")

<section class="container-fluid">
    <div class="row flex-nowrap">
        <!-- profile sidebar -->
        @include("inc/profile_sidebar")

        <!-- page -->
        <div class="p-5 col">
            <form action="profile/{{ Auth::user()->id }}" method="post" enctype="multipart/form-data" class="border border-gray p-5 bg-white">
                @csrf
                @method("put")

                <!-- image -->
                <div class="row justify-content-center">
                    <div class="col-2 p-0 circle border border-gray bg-cover bg-no-repeat bg-center" style="background-image: url('storage/{{ Auth::user()->profile->image }}')">
                    </div>
                </div>

                <!-- image input -->
                <div class="text-center pt-2 pb-3">
                    <label class="btn btn-secondary">
                        <i class="fas fa-camera pr-1"></i>
                        <span>change picture</span>
                        <input type="file" name="image" class="d-none">
                    </label>
                    @error("image")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- name -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize required">name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control @error('name') is-invalid  @enderror">
                    @error("name")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- email -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize required">email</label>
                    <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control @error('email') is-invalid  @enderror">
                    @error("email")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- phone -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize optional">phone</label>
                    <div class="d-flex align-items-stretch">
                        <div class="bg-light d-center px-3 border border-gray rounded">+212</div>
                        <input type="text" name="phone" value="{{ Auth::user()->profile->phone }}" class="@error('phone') is-invalid  @enderror flex-grow form-control">
                    </div>
                    @error("phone")
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <!-- address -->
                <div class="form-group">
                    <label class="font-weight-bold text-capitalize optional">address</label>
                    <input type="text" name="address" value="{{ Auth::user()->profile->address }}" class="form-control @error('address') is-invalid  @enderror" placeholder="We will deliver the products you buy to this address">
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
                    <button type="submit" class="btn btn-main text-capitalize text-dark">save the changes</button>
                </div>

            </form>
        </div>
    </div>
    </div>
</section>
@endsection