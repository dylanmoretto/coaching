<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\View;
use Symfony\Component\Translation\TranslatorInterface;

use Symfony\Component\Translation\Loader\ArrayLoader;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="front")
     */
    public function index(Request $request, TranslatorInterface $translator)
    {
    	$ip = $_SERVER['REMOTE_ADDR'];
    	$url =$request->getPathInfo();
		
		$this->saveView($ip,$url);

        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


    public function getContactForm(Request $request)
    {

        return $this->render('front/contact.html.twig');			
    }


    public function getContactPost(Request $request, \Swift_Mailer $mailer)
    {
    	$email = $request->get('email');
    	$phone = $request->get('phone');
    	$name = $request->get('name');
    	$contenu = $request->get('message');

	    $message = (new \Swift_Message('Hello Email'))
	        ->setFrom($email)
	        ->setTo('d.moretto@maxibazar.fr')
	        ->setBody(
	        	$name . "\n" .
	        	$phone . "\n" .
	        	$contenu
	        );

	    if (1 == $mailer->send($message)){
       		 return $this->render('front/contact.html.twig',array(
       		 	"sendEmail" => 1
       		 ));
	    }			
    }


    public function saveView($ip,$url)
    {
        $entityManager = $this->getDoctrine()->getManager();
    	$view = new View;

    	$view->setIp($ip);
    	$view->setUrl($url);
        $view->setDateTime(new \dateTime());

        // on sauvegarde en db
        $entityManager->persist($view);
        $entityManager->flush();

    }
}