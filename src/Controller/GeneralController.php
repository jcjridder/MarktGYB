<?php
// src/Controller/GeneralController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class GeneralController extends AbstractController
{
    /**
     * Matches /general/*
     *
     * @Route("/general/{img}", name="general_show")
     */
    public function show($img)
    {
        $webPath = $_SERVER["DOCUMENT_ROOT"] . '/public/';
        $filepath = $webPath . "/media/" .$img;

      if(file_exists($filepath)){
        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $img);
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/png');
        $response->setContent(file_get_contents($filepath));
        return $response;
      }else{
        return new Response('false');
      }
    }

    /**
     * Matches /js/*
     *
     * @Route("/js/{file}", name="general_js")
     */
    public function show_js($file)
    {
        $webPath = $_SERVER["DOCUMENT_ROOT"] . '/public/';
        $filepath = $webPath . "/js/" .$file;

      if(file_exists($filepath)){
        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $file);
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'text/javascript');
        $response->setContent(file_get_contents($filepath));
        return $response;
      }else{
        return new Response('false');
      }
    }


    /**
     * Matches /css/*
     *
     * @Route("/css/{file}", name="general_css")
     */
    public function show_css($file)
    {
        $webPath = $_SERVER["DOCUMENT_ROOT"] . '/public/';
        $filepath = $webPath . "/css/" .$file;

      if(file_exists($filepath)){
        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $file);
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'text/css');
        $response->setContent(file_get_contents($filepath));
        return $response;
      }else{
        return new Response('false');
      }
    }

    public function index()
    {
        return new Response(
            'index'
        );
    }
}