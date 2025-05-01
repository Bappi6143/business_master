@extends('backend.master')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">eCommerce</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active text-dark-blue" aria-current="page">Products</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex">
                    <h5 class="card-title text-dark-blue">Add New Product</h5>
                    <div class="ms-auto text-end">
                        <a href="{{ url('categories') }}" class="btn btn-primary"><i class="bx bxs-plus-square"></i> Add New Category</a>
                        <a href="{{ url('variants') }}" class="btn btn-primary"><i class="bx bxs-plus-square"></i> Add New Variant</a>
                    </div>
                </div>
                <hr />

                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="border border-3 p-4 rounded row">
                                    <div class="mb-3 col-md-4">
                                        <label for="inputProductTitle" class="form-label">Product Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="inputProductTitle" name="title" placeholder="Enter product title" required>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="inputProductCategory" class="form-label">Product Category</label>
                                        <select class="form-select" id="inputProductCategory" name="category">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="inputSubCategory" class="form-label">Sub Category</label>
                                        <select class="form-select" id="inputSubCategory" name="subcategory">
                                            <option value="">Select Sub Category</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="inputProductDescription" name="description" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="inputRegularPrice" class="form-label">Regular Price <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="inputRegularPrice" name="price" placeholder="00.00" required>
                                    </div>
                                </div>

                                <!-- Multi Variant Section -->
                                <div class="border border-3 p-4 rounded mt-4 mb-4">
                                    <h6>Product Variants</h6>
                                    <div id="variantRowsContainer">
                                        <div class="variant-row row mb-2">
                                            <div class="col-md-4">
                                                <label>Variant Name</label>
                                                <select name="variants[0][variant_id]" class="form-select" onchange="fetchVariantValues(this)">
                                                    <option value="">Select Variant</option>
                                                    @foreach ($variants as $variant)
                                                    <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Variant Value</label>
                                                <select name="variants[0][variant_value_id]" class="form-select">
                                                    <option value="">Select Variant Value</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-variant-row">X</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary" id="addVariantRow">+ Add More Variant</button>
                                </div>

                                <div class="border border-3 p-4 rounded row">
                                    <div class="mb-3 col-md-4 ">
                                        <label for="inputProductCode" class="form-label">SKU <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="inputProductCode" name="code" placeholder="Enter Product Code" required>
                                        <span>Must be a unique number </span>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="inputAvailableQuantity" class="form-label">Available Quantity <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="inputAvailableQuantity" name="initial_quantity" placeholder="Enter Quantity" required>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="inputProductStatus" class="form-label">Product Status</label>
                                        <select class="form-select" id="inputProductStatus" name="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="image-uploadify" class="form-label">Product Images</label>
                                        <input id="image-uploadify" name="image" type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="border border-3 p-4 rounded mt-4 mb-4">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Save Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#inputProductCategory').on('change', function() {
            let categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: "/get-subcategories/" + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#inputSubCategory').empty().append('<option value="">Select Sub Category</option>');
                        $.each(data, function(key, value) {
                            $('#inputSubCategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log("Error fetching subcategories:", error);
                    }
                });
            }
        });

        window.fetchVariantValues = function(element) {
            let variantId = $(element).val();
            let target = $(element).closest('.variant-row').find('select[name$="[variant_value_id]"]');
            if (variantId) {
                $.ajax({
                    url: "/get-variant-values/" + variantId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        target.empty().append('<option value="">Select Variant Value</option>');
                        $.each(data, function(key, value) {
                            target.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log("Error fetching variant values:", error);
                    }
                });
            }
        };

        let variantIndex = 1;
        $('#addVariantRow').on('click', function() {
            let html = `
                <div class="variant-row row mb-2">
                    <div class="col-md-4">
                        <select name="variants[${variantIndex}][variant_id]" class="form-select" onchange="fetchVariantValues(this)">
                            <option value="">Select Variant</option>
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="variants[${variantIndex}][variant_value_id]" class="form-select">
                            <option value="">Select Variant Value</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-variant-row">X</button>
                    </div>
                </div>
            `;
            $('#variantRowsContainer').append(html);
            variantIndex++;
        });

        $(document).on('click', '.remove-variant-row', function() {
            $(this).closest('.variant-row').remove();
        });
    });
</script>
@endsection