<?php
// src/Controller/ItemController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends AbstractController
{
    /**
     * Matches /item exactly
     *
     * @Route("/item", name="item_list")
     */
    public function list()
    {
        return new Response(
            'niks'
        );
    }

    /**
     * Matches /item/*
     * but not /item/slug/extra-part
     *
     * @Route("/item/{slug}", name="item_show")
     */
    public function show($slug)
    {
        // $slug will equal the dynamic part of the URL
        // e.g. at /item/yay-routing, then $slug='yay-routing'


        return new Response(
            'current slug' . $slug
        );
        // ...
    }
}