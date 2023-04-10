<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly PaginatorInterface $paginator
    ) {
        parent::__construct($registry, Order::class);
    }

    public function findOrderByUser(User $user, int $page, int $size): PaginationInterface
    {
        $qb = $this->createQueryBuilder('o')
            ->andWhere('o.user = :user AND o.status = :status')
            ->setParameter('user', $user)
            ->setParameter('status', Order::STATUS_COMPLETED)
            ->getQuery()
            ->getResult();

        return $this->paginator->paginate($qb, $page, $size);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOrderInCart(User $user): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.user = :user AND o.status = :status')
            ->setParameter('user', $user)
            ->setParameter('status', Order::STATUS_IN_CART)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function add(Order $order, bool $flush = false): void
    {
        $this->getEntityManager()->persist($order);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $order, bool $flush = false): void
    {
        $this->getEntityManager()->remove($order);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
