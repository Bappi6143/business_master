@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">eCommerce</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Orders</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <a href="{{ url('orders/create') }}" class="btn btn-primary "><i class="bx bxs-plus-square"></i>Add New Order</a>
                <a href="" class="btn btn-primary"><i class="bx bx-video"></i></a>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="d-flex flex-wrap justify-content-start">
                    <!-- ALL -->
                    <div class="card radius-10 status-all mr-4"
                        style="flex: 1 1 100%; max-width: 120px; height: 40px !important; cursor: pointer;"
                        id="status-all">
                        <div class="card-body px-2" style="height: 40px;">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <p class="mb-0 text-secondary">ALL</p>
                                <h4 class="my-1 text-end text-all">{{ $allCount }}</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Pending -->
                    <div class="card radius-10 status-pending  mr-4"
                        style="flex: 1 1 100%; max-width: 120px; height: 40px;  cursor: pointer;"
                        id="status-pending">
                        <div class="card-body px-2" style="height: 40px;">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <p class="mb-0 text-pending">Pending</p>
                                <h4 class="my-1 text-end text-pending">{{ $pendingCount }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmed -->
                    <div class="card radius-10 status-confirmed  mr-4"
                        style="flex: 1 1 100%; max-width: 120px; height: 40px;  cursor: pointer;"
                        id="status-confirmed">
                        <div class="card-body px-2" style="height: 40px;">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <p class="mb-0 text-confirmed">Confirmed</p>
                                <h4 class="my-1 text-end text-confirmed">{{ $confirmedCount }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Shipped -->
                    <div class="card radius-10 status-shipped  mr-4"
                        style="flex: 1 1 100%; max-width: 120px; height: 40px;  cursor: pointer;"
                        id="status-shipped">
                        <div class="card-body px-2" style="height: 40px;">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <p class="mb-0 text-shipped">Shipped</p>
                                <h4 class="my-1 text-end text-shipped">{{ $shippedCount }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Delivered -->
                    <div class="card radius-10 status-delivered  mr-4"
                        style="flex: 1 1 100%; max-width: 120px; height: 40px;  cursor: pointer;"
                        id="status-delivered">
                        <div class="card-body px-2" style="height: 40px;">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <p class="mb-0 text-delivered">Delivered</p>
                                <h4 class="my-1 text-end text-delivered">{{ $deliveredCount }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Cancelled -->
                    <div class="card radius-10 status-cancelled  mr-4"
                        style="flex: 1 1 100%; max-width: 120px; height: 40px;  cursor: pointer;"
                        id="status-cancelled">
                        <div class="card-body px-2" style="height: 40px;">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <p class="mb-0 text-cancelled">Cancelled</p>
                                <h4 class="my-1 text-end text-cancelled">{{ $cancelledCount }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Returned -->
                    <div class="card radius-10 status-returned  mr-4"
                        style="flex: 1 1 100%; max-width: 120px; height: 40px;  cursor: pointer;"
                        id="status-returned">
                        <div class="card-body px-2" style="height: 40px;">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <p class="mb-0 text-returned">Returned</p>
                                <h4 class="my-1 text-end text-returned">{{ $returnedCount }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Follow Up -->
                     <div class="card radius-10 status-follow  mr-4"
                        style="flex: 1 1 100%; max-width: 120px; height: 40px;  cursor: pointer;"
                        id="status-follow">
                        <div class="card-body px-2" style="height: 40px;">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <p class="mb-0 text-follow">Follow Up</p>
                                <h4 class="my-1 text-end text-follow">{{ $followCount }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Completed -->
                    <div class="card radius-10 status-completed  mr-4"
                        style="flex: 1 1 100%; max-width: 120px; height: 40px;  cursor: pointer;"
                        id="status-completed">
                        <div class="card-body px-2" style="height: 40px;">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <p class="mb-0 text-completed">Completed</p>
                                <h4 class="my-1 text-end text-completed">{{ $completedCount }}</h4>
                            </div>
                        </div>
                    </div>

                </div>

        <div class="card">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive" style="overflow: visible !important;">
                    <table id="example2" class="table table-striped table-bordered radius-10">
                        <thead class="table-light text-dark-blue">
                            <tr class="text-center">
                                <th>
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th>Order#</th>
                                <th>Customer Name</th>
                                <th>Phone Number</th>
                                <th>Total</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Delivery partner</th>
                                <th>Courier Tracking</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($orders as $order)
                            <tr class="text-center order-row" data-status="{{ strtolower($order->order_status) }}">
                                <td>
                                    <input type="checkbox" class="order-checkbox" value="{{ $order->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_contact }}</td>
                                <td>{{ $order->total_price }}</td>
                                <td>
                                    @foreach ($order->products as $product)
                                    {{ $product['name'] }} <br><strong class="text-muted">Quantity:</strong> {{ $product['quantity'] }}<br>
                                    @endforeach
                                </td>
                                <td>{{ $order->order_status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Select Courier
                                        </button>
                                        <ul class="dropdown-menu">
                                            @forelse($activePartners as $partner)
                                            <li>
                                                <form id="courierForm-{{ $partner->slug }}" action="{{ route('orders.assignDeliveryPartner') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="delivery_partner_id" value="{{ $partner->id }}">
                                                </form>
                                                @if($partner->slug === 'steadfast')
                                                <button type="button" class="dropdown-item" onclick="submitCourierForm('{{ $partner->slug }}', '{{ $partner->partner_name }}')">
                                                    {{ $partner->partner_name }}
                                                </button>
                                                @else
                                                <a class="dropdown-item courier-option" href="javascript:void(0);" onclick="submitCourierForm('{{ $partner->slug }}', '{{ $partner->partner_name }}')">
                                                    {{ $partner->partner_name }}
                                                </a>
                                                @endif
                                            </li>
                                            @empty
                                            <li><span class="dropdown-item text-danger">Not Add Partner</span></li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </td>

                                <td>
                                    {{ $order->trackingid }}
                                </td>

                                <!-- Three-Dot Dropdown for Actions -->
                                <td class="">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('orders.invoice', $order->id) }}">
                                                    <i class="bx bx-file"></i> invoice
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('orders.edit', $order->id) }}">
                                                    <i class="bx bx-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bx bx-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- page-content -->
</div> <!-- page-wrapper -->

<style>
    /* Fix dropdown visibility */
    .dropdown-menu {
        position: absolute !important;
        will-change: transform;
        z-index: 1050;
        /* Ensures it appears above other elements */
        transform: translate3d(0px, 0px, 0px) !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all status cards
        const statusCards = document.querySelectorAll('[id^="status-"]');
        document.getElementById('checkAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Add click event listener to each card
        statusCards.forEach(card => {
            card.addEventListener("click", function() {
                let status = this.id.replace('status-', ''); // Extract status from card ID

                // Fetch the orders based on the selected status
                filterOrdersByStatus(status);
            });
        });
    });

    // Function to filter orders based on selected status
    function filterOrdersByStatus(status) {
        let rows = document.querySelectorAll(".order-row");

        rows.forEach(row => {
            let orderStatus = row.dataset.status;

            if (status === 'all' || orderStatus === status) {
                row.style.display = ''; // Show the row
            } else {
                row.style.display = 'none'; // Hide the row
            }
        });
    }

    function submitCourierForm(slug, partnerName) {
        if (confirm('Are you sure you want to place this order to ' + partnerName + '?')) {
            document.getElementById('courierForm-' + slug).submit();
        }
    }
</script>

@endsection