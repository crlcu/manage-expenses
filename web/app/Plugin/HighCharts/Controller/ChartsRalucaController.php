<?php
class ChartsRalucaController extends HighChartsAppController {
    public $components = array('HighCharts.HighCharts');
    public $uses = array('Expenses.Payment', 'Expenses.Receipt');

    public function index() {
        $chartName = 'Raluca Chart';
        $chart = $this->HighCharts->create( $chartName, 'pie' );
		$chart->plotShadow = true;

		$payments = $this->Payment->find('all', array('fields' => array('sum(value) as total', 'ChildCategory.name'), 'group' => 'Payment.category_id'));
		
		$pie_values = array();
		foreach ($payments as $payment){
			$pie_values[] =  array($payment['ChildCategory']['name'], (float)$payment[0]['total']);
		}

        $this->HighCharts->setChartParams( $chartName,
			array(
				'chartBackgroundColorLinearGradient'=> array(0,0,0,300),
                'chartBackgroundColorStops'		=> array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),		
				'renderTo'				=> 'chart',  // div to display chart inside
				'title'					=> __('All Payments Summary'),
				'titleAlign'			=> 'center',
				'titleStyleFont'		=> '18px "Helvetica Neue", Helvetica, Arial, sans-serif',
				'titleStyleColor'		=> '#08C',
				'type'                  =>  'pie',
				'cursor'				=> 'pointer',
			)
		);
        $series = $this->HighCharts->addChartSeries();

        $series->showInLegend = true;
		$series->allowPointSelect = true;
        $series->addName('Value')->addData($pie_values);

        $chart->addSeries($series);

    }
	

}
