<?php

namespace App\Controllers;

use App\Requests\Request;
use App\Models\Product;
use Config\Database;

class ProductController
{
    private $db;
    private $product;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->product = new Product($this->db);
    }

    public function addProduct()
    {
        // Initialize Request with POST data
        $request = new Request($_POST);

        // Fetch existing SKUs
        $existingSKUs = $this->getExistingSKUs();

        // Validate required fields and unique SKU
        $request->validateRequired(['sku', 'name', 'price', 'product_type']);
        $request->validateUniqueSKU($request->get('sku'), $existingSKUs);

        // Validate numeric fields based on product type
        $numericFields = ['price'];
        switch ($request->get('product_type')) {
            case 'DVD':
                $numericFields[] = 'size';
                break;
            case 'Book':
                $numericFields[] = 'weight';
                break;
            case 'Furniture':
                $numericFields = array_merge($numericFields, ['height', 'width', 'length']);
                break;
        }

        // Validate numeric fields
        $request->validateNumeric($numericFields);

        // Handle errors or save product
        if ($request->hasErrors()) {
            $this->handleErrors($request->getErrors());
        } else {
            $this->setProductValues($request);
            if ($this->product->create()) {
                $this->handleSuccess("Product saved successfully.");
            } else {
                $this->handleError("Error while saving the product.");
            }
        }
    }

    private function handleErrors($errors)
    {
        $response = ['status' => 'error', 'errors' => $errors];
        echo $this->isAjax() ? json_encode($response) : include 'views/add-product.php';
        exit;
    }

    private function handleSuccess($message)
    {
        echo json_encode(['status' => 'success', 'message' => $message]);
        exit;
    }

    private function handleError($message)
    {
        echo json_encode(['status' => 'error', 'message' => $message]);
        exit;
    }

    private function setProductValues(Request $request)
    {
        $this->product->sku = $request->get('sku');
        $this->product->name = $request->get('name');
        $this->product->price = $request->get('price');
        $this->product->product_type = $request->get('product_type');
        $this->product->size = $request->get('size');
        $this->product->weight = $request->get('weight');
        $this->product->height = $request->get('height');
        $this->product->width = $request->get('width');
        $this->product->length = $request->get('length');
    }

    private function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function getProducts()
    {
        return $this->product->readAll();
    }

    private function getExistingSKUs()
    {
        return $this->product->getAllSKUs();
    }

    public function massDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log('Received POST request for mass delete.');

            if (isset($_POST['skus']) && is_array($_POST['skus'])) {
                $skus = $_POST['skus'];
                error_log('Received SKUs: ' . implode(',', $skus)); // سجل الـ SKUs المستلمة

                if (!empty($skus)) {
                    $deleted = $this->product->deleteBySKUs($skus);

                    if ($deleted) {
                        // تأكد من عدد المنتجات المحذوفة
                        error_log('Deleted SKUs: ' . implode(',', $skus));
                        echo json_encode([
                            'status' => 'success',
                            'message' => count($skus) . ' products deleted successfully.'
                        ]);
                    } else {
                        error_log('Failed to delete SKUs: ' . implode(',', $skus));
                        echo json_encode(['status' => 'error', 'message' => 'An error occurred while deleting products.']);
                    }
                } else {
                    error_log('No products were selected for deletion.');
                    echo json_encode(['status' => 'error', 'message' => 'No products were selected for deletion.']);
                }
            } else {
                error_log('No SKUs received or invalid format.');
                echo json_encode(['status' => 'error', 'message' => 'No SKUs received.']);
            }
        } else {
            error_log('Invalid request method for mass delete.');
            echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
        }
    }

}
