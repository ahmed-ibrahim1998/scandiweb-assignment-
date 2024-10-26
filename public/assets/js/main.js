// ===============================

//  Code For Product List Function


$(document).ready(function () {
    $('#mass-delete').on('click', function (e) {
        e.preventDefault();

        // Collect the SKUs from the selected products
        let selectedProducts = [];
        $('input[name="selected_products[]"]:checked').each(function () {
            selectedProducts.push($(this).val());
        });

        // Check if there are any selected products
        if (selectedProducts.length > 0) {
            // Perform the deletion directly without confirmation
            $.ajax({
                url: '', // Leave the URL empty as we are dealing with the same page
                type: 'POST',
                data: {
                    skus: selectedProducts, // Send the selected SKUs
                    action: 'mass_delete'   // Specify the action type in the request
                },
                success: function (response) {
                    let result = JSON.parse(response);

                    if (result.status === 'success') {
                        alert(result.message); // Show success message
                        location.reload(); // Reload the page after deletion
                    } else {
                        alert(result.message); // Show error message
                    }
                },
                error: function () {
                    alert('An error occurred while trying to delete the products.'); // Error message on failure
                }
            });
        } else {
            alert('Please select at least one product to delete.'); // Message when no product is selected
        }
    });

    // Redirect to add product page on button click
    $('#add-product').on('click', function () {
        window.location.href = 'add-product.php'; // Redirect to add product page
    });
});

// ===============================

//  Code For Add Product  Function

$(document).ready(function () {
    // Change dynamic fields based on product type selection
    $('#productType').change(function () {
        var productType = $(this).val();
        $('#dynamicFields').empty(); // Clear previous fields

        // Add dynamic fields based on product type
        if (productType === 'DVD') {
            $('#dynamicFields').append(`
                    <div class="form-group">
                        <label for="size">Size (MB):</label>
                        <input type="number" class="form-control" name="size" id="size" placeholder="Enter size in MB" required>
                        <div class="text-danger" id="size-error"></div>
                        <small class="form-text text-muted">Please, provide size in MB.</small> <!-- Description -->
                    </div>
                `);
        } else if (productType === 'Book') {
            $('#dynamicFields').append(`
                    <div class="form-group">
                        <label for="weight">Weight (Kg):</label>
                        <input type="number" class="form-control" name="weight" id="weight" placeholder="Enter weight in Kg" required>
                        <div class="text-danger" id="weight-error"></div>
                        <small class="form-text text-muted">Please, provide weight in Kg.</small> <!-- Description -->
                    </div>
                `);
        } else if (productType === 'Furniture') {
            $('#dynamicFields').append(`
                    <div class="form-group">
                        <label for="height">Height (cm):</label>
                        <input type="number" class="form-control" name="height" id="height" placeholder="Enter height in cm" required>
                        <div class="text-danger" id="height-error"></div>
                        <small class="form-text text-muted">Please, provide height in cm.</small> <!-- Description -->
                    </div>
                    <div class="form-group">
                        <label for="width">Width (cm):</label>
                        <input type="number" class="form-control" name="width" id="width" placeholder="Enter width in cm" required>
                        <div class="text-danger" id="width-error"></div>
                        <small class="form-text text-muted">Please, provide width in cm.</small> <!-- Description -->
                    </div>
                    <div class="form-group">
                        <label for="length">Length (cm):</label>
                        <input type="number" class="form-control" name="length" id="length" placeholder="Enter length in cm" required>
                        <div class="text-danger" id="length-error"></div>
                        <small class="form-text text-muted">Please, provide length in cm.</small> <!-- Description -->
                    </div>
                `);
        }
    });

    // Save product button click event
    $('#saveProduct').click(function (e) {
        e.preventDefault(); // Prevent default form submission

        // Clear previous error messages
        $('.text-danger').empty();
        $('#message').hide();

        // Submit form using AJAX
        $.ajax({
            url: '../index.php',
            type: 'POST',
            data: $('#product_Form').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#message').text('Product added successfully!').css({
                        'font-size': '20px',
                        'color': 'green',
                        'font-weight': 'bold',
                        'text-align' : 'center'
                    }).show();
                    // Redirect to product list page
                    setTimeout(function() {
                        window.location.href = '../views/product.php'; // Adjust path as needed
                    }, 2000); // Redirect after 2 seconds
                } else {
                    // Display errors if present
                    if (response.errors) {
                        ['sku', 'name', 'price', 'product_type', 'size', 'weight', 'height', 'width', 'length'].forEach(function(field) {
                            if (response.errors[field]) {
                                $('#' + field + '-error').text(response.errors[field]).css({
                                    'font-size': '20px',
                                    'color': 'red',
                                    'font-weight': 'bold'
                                });
                            }
                        });
                    }
                }
            },
            error: function() {
                // General error message on AJAX failure
                $('#dynamicFields').prepend('<div class="alert alert-danger font-weight-bold text-center">An error occurred while saving the product. Please try again.</div>');
            }
        });
    });

    // Cancel button click event
    $('#cancelButton').click(function() {
        // Redirect to product list page without saving
        window.location.href = '../views/product.php'; // Adjust path as needed
    });

});

// ===============================

