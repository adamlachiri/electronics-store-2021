@extends('inc/layout')

@section('content')
<section class="h-vh d-center">
    <form action="{{ route('password.email') }}" method="post" class=" b-full b-gray w-lg-6 w-md-8 w-10 mx-auto bg-white">
        @csrf
        <!-- title -->
        <div class="pl-5 t-3 py-3 bg-gray-1">
            reset password
        </div>

        <!-- success -->
        @if (session('status'))
        <div class="py-2 t-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <!-- inputs -->
        <section class="px-5">
            <!-- email -->
            <div class="d-flex pt-4 a-center">
                <!-- title -->
                <div class="w-4 pr-5 t-end ">
                    email
                </div>
                <!-- input -->
                <input type="email" class="w-8 @error('email') b-alert @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            <!-- error msg -->
            @error("email")
            <div class="w-8 ml-auto t-alert pt-1">
                {{$message}}
            </div>
            @enderror

            <!-- btn -->
            <div class="d-center py-4">
                <!-- btn -->
                <button class="btn btn-primary btn-medium">send password reset link</button>
            </div>
        </section>
    </form>
</section>
@endsection