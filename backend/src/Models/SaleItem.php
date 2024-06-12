<?php

namespace App\Models;

use App\Database;
use PDO;

class SaleItem
{
    protected $sale_id;
    protected $product_id;
    protected $quantity;
    protected $unit_price;
    protected $tax_amount;

    public function setSaleId($sale_id)
    {
        if (is_numeric($sale_id) && $sale_id > 0) {
            $this->sale_id = $sale_id;
        } else {
            throw new \InvalidArgumentException('The sale ID must be a positive number.');
        }
    }

    public function getSaleId()
    {
        return $this->sale_id;
    }

    public function setProductId($product_id)
    {
        if (is_numeric($product_id) && $product_id > 0) {
            $this->product_id = $product_id;
        } else {
            throw new \InvalidArgumentException('The product ID must be a positive number.');
        }
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function setQuantity($quantity)
    {
        if (is_numeric($quantity) && $quantity > 0) {
            $this->quantity = $quantity;
        } else {
            throw new \InvalidArgumentException('The quantity must be a positive number.');
        }
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setUnitPrice($unit_price)
    {
        if (is_numeric($unit_price) && $unit_price >= 0) {
            $this->unit_price = $unit_price;
        } else {
            throw new \InvalidArgumentException('The unit price must be a non-negative number.');
        }
    }

    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    public function setTaxAmount($tax_amount)
    {
        if (is_numeric($tax_amount) && $tax_amount >= 0) {
            $this->tax_amount = $tax_amount;
        } else {
            throw new \InvalidArgumentException('The tax amount must be a non-negative number.');
        }
    }

    public function getTaxAmount()
    {
        return $this->tax_amount;
    }

    public function createSaleItem()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                INSERT INTO sale_item (sale_id, product_id, quantity, unit_price, tax_amount) 
                VALUES (?, ?, ?, ?, ?)
            ");
            return $stmt->execute([$this->sale_id, $this->product_id, $this->quantity, $this->unit_price, $this->tax_amount]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error creating sale item: ' . $e->getMessage());
        }
    }

    public function getAllSaleItemsBySaleId($sale_id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM sale_item WHERE sale_id = ?");
            $stmt->execute([$sale_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching sale items by sale ID: ' . $e->getMessage());
        }
    }

    public function getSaleItemById($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM sale_item WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching sale item by ID: ' . $e->getMessage());
        }
    }

    public function updateSaleItem($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                UPDATE sale_item 
                SET product_id = ?, quantity = ?, unit_price = ?, tax_amount = ?
                WHERE id = ?
            ");
            return $stmt->execute([
                $this->product_id,
                $this->quantity,
                $this->unit_price,
                $this->tax_amount,
                $id
            ]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error updating sale item: ' . $e->getMessage());
        }
    }

    public function deleteSaleItem($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("DELETE FROM sale_item WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error deleting sale item: ' . $e->getMessage());
        }
    }
}
