<?php
class CategoriesController extends ExpensesAppController {
    public function beforeFilter(){
		parent::beforeFilter();
	}
	
	public function payments() {
		$this->paginate = array('Category' => array(
			'conditions' => array(
				'or' => array(
					'Category.user_id' => $this->Authorization->User->id(),
					'Category.team_id' => $this->Authorization->User->Team->id(),
				),
				'Category.parent_id' => null,
				'Category.type' => 'payments'
			),
			'order' => 'Category.order',
			'limit' => CATEGORIES_LIMIT
		));
		
		$this->set('categories', $this->paginate('Category'));
    }
	
	public function receivables() {
		$this->paginate = array('Category' => array(
			'conditions' => array(
				'or' => array(
					'Category.user_id' => $this->Authorization->User->id(),
					'Category.team_id' => $this->Authorization->User->Team->id(),
				),
				'Category.parent_id' => null,
				'Category.type' => 'receivables'
			),
			'order' => 'Category.order',
			'limit' => CATEGORIES_LIMIT
		));
		
		$this->set('categories', $this->paginate('Category'));
    }
    
    function add($type = null) {
        $this->set('parent_categories', $this->Category->find('list', array(
            'conditions' => array(
                'or' => array(
                    'Category.user_id' => $this->Authorization->User->id(),
                    'Category.team_id' => $this->Authorization->User->Team->id(),
                ),
                'Category.parent_id' => null, 
                'Category.type' => $type
            ),
            'order' => 'Category.order'
        )));
		$this->set('type', $type);
		
        if ( $this->request->is('post') ) {
			$this->request->data['Category']['type'] = $type;
			
			if ($this->Category->save($this->request->data)) {
				$this->__deleteUserCache();
				
				$this->Session->setFlash(__('%s category was successfully added!', ucfirst($type)), 'success');
				$this->redirect(array('action' => $type));
			}
		}
	}
    
    public function edit($id = null, $type = null) {
        $this->set('parent_categories', $this->Category->find('list', array(
            'conditions' => array(
                'or' => array(
                    'Category.user_id' => $this->Authorization->User->id(),
                    'Category.team_id' => $this->Authorization->User->Team->id(),
                ),
                'Category.parent_id' => null,
                'Category.type' => $type, 
                'Category.id <> '.$id
            ),
            'order' => 'Category.order'
        )));
		$this->set('type', $type);

		if ( $this->request->is('put') ) {
			if ($this->Category->save($this->data)) {
				$this->__deleteUserCache();
				
				$this->Session->setFlash(__('%s category was successfully modified!', ucfirst($type)), 'success');
				$this->redirect(array('action' => $type));
			}
		} else {
			$this->data = $this->Category->findById( $id );
		}
    }
    
    public function delete( $id = null ) {
		$category = $this->Category->findById($id);
		
		if ( $category && ($category['Category']['user_id'] == $this->Authorization->User->id() || $category['Category']['team_id'] == $this->Authorization->User->Team->id()) ){
			$this->Category->delete($id);
			$this->__deleteUserCache();
			
			$this->Session->setFlash(__('Category was successfully deleted!'), 'success');
		} else {
			$this->Session->setFlash(__('You have no rights to delete this category!'), 'info');
		}
		
		$this->redirect($this->referer()); 
    }
	
	private function __deleteUserCache(){
        $key = 'team_' . $this->Authorization->User->Team->id();
        
        if ( !$key )
            $key = $this->Authorization->User->id();        
        
		Cache::delete('payment_categories_'. $key, 'expenses');
		Cache::delete('receivable_categories_'. $key, 'expenses');
	}
}
