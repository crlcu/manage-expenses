<?php
App::uses('UsersAppModel', 'Users.Model');
App::uses('CakeEmail', 'Network/Email');

class UserGroup extends UsersAppModel {
    /**
	 * model has following models
	 */
	public $hasMany = array(
        'UserGroupPermission' => array(
			'dependent' => true,
			'className' => 'Users.UserGroupPermission'
		)
    );

    
	/**
	 * model validation array
	 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter name!'
            ),
			'isUnique' => array(
                'rule' 		=> 'isUnique',
                'required'	=> true,
				'message'	=> 'Group already exist!'
            )
        ),
		'allow_registration' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please chose allow registration!'
            )
		)
	);
    
    /**
	 *	model search conditions
	 */
	public $search = array(
        'UserGroup' => array(
            'id' => array(
                'condition' => '='
            ),
            'name' => array(
                'condition' => 'like'
            ),
			'alias_name' => array(
                'condition' => 'like'
            ),
            'allow_registration' => array(
                'condition' => 'like'
            ),
            'created' => array(
                'condition' => 'like'
            ),
            'modified' => array(
                'condition' => 'like'
            )
        )
    );
    
	/**
	 * model validation array
	 *
	 * @var array
	 */
	function addValidate() {
		$validate1 = array(
				'name'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter group name',
						'last'=>true),
					'mustAlphaNumeric'=>array(
						'rule' => 'alphaNumericDashUnderscoreSpace',
						'message'=> 'Group name must be alphaNumeric',
						'last'=>true),
					'mustAlpha'=>array(
						'rule' => 'alpha',
						'message'=> 'Group name must contain any letter',
						'last'=>true),
					'mustUnique'=>array(
						'rule' =>'isUnique',
						'message' =>'This group name already added',
						'on'=>'create',
						'last'=>true),
					),
				'alias_name'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter alias group name',
						'last'=>true),
					'mustAlphaNumeric'=>array(
						'rule' => 'alphaNumericDashUnderscore',
						'message'=> 'Alias group name must be alphaNumeric',
						'last'=>true),
					'mustAlpha'=>array(
						'rule' => 'alpha',
						'message'=> 'Alias group name must contain any letter',
						'last'=>true),
					'mustUnique'=>array(
						'rule' =>'isUnique',
						'message' =>'This alias group name already added',
						'on'=>'create',
						'last'=>true),
					),
				);
		$this->validate=$validate1;
		return $this->validates();
	}
	/**
	 * Used to check permissions of group
	 *
	 * @access public
	 * @param string $controller controller name
	 * @param string $action action name
	 * @param integer $userGroupID group id
	 * @return boolean
	 */
	public function isUserGroupAccess($controller, $action, $userGroupID) {
		$includeGuestPermission = false;
		$userGroupIDArray = explode(',', $userGroupID);
		$userGroupIDArray = array_map('trim', $userGroupIDArray);
        
		if ( !USERS_PERMISSIONS ) {
			return true;
		}
        
		if (in_array(USERS_ADMIN_GROUP_ID, $userGroupIDArray) && !USERS_ADMIN_PERMISSIONS) {
			return true;
		}

		$permissions = $this->getPermissions($userGroupID, $includeGuestPermission);
		$access = str_replace(' ', '', ucwords(str_replace('_', ' ', $controller))).'/'.$action;
        
		if (in_array($access, $permissions)) {
			return true;
		}
        
		return false;
	}
    
	/**
	 * Used to check permissions of guest group
	 *
	 * @access public
	 * @param string $controller controller name
	 * @param string $action action name
	 * @return boolean
	 */
	public function isGuestAccess($controller, $action) {
		if ( USERS_PERMISSIONS ) {
			return $this->isUserGroupAccess($controller, $action, USERS_GUEST_GROUP_ID);
		} else {
			return true;
		}
	}
    
	/**
	 * Used to get permissions from cache or database of a group
	 *
	 * @access public
	 * @param integer $userGroupID group id
	 * @return array
	 */
	public function getPermissions($userGroupID) {
		$permissions = array();
		$userGroupIDCache = str_replace(',', '-', $userGroupID);
        
		// using the cake cache to store rules
		$cacheKey = 'permissions_for_group_'.$userGroupIDCache;
		$actions = Cache::read($cacheKey, 'permissions');
		
        if ($actions === false) {
			$userGroupIDArray = explode(',', $userGroupID);
			$userGroupIDArray = array_map('trim', $userGroupIDArray);
			$actions = $this->UserGroupPermission->find('all',array('conditions' => array('UserGroupPermission.user_group_id' => $userGroupIDArray, 'UserGroupPermission.allowed' => 1)));
			Cache::write($cacheKey, $actions, 'permissions');
		}
        
		foreach ($actions as $action) {
			$permissions[] = $action['UserGroupPermission']['controller'].'/'.$action['UserGroupPermission']['action'];
		}
        
		return  array_unique($permissions);
	}
    
	/**
	 * Used to get group names
	 *
	 * @access public
	 * @return array
	 */
	public function getGroupNames() {
		$this->unbindModel(array('hasMany' => array('UserGroupPermission')));
		$result=$this->find("all", array("order"=>"id"));
		$i=0;
		$user_groups=array();
		foreach ($result as $row) {
			$user_groups[$i]=$row['UserGroup']['name'];
			$i++;
		}
		return $user_groups;
	}
	/**
	 * Used to get group names with ids
	 *
	 * @access public
	 * @return array
	 */
	public function getGroupNamesAndIds() {
		$this->unbindModel(array('hasMany' => array('UserGroupPermission')));
		$result=$this->find("all", array("order"=>"id"));
		$i=0;
		foreach ($result as $row) {
			$data['id']=$row['UserGroup']['id'];
			$data['name']=$row['UserGroup']['name'];
			$data['alias_name']=$row['UserGroup']['alias_name'];
			$user_groups[$i]=$data;
			$i++;
		}
		return $user_groups;
	}
	/**
	 * Used to get group names with ids without guest group
	 *
	 * @access public
	 * @return array
	 */
	public function getGroups() {
		$this->unbindModel(array('hasMany' => array('UserGroupPermission')));
		$result=$this->find("all", array("order"=>"id", "conditions"=>array('name !='=>"Guest")));
		$user_groups=array();
		$user_groups['']='Select';
		foreach ($result as $row) {
			$user_groups[$row['UserGroup']['id']]=$row['UserGroup']['name'];
		}
		return $user_groups;
	}
	/**
	 * Used to get group names with ids for registration
	 *
	 * @access public
	 * @return array
	 */
	public function getGroupsForRegistration() {
		$this->unbindModel(array('hasMany' => array('UserGroupPermission')));
		$result=$this->find("all", array("order"=>"id", "conditions"=>array('allow_registration'=>1)));
		$user_groups=array();
		$user_groups[0]='Select';
		foreach ($result as $row) {
			$user_groups[$row['UserGroup']['id']]=$row['UserGroup']['name'];
		}
		return $user_groups;
	}
	/**
	 * Used to check group is available for registration
	 *
	 * @access public
	 * @param integer $groupId group id
	 * @return boolean
	 */
	function isAllowedForRegistration($groupId) {
		$result=$this->findById($groupId);
		if (!empty($result)) {
			if($result['UserGroup']['allowRegistration']==1)
				return true;
		}
		return false;
	}
	/**
	 * Used to check user group by group id
	 *
	 * @access public
	 * @param integer $groupId group id
	 * @return string
	 */
	public function isValidUserId($groupId) {
		$res = $this->findById($groupId);
		if(!empty($res)) {
			return true;
		}
		return false;
	}
	/**
	 * Used to get group names by groupd ids
	 *
	 * @access public
	 * @return array
	 */
	public function getGroupsByIds($group_ids, $ruturn_array=false) {
		if(!is_array($group_ids)) {
			$group_ids = explode(',', $group_ids);
		}
		$this->unbindModel(array('hasMany' => array('UserGroupPermission')));
		$result=$this->find("all", array("order"=>"id", "conditions"=>array('id'=>$group_ids)));
		$user_groups=array();
		foreach ($result as $row) {
			$user_groups[$row['UserGroup']['id']]=$row['UserGroup']['name'];
		}
		if(!$ruturn_array) {
			$user_groups = implode(', ',$user_groups);
		}
		return $user_groups;
	}
}