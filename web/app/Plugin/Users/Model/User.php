<?php
App::uses('UsersAppModel', 'Users.Model');
App::uses('CakeEmail', 'Network/Email');

class User extends UsersAppModel {	
	public $belongsTo = array(
        'Group' => array(
			'className'	=> 'Users.UserGroup',
            'foreignKey' => 'user_group_id'
		)        
    );
    
    /**
	 * This model has one relation
	 */
	public $hasOne = array(
		'UserDetail' => array(
			'dependent' => true,
			'className'	=> 'Users.UserDetail'
		)
	);
	
	/**
	 * This model has many relations
	 */
	public $hasMany = array(
		'LoginToken' => array(
			'dependent' => true,
			'className'	=> 'Users.LoginToken',
			'limit'		=> 1
		)
	);
    
   	/**
	 * This model has and belongs to many relations
	 */
    public $hasAndBelongsToMany = array(
        'Team'
    );
	
	/**
	 * model validation array
	 */
	public $validate = array(
        'email' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter email!'
            ),
            'email' => array(
                'rule'		=> 'email',
                'required'	=> true,
                'message'	=> 'Invalid email format!'
            ),
			'isUnique' => array(
                'rule' 		=> 'isUnique',
                'required'	=> true,
				'message'	=> 'Email already exist!'
            )
        ),
		'username' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter username!'
            ),
			'isUnique' => array(
                'rule' 		=> 'isUnique',
                'required'	=> true,
				'message'	=> 'Username already exist!'
            )
        ),
        'password' => array(
			'notEmpty' => array(
				'on'		=> 'create',
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter password!'
            )
        ),
		'passwd' => array(
			'notEmpty' => array(
				'on'		=> 'create',
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter password!'
            ),
			'minLength' => array(
				'on'		=> 'create',
				'rule'    => array('minLength', '6'),
				'message' => 'Enter at least 6 characters!'	
			)
        ),
		'cpasswd' => array(
			'identic' => array(
				'on'		=> 'create',
				'rule'		=> array('identic', 'passwd'), 
				'message'	=> 'Passwords do not match!' 
            )
        )
    );
	
    //validate rules on register
    public $validateRegister = array(
        'email' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter email!'
            ),
            'email' => array(
                'rule'		=> 'email',
                'required'	=> true,
                'message'	=> 'Invalid email format!'
            ),
			'isUnique' => array(
                'rule' 		=> 'isUnique',
                'required'	=> true,
				'message'	=> 'Email already exist!'
            )
        ),
		'username' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter username!'
            ),
			'isUnique' => array(
                'rule' 		=> 'isUnique',
                'required'	=> true,
				'message'	=> 'Username already exist!'
            )
        ),
		'passwd' => array(
			'notEmpty' => array(
				'on'		=> 'create',
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter password!'
            ),
			'minLength' => array(
				'on'		=> 'create',
				'rule'    => array('minLength', '6'),
				'message' => 'Enter at least 6 characters!'	
			)
        ),
		'cpasswd' => array(
			'identic' => array(
				'on'		=> 'create',
				'rule'		=> array('identic', 'passwd'), 
				'message'	=> 'Passwords do not match!' 
            )
        )
    );
    
	//validate rules on login
    public $validateLogin = array(
        'email' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter email or username!'
            )
        ),
		'password' => array(
			'notEmpty' => array(
				'on'		=> 'create',
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter password!'
            )
        )
    );
    
    //validate rules on change password
    public $validateChangePassword = array(
        'oldpasswd' => array(
			'oldpasswd' => array(
				'rule'		=> array('oldpasswd'), 
				'message'	=> 'Old password is incorrect!' 
            )
        ),
        'passwd' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter new password!'
            ),
			'minLength' => array(
				'rule'    => array('minLength', '6'),
				'message' => 'Enter at least 6 characters!'	
			)
        ),
		'cpasswd' => array(
			'identic' => array(
				'rule'		=> array('identic', 'passwd'), 
				'message'	=> 'Passwords do not match!' 
            )
        )
    );
    
    //validate rules on forgot password
    public $validateForgotPassword = array(
        'email' => array(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required'	=> true,
                'message' 	=> 'Please enter email!'
            ),
            'email' => array(
                'rule'		=> 'email',
                'required'	=> true,
                'message'	=> 'Invalid email format!'
            )
        )
    );
	
	/**
	 *	model search conditions
	 */
	public $search = array(
        'User' => array(
            'username' => array(
                'condition' => 'like'
            ),
			'email' => array(
                'condition' => 'like'
            ),
            'language' => array(
                'condition' => 'like'
            ),
            'active' => array(
                'condition' => '='
            ),
            'email_verified' => array(
                'condition' => '='
            )
        ),
		'UserDetail' => array(
			'first_name' => array(
                'condition' => 'like'
            ),
			'last_name' => array(
                'condition' => 'like'
            ),
			'gender' => array(
                'condition' => '='
            )
		)
    );
	
	public function identic( $field = array(), $compare_field = null ){ 
        foreach( $field as $key => $value ){
            if ($value !== $this->data[$this->name][ $compare_field ]){ 
                return false; 
            } else { 
                continue;
            } 
        }
		
        return true; 
    }
    
    public function oldpasswd( $field = array() ){
        $user = $this->findById($this->Authorization->User->id());
        
        if ( $user['User']['password'] === $this->Authorization->makePassword($this->data['User']['oldpasswd'], $user['User']['salt']) )
            return true;
        
        return false;
    }
    
    public function beforeSave(){        
        if ( isset($this->data['User']['passwd']) && !empty($this->data['User']['passwd'])){
            $this->data['User']['salt'] = $this->makeSalt();
            $this->data['User']['password'] = $this->makePassword($this->data['User']['passwd'], $this->data['User']['salt']);
        }
        
        return true;
    }
    
    /**
	 * Used to make password in hash format
	 *
	 * @access public
	 * @param string $pass password of user
	 * @param string $salt salt of user for password
	 * @return hash
	 */
	public function makePassword($pass, $salt) {
		return md5(md5($pass).md5($salt));
	}
	
	/**
	 * Used to make salt in hash format
	 *
	 * @access public
	 * @return hash
	 */
	public function makeSalt() {		
		return md5( mt_rand(0, 32) . time() );
	}
    
	/**
	 * Authorization component object
	 *
	 * @var object
	 */
	public $Authorization;

	/**
	 * Used to validate captcha
	 *
	 * @access public
	 * @return boolean
	 */
	public function recaptchaValidate() {
		App::import("Vendor", "Users.recaptcha/recaptchalib");
		$recaptcha_challenge_field = (isset($_POST['recaptcha_challenge_field'])) ? $_POST['recaptcha_challenge_field'] : "";
		$recaptcha_response_field = (isset($_POST['recaptcha_response_field'])) ? $_POST['recaptcha_response_field'] : "";
		$resp = recaptcha_check_answer(PRIVATE_KEY_FROM_RECAPTCHA, $_SERVER['REMOTE_ADDR'], $recaptcha_challenge_field, $recaptcha_response_field);
		$error = $resp->error;
		if(!$resp->is_valid) {
			$this->validationErrors['captcha'][0]=$error;
		}
		return true;
	}
    
	/**
	 * Used to validate banned usernames
	 *
	 * @access public
	 * @return boolean
	 */
	public function isBanned() {
		$bannedUsers= explode(',', strtolower(BANNED_USERNAMES));
		$bannedUsers = array_map('trim', $bannedUsers);
		$checkMore=true;
		if(!empty($bannedUsers)) {
			if(isset($this->data['User']['id'])) {
				$oldUsername= $this->getUserNameById($this->data['User']['id']);
			}
			if(!isset($oldUsername) || $oldUsername !=$this->data['User']['username']) {
				if(in_array(strtolower($this->data['User']['username']), $bannedUsers)) {
					$this->validationErrors['username'][0]="You cannot set this username";
					$checkMore=false;
				}
			}
		}
		if($checkMore) {
			App::import("Component", "Users.ControllerList");
			$contList = new ControllerListComponent(new ComponentCollection());
			$conts = $contList->getControllers();
			unset($conts[-2]);
			unset($conts[-1]);
			$conts = array_map('strtolower', $conts);
			$usernameTmp =strtolower(str_replace(' ','',ucwords(str_replace('_',' ',$this->data['User']['username']))));
			if(in_array($usernameTmp, $conts)) {
				$this->validationErrors['username'][0]="You cannot set this username";
				$checkMore=false;
			}
			if($checkMore) {
				$plugins = App::objects('plugins');
				$plugins = array_map('strtolower', $plugins);
				if(in_array($usernameTmp, $plugins)) {
					$this->validationErrors['username'][0]="You cannot set this username";
					$checkMore=false;
				}
				if($checkMore) {
					$customRoutes = Router::$routes;
					$usernameTmp ='/'.$this->data['User']['username'];
					foreach($customRoutes as $customRoute) {
						if(strpos(strtolower($customRoute->template),strtolower($usernameTmp)) !==false) {
							$this->validationErrors['username'][0]="You cannot set this username";
							break;
						}
					}
				}
			}
		}
		return true;
	}
    
	/**
	 * Used to match old password
	 *
	 * @access public
	 * @return boolean
	 */
	public function verifyOldPass() {
		$userId = $this->Authorization->User->id();
		$user = $this->findById($userId);
		$oldpass = $this->Authorization->makePassword($this->data['User']['oldpassword'], $user['User']['salt']);
		return ($user['User']['password']===$oldpass);
	}
	
	/**
	 * Used to send email verification mail to user
	 *
	 * @access public
	 * @param array $user user detail array
	 * @return void
	 */     
	public function sendVerificationMail( $user ) {        
        // send email
		$email = new CakeEmail();
        
        $email->template('Users.verification')
            ->emailFormat('html')
            ->from(array( USERS_USERS_REGISTER_VERIFICATION_FROM_MAIL => USERS_USERS_REGISTER_VERIFICATION_FROM_NAME))
            ->to( $user['User']['email'] )
            ->subject( __(USERS_USERS_REGISTER_VERIFICATION_MAIL_SUBJECT) )
            ->viewVars(array('user' => $user, 'key' => $this->getActivationKey($user['User']['password'])));

		try{
			$result = $email->send();
		} catch (Exception $ex){
			$result = "Could not send verification email to : ".$user['User']['email'];
		}
        
		$this->log($result, LOG_DEBUG);
	}
    
	/**
	 * Used to send email verification code to user
	 *
	 * @access public
	 * @param array $user user detail array
	 * @return void
	 */
	public function sendVerificationCode($userId, $emailadd, $code) {
		$name = $this->getNameById($userId);
		$email = new CakeEmail();
		$fromConfig = EMAIL_FROM_ADDRESS;
		$fromNameConfig = EMAIL_FROM_NAME;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($emailadd);
		$email->subject('Email Verification Code');
		$body="Hi ".$name.", \n\n Your email verification code is ".$code;
		try{
			$result = $email->send($body);
		} catch (Exception $ex){
			// we could not send the email, ignore it
			$result="Could not send verification code email to userid-".$userId;
			$this->log($result, LOG_DEBUG);
		}
	}
    
	/**
	 * Used to generate activation key
	 *
	 * @access public
	 * @param string $password user password
	 * @return hash
	 */
	public function getActivationKey($password) {
		$salt = Configure::read ( "Security.salt" );
		return md5(md5($password).$salt);
	}
    
    /**
	 * Used to send registration mail to user
	 *
	 * @access public
	 * @param array $user user detail array
	 * @return void
	 */
	public function sendRegistrationMail($user) {        
        // send email
		$email = new CakeEmail();
        
        $email->template('Users.registration')
            ->emailFormat('html')
            ->from(array( USERS_USERS_REGISTER_REGISTRATION_FROM_MAIL => USERS_USERS_REGISTER_REGISTRATION_FROM_NAME))
            ->to( $user['User']['email'] )
            ->subject( __(USERS_USERS_REGISTER_REGISTRATION_MAIL_SUBJECT) )
            ->viewVars(array('user' => $user));

		try{
			$result = $email->send();
		} catch (Exception $ex){
			$result = "Could not send registration email to : ".$user['User']['email'];
		}
        
		$this->log($result, LOG_DEBUG);
	}
    
	/**
	 * Used to send forgot password mail to user
	 *
	 * @access public
	 * @param array $user user detail
	 * @return void
	 */
	public function sendForgotPasswordMail($user) {
        // send email
		$email = new CakeEmail();
        
        $email->template('Users.forgotPassword')
            ->emailFormat('html')
            ->from(array( USERS_USERS_FORGOTPASSWORD_FROM_MAIL => USERS_USERS_FORGOTPASSWORD_FROM_NAME))
            ->to( $user['User']['email'] )
            ->subject( __(USERS_USERS_FORGOTPASSWORD_MAIL_SUBJECT) )
            ->viewVars(array('user' => $user, 'key' => $this->getActivationKey($user['User']['password'])));

		try{
			$result = $email->send();
		} catch (Exception $ex){
			$result = "Could not send forgot password email to : ".$user['User']['email'];
		}
        
		$this->log($result, LOG_DEBUG);
	}
    
	/**
	 * Used to send change password mail to user
	 *
	 * @access public
	 * @param array $user user detail
	 * @return void
	 */
	public function sendChangePasswordMail($user) {
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		$fromConfig = EMAIL_FROM_ADDRESS;
		$fromNameConfig = EMAIL_FROM_NAME;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
		$email->subject(SITE_NAME.': Change Password Confirmation');
		$body= "Hey ".$user['User']['first_name'].", You recently changed your password on ".date('Y M d h:i:s', time()).".

As a security precaution, this notification has been sent to your email addresse associated with your account.

Thanks,\n".

SITE_NAME;
		try{
			$result = $email->send($body);
		} catch (Exception $ex){
			// we could not send the email, ignore it
			$result="Could not send change password email to userid-".$userId;
			$this->log($result, LOG_DEBUG);
		}
	}
	
	/**
	 * Used to mark cookie used
	 *
	 * @access public
	 * @param string $type
	 * @param string $credentials
	 * @return array
	 */
	public function authsomeLogin($type, $credentials = array()) {
		switch ($type) {
			case 'guest':
				// You can return any non-null value here, if you don't
				// have a guest account, just return an empty array
				return array();
			case 'cookie':
				$loginToken = false;
				
				if(strpos($credentials['token'], ":") !== false) {
					list($token, $user_id) = split(':', $credentials['token']);
					$duration = $credentials['duration'];

					$loginToken = $this->LoginToken->find('first', array(
						'conditions' => array(
							'user_id' => $user_id,
							'token' => $token,
							'duration' => $duration,
							'used' => false,
							'expires <=' => date('Y-m-d H:i:s', strtotime($duration)),
						),
						'contain' => false
					));
				}
				
				if (!$loginToken) {
					return false;
				}
				
				$loginToken['LoginToken']['used'] = true;
				$this->LoginToken->save($loginToken);

				$conditions = array(
					'User.id' => $loginToken['LoginToken']['user_id']
				);
				
				break;
			default:
				return array();
		}
		
		return $this->find('first', compact('conditions'));
	}
	
	/**
	 * Used to generate cookie token
	 *
	 * @access public
	 * @param integer $userId user id
	 * @param string $duration cookie persist life time
	 * @return string
	 */
	public function authsomePersist($user_id, $duration) {
		$token = md5(uniqid(mt_rand(), true));
		
		$this->LoginToken->create(array(
			'user_id' => $user_id,
			'token' => $token,
			'duration' => $duration,
			'expires' => date('Y-m-d H:i:s', strtotime($duration)),
		));
		
		$this->LoginToken->deleteAll(array('user_id' => $user_id), false);
		$this->LoginToken->save();
		
		return $token . ':' . $user_id;
	}
	
	/**
	 * Used to get name by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getNameById($userId) {
		$this->unbindModel(array('hasMany' => array('LoginToken'), 'hasOne' => array('UserDetail')));
		$res = $this->findById($userId);
		$name=(!empty($res)) ? ($res['User']['first_name'].' '.$res['User']['last_name']) : '';
		return $name;
	}
	
	/**
	 * Used to get username by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getUserNameById($userId) {
		$this->unbindModel(array('hasMany' => array('LoginToken'), 'hasOne' => array('UserDetail')));
		$res = $this->findById($userId);
		$name=(!empty($res)) ? ($res['User']['username']) : '';
		return $name;
	}
	
	/**
	 * Used to get email by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getEmailById($userId) {
		$this->unbindModel(array('hasMany' => array('LoginToken'), 'hasOne' => array('UserDetail')));
		$res = $this->findById($userId);
		$email=(!empty($res)) ? ($res['User']['email']) : '';
		return $email;
	}
	
	/**
	 * Used to get user by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getUserById($userId) {
		$res = $this->findById($userId);
		return $res;
	}
	
	/**
	 * Used to get gender array
	 *
	 * @access public
	 * @return string
	 */
	public function getGenderArray($select=true) {
		$gender = array();
		if($select) {
			$gender['']="Select Gender";
		}
		$gender['male']="Male";
		$gender['female']="Female";
		return $gender;
	}
	
	/**
	 * Used to get gender array
	 *
	 * @access public
	 * @return string
	 */
	public function getMaritalArray($select=true) {
		$rel = array();
		if($select) {
			$rel['']="Select Status";
		}
		$rel['single']="Single";
		$rel['married']="Married";
		$rel['divorced']="Divorced";
		$rel['widowed']="Widowed";
		return $rel;
	}
	
	/**
	 * Used to check user by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return boolean
	 */
	public function isValidUserId($userId) {
		$this->unbindModel(array('hasMany' => array('LoginToken'), 'hasOne' => array('UserDetail')));
		$res = $this->findById($userId);
		if(!empty($res)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Used to check users by group id
	 *
	 * @access public
	 * @param integer $groupId user id
	 * @return boolean
	 */
	public function isUserAssociatedWithGroup( $group_id = null ) {
		$res = $this->find('count', array('conditions' => array('User.user_group_id' => $group_id)));
		
		if(!empty($res)) {
			return true;
		}
		
		return false;
	}
}