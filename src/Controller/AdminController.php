<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Classes\Graph;


class AdminController extends AbstractController
{
 /**
  * Require ROLE_ADMIN for only this controller method.
  *
  * @IsGranted("ROLE_ADMIN")
  */
	public function getIndex()
	{
	   	// role admin
	   	$this->denyAccessUnlessGranted('ROLE_ADMIN');

      return $this->render('diet/admin.html.twig', array(
          'user' => $this->getUser(),
        ));		
	}


  public function getView()
  {
      $chart = new Graph;
      $tab = $chart->getGraphView();

      return $this->render('diet/view.html.twig', array(
          'user' => $this->getUser(),
          "tab" => $tab
        ));     
  }
}