<?php

namespace App\Models;

use PDO;
use PDOException;

class Product
{
    private $conn;
    private $table_name = "products";

    public $id;
    public $sku;
    public $name;
    public $price;
    public $product_type;
    public $size;
    public $weight;
    public $height;
    public $width;
    public $length;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function create(): bool
    {
        $query = "INSERT INTO " . $this->table_name . " 
            (sku, name, price, product_type, size, weight, height, width, length) 
            VALUES (:sku, :name, :price, :product_type, :size, :weight, :height, :width, :length)";

        $stmt = $this->conn->prepare($query);
        $this->bindParameters($stmt);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error creating product: " . $e->getMessage());
            return false;
        }
    }

    public function getAllSKUs(): array
    {
        $query = "SELECT sku FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function readAll(): array
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteBySKUs(array $skus): bool
    {
        if (empty($skus)) {
            error_log("No SKUs provided for deletion.");
            return false;
        }

        $placeholders = implode(',', array_fill(0, count($skus), '?'));
        $query = "DELETE FROM " . $this->table_name . " WHERE sku IN ($placeholders)";
        $stmt = $this->conn->prepare($query);

        try {
            if ($stmt->execute($skus)) {
                return true;
            } else {
                error_log("Error deleting products: " . implode(',', $skus) . " - " . implode(',', $stmt->errorInfo()));
                return false;
            }
        } catch (PDOException $e) {
            error_log("PDO Error deleting products: " . $e->getMessage());
            return false;
        }
    }

    private function bindParameters($stmt): void
    {
        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':product_type', $this->product_type);
        $stmt->bindParam(':size', $this->size);
        $stmt->bindParam(':weight', $this->weight);
        $stmt->bindParam(':height', $this->height);
        $stmt->bindParam(':width', $this->width);
        $stmt->bindParam(':length', $this->length);
    }
}
