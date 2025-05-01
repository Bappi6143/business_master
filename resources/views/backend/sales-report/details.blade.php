@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Reports</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Sales Details Report for {{ $date }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <!-- Sales Details Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product(s)</th>
                                <th>Customer</th>
                                <th>Total Quantity</th>
                                <th>Order ID</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <!-- Format the order creation date -->
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</td>
                                    
                                    <!-- List each order item with product name, quantity and price -->
                                    <td>
                                        @if($order->orderItems && $order->orderItems->count() > 0)
                                            <ul class="list-unstyled mb-0">
                                                @foreach($order->orderItems as $orderItem)
                                                    <li>
                                                        {{ $orderItem->product->name ?? 'Unknown Product' }}
                                                        - Qty: {{ $orderItem->quantity }}
                                                        - Price: ${{ number_format($orderItem->price, 2) }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    
                                    <!-- Display customer name -->
                                    <td>{{ $order->customer_name ?? 'N/A' }}</td>
                                    
                                    <!-- Display total quantity if available -->
                                    <td>{{ $order->ordered_quantity ?? 'N/A' }}</td>
                                    
                                    <!-- Display Order ID -->
                                    <td>{{ $order->id }}</td>
                                    
                                    <!-- Display the total order amount -->
                                    <td>${{ number_format($order->total_price, 2) }}</td>
                                </tr>
                            @endforeach

                            @if($orders->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">No sales found for this date.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- Back Button -->
                <a href="{{ route('sales') }}" class="btn btn-secondary mt-3">Back to Summary</a>
            </div>
        </div>
    </div>
</div>
@endsection
