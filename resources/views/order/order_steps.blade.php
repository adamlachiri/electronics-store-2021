 <!-- vars -->
 @php
 $order_step = Auth::user()->current_order->step;
 @endphp

 <!-- order steps -->
 <div class="d-center p-5 text-uppercase text-center font-weight-bold">
     <a href="order" class="px-2 {{ $order_step > 1  ? 'text-warning' : '' }}">password confirmation</a>
     <hr class="{{ $order_step > 1 ? 'border-warning' : '' }}" style="width:10%">
     <a href="order/shipping_address_form" class="px-2 {{ $order_step > 2 ? 'text-warning' : '' }}">shipping address</a>
     <hr style="width:10%" class="{{ $order_step > 2  ? 'border-warning' : '' }}">
     <a href="order/payment_method_form" class="px-2 {{ $order_step > 3  ? 'text-warning' : '' }}">place order</a>
 </div>