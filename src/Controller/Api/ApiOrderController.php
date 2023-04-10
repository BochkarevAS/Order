<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Manager\OrderManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiOrderController extends AbstractFOSRestController
{
    public function __construct(
        private readonly OrderManager $orderManager
    ) {
    }

    #[Route('/order/{id}/add', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Добавление в карзину'
    )]
    public function add(Product $product): View
    {
        $item = $this->orderManager->createOrderItem($product);

        $order = $this->orderManager->getCurrentOrder();
        $order->addItem($item);

        $this->orderManager->save($order);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/order/{id}/remove', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Удаление из карзины'
    )]
    public function remove(Product $product): View
    {
        $order = $this->orderManager->getCurrentOrder();

        /** @var OrderItem $item */
        foreach ($order->getItems() as $item) {
            if ($item->getProduct()->getId() === $product->getId()) {
                $order->removeItem($item);
            }
        }

        $this->orderManager->save($order);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
