<?php

namespace App\Models;

use App\Database;
use PDO;

class ProductType
{
    protected $name;
    protected $tax_rate;

    public function setName($name)
    {
        if (!empty($name)) {
            $this->name = $name;
        } else {
            throw new \InvalidArgumentException('The product type name cannot be empty.');
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTaxRate($tax_rate)
    {
        if (is_numeric($tax_rate) && $tax_rate >= 0) {
            $this->tax_rate = $tax_rate;
        } else {
            throw new \InvalidArgumentException('The tax rate must be a non-negative number.');
        }
    }

    public function getTaxRate()
    {
        return $this->tax_rate;
    }

    public function createProductType()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO product_type (name, tax_rate) VALUES (?, ?)");
            $stmt->execute([$this->name, $this->tax_rate]);

            $new_product_id = $db->lastInsertId();

            return [
                'id' => $new_product_id,
                'name' => $this->name,
                'tax_rate' => $this->tax_rate,
            ];
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error creating product type: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function getAllProductTypes()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT * FROM product_type ORDER BY id");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching product types: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function updateProductType($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE product_type SET name = ?, tax_rate = ? WHERE id = ?");
            return $stmt->execute([$this->name, $this->tax_rate, $id]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error updating product type: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function deleteProductType($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("DELETE FROM product_type WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error deleting product type: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function getProductTypeById($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM product_type WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching product type by ID: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }
}
