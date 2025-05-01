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
                        <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit User</h5>
                <hr />
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- User Name -->
                    <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
                    </div>

                    <!-- Password (Optional) -->
                    <div class="mb-3">
                        <label class="form-label">Password (Leave blank to keep current password)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-control" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Tenant Name (Read-only, as it cannot be changed) -->
                    <div class="mb-3">
                        <label class="form-label">Tenant Name</label>
                        <input type="text" class="form-control" value="{{ $user->tenant->name }}" readonly>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection