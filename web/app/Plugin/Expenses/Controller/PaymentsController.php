<?php
class PaymentsController extends ExpensesAppController {
    public $uses = array('Expenses.Payment', 'Expenses.Category');
	
	public function beforeFilter(){
		parent::beforeFilter();
	}
    
    public function index($month = false){
		$this->paginate = array('Payment' => array(
			'conditions' => array(
                'or' => array(
                    'Payment.user_id' => $this->Authorization->User->id(),
                    'Payment.team_id' => $this->Authorization->User->Team->id(),
                )
			),
			'order'    => array( 
				'Payment.date' => 'desc',
				'ParentCategory.name' => 'asc'
			),
			'limit'    => PAYMENTS_LIMIT
		));
		
		$total = $this->Payment->find('all', array(
            'fields' => array('sum(value) AS total'), 
            'conditions' => array(
                'or' => array(
                    'Payment.user_id' => $this->Authorization->User->id(),
                    'Payment.team_id' => $this->Authorization->User->Team->id(),
                )
            )
        ));
		
		$total_current = $this->Payment->find('all', array(
            'fields' => array('sum(value) AS total'),
            'conditions' => array(
                'or' => array(
                    'Payment.user_id' => $this->Authorization->User->id(),
                    'Payment.team_id' => $this->Authorization->User->Team->id(),
                ),
                'EXTRACT(YEAR_MONTH FROM Payment.date) = EXTRACT(YEAR_MONTH FROM NOW())'
            )
        ));
		
        $this->set('payments', $this->paginate('Payment'));
        $this->set('total', isset($total[0][0]['total'])? round($total[0][0]['total'], 2) : 0);
        $this->set('total_current', isset($total_current[0][0]['total'])? round($total_current[0][0]['total'], 2) : 0);
	}
    
    public function category( $id = null ) {
		$this->paginate = array('Payment' => array(
			'conditions' => array(
                'or' => array(
                    'Payment.user_id' => $this->Authorization->User->id(),
                    'Payment.team_id' => $this->Authorization->User->Team->id(),
                ),
				'or' => array(
					'ParentCategory.id' => $id,
					'ChildCategory.id' => $id
				)
			),
			'order'    => array( 
				'Payment.date' => 'desc',
				'ParentCategory.name' => 'asc'
			),
			'limit'    => PAYMENTS_LIMIT
		));
        
		$total = $this->Payment->find('all', array('conditions' => array('or' => array('ParentCategory.id' => $id, 'ChildCategory.id' => $id)), 'fields' => array('sum(value) AS total')));
		$total_current = $this->Payment->find('all', array('fields' => array('sum(value) AS total'), 'conditions' => array('or' => array('ParentCategory.id' => $id, 'ChildCategory.id' => $id), 'EXTRACT(YEAR_MONTH FROM Payment.date) = EXTRACT(YEAR_MONTH FROM NOW())')));
		
        $this->set('payments', $this->paginate('Payment'));
        $this->set('category', $this->Category->findById( $id ));
        $this->set('total', isset($total[0][0]['total'])? round($total[0][0]['total'], 2) : 0);
        $this->set('total_current', isset($total_current[0][0]['total'])? round($total_current[0][0]['total'], 2) : 0);
    }
    
    public function subcategory( $id = null ) {
		$this->paginate = array('Payment' => array(
			'conditions' => array(
                'or' => array(
                    'Payment.user_id' => $this->Authorization->User->id(),
                    'Payment.team_id' => $this->Authorization->User->Team->id(),
                ),
				'or' => array(
					'ParentCategory.id' => $id,
					'ChildCategory.id' => $id
				)
			),
			'order'    => array( 
				'Payment.date' => 'desc',
				'ParentCategory.name' => 'asc'
			),
			'limit'    => PAYMENTS_LIMIT
		));
		
		$total = $this->Payment->find('all', array('conditions' => array('or' => array('ParentCategory.id' => $id, 'ChildCategory.id' => $id)), 'fields' => array('sum(value) AS total')));
		$total_current = $this->Payment->find('all', array('fields' => array('sum(value) AS total'), 'conditions' => array('or' => array('ParentCategory.id' => $id, 'ChildCategory.id' => $id), 'EXTRACT(YEAR_MONTH FROM Payment.date) = EXTRACT(YEAR_MONTH FROM NOW())')));
        
        $this->set('payments', $this->paginate('Payment'));
        $this->set('category', $this->Category->findById( $id ));
        $this->set('total', isset($total[0][0]['total'])? round($total[0][0]['total'], 2) : 0);
        $this->set('total_current', isset($total_current[0][0]['total'])? round($total_current[0][0]['total'], 2) : 0);
	}
    
    public function add( $category_id = null ) {
		if ( $this->request->is('post') ) {
			if ($this->Payment->save($this->data)) {
				$this->__deleteUserCache();
				
				$this->Session->setFlash(__('Payment was successfully added!'), 'success');
				$this->redirect(array('action' => 'index'));
			}
		}
		
		$this->request->data['Payment']['category_id'] = $category_id;
		$this->set('categories', $this->Expenses->Payment->categories('list'));
	}
    
    public function edit($id = null) {
		if ( $this->request->is('post') ) {
			if ($this->Payment->save($this->data)) {
				$this->__deleteUserCache();
				
				$this->Session->setFlash(__('Payment was successfully modified!'), 'success');
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$this->data = $this->Payment->findById($id);
		}
        
        $this->set('categories', $this->Expenses->Payment->categories('list'));
    }


    public function delete($id = null) {    
        $this->Payment->delete($id);
		$this->__deleteUserCache();
		
        $this->Session->setFlash(__('Payment was successfully deleted'), 'success'); 
        $this->redirect(array('action'=>'index')); 
    }
	
	private function __deleteUserCache(){
        $key = 'team_' . $this->Authorization->User->Team->id();
        
        if ( !$key )
            $key = $this->Authorization->User->id();
            
		Cache::delete('payments_total_'. $key, 'expenses');
	}
}
