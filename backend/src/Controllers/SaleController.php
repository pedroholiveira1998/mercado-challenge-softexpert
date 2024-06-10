<?php

namespace App\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Database;

class SaleController
{
    protected $sale;
    protected $saleItem;
    protected $product;

    public function __construct(Sale $sale, SaleItem $saleItem, Product $product)
    {
        $this->sale = $sale;
        $this->saleItem = $saleItem;
        $this->product = $product;
    }
    public function store($request)
    {
        $db = Database::getInstance()->getConnection();

        try {
            $db->beginTransaction();

            $this->sale->setSaleDate($request['sale_date']);
            $this->sale->setTotalAmount($request['total_amount']);
            $this->sale->setTotalTax($request['total_tax']);
            $saleId = $this->sale->createSale();

            $saleId = $db->lastInsertId();

            foreach ($request['items'] as $item) {

                $product = $this->product->getProductById($item['product_id']);

                if(!$product) {
                    throw new \RuntimeException('Product does not exists');
                }
                if ($product['quantity_in_stock'] < $item['quantity']) {
                    throw new \RuntimeException('Insufficient stock for product ID: ' . $item['product_id']);
                }

                $this->saleItem->setSaleId($saleId);
                $this->saleItem->setProductId($item['product_id']);
                $this->saleItem->setQuantity($item['quantity']);
                $this->saleItem->setUnitPrice($item['unit_price']);
                $this->saleItem->setTaxAmount($item['tax_amount']);
                
                $this->saleItem->createSaleItem();

            }

            $db->commit();

            $newSale = $this->sale->getSaleById($saleId);

            return json([
                'message' => 'Sale created successfully!',
                'sale' => $newSale
            ], 201);

        } catch (\Exception $e) {
            $db->rollBack();
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $sales = $this->sale->getAllSales();
            return json($sales);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $sale = $this->sale->getSaleById($id);
            if ($sale) {
                return json($sale);
            } else {
                return json(['error' => 'Sale not found.'], 404);
            }
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id, $request)
    {
        try {
            $sale = $this->sale->getSaleById($id);

            if (!$sale) {
                return json(['error' => 'Sale not found.'], 404);
            }

            if (isset($request['sale_date'])) {
                $this->sale->setSaleDate($request['sale_date']);
            }

            if (isset($request['total_amount'])) {
                $this->sale->setTotalAmount($request['total_amount']);
            }

            if (isset($request['total_tax'])) {
                $this->sale->setTotalTax($request['total_tax']);
            }

            $this->sale->updateSale($id);

            return json(['message' => 'Sale updated successfully!']);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $sale = $this->sale->getSaleById($id);

            if (!$sale) {
                return json(['error' => 'Sale not found.'], 404);
            }

            $this->sale->deleteSale($id);

            return json(['message' => 'Sale deleted successfully!']);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }
}
