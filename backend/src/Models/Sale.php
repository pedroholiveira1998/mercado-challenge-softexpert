<?php

namespace App\Models;

use App\Database;
use PDO;

class Sale
{
    protected $sale_date;
    protected $total_amount;
    protected $total_tax;

    public function setSaleDate($sale_date)
    {
        $this->sale_date = $sale_date;
    }

    public function getSaleDate()
    {
        return $this->sale_date;
    }

    public function setTotalAmount($total_amount)
    {
        if (is_numeric($total_amount) && $total_amount >= 0) {
            $this->total_amount = $total_amount;
        } else {
            throw new \InvalidArgumentException('The total amount must be a non-negative number.');
        }
    }

    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    public function setTotalTax($total_tax)
    {
        if (is_numeric($total_tax) && $total_tax >= 0) {
            $this->total_tax = $total_tax;
        } else {
            throw new \InvalidArgumentException('The total tax must be a non-negative number.');
        }
    }

    public function getTotalTax()
    {
        return $this->total_tax;
    }

    public function createSale()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                INSERT INTO sale (sale_date, total_amount, total_tax) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$this->sale_date, $this->total_amount, $this->total_tax]);

            return $db->lastInsertId();
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error creating sale: ' . $e->getMessage());
        }
    }

    public function getAllSales()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("
                SELECT s.id, s.sale_date, s.total_amount, s.total_tax, 
                       i.product_id, p.name as product_name, p.type_id, pt.id as product_type_id, pt.name as product_type, 
                       i.quantity, i.unit_price, 
                       i.unit_price * i.quantity AS item_total_price,
                       i.tax_amount AS item_tax_amount
                FROM sale s
                LEFT JOIN sale_item i ON s.id = i.sale_id
                LEFT JOIN product p ON i.product_id = p.id
                LEFT JOIN product_type pt ON p.type_id = pt.id
                ORDER BY s.id
            ");
            $sales = [];
            $grandTotal = 0;
            $grandTaxTotal = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $saleId = $row['id'];
                if (!isset($sales[$saleId])) {
                    $sales[$saleId] = [
                        'id' => $saleId,
                        'sale_date' => $row['sale_date'],
                        'total_amount' => $row['total_amount'],
                        'total_tax' => $row['total_tax'],
                        'items' => [],
                    ];
                }
                
                $sales[$saleId]['items'][] = [
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'product_type_id' => $row['product_type_id'],
                    'product_type' => $row['product_type'],
                    'quantity' => $row['quantity'],
                    'unit_price' => $row['unit_price'],
                    'item_total_price' => $row['item_total_price'],
                    'item_tax_amount' => $row['item_tax_amount'],
                ];
                
                $grandTotal += $row['item_total_price'];
                $grandTaxTotal += $row['item_tax_amount'];
            }
            return [
                'sales' => array_values($sales),
                'grand_total' => $grandTotal,
                'grand_tax_total' => $grandTaxTotal,
            ];
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching sales: ' . $e->getMessage());
        }
    }    

    public function getSaleById($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM sale WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching sale by ID: ' . $e->getMessage());
        }
    }

    public function updateSale($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                UPDATE sale 
                SET sale_date = ?, total_amount = ?, total_tax = ? 
                WHERE id = ?
            ");
            return $stmt->execute([
                $this->sale_date,
                $this->total_amount,
                $this->total_tax,
                $id
            ]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error updating sale: ' . $e->getMessage());
        }
    }

    public function deleteSale($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("DELETE FROM sale WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error deleting sale: ' . $e->getMessage());
        }
    }
}
