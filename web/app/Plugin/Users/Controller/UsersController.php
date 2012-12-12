<?php
App::uses('UsersAppController', 'Users.Controller');

class UsersController extends UsersAppController {
	/**
	 * This controller uses following models
	 *
	 * @var array
	 */
	public $uses = array('Users.User', 'Users.UserGroup', 'Users.TmpEmail', 'Users.UserDetail', 'Users.UserActivity', 'Users.LoginToken', 'Users.UserGroupPermission');
	
    /**
	 * This controller uses following components
	 *
	 * @var array
	 */
	public $components = array('Cookie', 'Users.ControllerList');
    
	/**
	 * This controller uses following default pagination values
	 *
	 * @var array
	 */
	public $paginate = array(
		'limit' => 25
	);
    
	/**
	 * This controller uses following helpers
	 *
	 * @var array
	 */
	public $helpers = array('Js');
	
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->User->Authorization = $this->Authorization;
		
		if(isset($this->Security) &&  $this->request->is('ajax')){
			$this->Security->csrfCheck = false;
			$this->Security->validatePost = false;
		}
	}
	
	/**
	 * Used to display all users by Admin
	 *
	 * @access public
	 * @return array
	 */
	public function index( $group_id = null ) {
        if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
            
		$this->User->unbindModel( array('hasMany' => array('LoginToken')));
		
		$this->paginate = array(
			'limit' => USERS_USERS_INDEX_LIMIT
		);
		
		$this->data = empty($this->data)? $this->search : $this->data;
		$this->paginate = array_merge($this->paginate, array('conditions' => $this->User->search( $this->data )));
		
		if ($group_id) $this->paginate['conditions']['User.user_group_id'] = $group_id;
		
		$this->set('users', $this->paginate());
	}
	
	/**
	 * Used to display all online users by Admin
	 *
	 * @access public
	 * @return array
	 */
	public function online() {
        if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
            
		$this->paginate = array(
            'conditions' => array(
                'UserActivity.modified >' => (date('Y-m-d H:i:s', strtotime('-' . USERS_ONLINE_USER_TIME , time()))), 
                'UserActivity.logout' => 0
            ),
            'order' => 'UserActivity.modified desc', 
            'limit' => USERS_USERS_ONLINE_LIMIT,
            'recursive' => 2
            
        );
        
		$users = $this->paginate('UserActivity');
		$this->set('users', $users);
	}
	
	/**
	 * Used to edit user on the site by Admin
	 *
	 * @access public
	 * @param integer $id user id of user
	 * @return void
	 */
	public function edit( $id = null ) {
        if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
        
		$user = $this->User->findById( $id );
		
		if ( !$id || empty($user) ) {
			$this->Session->setFlash(__('Invalid user id!'), 'warning');
			$this->redirect(array('action' => 'index'));
		}
		
		if ( $this->request->is('put') ){
			if ( $this->User->saveAll( $this->data ) ){
				$this->Session->setFlash(__('User successfully saved!'), 'success');
				//$this->redirect(array('action' => 'index'));
                $this->set('redirect', array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'));
				echo json_encode(array('scuess' => true));
			}
		} else {
			$this->data = $this->User->findById( $id );
		}
		
		if ( !$groups = Cache::read('groups', 'daily') ){
			$groups = $this->UserGroup->find('list'/*, array('conditions' => array('UserGroup.allow_registration' => 1))*/);
			Cache::write('groups', $groups, 'daily');
		}
		
		$this->set('groups', $groups);
	}
	
	public function delete( $id = null ){
		$user = $this->User->findById( $id );
		
		if ( !$id || empty($user) ){
			$this->Session->setFlash(__('Invalid user id!'), 'warning');
			$this->redirect(array('action' => 'index'));	
		}
		
		if ( $this->User->deleteAll( array('User.id' => $user['User']['id']) ) ){			
			$this->Session->setFlash(__('User successfully deleted!'), 'success');
		} else {
			$this->Session->setFlash(__('User cannot be deleted!'), 'error');	
		}
		
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * Used to logged in the site
	 *
	 * @access public
	 * @return void
	 */
	public function login($connect = null, $from = null) {		
        $this->layout = 'login';
        $user = $this->Authorization->getUser();
        
		if ( $user ) {
			if( $connect ) {
				$this->render('popup');
			} else {
				$this->redirect( constant('USERS_USERS_LOGIN_' . strtoupper($user['Group']['name']) . '_REDIRECT_URL' ) );
			}
		}
        
		if ($connect == 'facebook'){
			$this->Session->read();
			$this->layout = null;
			$facebook = $this->Authorization->facebook();
			
			if(isset($_GET['error'])) {
				/* Do nothing user canceled authentication */
			} elseif(!empty($facebook['loginUrl'])) {
				$this->redirect($facebook['loginUrl']);
			} else {			
				$emailCheck = true;
				$user = $this->User->findByFbId($facebook['user_profile']['id']);
				
                if( empty($user) ) {
					$user = $this->User->findByEmail($facebook['user_profile']['email']);
					$emailCheck = false;
				}
                
				if(empty($user)) {
					if(USERS_SITE_REGISTRATION) {
						$user['User']['fb_id'] = $facebook['user_profile']['id'];
						$user['User']['fb_access_token'] = $facebook['user_profile']['accessToken'];
                        
						$user['User']['user_group_id'] = USERS_USER_GROUP_ID;
						$user['User']['username'] = $this->generateUserName($facebook['user_profile']['name']);
						$user['User']['password'] = $this->Authorization->generatePassword( $this->Authorization->generatePassword() );
						$user['User']['email'] = $facebook['user_profile']['email'];
						$user['User']['active'] = 1;
						$user['User']['email_verified'] = 1;
						
						$user['UserDetail']['first_name'] = $facebook['user_profile']['first_name'];
						$user['UserDetail']['last_name'] = $facebook['user_profile']['last_name'];
						$user['UserDetail']['gender'] = $facebook['user_profile']['gender'];
						$user['UserDetail']['photo'] = $photo;
						
                        
						$this->User->save($user, false);
						$userId=$this->User->getLastInsertID();
						$user['UserDetail']['user_id'] = $userId;
						$this->UserDetail->save($user, false);
						$user = $this->User->findById($userId);
						$this->Authorization->login($user);
						$this->Session->write('Authorization.FacebookLogin', true);
						$this->Session->write('Authorization.FacebookChangePass', true);
					} else {
						$this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later'));
					}
				} else {
					$login = false;
					
					if(!$emailCheck) {
						$user['User']['fb_id'] = $facebook['user_profile']['id'];
						$user['User']['fb_access_token'] = $facebook['user_profile']['accessToken'];
						$user['User']['email_verified'] = 1;
						$this->User->save($user, false);
						$login = true;
					} else if($user['User']['email_verified'] == 1) {
						$login = true;
					} else if($user['User']['email'] == $facebook['user_profile']['email']) {
						$user['User']['email_verified']=  1;
						$this->User->save($user, false);
						$login = true;
					}
					
					if($login) {
						$user = $this->User->findById($user['User']['id']);
						if ($user['User']['id'] != USERS_ADMIN_GROUP_ID && $user['User']['active'] == 0) {
							$this->Session->setFlash(__('Sorry your account is not active, please contact to Administrator'));
						} else {
							$this->Authorization->login($user);
							$this->Session->write('Authorization.FacebookLogin', true);
						}
					} else {
						$this->Session->setFlash(__('Sorry your email is not verified yet!'));
					}
				}
			}
			
			$this->Session->write('Authorization.Redirect', USERS_LOGIN_REDIRECT_URL);
			$this->render('popup');
		} elseif ( $connect == 'twitter' ) {
			$this->Session->read();
			$this->layout = null;
			
			$twitter = $this->Authorization->twitter();
			
			if(isset($_GET['denied'])) {
				$this->redirect('/login');
			} elseif(!isset($_GET['oauth_token'])) {
				$this->redirect($twitter['url']);
			} else {
				$user = $this->User->findByTwtId($twitter['user_profile']['id']);
				
				if(empty($user)) {
					if(USERS_SITE_REGISTRATION) {
						$user['User']['twt_id'] = $twitter['user_profile']['id'];
						$user['User']['twt_access_token'] = $twitter['user_profile']['accessToken'];
						$user['User']['twt_access_secret'] = $twitter['user_profile']['accessSecret'];
						$user['User']['user_group_id'] = DEFAULT_GROUP_ID;
						$user['User']['username'] = $this->generateUserName($twitter['user_profile']['screen_name']);
						$password = $this->Authorization->generatePassword();
						$user['User']['password'] = $this->Authorization->generatePassword($password);
						$name = preg_replace("/ /", "~", $twitter['user_profile']['name'], 1);
						$name = explode('~', $name);
						$user['User']['first_name'] = $name[0];
						$user['User']['last_name'] = (isset($name[1])) ? $name[1] : "";
						$user['User']['active'] = 1;
						$user['UserDetail']['location'] = $twitter['user_profile']['location'];
						$userImageUrl = 'http://api.twitter.com/1/users/profile_image?screen_name='.$twitter['user_profile']['screen_name'].'&size=original';
						$photo = $this->updateProfilePic($userImageUrl);
						$user['UserDetail']['photo'] = $photo;
						$this->User->save($user, false);
						$userId = $this->User->getLastInsertID();
						$user['UserDetail']['user_id'] = $userId;
						$this->UserDetail->save($user, false);
						$user = $this->User->findById($userId);
						$this->Authorization->login($user);
						$this->Session->write('Authorization.TwitterLogin', true);
						$this->Session->write('Authorization.TwitterChangePass', true);
					} else {
						$this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later'));
					}
				} else {
					if ($user['User']['id'] != 1 and $user['User']['active'] == 0) {
						$this->Session->setFlash(__('Sorry your account is not active, please contact to Administrator'));
					} else {
						$this->Authorization->login( $user );
						$this->Session->write('Authorization.TwitterLogin', true);
					}
				}
			}
			
			$this->render('popup');
		} elseif ($connect == 'gmail') {
			$this->Session->read();
			$this->layout=NULL;
			$gmailData = $this->Authorization->gmail();
			if(!isset($_GET['openid_mode'])) {
				$this->redirect($gmailData['url']);
			} else {
				if(!empty($gmailData)) {
					$user = $this->User->findByEmail($gmailData['email']);
					if(empty($user)) {
						if(USERS_SITE_REGISTRATION) {
							$user['User']['user_group_id']=DEFAULT_GROUP_ID;
							if(!empty($gmailData['name'])) {
								$user['User']['username']= $this->generateUserName($gmailData['name']);
							} else {
								$emailArr = explode('@', $gmailData['email']);
								$user['User']['username']= $this->generateUserName($emailArr[0]);
							}
							$password = $this->Authorization->generatePassword();
							$user['User']['password'] = $this->Authorization->generatePassword($password);
							$user['User']['first_name']=$gmailData['first_name'];
							$user['User']['last_name']=$gmailData['last_name'];
							$user['User']['email']=$gmailData['email'];
							$user['User']['active']=1;
							$user['User']['email_verified']=1;
							$user['UserDetail']['location']=$gmailData['location'];
							$this->User->save($user,false);
							$userId=$this->User->getLastInsertID();
							$user['UserDetail']['user_id']=$userId;
							$this->UserDetail->save($user,false);
							$user = $this->User->findById($userId);
							$this->Authorization->login($user);
							$this->Session->write('Authorization.GmailLogin', true);
							$this->Session->write('Authorization.GmailChangePass', true);
						} else {
							$this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later'));
						}
					} else {
						if($user['User']['email_verified'] !=1) {
							$user['User']['email_verified']=1;
							$this->User->save($user,false);
						}
						$user = $this->User->findById($user['User']['id']);
						if ($user['User']['id'] != 1 and $user['User']['active']==0) {
							$this->Session->setFlash(__('Sorry your account is not active, please contact to Administrator'));
						} else {
							$this->Authorization->login($user);
							$this->Session->write('Authorization.GmailLogin', true);
						}
					}
				}
			}
			$this->render('popup');
		} elseif ($connect == 'linkedin') {
			$this->Session->read();
			$this->layout=NULL;
			$ldnData = $this->Authorization->linkedin();
			if(!$_GET[LINKEDIN::_GET_RESPONSE]) {
				$this->redirect($ldnData['url']);
			} else {
				$ldnData = json_decode(json_encode($ldnData['user_profile']),TRUE);
				if(!empty($ldnData)) {
					$user = $this->User->findByLdnId($ldnData['id']);
					if(empty($user)) {
						if(USERS_SITE_REGISTRATION) {
							$user['User']['ldn_id']=$ldnData['id'];
							$user['User']['user_group_id']=DEFAULT_GROUP_ID;
							$user['User']['username']= $this->generateUserName($ldnData['first-name']. ' '.$ldnData['last-name']);
							$password = $this->Authorization->generatePassword();
							$user['User']['password'] = $this->Authorization->generatePassword($password);
							$user['User']['first_name']=$ldnData['first-name'];
							$user['User']['last_name']=$ldnData['last-name'];
							$user['User']['active']=1;
							if(isset($ldnData['picture-url'])) {
								$photo = $this->updateProfilePic($ldnData['picture-url']);
								$user['UserDetail']['photo']=$photo;
							}
							$this->User->save($user,false);
							$userId=$this->User->getLastInsertID();
							$user['UserDetail']['user_id']=$userId;
							$this->UserDetail->save($user,false);
							$user = $this->User->findById($userId);
							$this->Authorization->login($user);
							$this->Session->write('Authorization.LinkedinLogin', true);
							$this->Session->write('Authorization.LinkedinChangePass', true);
						} else {
							$this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later'));
						}
					} else {
						if ($user['User']['id'] != 1 and $user['User']['active']==0) {
							$this->Session->setFlash(__('Sorry your account is not active, please contact to Administrator'));
						} else {
							$this->Authorization->login($user);
							$this->Session->write('Authorization.LinkedinLogin', true);
						}
					}
				}
			}
			$this->render('popup');
		} elseif ($connect == 'foursquare') {
			$this->Session->read();
			$this->layout=NULL;
			$fsData = $this->Authorization->foursquare();
			if(!isset($_GET['code']) && !isset($_GET['error']) && empty($_SESSION['fs_access_token'])) {
				$this->redirect($fsData['url']);
			} else {
				$fsData = json_decode(json_encode($fsData['user_profile']),TRUE);
				if(!empty($fsData) && isset($fsData['user']['contact']['email'])) {
					$user = $this->User->findByEmail($fsData['user']['contact']['email']);
					if(empty($user)) {
						if(USERS_SITE_REGISTRATION) {
							$user['User']['user_group_id']=DEFAULT_GROUP_ID;
							$user['User']['username']= $this->generateUserName($fsData['user']['firstName']. ' '.$fsData['user']['lastName']);
							$password = $this->Authorization->generatePassword();
							$user['User']['password'] = $this->Authorization->generatePassword($password);
							$user['User']['email']=$fsData['user']['contact']['email'];
							$user['User']['first_name']=$fsData['user']['firstName'];
							$user['User']['last_name']=$fsData['user']['lastName'];
							$user['UserDetail']['gender']=$fsData['user']['gender'];
							if(isset($fsData['user']['photo'])) {
								$user['UserDetail']['photo']=$this->updateProfilePic($fsData['user']['photo']);
							}
							$user['User']['active']=1;
							$user['User']['email_verified']=1;
							$this->User->save($user,false);
							$userId=$this->User->getLastInsertID();
							$user['UserDetail']['user_id']=$userId;
							$this->UserDetail->save($user,false);
							$user = $this->User->findById($userId);
							$this->Authorization->login($user);
							$this->Session->write('Authorization.FoursquareLogin', true);
							$this->Session->write('Authorization.FoursquareChangePass', true);
						} else {
							$this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later'));
						}
					} else {
						if ($user['User']['id'] != 1 and $user['User']['active']==0) {
							$this->Session->setFlash(__('Sorry your account is not active, please contact to Administrator'));
						} else {
							$this->Authorization->login($user);
							$this->Session->write('Authorization.FoursquareLogin', true);
						}
					}
				}
			}
			$this->render('popup');
		} elseif ($connect == 'yahoo') {
			$this->Session->read();
			$this->layout=NULL;
			$yahooData = $this->Authorization->yahoo();
			if(!isset($_GET['openid_mode'])) {
				$this->redirect($yahooData['url']);
			} else {
				if(!empty($yahooData)) {
					$user = $this->User->findByEmail($yahooData['email']);
					if(empty($user)) {
						if(USERS_SITE_REGISTRATION) {
							$user['User']['user_group_id']=DEFAULT_GROUP_ID;
							if(!empty($yahooData['name'])) {
								$user['User']['username']= $this->generateUserName($yahooData['name']);
							} else {
								$emailArr = explode('@', $yahooData['email']);
								$user['User']['username']= $this->generateUserName($emailArr[0]);
							}
							$password = $this->Authorization->generatePassword();
							$user['User']['password'] = $this->Authorization->generatePassword($password);
							$user['User']['first_name']=$yahooData['first_name'];
							$user['User']['last_name']=$yahooData['last_name'];
							$user['User']['email']=$yahooData['email'];
							$user['User']['active']=1;
							$user['User']['email_verified']=1;
							$user['UserDetail']['gender']=$yahooData['gender'];
							$this->User->save($user,false);
							$userId=$this->User->getLastInsertID();
							$user['UserDetail']['user_id']=$userId;
							$this->UserDetail->save($user,false);
							$user = $this->User->findById($userId);
							$this->Authorization->login($user);
							$this->Session->write('Authorization.YahooLogin', true);
							$this->Session->write('Authorization.YahooChangePass', true);
						} else {
							$this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later'), 'info');
						}
					} else {
						if($user['User']['email_verified'] !=1) {
							$user['User']['email_verified']=1;
							$this->User->save($user,false);
						}
						if ($user['User']['id'] != 1 and $user['User']['active']==0) {
							$this->Session->setFlash(__('Sorry your account is not active, please contact to Administrator'), 'warning');
						} else {
							$this->Authorization->login($user);
							$this->Session->write('Authorization.YahooLogin', true);
						}
					}
				}
			}
			$this->render('popup');
		} else {
			if ($this->request -> is('post')) {
				$this->User->set($this->data);
                
				$this->User->validate = $this->User->validateLogin;
				
				if ( $this->User->validates() ) {
					$email  = $this->data['User']['email'];
					$password = $this->data['User']['password'];
					$user = $this->User->findByUsername($email);
                    
					if (empty($user)) {
						$user = $this->User->findByEmail($email);
						
						if ( empty($user) ) {
							$this->Session->setFlash(__('Incorrect E-mail / Username or Password'), 'warning');
							return;
						}
					}
                    
					if ( $user['User']['password'] === $this->Authorization->makePassword($password, $user['User']['salt']) ) {
						// check for inactive account
						if ($user['User']['user_group_id'] != USERS_ADMIN_GROUP_ID && $user['User']['active'] == 0) {
							$this->Session->setFlash(__('Sorry your account is not active, please contact the Administrator!'), 'warning');
							return;
						}
                        
						// check for verified account
						if ($user['User']['user_group_id'] != USERS_ADMIN_GROUP_ID && $user['User']['email_verified'] == 0) {
							$this->Session->setFlash(__('Your email has not been confirmed please verify your email or contact the Administrator'), 'warning');
							return;
						}
                        
						$this->Authorization->login( $user, null, (bool)$this->data['User']['remember']);
                        
						$redirect = $this->Session->read('Authorization.Redirect');
						$this->Session->delete('Authorization.Redirect');
						
						$redirect = (!empty($redirect)) ? $redirect : constant('USERS_USERS_LOGIN_' . strtoupper($user['Group']['name']) . '_REDIRECT_URL' );
                        
						$this->redirect($redirect);
					} else {
						$this->Session->setFlash(__('Incorrect E-mail / Username or Password'), 'warning');
						return;
					}
				}
			}
		}
		
		$this->set('title_for_layout', __('Login'));
	}
    
	/**
	 * Used to generate unique username
	 *
	 * @access private
	 * @return String
	 */
	private function generateUserName($name = null) {
		$username = '';
		
		if(!empty($name)) {
			$username = str_replace(' ', '', strtolower($name));
			while ($this->User->findByUsername($username)) {
				$username = str_replace(' ', '', strtolower($name)) . '_' . rand(1000, 9999);
			}
		}
		
		return $username;
	}
	
	/**
	 * Used to logged out from the site
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->Authorization->logout();        
        $this->redirect(USERS_LOGOUT_REDIRECT_URL);
	}
	
	/**
	 * Used to register on the site
	 *
	 * @access public
	 * @return void
	 */
	public function register() {
 		$this->layout = 'login';
        
        if ( $this->Authorization->getUser() ){
            $this->redirect( constant('USERS_LOGIN_' . strtoupper($user['Group']['name']) . '_REDIRECT_URL' ) );
        }
        
        if ( USERS_SITE_REGISTRATION ) {
            
            if ($this->request->is('post')) {
                $this->User->set( $this->request->data );
                $this->UserDetail->set( $this->request->data );
                
                //swich validate to register
                $this->User->validate = $this->User->validateRegister;
            
                $valid_user = $this->User->validates();
                $valid_user_detail = $this->UserDetail->validates();
                
                if ( $valid_user && $valid_user_detail ){
                    $this->request->data['User']['user_group_id'] = USERS_USER_GROUP_ID;
                    $this->request->data['User']['active'] = 1;
                    
                    if ( !USERS_USERS_REGISTER_SEND_VERIFICATION_MAIL ) {
						$this->request->data['User']['email_verified'] = 1;
					}
                    
                    if ( $this->User->saveAll( $this->request->data ) ){
                        $user = $this->User->read();
                    
                        if (USERS_USERS_REGISTER_SEND_REGISTRATION_MAIL && !USERS_USERS_REGISTER_SEND_VERIFICATION_MAIL) {
    						$this->User->sendRegistrationMail( $user );
    					}
                        
    					if (USERS_USERS_REGISTER_SEND_VERIFICATION_MAIL) {
    						$this->User->sendVerificationMail( $user );
    					}
                        
    					if ( isset($user['User']['active']) && $user['User']['active'] && !USERS_USERS_REGISTER_SEND_VERIFICATION_MAIL) {
    						$this->Authorization->login( $user );
                            
                            $this->Session->setFlash(__('Registration has been successful!'), 'success');
                            $this->redirect( USERS_USERS_REGISTER_REDIRECT_URL );
    					} else {
    						$this->Session->setFlash(__('Please check your mail and confirm your registration'), 'info');
    						$this->redirect(array('action' => 'login'));
    					}
                    } else {
                        $this->Session->setFlash(__('An error occurred. Please try again later!'), 'error');
                        $this->redirect( array('action' => 'register') );
                    }
                    
    			} else{
             	    $this->Session->setFlash(__('Please complete all the required fields!'), 'warning');
        	    }
            }
        } else {
        	$this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later!'), 'info');
        	$this->redirect(array('action' => 'login'));
		}
		
		$this->set('title_for_layout', __('Register'));
	}
	
	/**
	 * Used to verify email of user by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function verifyEmail($userId = null) {
		$page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1;
		$msg="Sorry there was a problem, please try again";
		$status=0;
		if (!empty($userId)) {
			if ($this->request -> isPost() || $this->request->is('ajax')) {
				$this->User->updateAll(array('User.email_verified'=>1), array('User.id'=>$userId));
				$msg = __('User email is successfully verified');
				$status=1;
			}
		}
		if($this->request->is('ajax')) {
			$this->set('userId', $userId);
			$this->set('result', $status);
			$this->set('funcName', 'verifyEmail');
			$this->set('updateMsg', $msg);
			$this->render('Elements/update_div');
		} else {
			$this->Session->setFlash($msg);
			$this->redirect(array('action'=>'index', 'page'=>$page));
		}
	}
	/**
	 * Used to show access denied page if user want to view the page without permission
	 *
	 * @access public
	 * @return void
	 */
	public function accessDenied() {
        $this->layout = 'default';
	}
    
	/**
	 * Used to verify user's email address
	 *
	 * @access public
	 * @return void
	 */
	public function verification( $id = null, $key = null ) {
		$user = $this->User->findById($id);
        
		if ( !empty($user) ) {
            $this->Authorization->login( $user );
            
			if ( !$user['User']['email_verified'] ) {
				$theKey = $this->User->getActivationKey( $user['User']['password'] );
                
				if ($key == $theKey) {
					$user['User']['email_verified'] = 1;
					$this->User->save($user, false);
					
                    if (USERS_USERS_REGISTER_SEND_REGISTRATION_MAIL) {
						$this->User->sendRegistrationMail($user);
					}
                                                
					$this->Session->setFlash(__('Thank you, your account is activated now'), 'success');
                    
                    $this->redirect( USERS_USERS_REGISTER_REDIRECT_URL );
				}
			} else {
				$this->Session->setFlash(__('Your account is already activated'), 'info');
                $this->redirect( constant('USERS_USERS_LOGIN_' . strtoupper($user['Group']['name']) . '_REDIRECT_URL' ) );
			}
		} else {
			$this->Session->setFlash(__('Sorry something went wrong, please click on the link again'), 'warning');
            $this->redirect(array('action' => 'login'));
        }
	}
    
	/**
	 * Used to send forgot password email to user
	 *
	 * @access public
	 * @return void
	 */
	public function forgotPassword() {
        $this->layout = 'login';
        if ( $this->request->is('ajax') )
            $this->layout = 'ajaxify';
        
        //swich validate to forgot password
        $this->User->validate = $this->User->validateForgotPassword;
            
		if ($this->request->is('post')) {
			$this->User->set($this->request->data);
        
			if ( $this->User->validates() ) {
				$email  = $this->data['User']['email'];
				$user = $this->User->findByUsername($email);

				if (empty($user)) {
					$user = $this->User->findByEmail($email);
                    
					if (empty($user)) {
						$this->Session->setFlash(__('This email does not exist in our database!'), 'warning');
						return;
					}
				}
                
				// check for unverified account
				if ($user['Group']['id'] != USERS_ADMIN_GROUP_ID && $user['User']['email_verified'] == 0) {
					$this->Session->setFlash(__('Your registration has not been confirmed yet please verify your email before reset password'), 'info');
					return;
				}
                
				$this->User->sendForgotPasswordMail($user);
				$this->Session->setFlash(__('Please check your mail for reset your password'), 'success');
				$this->redirect(array('action' => 'login'));
			}
		}
		
		$this->set('title_for_layout', __('Recover password'));
	}
    
	/**
	 * Used to send email verification mail to user
	 *
	 * @access public
	 * @return void
	 */
	public function emailVerification() {
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			
			$this->User->validate = $this->User->validateLogin;
			
			if ($this->User->validates()) {
				$email  = $this->data['User']['email'];
				$user = $this->User->findByUsername($email);
				if (empty($user)) {
					$user = $this->User->findByEmail($email);
					if (empty($user)) {
						$this->Session->setFlash(__('Incorrect Email / Username'), 'warning');
						return;
					}
				}
				if($user['User']['email_verified']==0) {
					$this->User->sendVerificationMail($user);
					$this->Session->setFlash(__('Please check your mail to verify your email'), 'success');
				} else {
					$this->Session->setFlash(__('Your email is already verified'), 'info');
				}
				$this->redirect('/login');
			}
		}
	}
	/**
	 *  Used to reset password when user comes on the by clicking the password reset link from their email.
	 *
	 * @access public
	 * @return void
	 */
	public function activatePassword() {
		if ($this->request -> isPost()) {
			if (!empty($this->data['User']['ident']) && !empty($this->data['User']['activate'])) {
				$this->set('ident',$this->data['User']['ident']);
				$this->set('activate',$this->data['User']['activate']);
				$this->User->set($this->data);
				if ($this->User->RegisterValidate()) {
					$userId= $this->data['User']['ident'];
					$activateKey= $this->data['User']['activate'];
					$user = $this->User->read(null, $userId);
					if (!empty($user)) {
						$password = $user['User']['password'];
						$thekey =$this->User->getActivationKey($password);
						if ($thekey==$activateKey) {
							$user['User']['password']=$this->data['User']['password'];
							$salt = $this->Authorization->makeSalt();
							$user['User']['salt']= $salt;
							$user['User']['password'] = $this->Authorization->makePassword($user['User']['password'], $salt);
							$this->User->save($user,false);
							$this->Session->setFlash(__('Your password has been reset successfully'));
							$this->redirect('/login');
						} else {
							$this->Session->setFlash(__('Something went wrong, please send password reset link again'));
						}
					} else {
						$this->Session->setFlash(__('Something went wrong, please click again on the link in email'));
					}
				}
			} else {
				$this->Session->setFlash(__('Something went wrong, please click again on the link in email'));
			}
		} else {
			if (isset($_GET['ident']) && isset($_GET['activate'])) {
				$this->set('ident',$_GET['ident']);
				$this->set('activate',$_GET['activate']);
			}
		}
	}
    
    /**
     * Used to edit account details
     */
     public function account(){
        $this->layout = 'default';
        
        if ( $this->request->is('put') ){            
            if ( $this->User->saveAll($this->request->data) ){
				$this->__deleteUserCache();
				
                $this->Session->setFlash(__('Account details have been successfully changed!'), 'success');   
                $this->redirect(array('action' => 'account')); 
            }    
        } else {
            $this->request->data = $this->User->findById($this->Authorization->User->id()); 
        }
     }
     
     /**
     * Used to change password
     */
     public function changePassword(){
        $this->layout = 'default';
        $this->User->validate = $this->User->validateChangePassword;
		
        if ( $this->request->is('put') ){
            if ( $this->User->save($this->request->data) ){
				$this->Session->delete('Authorization.FacebookChangePass');
				$this->__deleteUserCache();
				
                $this->Session->setFlash(__('Password was successfully changed!'), 'success');   
                $this->redirect(array('action' => 'changePassword')); 
            }
        } else {
            $this->request->data = $this->User->findById($this->Authorization->User->id()); 
        }
     }
	
	/**
	 *  Used to update profile pic from given url
	 *
	 * @access private
	 * @param integer $file_location url of pic
	 * @return String
	 */
	private function updateProfilePic($file_location) {
		$fullpath= WWW_ROOT."img".DS.IMG_DIR;
		$res1 = is_dir($fullpath);
		if($res1 != 1) {
			$res2= mkdir($fullpath, 0777, true);
		}
		$imgContent = file_get_contents($file_location);
		$photo=time().mt_rand().".jpg";
		$tempfile=$fullpath.DS.$photo;
		$fp = fopen($tempfile, "w");
		fwrite($fp, $imgContent);
		fclose($fp);
		return $photo;
	}
	
	private function __deleteUserCache(){
		Cache::delete('user_'.$this->Authorization->User->id(), 'users');
	}
}