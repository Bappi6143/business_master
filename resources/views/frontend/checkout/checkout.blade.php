@extends('frontend.master')

@section('content')
<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{route('home')}}">Home</a>
                <a class="breadcrumb-item text-dark" href="{{route('shop')}}">Shop</a>
                <a class="breadcrumb-item text-dark" href="{{route('checkout')}}">Checkout</a>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Checkout Start -->
<div class="container-fluid">
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Billing Address</span>
                </h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Full Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phone Number</label>
                            <input class="form-control" type="text" name="phone" placeholder="Enter your phone number" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <h5 class="section-title text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Order Summary</span>
                </h5>
                <div class="bg-light p-30 mb-5">
                    <h6>Products</h6>
                    <div class="border-bottom mb-3">
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                        <div class="d-flex justify-content-between">
                            <p>{{ $item['title'] }} (x{{ $item['quantity'] }})</p>
                            <p>${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>${{ number_format($total, 2) }}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6>Shipping</h6>
                        <h6>$10.00</h6>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <h5>Total</h5>
                        <h5>${{ number_format($total + 10, 2) }}</h5>
                    </div>

                    <input type="hidden" name="cart" value="{{ json_encode($cart) }}">
                    <input type="hidden" name="subtotal" value="{{ $total }}">
                    <input type="hidden" name="total" value="{{ $total + 10 }}">

                    <button class="btn btn-block btn-primary font-weight-bold py-3 mt-4">Place Order</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Checkout End -->
@endsection
