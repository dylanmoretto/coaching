<?php

namespace App\Classes;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ComboChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\VAxis;
use App\Entity\View;
use Doctrine\ORM\Entity;
use Doctrine\ORM\EntityRepository;
use \Datetime;

class Graph
{
    const ANIMATION_STARTUP = true;
    const ANIMATION_DURATION = 1000;
    const CHART_AREA_HEIGHT = '80%';
    const CHART_AREA_WIDTH = '80%';
    public $repository;
    public $time;


	public function __construct($repository, $em)
	{
		$this->repository = $repository;
		$this->em = $em;
	}


/*
 * Retourne un googleGraph des visites, selon param year/week/month/day
 * month => default
 */
	public function getGraphView()
	{
		$chart = new ComboChart();		

		// switch selon le type d'analyse
		switch ($this->time) {
			// cas analyse jour
			case 'day':				
			    $sql = 'SELECT 
							date(date_time) as date, 
							count(*) as nb
						from `view` 
						group by date(date_time)';
					break;			
			case 'month':
			// cas analyse mois
				$sql = 'SELECT 
							left(date(date_time),7) as date, 
							count(*) as nb
						from `view` 
						group by left(date(date_time),7)';
				break;
			case 'year':
			// cas analyse année
				$sql = 'SELECT 
							left(date(date_time),4) as date, 
							count(*) as nb
						from `view` 
						group by left(date(date_time),4)';
				break;
			case 'week':
			// cas analyse 7 derniers jours
				$date = new dateTime();
				$startDate = $date->format('Y-m-d');
	   		 	$endDate = $date->modify('-1 week');
	   		 	$endDate = $endDate->format('Y-m-d');

				$sql = "SELECT 
							date(date_time) as date, 
							count(*) as nb
						from `view` 
						where date_time BETWEEN '" . $endDate . "' and '" . $startDate . "'
						group by date(date_time)";
				break;
		}


	    $stmt = $this->em->query($sql);
	    $views = $stmt->fetchAll();

		// entete du googleGraph
		$arrayToDataTable[] = ['', 'Montant', ['role' => 'tooltip'], 'Evolution', ['role' => 'tooltip']]; 

		//data du googleGraph
		foreach ($views as $view){
			$arrayToDataTable[] = [$view['date'], intval($view['nb']), intval($view['nb']) ." vues", 0, "evolution"];
		}

		$chart->getData()->setArrayToDataTable($arrayToDataTable);
		$vAxisAmount = new VAxis();
		$vAxisAmount->setTitle('Nombre de vues');
		$chart->getOptions()->setVAxes([$vAxisAmount]);

		$seriesAmount = new \CMEN\GoogleChartsBundle\GoogleCharts\Options\ComboChart\Series();
		$seriesAmount->setType('bars');
		$seriesAmount->setTargetAxisIndex(0);
		$seriesEvol = new \CMEN\GoogleChartsBundle\GoogleCharts\Options\ComboChart\Series();
		$seriesEvol->setType('line');
		$seriesEvol->setTargetAxisIndex(1);
		$chart->getOptions()->setSeries([$seriesAmount, $seriesEvol]);
		$chart->getOptions()->setColors(['black', 'red']);	

		return $chart;		
	}
}