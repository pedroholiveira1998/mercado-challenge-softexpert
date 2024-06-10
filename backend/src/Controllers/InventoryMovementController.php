<?php

namespace App\Controllers;

use App\Models\InventoryMovement;

class InventoryMovementController
{
    protected $inventoryMovement;

    public function __construct(InventoryMovement $inventoryMovement)
    {
        $this->inventoryMovement = $inventoryMovement;
    }

    public function store($request)
    {
        try {
            $this->inventoryMovement->setProductId($request['product_id']);
            $this->inventoryMovement->setChangeQuantity($request['change_quantity']);
            $this->inventoryMovement->setMovementDate($request['movement_date']);
            $this->inventoryMovement->setMovementType($request['movement_type']);
            $this->inventoryMovement->createInventoryMovement();
            return json(['message' => 'Inventory movement created successfully!'], 201);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        try {
            $movements = $this->inventoryMovement->getAllMovements();
            return json($movements);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }


    public function getAllMovementsByProductId($product_id)
    {
        try {
            $movements = $this->inventoryMovement->getAllMovementsByProductId($product_id);
            return json($movements);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {
            $movement = $this->inventoryMovement->getMovementById($id);
            if ($movement) {
                return json($movement);
            } else {
                return json(['error' => 'Inventory movement not found.'], 404);
            }
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id, $request)
    {
        try {
            $movement = $this->inventoryMovement->getMovementById($id);

            if (!$movement) {
                return json(['error' => 'Inventory movement not found.'], 404);
            }

            if (isset($request['product_id'])) {
                $this->inventoryMovement->setProductId($request['product_id']);
            }

            if (isset($request['change_quantity'])) {
                $this->inventoryMovement->setChangeQuantity($request['change_quantity']);
            }

            if (isset($request['movement_date'])) {
                $this->inventoryMovement->setMovementDate($request['movement_date']);
            }

            if (isset($request['movement_type'])) {
                $this->inventoryMovement->setMovementType($request['movement_type']);
            }

            $this->inventoryMovement->updateInventoryMovement($id);
            return json(['message' => 'Inventory movement updated successfully!']);
        } catch (\InvalidArgumentException $e) {
            return json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $movement = $this->inventoryMovement->getMovementById($id);

            if (!$movement) {
                return json(['error' => 'Inventory movement not found.'], 404);
            }

            $this->inventoryMovement->deleteInventoryMovement($id);
            return json(['message' => 'Inventory movement deleted successfully!']);
        } catch (\RuntimeException $e) {
            return json(['error' => $e->getMessage()], 500);
        }
    }
}
