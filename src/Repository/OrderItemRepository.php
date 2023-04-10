<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }

    public function inCart(User $user): ?array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT product_id
            FROM orders_items oi
            LEFT JOIN orders o ON (o.id=oi.order_id)
            WHERE oi.user_id = :user AND o.status = :status
        ';

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery([
            'user'   => $user->getId(),
            'status' => Order::STATUS_IN_CART,
        ]);

        return $resultSet->fetchFirstColumn();
    }

    public function add(OrderItem $orderItem, bool $flush = false): void
    {
        $this->getEntityManager()->persist($orderItem);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderItem $orderItem, bool $flush = false): void
    {
        $this->getEntityManager()->remove($orderItem);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}