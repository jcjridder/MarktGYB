<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Orders;
use App\Entity\Product;
use Psr\Log\LoggerInterface;

class OrderController extends AbstractController
{

    /**
     * @Route("/submitorder/{information}", name="submitorder")
     */
    public function uploadFile($information, LoggerInterface $logger)
    {
        $orderInformation = json_decode($information, true);

        $logger->info(count($orderInformation));
        
        date_default_timezone_set('Europe/Amsterdam');
        $orderMoment = date("Y-m-d H:i:s",time());

        for ($i=0; $i < count($orderInformation); $i++) {
            $InsertOrder = new Orders();
            $entityManager = $this->getDoctrine()->getManager();




            $InsertOrder->setEan($orderInformation[$i]["ean"]);
            $InsertOrder->setPrice($orderInformation[$i]["price"]);
            $InsertOrder->setBuyin($orderInformation[$i]["profit"]);
            $InsertOrder->setAmount($orderInformation[$i]["amount"]);
            $InsertOrder->setMail(" ");
            $InsertOrder->setMethod($orderInformation[$i]["method"]);
            $InsertOrder->setTime($orderMoment);


            $entityManager->persist($InsertOrder);

            $entityManager->flush();


            $repository = $this->getDoctrine()->getRepository(Product::class);

            $product = $repository->findOneBy(['ean' => $orderInformation[$i]["ean"]]);

            $stock = $product->getStock();
            $stock = $stock - $orderInformation[$i]["amount"];

            $product->setStock($stock);


            $entityManager->persist($product);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        
        return new Response('Succes');

    }


    
}
