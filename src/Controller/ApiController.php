<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use App\Security\TokenAuthenticator;
use App\Entity\View;
use App\Entity\ApiUser;
use App\Entity\Food;


class ApiController extends AbstractController
{
	public $serializer;
	public $apiService;
	public $em;
	public $userRepository;
	

	public function __construct()
	{		
		$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new ObjectNormalizer());
		$this->serializer = new Serializer($normalizers, $encoders);		
		$this->apiService = new TokenAuthenticator();  
	}


	public function getProduct(Request $request)
	{				
		// on get le token
		$this->apiService->token = $request->get('token'); 
		// on push le repository
		$this->apiService->repository = $repository = $this->getDoctrine()->getRepository(ApiUser::class);

		// on check si la clé existe
		$checking = $this->apiService->checkToken();
		if ($checking == false){
			return $this->getAccessError();
		}
		// si exist on retourne les produit
		$repository = $this->getDoctrine()->getRepository(Food::class);

		$id = $request->get('id');
		$name = $request->get('name');

		// On veux récup un ID en particulier ou pas
		$product = ($id == null) ? $repository->findAll() : $repository->findById($id);

		if ($name != null){
			$product = $repository->createQueryBuilder('a')
						->where("a.name LIKE :name")						
			           ->setParameter('name', '%' . $name . '%')
			           ->getQuery()
                       ->getResult();
		}
		// si aucun résultat
		$product = (empty($product)) ? 'Aucun resultat' : $product;
		$jsonContent = $this->serializer->serialize($product, 'json');

		return new response($jsonContent);
	}


	public function createToken($token)
	{	
		// on instancie la repository
		$this->apiService->repository = $this->getDoctrine()->getRepository(ApiUser::class);

		//check si clé API admin
		if ($this->apiService->checkIfAdmin($token) == false){
			return $this->getAccessError();
		}

		// on génère un new token
		$newToken = $this->apiService->generateToken(); 

		// on push en DB
		$entityManager = $this->getDoctrine()->getManager();
        $apiUser = new ApiUser;
        $apiUser->setapiToken($newToken);
        $apiUser->setAdmin(0);
        $entityManager->persist($apiUser);
        $entityManager->flush();

        return new response ($newToken . ' généré');
	}


    public function getAccessError()
    {
		$response = $this->serializer->serialize("Access denied !" , 'json');
    	return new Response($response);
    }
}