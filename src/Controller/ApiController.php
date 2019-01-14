<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\View;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Translation\Loader\ArrayLoader;
use App\Entity\Food;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;


class ApiController extends AbstractController
{

	public $serializer;


	public function __construct()
	{		
		$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new ObjectNormalizer());
		$this->serializer = new Serializer($normalizers, $encoders);
	}


	public function getProduct()
	{

		$repository = $this->getDoctrine()->getRepository(Food::class);        
		$product = $repository->findAll();	

		$jsonContent = $this->serializer->serialize($product, 'json');


		dump($jsonContent);
		$person = $this->serializer->deserialize($jsonContent, Food::class, 'json');
		dump($person);die;
		return new response($jsonContent);
	}


}