<?php
class ChartsController extends HighChartsAppController {
    public $components = array('HighCharts.HighCharts');
    public $uses = array('Expenses.Payment', 'Expenses.Receivable');
	
    public function index( $model = 'payment' ) {
        $model = ucfirst( $model );
        
        $chartName = 'AreaSpline Chart';
        $chart = $this->HighCharts->create( $chartName, 'areaspline' );
		$data = array(
			'y' => array(),
			'x' => array()
		);
		
		$payments = $this->{$model}->find('all', array('fields' => array('sum(value) as total', 'date'), 'group' => $model.'.date'));
		
		foreach ($payments as $payment){
			$data['y'][] = (float)$payment[0]['total'];
			$data['x'][] = $payment[$model]['date'];	
		}
		
        $this->HighCharts->setChartParams( $chartName,
			array(
				'renderTo'				=> 'chart',  // div to display chart inside
				'title'					=> __('All %s Summary', Inflector::singularize('Receivables')),
				'titleAlign'			=> 'center',
				'titleStyleFont'		=> '18px "Helvetica Neue", Helvetica, Arial, sans-serif',
				'titleStyleColor'		=> '#08C',
				
				'chartMarginTop' 		=> 40,

				'xAxisLabelsEnabled' 	=> TRUE,
				'xAxisLabelsAlign' 		=> 'right',
				'xAxisLabelsStep' 		=> 1,
				'xAxisLabelsRotation' 	=> -20,
				'xAxisCategories'       => $data['x'],

				'yAxisTitleText' 		=> __('Payment value'),

				// autostep options
				'enableAutoStep' 		=> FALSE
			)
		);

        $series = $this->HighCharts->addChartSeries();

        $series->addName('Value')
            ->addData($data['y']);

        $chart->addSeries($series);
    }
	
	public function column() {
        $chartName = 'Column Chart';
        $mychart = $this->HighCharts->create( $chartName, 'column' );
		$data = array(
			'y' => array(),
			'x' => array()
		);
		
		$payments = $this->Payment->find('all', array('fields' => array('sum(value) as total', 'date'), 'group' => 'Payment.date'));
		
		foreach ($payments as $payment){
			$data['y'][] = (float)$payment[0]['total'];
			$data['x'][] = $payment['Payment']['date'];	
		}
		
        $this->HighCharts->setChartParams($chartName,
			array(
				'renderTo'								=> 'chart',  // div to display chart inside
				
				'title'					=> __('Weekly Payments Summary'),
				'titleAlign'			=> 'center',
				'titleStyleFont'		=> '18px "Helvetica Neue", Helvetica, Arial, sans-serif',
				'titleStyleColor'		=> '#08C',
				
				'chartMarginTop' 			=> 40,

				'xAxisLabelsEnabled' 					=> TRUE,
				'xAxisLabelsAlign' 						=> 'right',
				'xAxisLabelsStep' 						=> 1,
				'xAxisLabelsRotation' 					=> -35,
				'xAxisCategories'          				=> $data['x'],

				'yAxisTitleText' 			=> __('Payments value'),

				// autostep options
				'enableAutoStep' 			=> FALSE
			)
		);

        $series = $this->HighCharts->addChartSeries();
		
        $series->addName(__('Value'))
            ->addData($data['y']);

        $mychart->addSeries($series);
    }
	
	public function pie() {
        $chartName = 'Pie Chart';
        $pieChart = $this->HighCharts->create( $chartName, 'pie' );
		$data = array();
		
		$payments = $this->Payment->find('all', array('fields' => array('sum(value) as total', 'concat(concat(ParentCategory.name, " - "), ChildCategory.name) as name'), 'group' => 'Payment.category_id'));
		
		foreach ($payments as $payment){
			$data[] = array('name' => $payment[0]['name'], 'y' => (float)$payment[0]['total']);
		}

        $this->HighCharts->setChartParams($chartName,
			array(
				'renderTo'				=> 'chart',  // div to display chart inside
	
				'title'					=> __('Payments by category statistics'),
				'titleAlign'			=> 'center',
				'titleStyleFont'		=> '18px "Helvetica Neue", Helvetica, Arial, sans-serif',
				'titleStyleColor'		=> '#08C',
				
				'chartMarginTop' 			=> 40,
			)
		);

        $series = $this->HighCharts->addChartSeries();

        $series->addName(__('Value'))
            ->addData($data);

        $pieChart->addSeries($series);
	}
	
	public function chart( $model = 'Payment', $interval = array('from' => '0001-01-01', 'to' => false) ) {
		if ( $this->request->is('post') ){
			$model = $this->request->data['Chart']['model'];
			
			if ( !empty($this->request->data['Chart']['from']) && !empty($this->request->data['Chart']['to']) ){
				$interval = array('from' => $this->request->data['Chart']['from'], 'to' => $this->request->data['Chart']['to']);	
			} elseif ( !empty($this->request->data['Chart']['from']) && empty($this->request->data['Chart']['to']) ){
				$interval = array('from' => $this->request->data['Chart']['from'], 'to' => date('Y-m-d'));		
			} elseif ( empty($this->request->data['Chart']['from']) && !empty($this->request->data['Chart']['to']) ){
				$interval = array('from' => '0001-01-01', 'to' => $this->request->data['Chart']['to']);		
			}
		}
		
		if ( !$interval['to'] ){
			$interval['to'] = date('Y-m-d');
		}
		
		$chartName = 'chart';
        $pieChart = $this->HighCharts->create( $chartName, 'pie' );
		$data = array();
		
		$results = $this->{$model}->find('all', array(
			'fields' => array(
                'sum(value) as total',
                'concat(IFNULL(concat(ParentCategory.name, " - "), ""), ChildCategory.name) as name',
                $model . '.description'
            ),
			'conditions' => array(
				$model . '.date BETWEEN ? and ?' => $interval,
				'or' => array(
                    $model.'.user_id' => $this->Authorization->User->id(),
                    $model.'.team_id' => $this->Authorization->User->Team->id(),
                )
			),
			'group' => $model . '.category_id',
            'order' => 'total'
		));
		
		if ( !$results )
			$data = array(array('name' => __('No data available'), 'y' => 100.00, 'description' => 'descr'));
		
		foreach ($results as $result){
			$data[] = array('name' => $result[0]['name'], 'y' => (float)$result[0]['total'], 'description' => $result[$model]['description']);
		}
		
		if ( $interval['from'] == '0001-01-01' )
			$interval['from'] = __('the beginning of time');
			
		array_unshift($interval, Inflector::pluralize($model));
		
        $this->HighCharts->setChartParams($chartName,
			array(
				'renderTo'				=> 'chart',  // div to display chart inside
				
				'tooltipEnabled'		=> true,
				'tooltipFormatter'		=> "function() { return '<b>' + this.point.name + '</b>: '+ parseFloat(this.percentage).toFixed(2) +' %';}",
				
				'chartMarginTop' 			=> 40,
			)
		);

        $series = $this->HighCharts->addChartSeries();

        $series->addData($data);

        $pieChart->addSeries($series);
        
        $this->set('title', __('<strong>%s</strong> by category statistics from <strong>%s</strong> to <strong>%s</strong>', $interval));
	}
}
