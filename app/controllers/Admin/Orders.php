<?php

namespace controllers\admin;

use core\Controller;
use models\Dish;
use models\Order;

class Orders
{
    use Controller;

    public function index(): void
    {
        $order = new Order;
        $results['order_list'] = $order->getOrders();
        $this->view('admin/order', $results);
    }

    public function detail(): void
    {
        $order = new Order;
        $results['order_list'] = $order->getOrders();
        $this->view('admin/order.detail');
    }


    public function edit($order_id): void
    {
        $order = new Order;
        $results['order'] = $order->getOrder($order_id);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            show($_POST);
            $order = new Order;
            $order->editOrder($_POST);
            redirect('admin/orders');
        }
        $this->view('admin/order.edit', $results);
    }

    public function payment($order_id): void
    {
        $order = new Order;
        $results['order'] = $order->getOrder($order_id);
        $dish = new Dish();
        $results['dish'] = $dish->getDishById(34);
        $this->view('admin/payment', $results);

    }
}

