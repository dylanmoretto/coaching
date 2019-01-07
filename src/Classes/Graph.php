<?php

namespace App\Classes;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ComboChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\VAxis;
use App\Entity\View;


class Graph
{
    const ANIMATION_STARTUP = true;
    const ANIMATION_DURATION = 1000;
    const CHART_AREA_HEIGHT = '80%';
    const CHART_AREA_WIDTH = '80%';


	public function getGraphView()
	{
		$chart = new ComboChart();

    	$repository = $this->getDoctrine()->getRepository(View::class);
    	$clients = $repository->findAll();

		// entete
		$arrayToDataTable[] = ['', 'Montant', ['role' => 'tooltip'], 'Evolution', ['role' => 'tooltip']]; 

		//data
		$arrayToDataTable[] = ["2017", 1000, "15€", 0, "evolution"];
		$arrayToDataTable[] = ["2017", 1000, "15€", 0, "evolution"];
		$arrayToDataTable[] = ["2015", 2000, "15€", 0, "evolution"];

		$chart->getData()->setArrayToDataTable($arrayToDataTable);
	/* inutile ?
		$chart->getOptions()->getAnimation()->setStartup(self::ANIMATION_STARTUP);
		$chart->getOptions()->getAnimation()->setDuration(self::ANIMATION_DURATION);
		$chart->getOptions()->getChartArea()->setHeight(self::CHART_AREA_HEIGHT);
		$chart->getOptions()->getChartArea()->setWidth(self::CHART_AREA_WIDTH);
	*/
		$vAxisAmount = new VAxis();
		$vAxisAmount->setTitle('Montant en €');
		$vAxisEvol = new VAxis();
		$vAxisEvol->setTitle('Evolution en %');
		$chart->getOptions()->setVAxes([$vAxisAmount, $vAxisEvol]);

		$seriesAmount = new \CMEN\GoogleChartsBundle\GoogleCharts\Options\ComboChart\Series();
		$seriesAmount->setType('bars');
		$seriesAmount->setTargetAxisIndex(0);
		$seriesEvol = new \CMEN\GoogleChartsBundle\GoogleCharts\Options\ComboChart\Series();
		$seriesEvol->setType('line');
		$seriesEvol->setTargetAxisIndex(1);
		$chart->getOptions()->setSeries([$seriesAmount, $seriesEvol]);

		$chart->getOptions()->setColors(['#f6dc12', '#759e1a']);	

		return $chart;		
	}
}