<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAll()
    {
        try {
            $products = $this->product->getAllProducts();
            return json($products);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function store($request)
    {
        if (empty($request['name'])) {
            return json(['error' => "The name is required"], 500);
        }

        if (!isset($request['price']) || !is_numeric($request['price']) || $request['price'] < 0) {
            return json(['error' => "The price is required"], 500);
        }

        if (!isset($request['type_id']) || !is_numeric($request['type_id']) || $request['type_id'] <= 0) {
            return json(['error' => "The product type is required"], 500);
        }

        if (!isset($request['quantity_in_stock']) || !is_numeric($request['quantity_in_stock']) || $request['quantity_in_stock'] <= 0) {
            return json(['error' => "The quantity in stock is required"], 500);
        }

        try {
            $this->product->setName($request['name']);
            $this->product->setPrice($request['price']);
            $this->product->setTypeId($request['type_id']);
            $this->product->setQuantityInStock($request['quantity_in_stock']);
            $product = $this->product->createProduct();
            return json([...$product, 'message' => 'Product successfully created!'], 201);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id, $request)
    {
        try {
            $product = $this->product->getProductById($id);

            if (!$product) {
                return json(['error' => 'Product not found.'], 404);
            }

            if (empty($request)) {
                return json(['error' => 'No fields to update.'], 400);
            }

            if (isset($request['name'])) {
                $this->product->setName($request['name']);
            }

            if (isset($request['price'])) {
                $this->product->setPrice($request['price']);
            }

            if (isset($request['type_id'])) {
                $this->product->setTypeId($request['type_id']);
            }

            if (isset($request['quantity_in_stock'])) {
                $this->product->setQuantityInStock($request['quantity_in_stock']);
            }

            $this->product->updateProduct($id);

            return json(['message' => 'Product successfully updated!']);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $product = $this->product->getProductById($id);

            if (!$product) {
                return json(['error' => 'Product not found.'], 404);
            }

            $this->product->deleteProduct($id);

            return json(['message' => 'Product successfully deleted!']);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $product = $this->product->getProductById($id);
            return json($product);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function increaseStock($id, $quantity)
    {
        try {
            $success = $this->product->increaseStock($id, $quantity);
            if ($success) {
                return json(['message' => 'Stock increased successfully!']);
            } else {
                return json(['error' => 'Failed to increase stock.'], 500);
            }
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function decreaseStock($id, $quantity)
    {
        try {
            $success = $this->product->decreaseStock($id, $quantity);
            if ($success) {
                return json(['message' => 'Stock decreased successfully!']);
            } else {
                return json(['error' => 'Failed to decrease stock.'], 500);
            }
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }
}