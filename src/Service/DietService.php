<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Client;
use App\Entity\Food;
use App\Entity\DietItem;
use GS\OrderBundle\Entity\Customer;
use Doctrine\ORM\EntityManager; 


class DietService  extends Controller
{  

	public function getDietItemSum()
	{ 
    	$repository = $this->getDoctrine()->getRepository(Client::class);
        $conn = $this->getDoctrine()->getConnection();die;
        $sql = 'select
                  sum(qte) as qte,
                  sum(protein) as protein,
                  sum(carb) as carb,
                  sum(fat) as fat,
                  sum(kcal) as kcal
                from diet_item where id_diet =1';
        $stmt = $conn->prepare($sql); 
        $stmt->execute();

        return $stmt->fetchAll();
	}
}