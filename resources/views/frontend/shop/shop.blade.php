@extends('frontend.master')

@section('content')

<!-- Product Image Hover Style -->
<style>
    .product-img-hover {
        overflow: hidden;
        display: block;
        position: relative;
        border-radius: 8px;
    }

    .product-img-hover img {
        transition: all 0.4s ease-in-out;
    }

    .product-img-hover:hover img {
        transform: scale(1.1) translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
</style>

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('home') }}">Home</a>
                <a class="breadcrumb-item text-dark" href="{{ route('shop') }}">Shop</a>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 col-md-4">
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">Filter by Category</span>
            </h5>
            <div class="bg-light p-4 mb-30">
                <form action="{{ route('shop') }}" method="GET">
                    <select id="category" name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <h5 class="section-title position-relative text-uppercase mt-3">
                        <span class="bg-secondary pr-3">Filter by Subcategory</span>
                    </h5>
                    <select id="subcategory" name="subcategory" class="form-control">
                        <option value="">All Subcategories</option>
                        @if (request('category'))
                            @foreach ($categories->where('id', request('category'))->first()->subCategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    <button type="submit" class="btn btn-primary mt-3 w-100">Apply Filters</button>
                </form>
            </div>
        </div>

        <!-- Products -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="bg-white shadow-sm rounded p-3 h-100 d-flex flex-column justify-content-between">
                            <div class="text-center">
                                <a href="{{ route('product-detail', ['id' => $product->id]) }}" class="product-img-hover">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->title }}"
                                        class="img-fluid rounded mb-2"
                                        style="height: 220px; width: 100%; object-fit: cover;">
                                </a>

                                <h3 class="mt-2 text-start">{{ $product->title }}</h3>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="d-flex align-items-center">
                                        <h5 class="text-primary mb-0">৳ {{ $product->price }}</h5>
                                        @if ($product->regular_price && $product->regular_price > $product->price)
                                            <h6 class="text-muted mb-0 ms-2">
                                                <del>৳ {{ $product->regular_price }}</del>
                                            </h6>
                                        @endif
                                    </div>
                                    <p class="mb-0" style="font-size: 14px; color: {{ $product->stock_status == 'In stock' ? 'green' : 'red' }}">
                                        {{ $product->stock_status ?? 'In stock' }}
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-sm btn-outline-primary w-50 mr-1 add-to-cart"
                                    data-id="{{ $product->id }}">
                                    Add To Cart
                                </button>
                                <button class="btn btn-sm btn-primary w-50 ml-1 order-now"
                                    data-id="{{ $product->id }}">
                                    Order Now
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            {{ $products->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop End -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Scripts -->
<script>
    $(document).ready(function() {
        // Add to Cart Button
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');

            $.ajax({
                url: "{{ url('/cart/add') }}/" + productId,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    alert(response.message);
                    if (response.totalQuantity !== undefined) {
                        $('#cart-badge').text(response.totalQuantity).hide().fadeIn(200);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Order Now Button
        $(document).on('click', '.order-now', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');

            $.ajax({
                url: "{{ url('/cart/add') }}/" + productId,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success !== false) {
                        window.location.href = "{{ url('/cart') }}"; // ✅ Redirect directly to cart page
                    } else {
                        alert(response.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert('Something went wrong.');
                }
            });
        });

        // Load Subcategories Dynamically
        $('#category').on('change', function() {
            var categoryId = $(this).val();
            $('#subcategory').html('<option value="">All Subcategories</option>');

            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId,
                    type: 'GET',
                    success: function(response) {
                        response.forEach(function(subcategory) {
                            $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        });
                    }
                });
            }
        });

        // Form Reset subcategory if no category selected
        $('form').on('submit', function() {
            if (!$('#category').val()) {
                $('#subcategory').val('');
            }
        });
    });
</script>

@endsection
