<?php
class UserComponent extends Component {
    public $components = array('Session', 'Users.Group', 'Users.Team');
    
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
        return $this->Session->read('Authorization.User.id');
    }
    
    /**
	 * Used to get group id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function group_id() {
		return $this->Group->id();
	}
	
	    
	/**
	 * Used to check whether user is logged in or not
	 *
	 * @access public
	 * @return boolean
	 */
	public function isLogged() {
		return ($this->id() !== null);
	}
	
	/**
	 *
	 */
	public function agent(){
		return $this->Session->read('Config.userAgent');
	}
}