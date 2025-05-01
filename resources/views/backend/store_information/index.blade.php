@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Settings</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Delivery Partners</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body p-4">
                        <h4 class="text-dark-blue">Store/Shop Information</h4>

                        <form method="POST" 
                              action="{{ $storeInfo ? route('store_information.update', $storeInfo->id) : route('store_information.store') }}" 
                              enctype="multipart/form-data">
                            @csrf
                            @if($storeInfo)
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Shop Name</label>
                                <input type="text" name="name" class="form-control" 
                                       value="{{ old('name', $storeInfo->name ?? '') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" 
                                       value="{{ old('address', $storeInfo->address ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" 
                                       value="{{ old('phone_number', $storeInfo->phone_number ?? '') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email', $storeInfo->email ?? '') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Website</label>
                                <input type="text" name="website" class="form-control" 
                                       value="{{ old('website', $storeInfo->website ?? '') }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
