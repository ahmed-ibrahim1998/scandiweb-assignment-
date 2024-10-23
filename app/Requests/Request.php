<?php

namespace App\Requests;

class Request
{
    private $data;
    private $errors = [];

    public function __construct(array $post_data)
    {
        $this->data = $post_data;
    }

    public function validateRequired(array $fields): void
    {
        foreach ($fields as $field) {
            if (empty($this->data[$field])) {
                $this->errors[$field] = "The $field field is required.";
            }
        }
    }

    public function validateUniqueSKU(string $sku, array $existingSKUs): void
    {
        if (in_array($sku, $existingSKUs)) {
            $this->errors['sku'] = "SKU must be unique.";
        }
    }

    public function validateNumeric(array $fields): void
    {
        foreach ($fields as $field) {
            if (!isset($this->data[$field]) || !is_numeric($this->data[$field]) || $this->data[$field] <= 0) {
                $this->errors[$field] = "The $field field must be a valid number greater than zero.";
            }
        }
    }

    public function get(string $field, $default = null)
    {
        return $this->data[$field] ?? $default;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
