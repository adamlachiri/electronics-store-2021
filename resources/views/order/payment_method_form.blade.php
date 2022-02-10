@extends('inc/layout')

@section('content')
<div class="bg-white vh-100">

    @include("order/order_steps")

    <div class="container py-5">
        <div class="row d-center">
            <div class="col-md-6 text-capitalize">

                <!-- title -->
                <h3>placing order</h3>
                <hr>

                <!-- form -->
                <form action="order/payment_method" method="post">
                    @csrf

                    <!-- payment method -->
                    <div class="bg-light border borer-gray">
                        <!-- title -->
                        <h5 class="py-3 m-0 text-center border-bottom border-gray">
                            choose your payment method
                        </h5>

                        <!-- payment methods -->
                        <div class="d-flex">
                            <!-- vars -->
                            @php
                            $payment_methods = [
                            ["value" => "credit card", "img" => "storage/icons/credit_card.png"],
                            ["value" => "pay on delivery", "img" => "storage/icons/cash.png"],
                            ["value" => "paypal", "img" => "storage/icons/paypal.png"]
                            ];
                            @endphp

                            @foreach($payment_methods as $payment_method)
                            <label class="col-4 p-0 m-0 border border-gray hover-opacity js-radio position-relative" onclick="
                            radios_check()
                            ">
                                <!-- img -->
                                <div class="d-center p-2 square bg-white">
                                    <img src="{{ $payment_method['img'] }}" class="img-fluid" alt="">
                                </div>
                                <!-- span -->
                                <div class="js-span w-100 py-2 m-0 border border-gray text-center font-weight-bold bg-light">
                                    <span>{{ $payment_method['value'] }}</span>
                                    <input name="payment_method" type="radio" class="d-none js-input" value="{{ $payment_method['value'] }}">
                                </div>
                                <!-- check icon -->
                                <i class="fas fa-check-circle fa-2x text-main p-2 position-absolute top-0 left-0 d-none js-icon"></i>
                            </label>
                            @endforeach
                        </div>
                        <!-- js -->
                        <script>
                            function radios_check() {
                                const radios = document.getElementsByClassName("js-radio");
                                for (let i = 0; i < radios.length; i++) {
                                    // html
                                    const radio = radios[i];
                                    const input = radio.getElementsByClassName("js-input")[0];
                                    const span = radio.getElementsByClassName("js-span")[0];
                                    const icon = radio.getElementsByClassName("js-icon")[0];

                                    // events
                                    if (input.checked) {
                                        radio.classList.add("border-main");
                                        radio.classList.remove("border-gray");
                                        span.classList.add("bg-main");
                                        span.classList.remove("bg-light");
                                        icon.classList.remove("d-none");
                                    } else {
                                        radio.classList.remove("border-main");
                                        radio.classList.add("border-gray");
                                        span.classList.remove("bg-main");
                                        span.classList.add("bg-light");
                                        icon.classList.add("d-none");
                                    }
                                }

                            }
                        </script>
                    </div>

                    <!-- place order -->
                    <div class="pt-5 text-center h5 font-weight-bold">
                        <span class="pr-2">Total amount:</span>
                        <span class="text-danger">{{ Auth::user()->current_order->total_price }} DH</span>
                    </div>
                    <div class="text-center pt-2">
                        <button type="submit" class="btn btn-main btn-large w-100">place order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection