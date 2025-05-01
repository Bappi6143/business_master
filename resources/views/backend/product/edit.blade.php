@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">eCommerce</div>
            <div class="ps-3">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active text-dark-blue" aria-current="page">Edit Product</li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title text-dark-blue">Edit Product</h5>
                <hr />
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Left -->
                        <div class="col-lg-8">
                            <div class="border border-3 p-4 rounded row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $product->title) }}" required>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Category</label>
                                    <select class="form-select" id="inputProductCategory" name="category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Sub Category</label>
                                    <select class="form-select" id="inputSubCategory" name="subcategory">
                                        <option value="">Select Sub Category</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Price</label>
                                    <input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}" required>
                                </div>
                            </div>

                            <!-- Variants -->
                            <div class="border border-3 p-4 rounded mt-4">
                                <h6>Product Variants</h6>
                                @php
                                    $variantItems = is_array($product->variant_items)
                                        ? $product->variant_items
                                        : json_decode($product->variant_items, true);
                                @endphp
                                <div id="variantRowsContainer">
                                    @foreach($variantItems as $index => $item)
                                        @php
                                            $variantId = $item['variant_id'] ?? null;
                                            $valueId = $item['variant_value_id'] ?? null;
                                            $variant = \App\Models\Variant::find($variantId);
                                            $variantValueList = $variant ? $variant->variantValues : [];
                                        @endphp
                                        <div class="variant-row row mb-2">
                                            <div class="col-md-4">
                                                <label>Variant</label>
                                                <select name="variants[{{ $index }}][variant_id]" class="form-select" onchange="fetchVariantValues(this)">
                                                    <option value="">Select Variant</option>
                                                    @foreach ($variants as $v)
                                                        <option value="{{ $v->id }}" {{ $variantId == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Value</label>
                                                <select name="variants[{{ $index }}][variant_value_id]" class="form-select">
                                                    <option value="">Select Value</option>
                                                    @foreach ($variantValueList as $val)
                                                        <option value="{{ $val->id }}" {{ $valueId == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-variant-row">X</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-secondary mt-2" id="addVariantRow">+ Add Variant</button>
                            </div>

                            <div class="border border-3 p-4 rounded row mt-4">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" name="code" value="{{ old('code', $product->code) }}" required>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Initial Qty</label>
                                    <input type="number" class="form-control" name="initial_quantity" value="{{ old('initial_quantity', $product->initial_quantity) }}" required>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Right -->
                        <div class="col-lg-4">
                            <div class="border border-3 p-4 rounded">
                                <label class="form-label">Product Image</label>
                                @if($product->image)
                                    <div class="mb-3">
                                        <img src="{{ asset($product->image) }}" class="img-thumbnail" width="200">
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>

                            <!-- Stock -->
                            <div class="border border-3 p-4 rounded mt-4">
                                <div class="mb-3">
                                    <label class="form-label">Available Stock</label>
                                    <input type="number" class="form-control" id="inputAvailableStock" name="stock_quantity"
                                           value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                           data-original="{{ $product->stock_quantity }}" readonly>
                                    <small class="text-muted">Auto-updated when new stock is added.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Stock Add</label>
                                    <input type="number" class="form-control" id="inputNewStock" name="new_stock" placeholder="Enter additional stock">
                                </div>
                            </div>

                            <div class="border border-3 p-4 rounded mt-4">
                                <button type="submit" class="btn btn-primary w-100">Update Product</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let variantIndex = {{ count($variantItems ?? []) }};

    function fetchVariantValues(select) {
        let variantId = $(select).val();
        let target = $(select).closest('.variant-row').find('select[name$="[variant_value_id]"]');
        $.get(`/get-variant-values/${variantId}`, function(data) {
            let options = '<option value="">Select Value</option>';
            data.forEach(val => {
                options += `<option value="${val.id}">${val.name}</option>`;
            });
            target.html(options);
        });
    }

    $('#addVariantRow').click(function () {
        let html = `
        <div class="variant-row row mb-2">
            <div class="col-md-4">
                <select name="variants[${variantIndex}][variant_id]" class="form-select" onchange="fetchVariantValues(this)">
                    <option value="">Select Variant</option>
                    @foreach ($variants as $v)
                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="variants[${variantIndex}][variant_value_id]" class="form-select">
                    <option value="">Select Value</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-variant-row">X</button>
            </div>
        </div>`;
        $('#variantRowsContainer').append(html);
        variantIndex++;
    });

    $(document).on('click', '.remove-variant-row', function () {
        $(this).closest('.variant-row').remove();
    });

    $('#inputNewStock').on('input', function () {
        let newStock = parseInt($(this).val()) || 0;
        let originalStock = parseInt($('#inputAvailableStock').data('original')) || 0;
        let updatedStock = originalStock + newStock;
        $('#inputAvailableStock').val(updatedStock);
    });

    $('#inputProductCategory').on('change', function () {
        let categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                url: "/get-subcategories/" + categoryId,
                method: "GET",
                success: function (data) {
                    $('#inputSubCategory').html('<option value="">Select Sub Category</option>');
                    $.each(data, function (key, value) {
                        $('#inputSubCategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });
</script>
@endsection
