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
                        <li class="breadcrumb-item active" aria-current="page">Product Reviews</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <!-- Total Reviews -->
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="card text-center p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="me-2">
                            <i class="bx bx-star fs-2 text-warning"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">150</h4>
                            <strong>Total Reviews</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="card">
            <div class="card-body p-4">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <!-- Date Filter -->
                    <div class="d-flex gap-2">
                        <input type="date" class="form-control">
                        <input type="date" class="form-control">
                        <button class="btn btn-primary">Filter</button>
                    </div>

                    <!-- Search Product -->
                    <div class="position-relative ms-auto">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Product">
                        <span class="position-absolute top-50 product-show translate-middle-y">
                            <i class="bx bx-search"></i>
                        </span>
                    </div>
                </div>

                <!-- Reviews Table -->
                <x-table :headers="['Customer', 'Product', 'Rating', 'Review', 'Date', 'Actions']">
                    <tr>
                        <td>
                            <div><strong>Name:</strong> John Doe</div>
                            <div><strong>Phone:</strong> 123-456-7890</div>
                        </td>
                        <td>
                            <div><strong>Product:</strong> iPhone 13</div>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark">5 ★</span>
                        </td>
                        <td>
                            <div>Excellent product! Highly recommend.</div>
                        </td>
                        <td>
                            <div>10 Mar 2025</div>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div><strong>Name:</strong> Jane Smith</div>
                            <div><strong>Phone:</strong> 987-654-3210</div>
                        </td>
                        <td>
                            <div><strong>Product:</strong> Samsung Galaxy S22</div>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark">4 ★</span>
                        </td>
                        <td>
                            <div>Good phone, but battery could be better.</div>
                        </td>
                        <td>
                            <div>08 Mar 2025</div>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div><strong>Name:</strong> Mark Wilson</div>
                            <div><strong>Phone:</strong> 456-789-1230</div>
                        </td>
                        <td>
                            <div><strong>Product:</strong> MacBook Air</div>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark">5 ★</span>
                        </td>
                        <td>
                            <div>Lightweight and powerful! Great for work.</div>
                        </td>
                        <td>
                            <div>05 Mar 2025</div>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                </x-table>
            </div>
        </div>
    </div>
</div>
@endsection
