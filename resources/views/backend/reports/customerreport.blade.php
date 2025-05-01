@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Reports</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Customer Report</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered radius-10">
                        <thead class="text-dark-blue">
                            <tr>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Last Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->total_orders }}</td>
                                <td>${{ number_format($customer->total_spent, 2) }}</td>
                                <td>{{ $customer->last_order ? $customer->last_order->format('Y-m-d') : 'N/A' }}</td>
                            </tr>
                            @endforeach
                            @if($customers->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No customers found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
