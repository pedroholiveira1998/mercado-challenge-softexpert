<?php

use App\Controllers\ProductController;
use App\Models\Product;

$router->post('/api/product/store', function () {
	$productController = new ProductController(new Product());
    $requestData = json_decode(file_get_contents('php://input'), true);
    $productController->store($requestData);
});

$router->get('/api/product', function () {
    $productController = new ProductController(new Product());
    $productController->getAll();
});

$router->get('/api/product/{id}', function ($id) {
    $productController = new ProductController(new Product());
    return $productController->getById($id);
});


$router->put('/api/product/update/{id}', function ($id) {
    $productController = new ProductController(new Product());
    $requestData = json_decode(file_get_contents('php://input'), true);
    $productController->update($id, $requestData);
});

$router->delete('/api/product/delete/{id}', function ($id) {
    $productController = new ProductController(new Product());
    return $productController->delete($id);
});

$router->put('/api/product/{id}/increase-stock/{quantity}', function ($id, $quantity) {
    $productController = new ProductController(new Product());
    return $productController->increaseStock($id, $quantity);
});

$router->put('/api/product/{id}/decrease-stock/{quantity}', function ($id, $quantity) {
    $productController = new ProductController(new Product());
    return $productController->decreaseStock($id, $quantity);
});