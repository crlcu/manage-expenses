<?php
class TeamComponent extends Component {
    public $components = array('Session');
    
	public function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
	}
	
	public function initialize($controller) {
	}

	public function startup(&$controller = null) {
	}
	   
	/**
	 * Used to get user id from session
	 *
	 * @access public
	 * @return int
	 */
    public function id() {
        return $this->Session->read('Authorization.Team.0.id');
    }
    
    /**
	 * Used to get group name from session
	 *
	 * @access public
	 * @return string
	 */
	public function name() {
		return $this->Session->read('Authorization.UserGroup.name');
	}
}