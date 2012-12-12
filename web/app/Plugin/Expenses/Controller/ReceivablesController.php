<?php
class ReceivablesController extends ExpensesAppController {
	public $uses = array('Expenses.Receivable', 'Expenses.Category');
	
	public function beforeFilter(){
		parent::beforeFilter();
	}
	
	public function index() {
		$this->paginate = array('Receivable' => array(
			'conditions' => array(
                'or' => array(
                    'Receivable.user_id' => $this->Authorization->User->id(),
                    'Receivable.team_id' => $this->Authorization->User->Team->id(),
                )
			),
			'order'    => array( 
				'Receivable.date' => 'desc',
				'ParentCategory.name' => 'asc'
			),
			'limit'    => RECEIVABLES_LIMIT
		));
		
		$total = $this->Receivable->find('all', array(
            'fields' => array('sum(value) AS total'), 
            'conditions' => array(
                'or' => array(
                    'Receivable.user_id' => $this->Authorization->User->id(),
                    'Receivable.team_id' => $this->Authorization->User->Team->id(),
                )
            )
        ));
		
		$total_current = $this->Receivable->find('all', array(
            'fields' => array('sum(value) AS total'),
            'conditions' => array(
                'or' => array(
                    'Receivable.user_id' => $this->Authorization->User->id(),
                    'Receivable.team_id' => $this->Authorization->User->Team->id(),
                ),
                'EXTRACT(YEAR_MONTH FROM Receivable.date) = EXTRACT(YEAR_MONTH FROM NOW())'
            )
        ));
		
        $this->set('receivables', $this->paginate('Receivable'));
        $this->set('total', isset($total[0][0]['total'])? round($total[0][0]['total'], 2) : 0);
        $this->set('total_current', isset($total_current[0][0]['total'])? round($total_current[0][0]['total'], 2) : 0);
	}
    
    public function category( $id = null ) {
		$this->paginate = array('Receivable' => array(
			'conditions' => array(
                'or' => array(
                    'Receivable.user_id' => $this->Authorization->User->id(),
                    'Receivable.team_id' => $this->Authorization->User->Team->id(),
                ),
				 'or' => array(
					'ParentCategory.id' => $id,
					'ChildCategory.id' => $id
				)
			),
			'order'    => array( 
				'Receivable.date' => 'desc',
				'ParentCategory.name' => 'asc'
			),
			'limit'    => RECEIVABLES_LIMIT
		));
        
		$total = $this->Receivable->find('all', array('conditions' => array('or' => array('ParentCategory.id' => $id, 'ChildCategory.id' => $id)), 'fields'=>array('sum(value) AS total')));
		$total_current = $this->Receivable->find('all', array('fields'=>array('sum(value) AS total'), 'conditions' => array('or' => array('ParentCategory.id' => $id, 'ChildCategory.id' => $id), 'EXTRACT(YEAR_MONTH FROM Receivable.date) = EXTRACT(YEAR_MONTH FROM NOW())')));
		
        $this->set('category', $this->Category->findById( $id ));
        $this->set('receivables', $this->paginate('Receivable'));
        $this->set('total', isset($total[0][0]['total'])? round($total[0][0]['total'], 2) : 0);
        $this->set('total_current', isset($total_current[0][0]['total'])? round($total_current[0][0]['total'], 2) : 0);
    }
    
    public function subcategory( $id = null ) {
        $this->paginate = array('Receivable' => array(
			'conditions' => array(
                'or' => array(
                    'Receivable.user_id' => $this->Authorization->User->id(),
                    'Receivable.team_id' => $this->Authorization->User->Team->id(),
                ),
				 'or' => array(
					'ParentCategory.id' => $id,
					'ChildCategory.id' => $id
				)
			),
			'order'    => array( 
				'Receivable.date' => 'desc',
				'ParentCategory.name' => 'asc'
			),
			'limit'    => RECEIVABLES_LIMIT
		));
		
        $total = $this->Receivable->find('all', array('conditions' => array('or' => array('ParentCategory.id' => $id, 'ChildCategory.id' => $id)), 'fields'=>array('sum(value) AS total')));
		$total_current = $this->Receivable->find('all', array('fields'=>array('sum(value) AS total'), 'conditions' => array('or' => array('ParentCategory.id' => $id, 'ChildCategory.id' => $id), 'EXTRACT(YEAR_MONTH FROM Receivable.date) = EXTRACT(YEAR_MONTH FROM NOW())')));
		
        $this->set('category', $this->Category->findById( $id ));
        $this->set('receivables', $this->paginate('Receivable'));
		$this->set('total', isset($total[0][0]['total'])? round($total[0][0]['total'], 2) : 0);
        $this->set('total_current', isset($total_current[0][0]['total'])? round($total_current[0][0]['total'], 2) : 0);
	}
    
    public function add( $category_id = null ){		
        if ( $this->request->is('post') ) {
			if ($this->Receivable->save($this->data)) {
				$this->__deleteUserCache();
				
				$this->Session->setFlash(__('Receivable was successfully added!'), 'success');
				$this->redirect(array('action' => 'index'));
			}
		}
		
		$this->request->data['Receivable']['category_id'] = $category_id;
        $this->set('categories', $this->Expenses->Receivable->categories('list'));
	}
    
    public function edit( $id = null ) {
        if ( $this->request->is('post') ) {
			if ($this->Receivable->save($this->data)) {
				$this->__deleteUserCache();
				
				$this->Session->setFlash(__('Receivable was successfully modified!'), 'success');
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$this->data = $this->Receivable->findById( $id );	
		}
		
        $this->set('categories', $this->Expenses->Receivable->categories('list'));
    }


    public function delete( $id = null ) {    
        $this->Receivable->delete($id);
		$this->__deleteUserCache();
		
        $this->Session->setFlash(__('Receivable was successfully deleted'), 'success'); 
        $this->redirect(array('action'=>'index')); 
    } 
	
	private function __deleteUserCache(){
        $key = 'team_' . $this->Authorization->User->Team->id();
        
        if ( !$key )
            $key = $this->Authorization->User->id();
            
		Cache::delete('receivables_total_'. $key, 'expenses');
	}
}
