<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;


class ClientController extends Controller
{
	public function addClientForm()
	{
        return $this->render('diet/NewClient.html.twig');		
	}


	public function addClient(Request $request)
	{
        $entityManager = $this->getDoctrine()->getManager();
		$date = $request->get('date');
		$name = $request->get('name');
		$surname = $request->get('surname');
		$sexe = $request->get('sexe');

		$client = new client;

		$client->setName($name);
		$client->setSurname($surname);
		$client->setBirth(new \dateTime($date));
		$client->setGender($sexe);
		$client->setActive(1);

        // on sauvegarde en db
        $entityManager->persist($client);
        $entityManager->flush();

        return $this->render('diet/NewClient.html.twig', array(
        		"add" => 1,
        	));	        
	}

}