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
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <div class="ms-auto">
                    <!-- Open Modal Instead of Redirecting -->
                    <button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="bx bxs-plus-square"></i> Add New User
                    </button>
                </div>
                <hr />
                <div class="table-responsive">
                    <x-table :headers="['Name', 'Email', 'Tenant name', 'Phone', 'Role', 'Status', 'Actions']" id="userTable" class="custom-table">
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->tenant ? $user->tenant->name : 'N/A' }}</td>

                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->role->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($user->status) }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                    
                </div>
            </div>
        </div>  
    </div>
</div>

<!-- Include the Reusable Modal -->
<x-large-modal id="addUserModal" title="Add New User">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <!-- User Name -->
        <div class="mb-3">
            <label class="form-label">User Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role_id" class="form-control" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <!-- Tenant Name Field -->
        <div class="col-12">
            <label for="tenant_name" class="form-label">Tenant Name</label>
            <input type="text" name="tenant_name" class="form-control @error('tenant_name') is-invalid @enderror" id="tenant_name" placeholder="Your Tenant Name" required>
            @error('tenant_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-large-modal>

@endsection
