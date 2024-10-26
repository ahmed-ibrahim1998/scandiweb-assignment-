<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" type="text/css" href="../public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../public/assets/css/style.css">
    <script src="../public/assets/js/jquery3.4.1.min.js"></script>
    <script src="../public/assets/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container mt-5">
    <div class="form-buttons mb-3">
        <button id="saveProduct" type="button" class="btn btn-success">Save</button>
        <button id="cancelButton" type="button" class="btn btn-secondary">Cancel</button> <!-- Cancel Button -->
    </div>

    <h2>Add Product</h2>
    <div id="message" class="alert alert-success" style="display: none;"></div>

    <form id="product_Form" action="/index.php" method="POST">
        <div class="form-group">
            <label for="sku">SKU:</label>
            <input type="text" class="form-control" name="sku" id="sku" placeholder="Enter SKU" required>
            <div class="text-danger" id="sku-error"></div>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name" required>
            <div class="text-danger" id="name-error"></div>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" name="price" id="price" placeholder="Enter price" required>
            <div class="text-danger" id="price-error"></div>
        </div>
        <div class="form-group">
            <label for="productType">Product Type:</label>
            <select class="form-control" name="product_type" id="productType" required>
                <option value="">Select product type</option>
                <option value="DVD">DVD</option>
                <option value="Book">Book</option>
                <option value="Furniture">Furniture</option>
            </select>
            <div class="text-danger" id="productType-error"></div>
        </div>
        <div id="dynamicFields"></div>
        <input type="submit" style="display: none;"> <!-- Hidden submit button -->
    </form>
</div>
<script src="../public/assets/js/main.js"></script>
</body>
</html>
