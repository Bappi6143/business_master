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
                        <li class="breadcrumb-item active" aria-current="page">Roles</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Role Management</h5>
                    <button type="button" class="btn btn-primary radius-30" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="bx bxs-plus-square"></i> Add New Role
                    </button>
                </div>
                <hr />
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <span class="badge {{ $role->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($role->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $role->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $role->id }}">Edit</button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Role Modal -->
                                <x-large-modal id="editRoleModal-{{ $role->id }}" title="Edit Role">
                                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label">Role Name</label>
                                            <input type="text" name="name" value="{{ $role->name }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="active" {{ $role->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $role->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
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

<!-- Add Role Modal -->
<x-large-modal id="addRoleModal" title="Add New Role">
    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Role Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-large-modal>

@endsection
