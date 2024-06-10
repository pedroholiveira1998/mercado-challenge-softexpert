<?php

namespace App\Controllers;

use App\Models\SaleItem;

class SaleItemController
{
    protected $saleItem;

    public function __construct(SaleItem $saleItem)
    {
        $this->saleItem = $saleItem;
    }

    public function store($request)
    {
        try {
            $this->saleItem->setSaleId($request['sale_id']);
            $this->saleItem->setProductId($request['product_id']);
            $this->saleItem->setQuantity($request['quantity']);
            $this->saleItem->setUnitPrice($request['unit_price']);
            $this->saleItem->setTaxAmount($request['tax_amount']);
            $this->saleItem->createSaleItem();

            return json(['message' => 'Sale item created successfully!'], 201);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAllBySaleId($sale_id)
    {
        try {
            $saleItems = $this->saleItem->getAllSaleItemsBySaleId($sale_id);
            return json($saleItems);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $saleItem = $this->saleItem->getSaleItemById($id);
            if ($saleItem) {
                return json($saleItem);
            } else {
                return json(['error' => 'Sale item not found.'], 404);
            }
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id, $request)
    {
        try {
            $saleItem = $this->saleItem->getSaleItemById($id);

            if (!$saleItem) {
                return json(['error' => 'Sale item not found.'], 404);
            }

            if (isset($request['product_id'])) {
                $this->saleItem->setProductId($request['product_id']);
            }

            if (isset($request['quantity'])) {
                $this->saleItem->setQuantity($request['quantity']);
            }

            if (isset($request['unit_price'])) {
                $this->saleItem->setUnitPrice($request['unit_price']);
            }

            if (isset($request['tax_amount'])) {
                $this->saleItem->setTaxAmount($request['tax_amount']);
            }

            $this->saleItem->updateSaleItem($id);

            return json(['message' => 'Sale item updated successfully!']);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $saleItem = $this->saleItem->getSaleItemById($id);

            if (!$saleItem) {
                return json(['error' => 'Sale item not found.'], 404);
            }

            $this->saleItem->deleteSaleItem($id);

            return json(['message' => 'Sale item deleted successfully!']);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }
}
