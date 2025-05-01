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
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Customers</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                    <i class="bx bxs-plus-square"></i> Add New Customer
                </button>
                <a href="" class="btn btn-primary"><i class="bx bx-video"></i></a>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="card">
            <div class="card-body p-4">
                <div class="table-responsive" style="overflow: visible !important;">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead class="text-dark-blue">
                            <tr class="text-center">
                                <th>Customer Name</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr class="text-center">
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="{{ route('customers.edit', $customer->id) }}" class="dropdown-item">Edit</a>
                                            </li>
                                            <li>
                                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
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

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark-blue" id="addCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" required
                            pattern="0\d{10}"
                            oninvalid="this.setCustomValidity('Phone number must start with 0 and be exactly 11 digits')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCustomerForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="customer_id" id="customer_id">
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control" required
                            pattern="0\d{10}"
                            oninvalid="this.setCustomValidity('Phone number must start with 0 and be exactly 11 digits')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" id="edit_address" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#editCustomerModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var customerId = button.data('id');
            var customerName = button.data('name');
            var customerPhone = button.data('phone');
            var customerAddress = button.data('address');

            console.log("Customer ID:", customerId);
            console.log("Customer Name:", customerName);
            console.log("Customer Phone:", customerPhone);
            console.log("Customer Address:", customerAddress);

            var modal = $(this);
            modal.find('#customer_id').val(customerId);
            modal.find('#edit_name').val(customerName);
            modal.find('#edit_phone').val(customerPhone);
            modal.find('#edit_address').val(customerAddress);

            var formAction = "{{ route('customers.update', ':id') }}".replace(':id', customerId);
            $('#editCustomerForm').attr('action', formAction);
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        let dropdownButtons = document.querySelectorAll(".dropdown-toggle");

        dropdownButtons.forEach(button => {
            button.addEventListener("click", function() {
                let dropdownMenu = this.nextElementSibling;
                let rect = dropdownMenu.getBoundingClientRect();
                let windowHeight = window.innerHeight;

                if (rect.bottom > windowHeight) {
                    dropdownMenu.classList.add("dropup");
                } else {
                    dropdownMenu.classList.remove("dropup");
                }
            });
        });
    });
</script>
@endsection
