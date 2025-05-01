@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">eCommerce</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Website Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card">
            <div class="card-body p-4">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <!-- Date Filter -->
                    <div class="d-flex gap-2">
                        <input type="date" class="form-control" placeholder="Start Date">
                        <input type="date" class="form-control" placeholder="End Date">
                        <button class="btn btn-primary">Filter</button>
                    </div>
                </div>

                <!-- Display Checkout Data -->
                <div class="table-responsive mt-4" style="overflow: visible !important;">
                    <table id="example2" class="table table-striped table-bordered radius-10">
                        <thead class="text-dark-blue">
                            <tr>
                                <th>Customer Details</th>
                                <th>Product Details</th>
                                <th>Order Details</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checkouts as $checkout)
                            <tr>
                                <td>
                                    <div><strong>Name:</strong> {{ $checkout->name }}</div>
                                    <div><strong>Phone:</strong> {{ $checkout->phone }}</div>
                                    <div><strong>Address:</strong> {{ $checkout->address }}</div>
                                </td>
                                <td>
                                    @php
                                    // Ensure cart_data is decoded correctly
                                    $cartItems = is_array($checkout->cart_data) ? $checkout->cart_data : json_decode($checkout->cart_data, true);
                                    @endphp

                                    @if(is_array($cartItems) && count($cartItems) > 0)
                                    @foreach($cartItems as $cart)
                                    <div><strong>Product Name:</strong> {{ $cart['product_name'] ?? 'N/A' }}</div>
                                    <div><strong>Quantity:</strong> {{ $cart['quantity'] ?? '0' }}</div>
                                    @endforeach
                                    @else
                                    <div>No products found</div>
                                    @endif
                                </td>
                                <td>
                                    <div><strong>Subtotal:</strong> {{ $checkout->subtotal }}</div>
                                    <div><strong>Shipping:</strong> {{ $checkout->shipping_charge }}</div>
                                    <div><strong>Total:</strong> {{ $checkout->total }}</div>
                                </td>
                                
                                <td>
                                    <!-- <a href="#" class="btn btn-warning btn-sm">Edit</a> -->
                                    <form action="{{ route('checkout.destroy', $checkout->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection