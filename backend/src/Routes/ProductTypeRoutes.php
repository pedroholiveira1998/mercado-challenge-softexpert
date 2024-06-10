<?php

use App\Controllers\ProductTypeController;
use App\Models\ProductType;

$router->post('/api/productType/store', function () {
    $productTypeController = new ProductTypeController(new ProductType());
    $requestData = json_decode(file_get_contents('php://input'), true);
    $productTypeController->store($requestData);
});

$router->get('/api/productType', function () {
    $productTypeController = new ProductTypeController(new ProductType());
    $productTypeController->getAll();
});

$router->get('/api/productType/{id}', function ($id) {
    $productTypeController = new ProductTypeController(new ProductType());
    $productTypeController->getById($id);
});

$router->put('/api/productType/update/{id}', function ($id) {
    $productTypeController = new ProductTypeController(new ProductType());
    $requestData = json_decode(file_get_contents('php://input'), true);
    $productTypeController->update($id, $requestData);
});

$router->delete('/api/productType/delete/{id}', function ($id) {
    $productTypeController = new ProductTypeController(new ProductType());
    $productTypeController->delete($id);
});


