<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;
use Psr\Log\LoggerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/uploadfile/{ean}", name="upload_file")
     */
    public function uploadFile($ean, LoggerInterface $logger)
    {
        $logger->info('uploadFile');

        $webPath = $_SERVER["DOCUMENT_ROOT"] . '/public/';
        
        $logger->info($webPath);
        
        $directories = glob($_SERVER["DOCUMENT_ROOT"] . '/public/*', GLOB_ONLYDIR);
        $baseDirArray = array();
        for($d=0; $d<count($directories); $d++){
            $dirFullName = basename($directories[$d]);
            $baseDirArray[] = $dirFullName;
            $logger->info($dirFullName);
        }
        if (!in_array("media", $baseDirArray)){
            mkdir($webPath . "media");
        }
        $target_dir = $webPath . "/media/" ;
        $logger->info($target_dir);


        $overlayHtml = "";
        
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        
        $logger->info($target_file);
        $uploadOk = 1;
        $error = "";
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $logger->info($fileType);
        // Check if image file is a actual image or fake image
        $logger->info($_FILES["file"]["tmp_name"]);
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".";
        } else {
            echo "Het bestand heeft niet de juiste format.";
        }
        if ($_FILES["file"]["size"] > 20000000) {
            $error = "Sorry, het bestand is te groot.";
        }
          if(strtolower($fileType) != "jpg" && strtolower($fileType) != "gif" && strtolower($fileType) != "png" && strtolower($fileType) != "jpeg" && strtolower($fileType) != "bmp" && strtolower($fileType) != "tif") {
              $error .= "Er mogen alleen bestanden met de extensies: gif, jpg, jpeg of png toegevoegd worden.";
          }
        if($error == ""){
          if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

            return new Response($overlayHtml);
          } else {
            $overlayHtml .= "Oeps, het lijkt er op dat er iets fout is gegaan";
        
            return new Response($overlayHtml);
          }
        }else{
            $overlayHtml = $error;
        
          return new Response($overlayHtml);
        }
        return new Response("?!");

    }


    /**
     * @Route("/updatecreateproduct/{information}", name="create_product")
     */
    public function updateCreateProduct($information): Response
    {

        $productInformation = json_decode($information, true);
        // you can fetch the EntityManager via $this->getDoctrine()
        $repository = $this->getDoctrine()->getRepository(Product::class);

        $product = $repository->findOneBy(['ean' => $productInformation["ean"]]);

        if (!$product) {
            $entityManager = $this->getDoctrine()->getManager();

            $InsertProduct = new Product();
            if($productInformation["name"] == ""){
                $InsertProduct->setName(" ");
            }else{
                $InsertProduct->setName($productInformation["name"]);
            }
            // This will trigger a type mismatch error: an integer is expected
            $InsertProduct->setPrice($productInformation["price"]);
            if($productInformation["description"] == ""){
                $InsertProduct->setDescription(" ");
            }else{
                $InsertProduct->setDescription($productInformation["description"]);
            }
            $InsertProduct->setEan($productInformation["ean"]);
            $InsertProduct->setPicture($productInformation["picture"]);
            $InsertProduct->setColor($productInformation["color"]);
            $InsertProduct->setStock($productInformation["stock"]);
            $InsertProduct->setImagelong(' ');
            $InsertProduct->setBuyprice($productInformation["buyprice"]);
            $InsertProduct->setArtnr($productInformation["artnr"]);
            $InsertProduct->setOrdernr(0);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($InsertProduct);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }else{
            $entityManager = $this->getDoctrine()->getManager();

            if($productInformation["name"] == ""){
                $product->setName(" ");
            }else{
                $product->setName($productInformation["name"]);
            }
            // $product->setName($productInformation["name"]);
            // This will trigger a type mismatch error: an integer is expected
            $product->setPrice($productInformation["price"]);
            if($productInformation["description"] == ""){
                $product->setDescription(" ");
            }else{
                $product->setDescription($productInformation["description"]);
            }
            $product->setEan($productInformation["ean"]);
            if($productInformation["picture"] != ""){
                $product->setPicture($productInformation["picture"]);
            }
            $product->setColor($productInformation["color"]);
            $product->setStock($productInformation["stock"]);
            $product->setImagelong(' ');
            $product->setBuyprice($productInformation["buyprice"]);
            $product->setArtnr($productInformation["artnr"]);
            $product->setOrdernr(0);

            $entityManager->persist($product);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            
        }


        return new Response('Succes');
    }

    /**
     * @Route("/fetchproduct/{information}", name="fetch_product")
     */
    public function fetchProduct($information): Response
    {

        $productInformation = json_decode($information, true);
        // you can fetch the EntityManager via $this->getDoctrine()
        // $product = $this->getDoctrine()->getRepository(Product::class)->find($productInformation["setEan"]);
        $repository = $this->getDoctrine()->getRepository(Product::class);

        $product = $repository->findOneBy(['ean' => $productInformation["setEan"]]);

        if (!$product) {
            $responseJson = array("result" => "new","ean" => $productInformation["setEan"]);
            return new Response(json_encode($responseJson));
        }else{
            $responseJson = array("result" => "existing",
            "ean" => $productInformation["setEan"],
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'picture' => $product->getPicture(),
            'color' => $product->getColor(),
            'stock' => $product->getStock(),
            'description' => $product->getDescription(),
            'buyprice' => $product->getBuyprice(),
            'artnr' => $product->getArtnr()
            );
            return new Response(json_encode($responseJson));
        }


    }

    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
