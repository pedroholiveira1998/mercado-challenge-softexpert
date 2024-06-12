<?php

use App\Controllers\InventoryMovementController;
use App\Models\InventoryMovement;

$router->post('/api/inventory-movement/store', function () {
    $inventoryMovementController = new InventoryMovementController(new InventoryMovement());
    $requestData = json_decode(file_get_contents('php://input'), true);
    return $inventoryMovementController->store($requestData);
});

$router->get('/api/inventory-movement', function () {
    $inventoryMovementController = new InventoryMovementController(new InventoryMovement());
    return $inventoryMovementController->getAll();
});

$router->get('/api/inventory-movement/{id}', function ($id) {
    $inventoryMovementController = new InventoryMovementController(new InventoryMovement());
    return $inventoryMovementController->getById($id);
});

$router->put('/api/inventory-movement/update/{id}', function ($id) {
    $inventoryMovementController = new InventoryMovementController(new InventoryMovement());
    $requestData = json_decode(file_get_contents('php://input'), true);
    return $inventoryMovementController->update($id, $requestData);
});

$router->delete('/api/inventory-movement/delete/{id}', function ($id) {
    $inventoryMovementController = new InventoryMovementController(new InventoryMovement());
    return $inventoryMovementController->delete($id);
});