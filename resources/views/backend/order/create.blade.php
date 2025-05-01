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
                            <li class="breadcrumb-item active text-dark-blue" aria-current="page">Create Order</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{ url('customers') }}" class="btn btn-primary "><i class="bx bxs-plus-square"></i>Add New
                        Customer</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title text-dark-blue">Create New Order</h5>
                    <hr />

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="selectCustomerContact" class="form-label">Customer Contact <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="selectCustomerContact" required></select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputCustomerName" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="inputCustomerName" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputCustomerAddress" class="form-label">Customer Address</label>
                                        <textarea class="form-control" id="inputCustomerAddress" rows="3" readonly></textarea>
                                    </div>
                                </div>

                                <div class="border border-3 p-4 rounded mt-4 mb-4">
                                    <div class="mb-3">
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-primary" id="addProductButton">Add
                                                Product</button>
                                        </div>
                                    </div>
                                    <div id="productContainer"></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputOrderStatus" class="form-label">Order Status</label>
                                        <select class="form-select" id="inputOrderStatus" required>
                                            <option value="pending">Pending</option>
                                            <option value="confirmed">Confirmed</option>
                                            <option value="completed">Completed</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="returned">Returned</option>
                                            <option value="follow">Follow Up</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="delivery_zone_id" class="form-label">Delivery Zone <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="delivery_zone_id" required>
                                            <option value="">Select Zone</option>
                                            @foreach ($deliveryZones as $zone)
                                                <option value="{{ $zone->id }}"
                                                    data-charge="{{ $zone->delivery_charge }}">{{ $zone->zone_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputDeliveryCharge" class="form-label">Delivery Charge</label>
                                        <input type="number" class="form-control" id="inputDeliveryCharge"
                                            placeholder="00.00" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="ordered_quantity" class="form-label">Order Quantity</label>
                                        <input type="number" class="form-control" id="ordered_quantity" placeholder="00.00"
                                            readonly>
                                    </div>
                                </div>

                                <div class="border border-3 p-4 rounded mt-4 mb-4">
                                    <div class="mb-3">
                                        <label for="inputSubtotal" class="form-label">Subtotal</label>
                                        <input type="text" class="form-control" id="inputSubtotal" placeholder="00.00"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputDiscount" class="form-label">Discount Amount</label>
                                        <input type="number" class="form-control" id="inputDiscount" placeholder="00.00"
                                            value="0" min="0">
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputTotalPrice" class="form-label">Total Price</label>
                                        <input type="text" class="form-control" id="inputTotalPrice"
                                            placeholder="00.00" readonly>
                                    </div>
                                </div>

                                <div class="border border-3 p-4 rounded">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary" id="saveOrderButton">Save
                                            Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .product-name option {
            position: relative;
        }

        .product-name option::after {
            content: attr(data-sku);
            color: #666;
            margin-left: 10px;
            font-size: 0.9em;
        }
    </style>
    <script>
        $(document).ready(function() {
            let productCount = 0;
            let productData = {};

            // Fetch customers dynamically
            $.ajax({
                url: "/admin/customers",
                method: "GET",
                success: function(response) {
                    let select = $("#selectCustomerContact");
                    select.append('<option value="">Select Contact</option>');
                    response.forEach(customer => {
                        select.append(
                            `<option value="${customer.phone}" data-name="${customer.name}" data-address="${customer.address}">${customer.phone}</option>`
                            );
                    });
                }
            });

            // Fetch products dynamically
            $.ajax({
                url: "/admin/products",
                method: "GET",
                success: function(response) {
                    productData = response.reduce((obj, item) => {
                        obj[item.id] = {
                            name: `${item.title} (${item.code})`,
                            price: parseFloat(item.price),
                            sku: item.code,
                            stock: item.stock_quantity
                        };
                        return obj;
                    }, {});
                }
            })

            // Populate customer details on selection
            $('#selectCustomerContact').change(function() {
                let selectedOption = $(this).find(':selected');
                $('#inputCustomerName').val(selectedOption.data('name') || '');
                $('#inputCustomerAddress').val(selectedOption.data('address') || '');
            });

            // Set delivery charge when zone is selected
            $('#delivery_zone_id').change(function() {
                let selectedOption = $(this).find(':selected');
                let deliveryCharge = selectedOption.data('charge') || 0;
                $('#inputDeliveryCharge').val(deliveryCharge);
                updateTotalPrice();
            });

            // Add new product row
            $('#addProductButton').click(function() {
                productCount++;
                let productOptions = Object.keys(productData)
                    .map(id =>
                        `<option value="${id}" data-sku="${productData[id].sku}">${productData[id].name}</option>`
                        )
                    .join('');

                $('#productContainer').append(`
        <div class="border border-3 p-2 mb-3 row product-item" id="product${productCount}">
            <h6>Product ${productCount}</h6>
            <div class="mb-3 col-md-4">
                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                <select class="form-select product-name" data-id="${productCount}">
                    <option value="">Select Product</option>
                    ${productOptions}
                </select>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label">Price</label>
                <input type="text" class="form-control product-price" data-id="${productCount}" readonly>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control product-quantity" data-id="${productCount}" value="1" min="1">
            </div>
              <div class="mb-3 col-md-2 mt-2">
                  </br>
                  <button type="button " class="btn btn-danger remove-product" data-id="${productCount}">Remove</button>
              </div>
        </div>
    `);
            });

            // Update price and show stock when product is selected
            $(document).on('change', '.product-name', function() {
                let productId = $(this).val();
                let productRow = $(this).closest('.product-item');
                let priceField = productRow.find('.product-price');

                if (productData[productId]) {
                    priceField.val(productData[productId].price.toFixed(2));

                    // ✅ Show available stock next to Quantity input
                    if (!productRow.find('.available-stock').length) {
                        productRow.find('.product-quantity').after(
                            `<small class="text-muted available-stock" style="display:block;">Available: ${productData[productId].stock}</small>`
                            );
                    } else {
                        productRow.find('.available-stock').text(
                            `Available: ${productData[productId].stock}`);
                    }

                    // ✅ Reset quantity if previously selected
                    productRow.find('.product-quantity').val(1);
                } else {
                    priceField.val("");
                    productRow.find('.available-stock').remove();
                }

                updateTotalPrice();
            });


            // Update total price when quantity is changed
            $(document).on('input', '.product-quantity', function() {
                updateTotalPrice();
            });

            // Remove product row
            $(document).on('click', '.remove-product', function() {
                let productId = $(this).data('id');
                $('#product' + productId).remove();
                updateTotalPrice();
            });

            // Update discount amount and recalculate total
            $(document).on('input', '#inputDiscount', function() {
                updateTotalPrice();
            });

            // Update total price calculation
            function updateTotalPrice() {
                let subtotal = 0;
                let totalQuantity = 0;

                $('.product-item').each(function() {
                    let price = parseFloat($(this).find('.product-price').val()) || 0;
                    let quantity = parseInt($(this).find('.product-quantity').val()) || 1;
                    subtotal += price * quantity;
                    totalQuantity += quantity;
                });

                let deliveryCharge = parseFloat($('#inputDeliveryCharge').val()) || 0;
                let discountAmount = parseFloat($('#inputDiscount').val()) || 0;

                $('#inputSubtotal').val(subtotal.toFixed(2));
                $('#ordered_quantity').val(totalQuantity);

                let totalPrice = subtotal + deliveryCharge - discountAmount;
                $('#inputTotalPrice').val(totalPrice.toFixed(2));
            }

            // CSRF Token setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Save order
            // Save order
            $('#saveOrderButton').click(function() {
                let products = [];
                let stockError = false; // ✅ Add this

                $('.product-item').each(function() {
                    let productId = $(this).find('.product-name').val();
                    let quantity = parseInt($(this).find('.product-quantity').val());
                    let price = $(this).find('.product-price').val();

                    if (productId) {
                        if (quantity > productData[productId].stock) { // ✅ Check stock
                            alert(
                                `Order quantity for "${productData[productId].name}" exceeds available stock!`);
                            stockError = true;
                        }
                        products.push({
                            id: productId,
                            quantity: quantity,
                            price: price
                        });
                    }
                });

                if (stockError) {
                    return; // ✅ Stop the Save process if stock error
                }

                let orderData = {
                    customer_contact: $('#selectCustomerContact').val(),
                    customer_name: $('#inputCustomerName').val(),
                    customer_address: $('#inputCustomerAddress').val(),
                    products: products,
                    order_status: $('#inputOrderStatus').val(),
                    delivery_zone_id: $('#delivery_zone_id').val(),
                    delivery_charge: $('#inputDeliveryCharge').val(),
                    subtotal: $('#inputSubtotal').val(),
                    discount_amount: $('#inputDiscount').val(),
                    total_price: $('#inputTotalPrice').val(),
                    ordered_quantity: $('#ordered_quantity').val()
                };

                $.ajax({
                    url: '/orders',
                    method: 'POST',
                    data: orderData,
                    success: function(response) {
                        window.location.href = '/orders';
                    },
                    error: function(error) {
                        console.error(error);
                        alert('An error occurred while saving the order.');
                    }
                });
            });

        });
    </script>
@endsection
