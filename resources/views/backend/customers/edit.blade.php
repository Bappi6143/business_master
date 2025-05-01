@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Customer</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Customer</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="card">
            <div class="card-body">
                <h5 class="mb-4 text-dark-blue">Update Customer Information</h5>
                <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}" required
                        pattern="0\d{10}"
                            oninvalid="this.setCustomValidity('Phone number must start with 0 and be exactly 11 digits')"
                            oninput="this.setCustomValidity('')">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $customer->address) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Update Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
