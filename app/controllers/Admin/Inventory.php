<?php

namespace controllers\admin;

use core\Controller;
use models\InventoryDetail;

class Inventory
{
    use Controller;

    public function index(): void
    {
        $inv = new \models\Inventory();
        $inventory = $inv->getInventory();
        $this->view('admin/inventory', ['inventory' => $inventory, 'controller' => 'inventory']);
    }

    public function info(): void
    {
        $inv2 = new InventoryDetail();
        $inventory2 = $inv2->getInventory();
        $this->view('admin/inventory2', ['inventory2' => $inventory2, 'controller' => 'inventory2']);
    }

    public function updateInventory(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $m = new InventoryDetail();

            $data = json_decode(file_get_contents("php://input"), true);
            for ($i = 0; $i < count($data); $i++) {
                $pid = $data[$i]['pid'];
                $fieldName = $data[$i]['fieldName'];
                $newValue = $data[$i]['newValue'];

                if ($fieldName === 'amount_remaining') {
                    $m->updateInventory($pid, $newValue);
                } else if ($fieldName === 'special_notes') {
                    $m->updateInventory($pid, null, $newValue);
                } else if ($fieldName === 'expiryrisk') {
                    $m->updateInventory($pid, null, null, $newValue);
                }
            }
            echo json_encode(array("status" => "success", "message" => "Data received successfully"));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }

    public function deleteInventory(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = json_decode(file_get_contents("php://input"), true);
            $id = $id['purchaseId'];

            $m = new InventoryDetail();
            $m->deleteInventory($id);

            echo json_encode(array("status" => "success", "message" => "Data received successfully", "id" => $id));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }

    public function updateMain(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $m = new \models\Inventory();

            $data = json_decode(file_get_contents("php://input"), true);
            for ($i = 0; $i < count($data); $i++) {
                $id = $data[$i]['itemid'];
                $fieldName = $data[$i]['fieldName'];
                $newValue = $data[$i]['newValue'];

                if ($fieldName === 'max_stock_level') {
                    $m->updateInventory($id, max: $newValue);
                } else if ($fieldName === 'buffer_stock_level') {
                    $m->updateInventory($id, buffer: $newValue);
                } else if ($fieldName === 'reorder_level') {
                    $m->updateInventory($id, reorder: $newValue);
                } else if ($fieldName === 'lead_time') {
                    $m->updateInventory($id, lead: $newValue);
                }
            }
            echo json_encode(array("status" => "success", "message" => "Data received successfully"));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }
}
