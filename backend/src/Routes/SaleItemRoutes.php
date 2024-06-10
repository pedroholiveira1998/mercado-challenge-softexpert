<?php

use App\Controllers\SaleItemController;
use App\Models\SaleItem;

$router->post('/api/sale-item/store', function () {
    $saleItemController = new SaleItemController(new SaleItem());
    $requestData = json_decode(file_get_contents('php://input'), true);
    return $saleItemController->store($requestData);
});

$router->get('/api/sale-item/sale/{sale_id}', function ($sale_id) {
    $saleItemController = new SaleItemController(new SaleItem());
    return $saleItemController->getAllBySaleId($sale_id);
});

$router->get('/api/sale-item/{id}', function ($id) {
    $saleItemController = new SaleItemController(new SaleItem());
    return $saleItemController->getById($id);
});

$router->put('/api/sale-item/update/{id}', function ($id) {
    $saleItemController = new SaleItemController(new SaleItem());
    $requestData = json_decode(file_get_contents('php://input'), true);
    return $saleItemController->update($id, $requestData);
});

$router->delete('/api/sale-item/delete/{id}', function ($id) {
    $saleItemController = new SaleItemController(new SaleItem());
    return $saleItemController->delete($id);
});