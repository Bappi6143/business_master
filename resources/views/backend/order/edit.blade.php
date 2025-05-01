@extends('backend.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">eCommerce</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active text-dark-blue" aria-current="page">Edit Order</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title text-dark-blue">Edit Order</h5>
                    <hr />
                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Customer Info -->
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="selectCustomerContact" class="form-label">Customer Contact</label>
                                        <select class="form-select" id="selectCustomerContact"></select>
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

                                <!-- Product Section -->
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
                                <!-- Order Info -->
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputOrderStatus" class="form-label">Order Status</label>
                                        <select class="form-select" id="inputOrderStatus">
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
                                        <label for="delivery_zone_id" class="form-label">Delivery Zone</label>
                                        <select class="form-select" id="delivery_zone_id">
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
                                        <input type="number" class="form-control" id="inputDeliveryCharge" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="ordered_quantity" class="form-label">Order Quantity</label>
                                        <input type="number" class="form-control" id="ordered_quantity" readonly>
                                    </div>
                                </div>

                                <!-- Price Summary -->
                                <div class="border border-3 p-4 rounded mt-4 mb-4">
                                    <div class="mb-3">
                                        <label for="inputSubtotal" class="form-label">Subtotal</label>
                                        <input type="text" class="form-control" id="inputSubtotal" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputDiscount" class="form-label">Discount Amount</label>
                                        <input type="number" class="form-control" id="inputDiscount" value="0"
                                            min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputTotalPrice" class="form-label">Total Price</label>
                                        <input type="text" class="form-control" id="inputTotalPrice" readonly>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="border border-3 p-4 rounded">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary" id="saveOrderButton">Update
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

    <script>
        $(document).ready(function() {
            let order = {!! json_encode($order) !!};
            let products = JSON.parse(order.products);
            let productData = {};
            let productCount = 0;

            // Load customers
            $.get("/admin/customers", function(customers) {
                let select = $('#selectCustomerContact').append('<option value="">Select</option>');
                customers.forEach(c => {
                    let selected = c.phone === order.customer_contact ? 'selected' : '';
                    select.append(
                        `<option value="${c.phone}" data-name="${c.name}" data-address="${c.address}" ${selected}>${c.phone}</option>`
                        );
                });
                $('#inputCustomerName').val(order.customer_name);
                $('#inputCustomerAddress').val(order.customer_address);
            });

            // Load products
            $.get("/admin/products", function(response) {
                productData = response.reduce((obj, item) => {
                    obj[item.id] = {
                        name: item.title,
                        price: parseFloat(item.price),
                        stock: item.stock_quantity
                    };
                    return obj;
                }, {});
                products.forEach((p, i) => addProductRow(p, ++productCount));
                updateTotalPrice();
            });

            $('#delivery_zone_id').change(function() {
                let charge = $(this).find(':selected').data('charge') || 0;
                $('#inputDeliveryCharge').val(charge);
                updateTotalPrice();
            });

            $('#inputDiscount').on('input', updateTotalPrice);

            $('#addProductButton').click(() => addProductRow({}, ++productCount));

            $(document).on('change', '.product-name', function() {
                let id = $(this).val();
                let price = productData[id] ? productData[id].price : '';
                let stock = productData[id] ? productData[id].stock : 0;

                let productRow = $(this).closest('.product-item');
                productRow.find('.product-price').val(price);

                if (!productRow.find('.available-stock').length) {
                    productRow.find('.product-quantity').after(
                        `<small class="available-stock text-muted d-block">Available: ${stock}</small>`);
                } else {
                    productRow.find('.available-stock').text(`Available: ${stock}`);
                }
            });

            $(document).on('input', '.product-quantity', updateTotalPrice);

            $(document).on('click', '.remove-product', function() {
                $('#product' + $(this).data('id')).remove();
                updateTotalPrice();
            });

            function addProductRow(p = {}, index) {
                let options = Object.keys(productData).map(id => {
                    return `<option value="${id}" ${id == p.id ? 'selected' : ''}>${productData[id].name}</option>`;
                }).join('');

                $('#productContainer').append(`
        <div class="border border-3 p-2 mb-3 row product-item" id="product${index}">
            <h6>Product ${index}</h6>
            <div class="mb-3 col-md-4">
                <label class="form-label">Product</label>
                <select class="form-select product-name" data-id="${index}">${options}</select>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label">Price</label>
                <input type="text" class="form-control product-price" value="${p.price || ''}" readonly>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control product-quantity" value="${p.quantity || 1}" min="1">
            </div>
            <div class="mb-3 col-md-2 mt-2">
                <br>
                <button type="button" class="btn btn-danger remove-product" data-id="${index}">Remove</button>
            </div>

        </div>`);
            }

            function updateTotalPrice() {
                let subtotal = 0;
                let quantity = 0;
                $('.product-item').each(function() {
                    let price = parseFloat($(this).find('.product-price').val()) || 0;
                    let qty = parseInt($(this).find('.product-quantity').val()) || 1;
                    subtotal += price * qty;
                    quantity += qty;
                });
                let delivery = parseFloat($('#inputDeliveryCharge').val()) || 0;
                let discount = parseFloat($('#inputDiscount').val()) || 0;
                let total = subtotal + delivery - discount;

                $('#inputSubtotal').val(subtotal.toFixed(2));
                $('#inputTotalPrice').val(total.toFixed(2));
                $('#ordered_quantity').val(quantity);
            }

            $('#saveOrderButton').click(function() {
                let products = [];
                let stockError = false;

                $('.product-item').each(function() {
                    let id = $(this).find('.product-name').val();
                    let qty = parseInt($(this).find('.product-quantity').val());
                    let price = $(this).find('.product-price').val();

                    if (productData[id] && qty > productData[id].stock) {
                        alert(
                            `Order quantity for "${productData[id].name}" exceeds available stock!`);
                        stockError = true;
                    }

                    if (id) products.push({
                        id,
                        quantity: qty,
                        price
                    });
                });

                if (stockError) {
                    return;
                }

                let data = {
                    customer_contact: $('#selectCustomerContact').val(),
                    customer_name: $('#inputCustomerName').val(),
                    customer_address: $('#inputCustomerAddress').val(),
                    products,
                    order_status: $('#inputOrderStatus').val(),
                    delivery_zone_id: $('#delivery_zone_id').val(),
                    delivery_charge: $('#inputDeliveryCharge').val(),
                    subtotal: $('#inputSubtotal').val(),
                    discount_amount: $('#inputDiscount').val(),
                    total_price: $('#inputTotalPrice').val(),
                    ordered_quantity: $('#ordered_quantity').val()
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: `/orders/${order.id}`,
                    type: 'PUT',
                    data: data,
                    success: () => window.location.href = "/orders",
                    error: err => {
                        console.error(err);
                        alert('Error updating order');
                    }
                });
            });
        });
    </script>
@endsection
