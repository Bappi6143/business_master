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
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Category</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
            <a href="{{ url('products') }}" class="btn btn-primary"> + Add New Product </a>
                <a href="" class="btn btn-primary"><i class="bx bx-video"></i></a>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <!-- Add Category -->
                    <div class="col-md-6">
                        <h5 class="text-dark-blue mb-4">Add New Category</h5>
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Category Name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <select name="status" class="form-select" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>
                    </div>

                    <!-- Add Subcategory -->
                    <div class="col-md-6">
                        <h5 class="text-dark-blue mb-4">Add New Subcategory</h5>
                        <form action="{{ route('subcategories.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <select name="category_id" class="form-select" required>
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Subcategory Name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <select name="status" class="form-select" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Subcategory</button>
                        </form>
                    </div>
                </div>

                <hr>

                <!-- Category Table -->
                <div class="table-responsive mt-4" style="overflow: visible !important;">
                    <table id="" class="table table-striped table-bordered radius-10 dataTable no-footer">
                        <thead>
                            <tr class="text-center text-dark-blue">
                                <th>Category</th>
                                <th>Subcategories</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr class="text-center">
                                <td>{{ $category->name }}</td>
                                <td>
                                    @foreach ($category->subCategories as $subCategory)
                                    <span class="badge bg-pri">{{ $subCategory->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge {{ $category->status ? 'bg-active' : 'bg-inactive' }}">
                                        {{ $category->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="{{ route('categories.edit', $category->id) }}" class="dropdown-item">Edit</a>
                                            </li>
                                            <li>
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
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

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        let dropdownButtons = document.querySelectorAll(".dropdown-toggle");

        dropdownButtons.forEach(button => {
            button.addEventListener("click", function() {
                let dropdownMenu = this.nextElementSibling;

                // Adjust dropdown position dynamically
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