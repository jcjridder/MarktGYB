<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Product;
use App\Entity\Orders;
use Psr\Log\LoggerInterface;


class OnlineController extends AbstractController
{
    /**
     * @Route("/beheer", name="beheer")
     */
    public function index( Security $security )
    {
        if( $security->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $this->render('beheer/hoofd.html.twig', [
                'controller_name' => 'OnlineController',
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
    }


    /**
     * @Route("/orders", name="orders")
     */
    public function orders(Security $security)
    {
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('beheer/orders.html.twig', [
                'controller_name' => 'OnlineController',
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }



    /**
     * @Route("/getallproducts", name="get_beheer")
     */
    public function getAllProducts()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        $data = "";
        
        $data .= "<table id=\"productsTable\" style=\"width: 100%; text-align: left !important;\">";
        $data .= "<thead>";
        $data .= "<tr>";
        $data .= "<th class='text-align: left;'> </th>";
        $data .= "<th class='text-align: left;'>Voorraad</th>";
        $data .= "<th class='text-align: left;'>EAN</th>";
        $data .= "<th class='text-align: left;'>Artikelenummer</th>";
        $data .= "<th class='text-align: left;'>Naam</th>";
        $data .= "<th class='text-align: left;'>Kleur</th>";
        $data .= "<th class='text-align: left;'>Prijs</th>";
        $data .= "<th class='text-align: left;'>Inkoopprijs</th>";
        $data .= "</tr>";
        $data .= "</thead>";
        
        $data .= "<tbody>";
        for ($i=0; $i < count($products); $i++) {
            $data .= "<tr onclick=\"GetProduct('".$products[$i]->getEan()."')\" data-ean=".$products[$i]->getEan().">";
            if(trim($products[$i]->getPicture()) != ""){
                $data .= "<td><img style=\"width: 100px; height: auto;\" src='/general/".$products[$i]->getPicture()."'></td>";    
            }else{
                $data .= "<td> </td>";
            }
            $data .= "<td>".$products[$i]->getStock()."</td>";
            $data .= "<td>".$products[$i]->getEan()."</td>";
            $data .= "<td>".$products[$i]->getArtnr()."</td>";
            $data .= "<td>".$products[$i]->getName()."</td>";
            $data .= "<td>".$products[$i]->getColor()."</td>";
            $priceCents = substr($products[$i]->getPrice(), -2);
            $priceRest = substr($products[$i]->getPrice(),0, -2);
            $priceFinal = $priceRest . "," . $priceCents;
            $data .= "<td>&euro; ".$priceFinal."</td>";
            if($products[$i]->getBuyprice() == 0 || $products[$i]->getBuyprice() == "0"){

                $data .= "<td>&euro; 0,00</td>";
            }else{
                $priceBuyinCents = substr($products[$i]->getBuyprice(), -2);
                $priceBuyinRest = substr($products[$i]->getBuyprice(),0, -2);
                $priceBuyinFinal = $priceBuyinRest . "," . $priceBuyinCents;
                $data .= "<td>&euro; ".$priceBuyinFinal."</td>";
            }
            $data .= "</tr>";
        }
        $data .= "</tbody>";
        $data .= "</table>";

        return new Response($data);
    }

    /**
     * @Route("/searchproducts/{search}", name="get_beheer")
     */
    public function searchProduct($search, LoggerInterface $logger)
    {

        $searchData = json_decode($search,true);

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->createQueryBuilder('Product')
        ->andWhere('Product.name LIKE :searchTerm OR Product.ean LIKE :searchTerm OR Product.color LIKE :searchTerm OR Product.artnr LIKE :searchTerm')
        ->setParameter('searchTerm', '%'.$searchData["search"].'%')
        ->getQuery()->execute();
        
        $data = "";
        $data .= "<table id=\"productsTable\" style=\"width: 100%; text-align: left !important;\">";
        $data .= "<thead>";
        $data .= "<tr>";
        $data .= "<th class='text-align: left;'> </th>";
        $data .= "<th class='text-align: left;'>Voorraad</th>";
        $data .= "<th class='text-align: left;'>EAN</th>";
        $data .= "<th class='text-align: left;'>Artikelenummer</th>";
        $data .= "<th class='text-align: left;'>Naam</th>";
        $data .= "<th class='text-align: left;'>Kleur</th>";
        $data .= "<th class='text-align: left;'>Prijs</th>";
        $data .= "<th class='text-align: left;'>Inkoopprijs</th>";
        $data .= "</tr>";
        $data .= "</thead>";
        
        $data .= "<tbody>";
        for ($i=0; $i < count($products); $i++) {
            $data .= "<tr onclick=\"GetProduct('".$products[$i]->getEan()."')\" data-ean=".$products[$i]->getEan().">";
            if(trim($products[$i]->getPicture()) != ""){
                $data .= "<td><img style=\"width: 100px; height: auto;\" src='/general/".$products[$i]->getPicture()."'></td>";    
            }else{
                $data .= "<td> </td>";
            }
            $data .= "<td>".$products[$i]->getStock()."</td>";
            $data .= "<td>".$products[$i]->getEan()."</td>";
            $data .= "<td>".$products[$i]->getArtnr()."</td>";
            $data .= "<td>".$products[$i]->getName()."</td>";
            $data .= "<td>".$products[$i]->getColor()."</td>";
            $priceCents = substr($products[$i]->getPrice(), -2);
            $priceRest = substr($products[$i]->getPrice(),0, -2);
            $priceFinal = $priceRest . "," . $priceCents;
            $data .= "<td>&euro; ".$priceFinal."</td>";
            if($products[$i]->getBuyprice() == 0 || $products[$i]->getBuyprice() == "0"){

                $data .= "<td>&euro; 0,00</td>";
            }else{
                $priceBuyinCents = substr($products[$i]->getBuyprice(), -2);
                $priceBuyinRest = substr($products[$i]->getBuyprice(),0, -2);
                $priceBuyinFinal = $priceBuyinRest . "," . $priceBuyinCents;
                $data .= "<td>&euro; ".$priceBuyinFinal."</td>";
            }
            $data .= "</tr>";
        }
        $data .= "</tbody>";
        $data .= "</table>";

        return new Response($data);
    }


    /**
     * @Route("/getorders", name="get_orders")
     */
    public function getOrders(LoggerInterface $logger)
    {

        $repository = $this->getDoctrine()->getRepository(Orders::class);
        $Orders = $repository->findAll();


        $data = "";
        $data .= "<table id=\"ordersTable\" style=\"width: 100%; text-align: left !important;\">";
        $data .= "<thead>";
        $data .= "<tr>";
        $data .= "<th class='text-align: left;'>EAN</th>";
        $data .= "<th class='text-align: left;'>Verkoopprijs</th>";
        $data .= "<th class='text-align: left;'>Inkoopprijs</th>";
        $data .= "<th class='text-align: left;'>Winst</th>";
        $data .= "<th class='text-align: left;'>Aantal</th>";
        $data .= "<th class='text-align: left;'>Cash/Pin</th>";
        $data .= "<th class='text-align: left;'>Tijd</th>";
        $data .= "</tr>";
        $data .= "</thead>";

        $data .= "<tbody>";
        for ($i = 0; $i < count($Orders); $i++) {
            $data .= "<td>" . $Orders[$i]->getEan() . "</td>";

            $priceFinal = $Orders[$i]->getPrice() / 100;
            $data .= "<td>&euro; " .  number_format($priceFinal, 2, ',', '.') . "</td>";
            if ($Orders[$i]->getBuyin() == 0 || $Orders[$i]->getBuyin() == "0") {
                $data .= "<td>&euro; 0,00</td>";
            } else {
                $priceBuyinFinal = $Orders[$i]->getBuyin() / 100;
                $data .= "<td>&euro; " .  number_format($priceBuyinFinal, 2, ',', '.') . "</td>";
            }
            if ($Orders[$i]->getBuyin() == 0 || $Orders[$i]->getBuyin() == "0") {
                $price = $priceFinal / 1.21;
                $data .= "<td>&euro; " .  number_format($price, 2, ',', '.') . "</td>";
            }else{

                $priceFinalTotal = ($priceFinal / 1.21) - $priceBuyinFinal;
                $data .= "<td>&euro; " . number_format($priceFinalTotal, 2, ',', '.'). "</td>";
            }
            $data .= "<td>" . $Orders[$i]->getAmount() . "</td>";
            $data .= "<td>" . $Orders[$i]->getMethod() . "</td>";
            $data .= "<td>" . $Orders[$i]->getTime() . "</td>";
            $data .= "</tr>";
        }
        $data .= "</tbody>";
        $data .= "</table>";

        return new Response($data);
    }



}
