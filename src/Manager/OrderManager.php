<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use App\Factory\OrderFactory;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * OrderManager классический паттерн фасад. Предаставляет нам удобный АПИ для работы с объектами.
 */
class OrderManager
{
    public function __construct(
        private readonly OrderFactory $orderFactory,
        private readonly OrderRepository $orderRepository,
        private readonly OrderItemRepository $orderItemRepository,
        private readonly Security $security,
    ) {
    }

    public function getCurrentOrder(): ?Order
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if (null === $user) {
            return null;
        }

        $order = $this->orderRepository->findOrderInCart($user);

        if (!$order) {
            $order = $this->orderFactory->create($user);
        }

        return $order;
    }

    public function createOrderItem(Product $product): OrderItem
    {
        /** @var User $user */
        $user = $this->security->getUser();

        return $this->orderFactory->createItem($user, $product);
    }

    public function inCart(): array
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if (null === $user) {
            return [];
        }

        return $this->orderItemRepository->inCart($user);
    }

    public function save(Order $order): void
    {
        $this->orderRepository->add($order, true);
    }
}
