<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;

class MainController extends Controller
{
    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
    	//get product
    	$repository = $this->getDoctrine()->getRepository(Product::class);
    	$product = $repository->findAll();

    	//serialize
    	$data = $this->get('jms_serializer')->serialize($product, 'json');

    	//return json response
    	$response = new Response($data);
    	$response->headers->set('Content-Type', 'application/json');

    	return $response;
    }
}
