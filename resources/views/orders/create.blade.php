@extends('layouts.app')

@section('content')
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://images.pexels.com/photos/4483610/pexels-photo-4483610.jpeg?cs=srgb&dl=pexels-tiger-lily-4483610.jpg&fm=jpg");
            background-size: cover;
            background-position: center;
            font-family: 'Montserrat', sans-serif;
        }
    </style>

    <div class="container bg-white py-3 ">
        <h3>Create an Order</h3>

        @include('inc.alert')

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary me-3" title="Back to Previous URL">Back</a>
            </div>
        </div>

        <form action="#" method="post">
            <div class="row my-3">
                <div class="col-6">
                    <div class="row">
                        <label class="col-12">Customer Name</label>
                        <select id="customer_id" name="customer_id" class="form-control" required>
                            <option value="">-- Select Customer -- </option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->firstname . ' ' . $customer->lastname }}
                                </option>
                            @endforeach
                        </select>
                        <script>
                            $(() => {
                                const choices = new Choices("#customer_id", {
                                    searchEnabled: true,
                                    searchResultLimit: 5,
                                    renderChoiceLimit: 5
                                });
                            });
                        </script>
                    </div>
                    @csrf
                    <div class="row my-3">
                        <label class="col-12">Customer Phone Number</label>
                        <div class="col-12">
                            <input type="text" name="customer_phone" class="form-control" id="customer_phone" readonly>
                        </div>
                    </div>
                    <div class="row my-3">
                        <label class="col-12">Customer Email</label>
                        <div class="col-12">
                            <input type="email" name="customer_email" class="form-control" id="customer_email" required>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <label class="col-12">Date: </label>
                        <div class="col-12">
                            <input type="text" class="form-control" name="order_date" required readonly
                                value="{{ date('m/d/Y') }}">
                        </div>
                    </div>
                    <div class="row my-3">
                        <label class="col-12">Shipping Address</label>
                        <div class="col-12">
                            <textarea name="shipping_address" class="form-control" required style="resize: none" id="shipping_address"></textarea>
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-12">Warehouse</label>
                        <select id="warehouse_id" name="warehouse_id" class="form-control" required>
                            <option value="">-- Select Warehouse -- </option>
                            @foreach ($warehouses as $_warehouse)
                                <option value="{{ $_warehouse->id }}" {{ $_warehouse->slug == $slug ? 'selected' : '' }}>
                                    {{ $_warehouse->name }}</option>
                            @endforeach
                        </select>
                        <script>
                            $(() => {
                                const choices = new Choices("#warehouse_id", {
                                    searchEnabled: true,
                                    searchResultLimit: 5,
                                    renderChoiceLimit: 5
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row my-3">
                <div class="col-12">
                    <h5 class="fw-bold mb-3">Add Product</h5>
                    <button type="button" id="addProduct" class="addProduct btn btn-primary float-end me-3"><i
                            class="fa fa-plus"></i></button>
                </div>

                <div class="col-12 my-3">
                    <div id="productContainer" class="productContainer">
                        <div class="row my-3">
                            <div class="col-4">
                                <label class="fw-bold">Product</label>
                                <select class="form-control products" name="products[1]" required>

                                </select>
                            </div>
                            <div class="col-1">
                                <label class="fw-bold">Qty</label>
                                <input type="number" class="form-control quantity" name="quantity[1]" required>
                            </div>
                            <div class="col-1">
                                <label class="fw-bold">Stock Qty</label>
                                <input type="number" class="form-control stock_quantity" disabled>
                            </div>
                            <div class="col-2">
                                <label class="fw-bold">Price</label>
                                <input type="number" class="form-control price" disabled>
                            </div>
                            <div class="col-2">
                                <label class="fw-bold">Total Price</label>
                                <input type="number" class="form-control total_price" disabled>
                            </div>
                            <div class="col-2">
                                <label class="fw-bold">Action</label><br>
                                <button type="button" class="btn btn-danger me-3 removeProduct"><i
                                        class="fa fa-x"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <hr>
            <div class="row my-3">
                <div class="col-12">
                    <h5 class="fw-bold mb-3">Printing Service</h5>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <select class="form-control" id="printing_services" name="printing_services">
                                <option value="0">No Design</option>
                                <option value="1">Minimal</option>
                                <option value="2">Half Box</option>
                                <option value="3">Full Box</option>
                            </select>

                            <p>Cost: <span id="printing_cost">0.00</span></p>
                        </div>
                    </div>
                </div>

            </div>

            <hr>
            <div class="row my-3 justify-content-center">
                <div class="col-12">
                    <h5 class="fw-bold mb-3">Payment</h5>
                </div>

                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <label>Gross Amount</label>
                            <input type="number" name="gross_amount" id="gross_amount" class="form-control" readonly
                                required>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-12">
                            <label>Vat (12%)</label>
                            <input type="number" name="vat" id="vat" class="form-control" readonly required>
                        </div>
                    </div>
                    {{-- <div class="row my-3">
                    <div class="col-12">
                        <label>Discount</label>
                        <input type="number" name="discount" id="discount" class="form-control">
                    </div>
                </div> --}}
                    <div class="row my-3">
                        <div class="col-12">
                            <label>Total Amount</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control" readonly
                                required>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success">Submit Order</button>
                        </div>
                    </div>
                </div>

                <script>
                    var totalSum = 0;
                    var vat = 0;
                    var totalAmount = 0;

                    function calculate() {
                        totalSum = 0; // Reset totalSum before recalculating
                        $(".total_price").each(function() {
                            var price = parseFloat($(this).val());
                            totalSum += price;
                        });

                        totalSum += printing_cost;

                        vat = totalSum * 0.12;
                        totalAmount = totalSum + vat;

                        $("#gross_amount").val(totalSum.toFixed(2));
                        $("#vat").val(vat.toFixed(2));
                        $("#total_amount").val(totalAmount.toFixed(2));
                    }

                    $(() => {
                        $(document).on('change input', '.quantity', () => {
                            calculate();
                        });
                    });
                </script>



            </div>
        </form>

    </div>

    <script>
        var products = @json($products);
        var selectedProducts = [];

        // Add product
        var productIndex = 2;

        $(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });


            // Populate products
            function populateSelect(items) {
                var select = $('.products');
                select.empty();
                select.append(`<option>-- Select Product -- </option>`);
                $.each(items, function(index, product) {
                    if (!selectedProducts.includes(product.id)) {
                        select.append($('<option>', {
                            value: product.id,
                            text: product.product.name
                        }));
                    }
                });
            }

            // Populate the select when the page loads
            populateSelect(products);


            function calculateTotalPrice(productDiv) {
                var quantity = parseFloat(productDiv.find('.quantity').val()) || 0;
                var price = parseFloat(productDiv.find('.price').val()) || 0;
                var total_price = quantity * price;
                productDiv.find('.total_price').val(total_price);
            }

            function attachChangeListeners(productDiv) {
                productDiv.find('.quantity').on('change input', function() {
                    calculateTotalPrice(productDiv);
                });
                productDiv.find('.price').on('change input', function() {
                    calculateTotalPrice(productDiv);
                });
            }

            // Handle the "Add Product" button click
            $('.addProduct').click(function() {
                var productDiv = $('#productContainer .row').last();
                var productsDropdown = productDiv.find('.products');
                var quantityInput = productDiv.find('.quantity');
                var selectedProductId = productsDropdown.val();

                if (products.length == selectedProducts.length) {
                    Swal.fire({
                        title: 'All products have been selected',
                        icon: 'error'
                    });
                    return;
                }

                // Check if both product and quantity are selected/entered
                console.log(productsDropdown.val());

                if (productsDropdown.val() && quantityInput.val()) {

                    if (!selectedProducts.includes(selectedProductId)) {
                        selectedProducts.push(selectedProductId);
                    }

                    if (products.length == selectedProducts.length) {
                        Swal.fire({
                            title: 'All products have been selected',
                            icon: 'info'
                        });
                    }
                    var newProductDiv = productDiv.clone();
                    newProductDiv.attr('id', 'product-' + productIndex);

                    // Clear input values for the new row
                    newProductDiv.find('.products').val('');
                    newProductDiv.find('.quantity').val('');

                    // Update input names to use array notation
                    newProductDiv.find('.products').attr('name', 'products[' + productIndex + ']');
                    newProductDiv.find('.quantity').attr('name', 'quantity[' + productIndex + ']');
                    newProductDiv.find('.stock_quantity').attr('name', 'stock_quantity[' + productIndex +
                        ']').val('');
                    newProductDiv.find('.price').attr('name', 'price[' + productIndex + ']').val('');
                    newProductDiv.find('.total_price').attr('name', 'total_price[' + productIndex + ']')
                        .val('0');

                    // Append the new product
                    $('#productContainer').append(newProductDiv);

                    // Refresh the product select options for the newly added product only
                    populateSelectProduct(products, newProductDiv.find('.products'));
                    attachChangeListeners(newProductDiv);



                    productIndex++;
                } else {
                    Swal.fire({
                        title: 'Please select a product and enter a quantity before adding.',
                        icon: 'error'
                    });
                }
            });



            function populateSelectProduct(items, selectElement) {
                selectElement.empty();
                selectElement.append(`<option>-- Select Product --</option>`);
                $.each(items, function(index, product) {
                    if (!selectedProducts.includes(product.id)) {
                        selectElement.append($('<option>', {
                            value: product.id,
                            text: product.product.name
                        }));
                    }
                });
            }


            // $('.addProduct').click(function() {
            //     var productDiv = $('#productContainer .row').first();
            //     var productsDropdown = productDiv.find('.products');
            //     var quantityInput = productDiv.find('.quantity');


            //     // Check if both product and quantity are selected/entered
            //     if (productsDropdown.val() && quantityInput.val()) {
            //         var newProductDiv = productDiv.clone();
            //         newProductDiv.attr('id', 'product-' + productIndex);

            //         // Update input names to use array notation
            //         newProductDiv.find('.products').attr('name', 'products[' + productIndex + ']');
            //         newProductDiv.find('.quantity').attr('name', 'quantity[' + productIndex + ']').val("");
            //         newProductDiv.find('.stock_quantity').attr('name', 'stock_quantity[' + productIndex +
            //             ']').val("");
            //         newProductDiv.find('.price').attr('name', 'price[' + productIndex + ']').val("");
            //         newProductDiv.find('.total_price').attr('name', 'total_price[' + productIndex + ']')
            //             .val("0");

            //         // newProductDiv.css('display', 'block');
            //         $('#productContainer').append(newProductDiv);

            //         attachChangeListeners(newProductDiv);
            //         productIndex++;
            //     } else {
            //         Swal.fire({
            //             title: 'Please select a product and enter a quantity before adding.',
            //             icon: 'error'
            //         });
            //     }
            // });


            // Handle the "Remove Product" button click
            $('#productContainer').on('click', '.removeProduct', function() {
                var productDiv = $(this).closest('.row');
                var selectedProductId = productDiv.find('.products').val();
                console.log(selectedProductId);
                if (selectedProductId) {
                    // Remove the product from the selectedProducts array
                    var index = selectedProducts.indexOf(selectedProductId);
                    if (index > -1) {
                        selectedProducts.splice(index, 1);
                    }
                    console.log(selectedProducts);
                }



                // Remove the product from the list
                removeProduct(productDiv);
            });

            function removeProduct(productDiv) {
                // Check if there is at least one item
                if ($('#productContainer .row').length > 1) {
                    productDiv.remove();
                    calculate();
                } else {
                    Swal.fire({
                        title: 'You must have at least one item in the list.',
                        icon: 'error'
                    });
                }
            }



            // Attach change listeners to the initial product field
            attachChangeListeners($('#productContainer'));

            // Calculate total price for the initial product field
            calculateTotalPrice($('#productContainer'));

            // Function to populate price and current_quantity
            function populatePriceAndQuantity(selectedProductId, productDiv) {
                var selectedProduct = products.find(product => product.id === selectedProductId);
                if (selectedProduct) {
                    var priceInput = productDiv.find('.price');
                    var stockQuantityInput = productDiv.find('.stock_quantity');
                    priceInput.val(selectedProduct.product.price);
                    stockQuantityInput.val(selectedProduct.current_quantity);
                }
            }

            // Handle the change event of the product dropdown
            $('#productContainer').on('change', '.products', function() {
                var selectedProductId = parseInt($(this).val());
                var productDiv = $(this).closest('.row');
                populatePriceAndQuantity(selectedProductId, productDiv);
            });

            $('#productContainer').on('change', '.products', function() {
                var productDiv = $(this).closest('.row');
                var productsDropdown = productDiv.find('.products');
                var selectedProductId = productsDropdown.val();

                if (selectedProducts.includes(selectedProductId)) {
                    Swal.fire({
                        title: 'This product has already been added.',
                        icon: 'error'
                    });
                    // Refresh the product select options and clear the quantity input
                    populateSelectProduct(products, productsDropdown);
                    // quantityInput.val("");
                    // return; // Return early to prevent adding a duplicate product
                }
            });


            $("#productContainer").on('change input', '.quantity', function() {
                var productDiv = $(this).closest('.row');
                var productQuantity = productDiv.find('.quantity');
                var productStock = productDiv.find('.stock_quantity');

                var quantity = parseInt(productQuantity.val());
                var stock = parseInt(productStock.val());

                if (quantity < 0) {
                    Swal.fire({
                        title: 'Invalid value',
                        icon: 'error'
                    });
                    productQuantity.val("");
                }

                if (quantity > stock) {
                    Swal.fire({
                        title: 'Not enough stock',
                        icon: 'error'
                    });

                    productQuantity.val(stock);
                }

            });

            /////////////////////////////////////

            // Get customer info
            $("#customer_id").on('change', () => {
                var id = parseInt($("#customer_id").val());

                $.ajax({
                    url: "{{ route('orders.getCustomer') }}",
                    type: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: (data) => {
                        $("#customer_phone").val(data.phone);
                        $("#customer_email").val(data.email);
                    }
                });
            });

            $("#warehouse_id").on('change', () => {
                var id = parseInt($("#warehouse_id").val());

                $.ajax({
                    url: "{{ route('orders.getProductsByWarehouse') }}",
                    type: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: (data) => {
                        products = data;
                        $("#productContainer").html("");
                        var html = `
                        <div class="row my-3">
                        <div class="col-4">
                            <label class="fw-bold">Product</label>
                            <select class="form-control products" name="products[1]" required>

                            </select>
                        </div>
                        <div class="col-1">
                            <label class="fw-bold">Qty</label>
                            <input type="number" class="form-control quantity" name="quantity[1]" required>
                        </div>
                        <div class="col-1">
                            <label class="fw-bold">Stock Qty</label>
                            <input type="number" class="form-control stock_quantity" disabled>
                        </div>
                        <div class="col-2">
                            <label class="fw-bold">Price</label>
                            <input type="number" class="form-control price" disabled>
                        </div>
                        <div class="col-2">
                            <label class="fw-bold">Total Price</label>
                            <input type="number" class="form-control total_price" disabled>
                        </div>
                        <div class="col-2">
                            <label class="fw-bold">Action</label><br>
                            <button type="button" class="btn btn-danger me-3 removeProduct"><i
                                    class="fa fa-x"></i></button>
                        </div>
                    </div>
                        `;

                        $("#productContainer").append(html);
                        populateSelect(products);
                        selectedProducts = [];
                        console.log(products);
                    }
                });
            });
        });

        var printing_cost = 0;
        var previous_printing_cost = 0; // Variable to store the previous printing_cost

        $(() => {
            $("#printing_services").on('change', function() {
                var p = $(this).val();

                // Subtract the previous printing_cost
                totalSum -= previous_printing_cost;

                switch (p) {
                    case "0":
                        $("#printing_cost").text("0.00");
                        printing_cost = 0;
                        break;

                    case "1":
                        $("#printing_cost").text("80.00");
                        printing_cost = 80;
                        break;

                    case "2":
                        $("#printing_cost").text("120.00");
                        printing_cost = 120;
                        break;

                    case "3":
                        $("#printing_cost").text("200.00");
                        printing_cost = 200;
                        break;
                }

                // Update the previous_printing_cost
                previous_printing_cost = printing_cost;

                // Update totalSum, vat, and totalAmount
                totalSum += printing_cost;
                vat = totalSum * 0.12;
                totalAmount = totalSum + vat;

                $("#gross_amount").val(totalSum.toFixed(2));
                $("#vat").val(vat.toFixed(2));
                $("#total_amount").val(totalAmount.toFixed(2));
            });
        });
    </script>
@endsection
