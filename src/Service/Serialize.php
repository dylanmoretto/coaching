<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Article;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Serialize   extends Controller
{
	public static function SeraliseData($data)
	{
		$dataSerialized = $this->get('jms_serializer')->serialize($data, 'json');

    	$response = new Response($dataSerialized);
    	$response->headers->set('Content-Type', 'application/json');

    	return $response;
	}
}