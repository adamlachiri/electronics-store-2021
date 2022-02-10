@extends('inc/layout')

@section('content')

<!-- vars -->
@php
$order_items = Auth::user()->order_items;
@endphp

<!-- navbar -->
@include("inc/navbar")

<section class="container-fluid">
    <div class="row flex-nowrap">
        <!-- admin sidebar -->
        @include("inc/profile_sidebar")

        <!-- page -->
        <div class="text-dark col p-5">
            <div class="p-5 bg-white">
                <!-- title -->
                <h4 class="text-center pb-2">your orders</h4>

                <!-- order_items -->
                @if(count($order_items) > 0)
                <table class="table-bordered w-100">
                    <thead class="text-capitalize">
                        <tr class="bg-dark text-light">
                            <th scope="col" class="p-1">order id</th>
                            <th scope="col" class="p-1">product name</th>
                            <th scope="col" class="p-1">unit price (DH)</th>
                            <th scope="col" class="p-1">quantity</th>
                            <th scope="col" class="p-1">order date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($order_items as $key => $order_item)
                        <tr class="{{ $key % 2 == 0 ? '' : 'bg-light' }}">
                            <!-- image -->
                            <td class="p-1">
                                {{ $order_item->order_id }}
                            </td>

                            <!-- name -->
                            <td class="p-1">
                                <a href="products/{{ $order_item->product->id }}" class="hover-text-main-dark">{{ $order_item->product->name }}</a>
                            </td>

                            <!-- unit price -->
                            <td class="p-1">
                                {{ $order_item->unit_price }}
                            </td>

                            <!-- quantity -->
                            <td class="p-1">
                                {{$order_item->quantity}}
                            </td>


                            <!-- order_date -->
                            <td class="p-1">
                                {{$order_item->created_at}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- no order_items found -->
        @else
        <h5 class="text-muted text-center pt-5">
            You haven't ordered anything yet
        </h5>
        @endif

    </div>


    </div>
</section>
@endsection