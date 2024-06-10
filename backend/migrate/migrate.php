<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/dotenv.php';

$config = include(__DIR__ . '/../config/database.php');

try {
    $pdo = new PDO(
        "pgsql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_user'],
        $config['db_password']
    );

    // Create product_types table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS product_type (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            tax_rate DECIMAL(5, 2) NOT NULL
        );
    ");

    // Create product table with quantity_in_stock column
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS product (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            quantity_in_stock INT NOT NULL DEFAULT 0,
            type_id INT NOT NULL,
            CONSTRAINT fk_product_type
                FOREIGN KEY(type_id) 
                REFERENCES product_type(id)
                ON DELETE CASCADE
        );
    ");

    // Create sale table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS sale (
            id SERIAL PRIMARY KEY,
            sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            total_amount DECIMAL(10, 2) NOT NULL,
            total_tax DECIMAL(10, 2) NOT NULL
        );
    ");

    // Create sale_item table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS sale_item (
            id SERIAL PRIMARY KEY,
            sale_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            unit_price DECIMAL(10, 2) NOT NULL,
            tax_amount DECIMAL(10, 2) NOT NULL,
            CONSTRAINT fk_sale
                FOREIGN KEY(sale_id) 
                REFERENCES sale(id)
                ON DELETE CASCADE,
            CONSTRAINT fk_product
                FOREIGN KEY(product_id) 
                REFERENCES product(id)
                ON DELETE CASCADE
        );
    ");

    // Create inventory_movement table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS inventory_movement (
            id SERIAL PRIMARY KEY,
            product_id INT NOT NULL,
            movement_type VARCHAR(10) NOT NULL CHECK (movement_type IN ('IN', 'OUT')),
            quantity INT NOT NULL,
            movement_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            description VARCHAR(255),
            CONSTRAINT fk_product_inventory_movement
                FOREIGN KEY(product_id) 
                REFERENCES product(id)
                ON DELETE CASCADE
        );
    ");

    echo "Successful migration!\n";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage() . "\n";
}