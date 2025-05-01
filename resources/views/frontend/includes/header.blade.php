<!-- Header Start -->
<div class="container-fluid header-1 px-4">
    <div class="row align-items-center py-1">
        <div class="col-md-3 text-center text-md-left"></div>

        <!-- Important Text in the Middle -->
        <div class="col-md-6 text-center py-1">
            <div class="moving-text-container text-light font-weight-bold">
                <span class="moving-text">{{ \App\Models\Setting::getValue('header_text') }}</span>
            </div>
        </div>

        <!-- Customer Service on the Right -->
        <div class="col-md-3 text-center text-md-right py-1 d-flex align-items-center justify-content-md-end">
            <i class="fas fa-phone-alt text-light mr-2 phone-icon"></i> <!-- Animated Phone Icon -->
            <h6 class="m-0 text-light customer-service-number">{{ \App\Models\Setting::getValue('customer_service_number') }}</h6>
        </div>
    </div>
</div>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-dark header-2 sticky-top">
    <div class="container-fluid ">

        <!-- Logo on the Left -->
        <a href="#">
            <img src="{{ asset(\App\Models\Setting::getValue('logo')) }}" alt="logo" width="60">
        </a>

        <!-- Navbar Toggler for Mobile View -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Center: Navbar Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('shop') }}" class="nav-link">Shop</a></li>
                <li class="nav-item"><a href="{{ route('cart') }}" class="nav-link">Cart</a></li>
                <li class="nav-item"><a href="{{ route('checkout') }}" class="nav-link">Checkout</a></li>
                <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
            </ul>
        </div>

        <!-- Right Side: Icons Section -->
        <div class="d-flex align-items-center">

            <!-- Search Bar (Hidden on Mobile) -->
            <div class="d-none d-lg-block mx-3">
                <form action="{{ route('shop') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search products...">
                        <div class="input-group-append">
                            <button class="btn btn-success all-search-btn" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Cart Icon (Updated) -->
            <a href="{{ route('cart') }}" class="icon-link mx-3 position-relative">
                <i class="fa fa-shopping-cart icon-style"></i>
                <span id="cart-badge" class="badge-custom">
                    {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                </span>
            </a>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<script>
    $(document).ready(function() {
        $('.add-to-cart-btn').click(function(e) {
            e.preventDefault();
            let productId = $(this).data('id');

            $.ajax({
                url: "/cart/add/" + productId, // Update with correct route
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.cart) {
                        let totalQuantity = Object.values(response.cart).reduce((sum, item) => sum + item.quantity, 0);

                        // Smoothly update cart badge without reloading
                        let $cartBadge = $('#cart-badge');
                        $cartBadge.text(totalQuantity).hide().fadeIn(300);
                    }

                    // Optional: Show a success notification instead of alert
                    toastr.success(response.message);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    });
</script>