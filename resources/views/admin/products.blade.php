@extends('inc/layout')

@section('content')

<!-- navbar -->
@include('inc/navbar')

<section class="container-fluid">
    <div class="row flex-nowrap">
        <!-- admin sidebar -->
        @include("inc/admin_sidebar")

        <!-- page -->
        <div class="p-5 text-dark col">
            <div class="p-5 border border-gray bg-white">

                <!-- search form -->
                <form action="" method="get" class="border border-main rounded row">
                    @csrf
                    <!-- btn -->
                    <button type="submit" class="bg-main hover-opacity px-3 py-2">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- input -->
                    <input type="text" value="{{ old('name') }}" name="name" class="flex-grow" placeholder="Enter the product name">
                </form>

                <!-- search results -->
                <section class="pt-5">
                    @if(isset($products))
                    @if(count($products) > 0)
                    <!-- table -->
                    <table class="table table-bordered">
                        <thead class="font-weight-bold">
                            <tr>
                                <th class="col-4">image</th>
                                <th class="col-1">id</th>
                                <th class="col-7">name</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $key => $product)
                            <tr class="{{ $key % 2 == 0 ? '' : 'bg-light' }}">
                                <!-- image -->
                                <td class="col-4">
                                    <a href="products/{{ $product->id }}/edit" class="d-center" style="height:15rem">
                                        <img src="storage/{{ $product->main_image }}" class="img-fluid" alt="">
                                    </a>
                                </td>

                                <!-- id -->
                                <td class="col-1">
                                    {{ $product->id }}
                                </td>

                                <!-- name -->
                                <td class="col-7">
                                    <a href="products/{{ $product->id }}/edit" class="hover-text-main-dark h6">{{ $product->name }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>



                    <!-- no products found -->
                    @else
                    <h5 class="text-muted text-center">
                        No product corresponds to your search
                    </h5>
                    @endif
                    @else
                    <h5 class="text-muted text-center">
                        Your search results will appear here
                    </h5>
                    @endif

                </section>

            </div>
        </div>


    </div>
</section>
@endsection