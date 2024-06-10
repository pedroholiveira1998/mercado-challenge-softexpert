<?php

namespace App\Models;

use App\Database;
use PDO;

class InventoryMovement
{
    protected $product_id;
    protected $change_quantity;
    protected $movement_date;
    protected $movement_type;

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

    public function setChangeQuantity($quantity)
    {
        if (is_numeric($quantity) && $quantity != 0) {
            $this->change_quantity = $quantity;
        } else {
            throw new \InvalidArgumentException('The change quantity must be a non-zero number.');
        }
    }

    public function getChangeQuantity()
    {
        return $this->change_quantity;
    }

    public function setMovementDate($movement_date)
    {
        $this->movement_date = $movement_date;
    }

    public function getMovementDate()
    {
        return $this->movement_date;
    }

    public function setMovementType($movement_type)
    {
        if (in_array($movement_type, ['INCREASE', 'DECREASE'])) {
            $this->movement_type = $movement_type;
        } else {
            throw new \InvalidArgumentException('The movement type must be "INCREASE" or "DECREASE".');
        }
    }

    public function getMovementType()
    {
        return $this->movement_type;
    }

    public function createInventoryMovement()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                INSERT INTO inventory_movement (product_id, change_quantity, movement_date, movement_type) 
                VALUES (?, ?, ?, ?)
            ");
            return $stmt->execute([$this->product_id, $this->change_quantity, $this->movement_date, $this->movement_type]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error creating inventory movement: ' . $e->getMessage());
        }
    }

    public function getAllMovements()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT * FROM inventory_movement");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching all inventory movements: ' . $e->getMessage());
        }
    }

    public function getAllMovementsByProductId($product_id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM inventory_movement WHERE product_id = ?");
            $stmt->execute([$product_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching inventory movements by product ID: ' . $e->getMessage());
        }
    }

    public function getMovementById($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM inventory_movement WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching inventory movement by ID: ' . $e->getMessage());
        }
    }

    public function updateInventoryMovement($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                UPDATE inventory_movement
                SET product_id = ?, change_quantity = ?, movement_date = ?, movement_type = ?
                WHERE id = ?
            ");
            return $stmt->execute([
                $this->product_id,
                $this->change_quantity,
                $this->movement_date,
                $this->movement_type,
                $id
            ]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error updating inventory movement: ' . $e->getMessage());
        }
    }

    public function deleteInventoryMovement($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("DELETE FROM inventory_movement WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error deleting inventory movement: ' . $e->getMessage());
        }
    }
}
