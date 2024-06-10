<?php

namespace App\Controllers;

use App\Models\ProductType;

class ProductTypeController
{
    protected $productType;

    public function __construct(ProductType $productType)
    {
        $this->productType = $productType;
    }

    public function getAll()
    {
        try {
            $types = $this->productType->getAllProductTypes();
            return json($types);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $type = $this->productType->getProductTypeById($id);
            if ($type) {
                return json($type);
            } else {
                return json(['error' => 'Product type not found'], 404);
            }
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function store($request)
    {
        if (empty($request['name'])) {
            return json(['error' => "The name is required"], 400);
        }

        if (!isset($request['tax_rate']) || !is_numeric($request['tax_rate']) || $request['tax_rate'] < 0) {
            return json(['error' => "The tax rate is required"], 400);
        }

        try {
            $this->productType->setName($request['name']);
            $this->productType->setTaxRate($request['tax_rate']);
            $productType = $this->productType->createProductType();
            return json([$productType, 'message' => 'Product type successfully created!'], 201);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id, $request)
    {
        if (empty($request['name'])) {
            return json(['error' => "The name is required"], 400);
        }

        if (!isset($request['tax_rate']) || !is_numeric($request['tax_rate']) || $request['tax_rate'] < 0) {
            return json(['error' => "The tax rate is required"], 400);
        }

        try {
            $this->productType->setName($request['name']);
            $this->productType->setTaxRate($request['tax_rate']);
            $this->productType->updateProductType($id);
            return json(['message' => 'Product type successfully updated!']);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $this->productType->deleteProductType($id);
            return json(['message' => 'Product type successfully deleted!']);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }
}
