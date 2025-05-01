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
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Delivery Charges</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark-blue">Delivery Charges</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addChargeModal">
                        <i class="bx bxs-plus-square"></i> Add New Charge
                    </button>
                </div>
                <hr />
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered radius-10">
                        <thead class="text-dark-blue">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Zone Name</th>
                                <th>Delivery Charge (BDT)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($charges as $index => $charge)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $charge->zone_name }}</td>
                                <td>{{ number_format($charge->delivery_charge, 2) }}</td>
                                <td>
                                    <span class="badge {{ $charge->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $charge->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a  data-bs-toggle="modal" data-bs-target="#editChargeModal-{{ $charge->id }}" class="dropdown-item">Edit</a>
                                            </li>
                                            <li>
                                                <form action="{{ route('delivery_charges.destroy', $charge->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <x-large-modal id="editChargeModal-{{ $charge->id }}" title="Edit Delivery Charge">
                                <form method="POST" action="{{ route('delivery_charges.update', $charge->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Zone Name</label>
                                        <input type="text" name="zone_name" value="{{ $charge->zone_name }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Delivery Charge (BDT)</label>
                                        <input type="number" name="delivery_charge" value="{{ $charge->delivery_charge }}" class="form-control" required min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="1" {{ $charge->status ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$charge->status ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </x-large-modal>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<x-large-modal id="addChargeModal" title="Add New Delivery Charge">
    <form method="POST" action="{{ route('delivery_charges.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Zone Name <span class="text-danger">*</span></label>
            <input type="text" name="zone_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Delivery Charge (BDT) <span class="text-danger">*</span></label>
            <input type="number" name="delivery_charge" class="form-control" required min="0">
        </div>
        <div class="mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-large-modal>

@endsection