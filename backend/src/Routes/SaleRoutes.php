<?php

use App\Controllers\SaleController;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;

$router->post('/api/sale/store', function () {
    $saleController = new SaleController(new Sale(), new SaleItem(), new Product());
    $requestData = json_decode(file_get_contents('php://input'), true);
    $saleController->store($requestData);
});

$router->get('/api/sale', function () {
    $saleController = new SaleController(new Sale(), new SaleItem(), new Product());
    $saleController->getAll();
});

$router->get('/api/sale/{id}', function ($id) {
    $saleController = new SaleController(new Sale(), new SaleItem(), new Product());
    $saleController->getById($id);
});

$router->put('/api/sale/update/{id}', function ($id) {
    $saleController = new SaleController(new Sale(), new SaleItem(), new Product());
    $requestData = json_decode(file_get_contents('php://input'), true);
    $saleController->update($id, $requestData);
});

$router->delete('/api/sale/delete/{id}', function ($id) {
    $saleController = new SaleController(new Sale(), new SaleItem(), new Product());
    $saleController->delete($id);
});
