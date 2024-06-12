<?php

namespace App\Models;

use App\Database;
use PDO;

class Product
{
    protected $name;
    protected $price;
    protected $type_id;
    protected $quantity_in_stock;

    public function setName($name)
    {
        if (!empty($name)) {
            $this->name = $name;
        } else {
            throw new \InvalidArgumentException('The product name cannot be empty.');
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        if (is_numeric($price) && $price >= 0) {
            $this->price = $price;
        } else {
            throw new \InvalidArgumentException('The product price must be a positive number.');
        }
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setTypeId($type_id)
    {
        if (is_numeric($type_id) && $type_id > 0) {
            $this->type_id = $type_id;
        } else {
            throw new \InvalidArgumentException('The product type ID must be a positive number.');
        }
    }

    public function getTypeId()
    {
        return $this->type_id;
    }

    public function setQuantityInStock($quantity)
    {
        if (is_numeric($quantity) && $quantity >= 0) {
            $this->quantity_in_stock = $quantity;
        } else {
            throw new \InvalidArgumentException('The product quantity must be a non-negative number.');
        }
    }

    public function getQuantityInStock()
    {
        return $this->quantity_in_stock;
    }

    public function createProduct()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                INSERT INTO product (name, price, type_id, quantity_in_stock) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$this->name, $this->price, $this->type_id, $this->quantity_in_stock]);

            $new_product_id = $db->lastInsertId();

            return [
                'id' => $new_product_id,
                'name' => $this->name,
                'price' => $this->price,
                'type_id' => $this->type_id,
                'quantity_in_stock' => $this->quantity_in_stock
            ];
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error creating product: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function getAllProducts()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("
                SELECT product.*, product_type.name AS type_name, product_type.tax_rate
                FROM product
                INNER JOIN product_type ON product.type_id = product_type.id
                ORDER BY id
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching products with product types: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function updateProduct($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                UPDATE product
                SET name = ?, price = ?, type_id = ?, quantity_in_stock = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$this->name, $this->price, $this->type_id, $this->quantity_in_stock, $id]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error updating product: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function deleteProduct($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("DELETE FROM product WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error deleting product: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function getProductById($id)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM product WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error fetching product by ID: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function increaseStock($id, $quantity)
    {
        if (!is_numeric($quantity) || $quantity <= 0) {
            throw new \InvalidArgumentException('The quantity to add must be a positive number.');
        }

        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                UPDATE product
                SET quantity_in_stock = quantity_in_stock + ? 
                WHERE id = ?
            ");
            return $stmt->execute([$quantity, $id]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error increasing stock: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }

    public function decreaseStock($id, $quantity)
    {
        if (!is_numeric($quantity) || $quantity <= 0) {
            throw new \InvalidArgumentException('The quantity to subtract must be a positive number.');
        }

        try {
            $db = Database::getInstance()->getConnection();

            $stmt = $db->prepare("SELECT quantity_in_stock FROM product WHERE id = ?");
            $stmt->execute([$id]);
            $currentStock = $stmt->fetchColumn();

            if ($currentStock < $quantity) {
                throw new \RuntimeException('Insufficient stock available.');
            }

            $stmt = $db->prepare("
                UPDATE product
                SET quantity_in_stock = quantity_in_stock - ? 
                WHERE id = ?
            ");
            return $stmt->execute([$quantity, $id]);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error decreasing stock: ' . $e->getMessage());
        } finally {
            $stmt = null;
        }
    }
}
