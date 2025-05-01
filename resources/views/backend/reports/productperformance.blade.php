@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Reports</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Product Performance Report</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered radius-10">
                        <thead class="text-dark-blue">
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Units Sold</th>
                                <th>Total Revenue</th>
                                <th>Average Price</th>
                                <th>Remaining Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $item)
                            <tr>
                                <td>{{ $item->product->title ?? 'Unknown' }}</td>
                                <td>{{ $item->product->category->name ?? 'N/A' }}</td>
                                <td>{{ $item->total_units_sold ?? 0 }}</td>
                                <td>${{ number_format($item->total_revenue ?? 0, 2) }}</td>
                                <td>${{ number_format($item->average_price ?? 0, 2) }}</td>
                                <td>{{ $item->product->stock_quantity ?? 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">No data available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection