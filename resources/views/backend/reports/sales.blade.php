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
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Sales Report</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <!-- Date Filter Form -->
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('sales') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('sales') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sales Report Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-dark-blue">
                                <th>Date</th>
                                <th>Total Orders</th>
                                <th>Total Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->date }}</td>
                                    <td>{{ $order->orders_count }}</td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-secondary">View Details</a>
                                    </td>
                                </tr>
                            @endforeach

                            @if($orders->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">No sales found.</td>
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
