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
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    <i class="bx bx-home-alt"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('categories.index') }}">Category</a>
                            </li>
                            <li class="breadcrumb-item active text-dark-blue" aria-current="page">Edit Category</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Success & Error Messages -->
            <div class="card">
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Edit Category Section -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-dark-blue">Edit Category</h5>
                            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}"
                                        placeholder="Enter Category Name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </form>
                        </div>

                        <!-- Edit Subcategories Section -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-dark-blue">Edit Subcategories</h5>
                            @forelse ($category->subCategories as $subCategory)
                                <div class="mb-4 border p-3 rounded">
                                    <!-- Update Subcategory Form -->
                                    <form action="{{ route('subcategories.update', $subCategory->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label">Subcategory Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $subCategory->name }}"
                                                placeholder="Enter Subcategory Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="1" {{ $subCategory->status ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$subCategory->status ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Subcategory</button>
                                    </form>

                                    <!-- Delete Subcategory Form -->
                                    <form action="{{ route('subcategories.destroy', $subCategory->id) }}" method="POST"
                                        class="mt-2"
                                        onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete Subcategory</button>
                                    </form>

                                </div>
                            @empty
                                <div class="alert alert-info">
                                    No subcategories available for this category.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection