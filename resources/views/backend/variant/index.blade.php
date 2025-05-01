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
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Variants</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
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
                    <!-- Add Variant -->
                    <div class="col-md-6">
                        <h5 class="text-dark-blue mb-4">Add Variant</h5>
                        <form action="{{ route('variants.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Variant Name" required>
                            </div>
                            <div class="mb-3">
                                <select name="status" class="form-select" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Variant</button>
                        </form>
                    </div>

                    <!-- Add Variant Value -->
                    <div class="col-md-6">
                        <h5 class="text-dark-blue mb-4">Add Variant Value</h5>
                        <form action="{{ route('variant-values.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <select name="variant_id" class="form-select" required>
                                    <option value="" disabled selected>Select Variant</option>
                                    @foreach ($variants as $variant)
                                    <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Variant Value Name" required>
                            </div>
                            <div class="mb-3">
                                <select name="status" class="form-select" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Variant Value</button>
                        </form>
                    </div>
                </div>

                <hr>

                <!-- Variant Table -->
                <!-- Category Table -->
                <div class="table-responsive" style="overflow: visible !important;">
                    <table id="" class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Values</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($variants as $variant)
                            <tr class="text-center">
                                <td>{{ $variant->name }}</td>
                                <td>
                                    @foreach ($variant->variantValues as $value)
                                    <span class="badge bg-pri">{{ $value->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge {{ $variant->status ? 'bg-active' : 'bg-inactive' }}">
                                        {{ $variant->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a  href="{{ route('variants.edit', $variant->id) }}" class="dropdown-item">Edit</a>
                                            </li>
                                            <li>
                                                <form action="{{ route('variants.destroy', $variant->id) }}" method="POST" class="d-inline">
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