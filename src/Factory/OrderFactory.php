<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;

class OrderFactory
{
    public function create(User $user): Order
    {
        $order = new Order();
        $order->setStatus(Order::STATUS_IN_CART);
        $order->setUser($user);

        return $order;
    }

    public function createItem(User $user, Product $product): OrderItem
    {
        $cart = new OrderItem();
        $cart->setUser($user);
        $cart->setProduct($product);
        $cart->setQuantity(1);

        return $cart;
    }
}