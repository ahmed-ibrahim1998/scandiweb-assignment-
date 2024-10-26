<?php
namespace App\Controllers;

require_once '../vendor/autoload.php'; // Ensure autoload is loaded
require_once '../app/controllers/ProductController.php'; // Ensure the path is correct

use App\Controllers\ProductController;

$productController = new ProductController();
$products = $productController->getProducts();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mass_delete') {
    $productController->massDelete(); // Call the mass delete function
    exit; // End the script after performing the deletion
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" type="text/css" href="../public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../public/assets/css/style.css">
    <script src="../public/assets/js/jquery3.4.1.min.js"></script>
    <script src="../public/assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Product List</h2>
        <div>
            <button class="btn btn-primary" id="add-product">ADD</button> <!-- Changed to button -->
            <button class="btn btn-danger" id="mass-delete">MASS DELETE</button>
        </div>
    </div>

    <form id="product-form" method="POST" action="">
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4"> <!-- Change here to display 4 cards in a row -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <input type="checkbox" name="selected_products[]"
                                   value="<?php echo htmlspecialchars($product->sku); ?>">
                            <h5 class="mb-0"><?php echo htmlspecialchars($product->name); ?></h5>
                        </div>
                        <div class="card-body">
                            <p><strong>SKU:</strong> <?php echo htmlspecialchars($product->sku); ?></p>
                            <p><strong>Price:</strong> $<?php echo htmlspecialchars($product->price); ?></p>
                            <p><strong>Product Type:</strong> <?php echo htmlspecialchars($product->product_type); ?>
                            </p>
                            <?php if ($product->product_type === 'DVD'): ?>
                                <p><strong>Size:</strong> <?php echo htmlspecialchars($product->size); ?> MB</p>
                            <?php elseif ($product->product_type === 'Book'): ?>
                                <p><strong>Weight:</strong> <?php echo htmlspecialchars($product->weight); ?> Kg</p>
                            <?php elseif ($product->product_type === 'Furniture'): ?>
                                <p><strong>Dimensions:</strong> <?php echo htmlspecialchars($product->height); ?>
                                    x <?php echo htmlspecialchars($product->width); ?>
                                    x <?php echo htmlspecialchars($product->length); ?> cm</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </form>


    <script src="../public/assets/js/main.js"></script>
</body>
</html>
