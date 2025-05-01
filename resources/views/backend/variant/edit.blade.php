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
                        <li class="breadcrumb-item"><a href="{{ route('variants.index') }}">Variants</a></li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Edit Variant</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <!-- Edit Variant -->
                    <div class="col-md-6">
                        <h5 class="text-dark-blue">Edit Variant</h5>
                        <form action="{{ route('variants.update', $variant->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" value="{{ $variant->name }}" placeholder="Variant Name" required>
                            </div>
                            <div class="mb-3">
                                <select name="status" class="form-select" required>
                                    <option value="1" {{ $variant->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$variant->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Variant</button>
                        </form>
                    </div>

                    <!-- Edit Variant Values -->
                    <div class="col-md-6">
                        <h5 class="text-dark-blue">Edit Variant Values</h5>
                        @foreach ($variant->variantValues as $value)
                            <div class="mb-4 border p-3 rounded">
                                <!-- Update Form -->
                                <form action="{{ route('variant-values.update', $value->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Value Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $value->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="1" {{ $value->status ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$value->status ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Value</button>
                                </form>

                                <!-- Delete Form -->
                                <form action="{{ route('variant-values.destroy', $value->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Are you sure you want to delete this value?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Value</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
