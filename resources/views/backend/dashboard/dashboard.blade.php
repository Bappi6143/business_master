@extends('backend.master')


@section('content')

<style>
    .wave-emoji {
        display: inline-block;
        animation: wave-animation 2s infinite;
        transform-origin: 70% 70%;
        font-size: 3rem;
    }

    @keyframes wave-animation {
        0% { transform: rotate(0deg); }
        10% { transform: rotate(14deg); }
        20% { transform: rotate(-8deg); }
        30% { transform: rotate(14deg); }
        40% { transform: rotate(-4deg); }
        50% { transform: rotate(10deg); }
        60% { transform: rotate(0deg); }
        100% { transform: rotate(0deg); }
    }
</style>


<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row mb-5">
            <div class="col">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="my-1 text-dark-blue d-flex align-items-center">
                            Welcome MetaSoft
                            <span class="wave-emoji ms-2">👋</span>
                        </h4>
                        <p class="mb-0 font-16 text-mute mt-4">System is stable and ready. <a class="border radius-10 p-2 bg-light" style="font-weight: 500; color: rgb(64, 137, 173);" href="{{ route("home") }}" target="_blank">Click your Website</a></p>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3">
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3">
                    <div class="card-body border-gray radius-10">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-gray">Total Completed Orders</p>
                                <p class="mb-0 font-13 text-dark-blue">Updated live</p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="my-1 text-dark-blue">{{ number_format($completedOrderAmount, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3">
                    <div class="card-body border-gray radius-10">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-gray">Expenses</p>
                                <p class="mb-0 font-13 text-dark-blue">Updated live</p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="my-1 text-dark-blue">{{ number_format($totalExpenses, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3">
                    <div class="card-body border-gray radius-10 ">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-gray">Confirmed Order</p>

                                <p class="mb-0 font-13 text-dark-blue">Updated live</p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="my-1 text-dark-blue">{{ $confirmedOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3">
                    <div class="card-body border-gray radius-10">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-gray">Pending Order</p>
                                <p class="mb-0 font-13 text-dark-blue">Updated live</p>
                            </div>
                            <div class="ms-auto">
                                <h4 class="my-1 text-dark-blue">{{ $pendingOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mt-2">
                <a href="{{ route('settings.edit', ['section' => 'header']) }}" class="text-decoration-none">
                    <div class="card radius-10 border-start border-0 border-3">
                        <div class="card-body border-gray radius-10">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 class="my-1 text-gray-h4">Custom Your Shop</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col mt-2">
                <a href="{{ url('/store_information') }}" class="text-decoration-none">
                    <div class="card radius-10 border-start border-0 border-3">
                        <div class="card-body border-gray radius-10">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 class="my-1 text-gray-h4">Store Setting</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col mt-2">
                <a href="{{ url('/delivery-partners') }}" class="text-decoration-none">
                    <div class="card radius-10 border-start border-0 border-3">
                        <div class="card-body border-gray radius-10">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 class="my-1 text-gray-h4">Courier Integration</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col mt-2">
                <a href="{{ url('/domain') }}" class="text-decoration-none">
                    <div class="card radius-10 border-start border-0 border-3">
                        <div class="card-body border-gray radius-10">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 class="my-1 text-gray-h4">Connect Your Domain</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


        </div><!--end row-->

        <div class="row mb-3">
            <div class="col-12 col-lg-4 mt-2">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-dark-blue"">Product Order Sources</h6>
                            </div>
                        </div>
                        <div class=" row mt-2">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center justify-content-between  p-2">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('backend-assets/images/avatars/fb.png') }}" class="rounded-circle me-3" alt="Facebook" style="width: 40px; height: 40px;">
                                                <span class="fw-semibold fs-6">Facebook</span>
                                            </div>
                                            <span class="fw-bold text-muted fs-5">0</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center justify-content-between  p-2">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('backend-assets/images/avatars/whatsapp.png') }}" class="rounded-circle me-3" alt="Facebook" style="width: 40px; height: 40px;">
                                                <span class="fw-semibold fs-6">What'sApp</span>
                                            </div>
                                            <span class="fw-bold text-muted fs-5">0</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center justify-content-between  p-2">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('backend-assets/images/avatars/website.png') }}" class="rounded-circle me-3" alt="Facebook" style="width: 40px; height: 40px;">
                                                <span class="fw-semibold fs-6">Website</span>
                                            </div>
                                            <span class="fw-bold text-muted fs-5">0</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center justify-content-between  p-2">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('backend-assets/images/avatars/phone.png') }}" class="rounded-circle me-3" alt="Facebook" style="width: 40px; height: 40px;">
                                                <span class="fw-semibold fs-6">Cell Phone</span>
                                            </div>
                                            <span class="fw-bold text-muted fs-5">0</span>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between  p-2">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('backend-assets/images/avatars/ig.png') }}" class="rounded-circle me-3" alt="Facebook" style="width: 40px; height: 40px;">
                                        <span class="fw-semibold fs-6">Intagram</span>
                                    </div>
                                    <span class="fw-bold text-muted fs-5">0</span>
                                </div>
                            </div> -->
                                    <!-- <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between  p-2">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('backend-assets/images/avatars/store.png') }}" class="rounded-circle me-3" alt="Facebook" style="width: 40px; height: 40px;">
                                        <span class="fw-semibold fs-6">Store</span>
                                    </div>
                                    <span class="fw-bold text-muted fs-5">0</span>
                                </div>
                            </div> -->
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-lg-8">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0 text-dark-blue">Recent Orders</h6>
                                </div>
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table align-middle mb-0 mt-2">
                                    <thead class="table-light ">
                                        <tr class="text-dark-blue">
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                            <th>Date</th>

                                        </tr>
                                    </thead>
                                    @php
                                    $maxRows = 5;
                                    $count = $recentOrders->count();
                                    @endphp

                                    <tbody>
                                        @foreach($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->product_names ?? 'N/A' }}</td>
                                            <td>{!! $order->product_variants ?? 'N/A' !!}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>
                                                @php
                                                $badgeClass = match($order->order_status) {
                                                'confirmed', 'confirmed' => 'bg-gradient-confirmed',
                                                'completed', 'completed' => 'bg-gradient-completed',
                                                'pending' => 'bg-gradient-pending',
                                                'shipped' => 'bg-gradient-shipped',
                                                'delivered', 'delivered' => 'bg-gradient-delivered',
                                                'cancelled', 'cancelled' => 'bg-gradient-cancelled',
                                                'returned', 'returned' => 'bg-gradient-returned',
                                                'follow', 'follow' => 'bg-gradient-follow',
                                                default => 'bg-secondary',
                                                };
                                                @endphp
                                                <span class="badge {{ $badgeClass }} text-white shadow-sm w-100 text-capitalize">
                                                    {{ $order->order_status }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($order->total_price, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                        </tr>

                                        @endforeach

                                        {{-- Add placeholder rows if less than 5 --}}
                                        @for ($i = 0; $i < $maxRows - $count; $i++)
                                            <tr>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td><span class="badge status_na shadow-sm w-15">N/A</span></td>
                                            <td>0.00</td>
                                            <td>N/A</td>
                                            </tr>
                                            @endfor
                                    </tbody>



                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->
            <div class="row mb-3">
                <div class="col-12 col-lg-6">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0 text-dark-blue">Top Selling Products</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                                        <i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Export</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">View All</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Settings</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 mt-2">
                                    <thead class="table-light text-dark-blue">
                                        <tr>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th>Units Sold</th>
                                            <th>Total Revenue</th>
                                        </tr>
                                    </thead>
                                    @php
                                    $maxRows = 5;
                                    $count = $topSellingProducts->count();
                                    @endphp

                                    <tbody>
                                        {{-- Loop through actual top-selling products --}}
                                        @foreach($topSellingProducts as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($item->product->image ?? 'backend-assets/images/products/default.png') }}"
                                                    class="product-img-2" alt="product img">
                                            </td>
                                            <td>{{ $item->product->title ?? 'N/A' }}</td>
                                            <td>{!! $order->product_variants ?? 'N/A' !!}</td>
                                            <td>{{ $item->total_units }}</td>
                                            <td>{{ number_format($item->total_revenue, 2) }}</td>
                                        </tr>
                                        @endforeach

                                        {{-- Fill with placeholder rows if less than 5 --}}
                                        @for($i = 0; $i < $maxRows - $count; $i++)
                                            <tr>
                                            <td>
                                                <img src="{{ asset('backend-assets/images/products/default.png') }}"
                                                    class="product-img-2" alt="product img">
                                            </td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>0</td>
                                            <td>0.00</td>
                                            </tr>
                                            @endfor
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-lg-6">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0 text-dark-blue">Low Stock Products</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                                        <i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Restock All</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Export</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Settings</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 mt-2">
                                    <thead class="table-light text-dark-blue">
                                        <tr>
                                            <th>Photo</th>
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th>Stock Left</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    @php
                                    $maxRows = 5;
                                    $count = $lowStockProducts->count();
                                    @endphp

                                    <tbody>
                                        {{-- Loop through available products --}}
                                        @foreach($lowStockProducts as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($product->image ?? 'backend-assets/images/products/default.png') }}" class="product-img-2" alt="product img">
                                            </td>
                                            <td>{{ $product->title }}</td>
                                            <td>{!! $order->product_variants ?? 'N/A' !!}</td>
                                            <td>{{ $product->stock_quantity }}</td>
                                            <td>
                                                @if($product->stock_quantity <= 5)
                                                    <span class="badge  status-red shadow-sm w-50">Reorder Needed</span>
                                                    @else
                                                    <span class="badge status-yellow shadow-sm w-50">Low</span>
                                                    @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                        {{-- Fill with placeholder rows if less than 5 --}}
                                        @for($i = 0; $i < $maxRows - $count; $i++)
                                            <tr>
                                            <td>
                                                <img src="{{ asset('backend-assets/images/products/default.png') }}" class="product-img-2" alt="product img">
                                            </td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>0</td>
                                            <td>
                                                <span class="badge status_na shadow-sm w-50">N/A</span>
                                            </td>
                                            </tr>
                                            @endfor
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button-->
    <!-- <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a> -->
    <!--End Back To Top Button-->


    <style>
        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: inherit;
            border-style: none;
            border-width: 0;
        }

        .table>thead {
            vertical-align: bottom;
            color: #6c757d;
            font-weight: 500;
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            background-color: white !important;
        }
    </style>
    @endsection