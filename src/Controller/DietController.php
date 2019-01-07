<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Client;
use App\Entity\Food;
use App\Entity\DietItem;
use App\Entity\Diet;
use Symfony\Component\HttpFoundation\Session\Session;
use Knp\Bundle\SnappyBundle\KnpSnappyBundle;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;


class DietController extends Controller
{
    public $diet;
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        // on liste les clients pour la selection
    	$repository = $this->getDoctrine()->getRepository(Client::class);
    	$clients = $repository->findAll();

        return $this->render('diet/chooseClient.html.twig', array(
        			'clients' => $clients
        		));
    }


    public function getNewDiet($id)
    {
        // création d'une nouvelle diet
        $entityManager = $this->getDoctrine()->getManager();
        $diet = new Diet;

        // on affecte la date et l'id client
        $diet->setClient($id);
        $diet->setDate(new \dateTime());

        // on sauvegarde en db
        $entityManager->persist($diet);
        $entityManager->flush();

        // on supprime la session pour eviter les conflits (si une diet a été créé auparavent)
        if (isset($_SESSION['diet'])){
            session_destroy();
        }

        // on affecte le numéro de diet qui vient d'etre créé
        $this->diet = $diet->getId();
        return $this->getDiet($diet->getId());
    }


    public function getListDiet($id, $newDiet)
    {         
        $repository = $this->getDoctrine()->getRepository(Diet::class);        
        $dietClient = $repository->findBy(["client" => $id]);
        // si on a choisi d'effectué une nouvelle diet
        if ($newDiet == 'true'){
            return $this->getNewDiet($id);
        } else if (empty($dietClient)){
        // si le client n'a pas de diet !
            return $this->getNewDiet($id);
        } 

        // sinon on retourne un tableau de selection des diets du client
        return $this->render('diet/dietSelect.html.twig',array(
            "dietClient" => $dietClient,
        ));
    }


    public function getDiet($id)
    {
        // on démarre la session
        if(session_id() == '') {
            session_start();
        }
        // on affecte l'id de la diet en session
        $_SESSION['diet'] = $id;

        // a virer ??
        $this->diet = $id;

        return $this->getDietView();
    }


    public function addDiet($idAliment, $quantity, $repas)
    {  
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Food::class);

        // on récupère les info de l'aliment
        $food = $repository->find($idAliment);

        // on récupère l'id de la diet en session
        $diet = $_SESSION['diet'];

        /// si on trouve bien l'aliment
        if ($food != null){
            // les macros sont stocké en G, on multiplie la qte par les macro / par 100
            $protein = $quantity * ($food->getProtein() / 100);
            $carb = $quantity * ($food->getGlucide() / 100);
            $fat = $quantity * ($food->getFat() / 100);
            $kcal = $quantity * ($food->getKcal() / 100);

            // on stock l'aliment dans la table 
            $dietItem = new dietItem;
            $dietItem->setFoodId($idAliment);
            $dietItem->setName($food->getName());
            $dietItem->setQte($quantity);
            $dietItem->setProtein($protein);
            $dietItem->setCarb($carb);
            $dietItem->setFat($fat);
            $dietItem->setKcal($kcal);
            $dietItem->setidDiet($diet);
            $dietItem->setRepas($repas);

            $entityManager->persist($dietItem);
            $entityManager->flush();
        }

        // on retourne la vue
        return $this->getDietView();
    }


    public function getDietSum()
    {
        // on fait un SUM sur les macro
        $conn = $this->getDoctrine()->getConnection();
        $repository = $this->getDoctrine()->getRepository(DietItem::class);
        $sql = 'select
                  sum(qte) as qte,
                  sum(protein) as protein,
                  sum(carb) as carb,
                  sum(fat) as fat,
                  sum(kcal) as kcal
                from diet_item where id_diet =' . $_SESSION['diet'] ;
        $stmt = $conn->prepare($sql); 
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function getRepasSum()
    {     
        // on liste les repas de la diet
        $conn = $this->getDoctrine()->getConnection();
        $repository = $this->getDoctrine()->getRepository(DietItem::class);   
        $sql = 'select
                    repas
                   from diet_item where id_diet =' . $_SESSION['diet'] .'
                   group by repas';
        $stmt = $conn->prepare($sql); 
        $stmt->execute();

        return $stmt->fetchAll();
    }

    
    public function getDietItem()
    {      
        // on list les aliments de la diet
        $repository = $this->getDoctrine()->getRepository(DietItem::class);   

        return $repository->findBy(['idDiet' => $_SESSION['diet']]);
    }   


    public function delDietItem($id)
    {
        // on supprime les aliments de la diet !
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(DietItem::class)->find($id);

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->getDietView();
    } 


    public function delDiet($idDiet, $idClient)
    {
        // on supprime la diet !
        $entityManager = $this->getDoctrine()->getManager();
        $dietClient = $entityManager->getRepository(Diet::class)->find($idDiet);
       
        $entityManager->remove($dietClient);
        $entityManager->flush();

        $dietClient = $entityManager->getRepository(Diet::class)->findBy(["client" => $idClient]);

        return $this->render('diet/dietSelect.html.twig',array(
            "dietClient" => $dietClient,
        ));
    } 


    public function getDietView()
    {
        // on charge les aliment dans la table de droite
        $repository = $this->getDoctrine()->getRepository(Food::class);  
        $food = $repository->findAll();

        // on va chercher les sommes macro / les repas et les aliments de la diet
        $sum = $this->getDietSum();
        $repas = $this->getRepasSum();
        $diet = $this->getDietItem();  

        // on retourne la vue
        return $this->render('diet/diet.html.twig',array(
            "foods" => $food,
            "diet" => $diet,
            "sum" => $sum,
            "repas" => $repas,
        ));
    }
}