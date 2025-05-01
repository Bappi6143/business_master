@extends('backend.master')

@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #invoiceSection, #invoiceSection * {
            visibility: visible;
        }
        #invoiceSection {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            margin: 0;
        }
        .no-print {
            display: none;
        }
    }
    .invoice-table th, .invoice-table td {
        padding: 8px;
        border: 1px solid #ddd;
    }
    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .summary-table {
        width: 300px;
        float: right;
        margin-top: 20px;
    }
    .summary-table th, .summary-table td {
        padding: 6px;
        text-align: right;
    }
    .notes-section {
        clear: both;
        margin-top: 50px;
    }
</style>

<div class="page-wrapper">
    <div class="page-content">
        <div class="d-flex justify-content-end no-print mb-3">
            <button onclick="window.print()" class="btn btn-primary"><i class="bx bx-printer"></i> Print Invoice</button>
        </div>

        <div id="invoiceSection" class="card">
            <div class="card-body">
                <!-- Store Info -->
                <div class="text-center mb-4">
                    <h3>{{ $store->name ?? 'Store Name' }}</h3>
                    <p>{{ $store->address ?? 'Address not set' }}</p>
                    <p>Phone: {{ $store->phone_number ?? 'N/A' }} | Email: {{ $store->email ?? 'N/A' }}</p>
                    @if (!empty($store->website))
                        <p>Website: <a href="{{ $store->website }}" target="_blank">{{ parse_url($store->website, PHP_URL_HOST) }}</a></p>
                    @endif
                </div>

                <!-- Invoice & Customer Info -->
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <strong>Invoice No:</strong> MSBD-ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}<br>
                        <strong>Invoice Date:</strong> {{ $order->created_at->format('d M Y') }}
                    </div>
                    <div>
                        <strong>Payment Method:</strong> {{ $order->payment_method ?? 'Cash on Delivery' }}<br>
                        <strong>Delivery Method:</strong> {{ $order->zone_name ?? 'N/A' }}
                    </div>
                </div>

                <!-- Customer Details -->
                <h5>Customer Information</h5>
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_contact }}</p>
                <p><strong>Address:</strong> {{ $order->customer_address }}</p>

                <!-- Product Table -->
                <h5 class="mt-4">Order Details</h5>
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Variation</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['variation'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>{{ number_format($product['price'], 2) }}</td>
                            <td>{{ number_format($product['total'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Summary -->
                <table class="summary-table">
                    <tr>
                        <th>Subtotal:</th>
                        <td>{{ number_format($order->subtotal, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <th>Delivery Charge:</th>
                        <td>{{ number_format($order->delivery_charge, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <th>Discount:</th>
                        <td>-{{ number_format($order->discount_amount, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <th><strong>Total Payable:</strong></th>
                        <td><strong>{{ number_format($order->total_price, 2) }} BDT</strong></td>
                    </tr>
                    <tr>
                        <th>Paid Amount:</th>
                        <td>{{ number_format($order->paid_amount ?? 0, 2) }} BDT</td>
                    </tr>
                    <tr>
                        <th>Due Amount:</th>
                        <td>{{ number_format($order->total_price - ($order->paid_amount ?? 0), 2) }} BDT</td>
                    </tr>
                    <tr>
                        <th>Delivery Status:</th>
                        <td>{{ $order->order_status }}</td>
                    </tr>
                    <tr>
                        <th>Tracking ID:</th>
                        <td>{{ $order->tracking_id ?? 'N/A' }}</td>
                    </tr>
                </table>

                <div class="notes-section">
                    <h6>Notes:</h6>
                    <ul>
                        <li>Estimated Delivery: 2–4 working days</li>
                        <li>Please check the product before confirming delivery</li>
                        <li>For any issues, contact support within 48 hours of delivery</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
