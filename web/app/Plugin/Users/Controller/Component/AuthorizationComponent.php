<?php
class AuthorizationComponent extends Component {
	/**
	 * This component uses following components
	 *
	 * @var array
	 */
	public $components = array('Session', 'Cookie', 'RequestHandler', 'Users.User', 'Users.Ssl');
	
	/**
	 * configur key
	 *
	 * @var string
	 */
	public $configureKey = 'users';

	function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
	}
	
	function initialize($controller) {
	}

	function startup(&$controller = null) {
		$this->authorize(&$controller);
	}
	
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @param object $c current controller object
	 * @return void
	 */
	function authorize(&$controller) {
		$user = $this->getUser();
		
		$pageRedirect = $controller->Session->read('permission_error_redirect');
		$controller->Session->delete('permission_error_redirect');
		$action = $controller->params['action'];
		$actionUrl = $controller->params['controller'].'/'.$action;
		$this->updateActivity($controller, $actionUrl);
		$requested = (isset($controller->params['requested']) && $controller->params['requested'] == 1) ? true : false;
		
		if ( !in_array($actionUrl, unserialize(PERMISSION_FREE)) && empty($pageRedirect) && !$requested && !in_array($controller->params['controller'], array('css', 'img')) ) {
            App::import("Model", "Users.UserGroup");
			$userGroupModel = new UserGroup();
			
			if ( !$this->User->isLogged() ){
                if ( !$userGroupModel->isGuestAccess($controller->params['controller'], $action) ) {
					$controller->Session->write('permission_error_redirect', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
					$controller->Session->setFlash(__('You need to be signed in to view this page!'), 'warning');
					$cUrl = '/'.$controller->params->url;
                    
					if(!empty($_SERVER['QUERY_STRING'])) {
						$rUrl = $_SERVER['REQUEST_URI'];
						$pos = strpos($rUrl, $cUrl);
						$cUrl = substr($rUrl, $pos, strlen($rUrl));
					}
					
					if($controller->request->is('ajax')) {
						$controller->Session->write('Authorization.Redirect', $_SERVER['HTTP_REFERER']);
						$controller->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
					}
					
					$controller->Session->write('Authorization.Redirect', $cUrl);
                    $controller->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));
				}
			} else {
				if (!$userGroupModel->isUserGroupAccess($controller->params['controller'], $action, $this->User->Group->id())) {
					$controller->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'accessDenied'));
				}
			}
		} elseif ( !empty($pageRedirect) ){
			$controller->redirect($pageRedirect);	
		}
		
        $this->setLanguage( $this->getLanguage() );
	}
	
	/**
	 * Used to get user from session
	 *
	 * @access public
	 * @return array
	 */
	public function getUser() {
		$user = $this->Cookie->read('Authorization');

		if ( is_array($user) ){
			$this->Cookie->write('Authorization', $user);
			$this->Session->write('Authorization', $user);
		}

		return $this->Session->read('Authorization');
	}
    
    private function setLanguage( $language = 'eng' ){
		/**
		* Configure user language
		*/
		Configure::write('Config.language', $language);
	}
    
    private function getLanguage(){
		return $this->Session->read('Authorization.UserDetail.language');
	}
	
	function beforeRender(&$controller) {
		if(defined('USE_HTTPS') && USE_HTTPS) {
			$this->Ssl->force($controller);
		} else {
			$actionUrl = strtolower($controller->params['controller'].'/'.$controller->params['action']);
			
			if(defined('HTTPS_URLS')) {
				$httpsUrls = explode(',', strtolower(HTTPS_URLS));
				$httpsUrls = array_map('trim', $httpsUrls);
				
				if(in_array($actionUrl, $httpsUrls)) {
					$this->Ssl->force($controller);
				} else {
					$this->Ssl->unforce($controller);
				}
			}
		}
		
		$user = array();
		
		if ( $this->User->id() ) {
			if ( !$user = Cache::read('user_' . $this->User->id() , 'users') ){
				App::import("Model", "Users.User");
				$userModel = new User();
				$user = $userModel->findById( $this->User->id() );
				
				Cache::write('user_' . $this->User->id(), $user, 'users');
			}
		}
		
		if(isset($user['LoginToken'])){
			unset($user['LoginToken']);
		}
		
		if(isset($user['Search'])) {
			unset($user['Search']);
		}
		
		$controller->set('var', $user);
	}
	
	public function exist(){
		return ($this->User->id() !== null);	
	}
	
	/**
	 * Used to check is admin logged in
	 *
	 * @access public
	 * @return string
	 */
	public function isAdmin() {
		$idName = $this->Session->read('Authorization.UserGroup.idName');
        
		return isset($idName[USERS_ADMIN_GROUP_ID]);
	}
	
	/**
	 * Used to check is guest logged in
	 *
	 * @access public
	 * @return string
	 */
	public function isGuest() {
		$idName = $this->Session->read('Authorization.UserGroup.idName');
        
		return empty($idName);
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
	 * Used to generate random password
	 *
	 * @access public
	 * @return string
	 */
	public function generatePassword()  {
		$rand = mt_rand(0, 32);
		$newpass = md5($rand . time());
		$newpass = substr($newpass, 0, 7);
		
		return md5($newpass);
	}
	
	/**
	 * Used to maintain login session of user
	 *
	 * @access public
	 * @param mixed $type possible values 'guest', 'cookie', user array
	 * @param string $credentials credentials of cookie, default null
	 * @return array
	 */
	public function login($user = 'guest', $credentials = null, $remember = false ) {
		App::import("Model", "Users.User");
		$userModel = new User();
		
		if (is_string($user) && ($user == 'guest' || $user == 'cookie')) {
			$user = $userModel->authsomeLogin($user, $credentials);
		}
		
		if ( $remember ){
			$this->Cookie->write('Authorization', $user, false, '1 day');
		}
		
		$this->Session->write('Authorization', $user);
		
		if ( isset($user['User']['id']) ){
			$user['User']['last_login'] = date('Y-m-d h:i:s');
			$userModel->save($user, false);
		}
		
		return $user;
	}
    
    /**
	 *
	 *
	 * @return array
	 */
	function facebook() {
		App::import("Vendor", "Users.facebook/facebook");
        
		$response = array();
		$facebook = new Facebook(array('appId'  => FACEBOOK_APP_ID, 'secret' => FACEBOOK_SECRET));
		$user = $facebook->getUser();
        
		if( $user ) {
			try {
				$response['user_profile'] = $facebook->api('/me');
				$response['user_profile']['accessToken'] = $facebook->getAccessToken();
			} catch (FacebookApiException $e) {
				$user = null;
			}
		}
        
		if($user) {
			$response['logoutUrl'] = $facebook->getLogoutUrl();
			$response['loginUrl'] = '';
		} else {
			$response['loginUrl'] = $facebook->getLoginUrl(array('canvas' => 1, 'fbconnect' => 0, 'display' => 'popup', 'scope'=> FACEBOOK_SCOPE));
			$response['logoutUrl'] = '';
		}
        
		return $response;
	}
    
	/**
	 *
	 *
	 * @return array
	 */
	function twitter() {
		App::import("Vendor", "Users.twitter/EpiCurl");
		App::import("Vendor", "Users.twitter/EpiOAuth");
		App::import("Vendor", "Users.twitter/EpiTwitter");
        
		$twitterObj = new EpiTwitter(TWITTER_APP_ID, TWITTER_SECRET);
		$response = array();
        $response['url'] = $twitterObj->getAuthorizationUrl();
        
		if(isset($_GET['oauth_token'])) {
			$twitterObj->setToken($_GET['oauth_token']);
			$token = $twitterObj->getAccessToken();
			$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
			$_SESSION['ot'] = $token->oauth_token;
			$_SESSION['ots'] = $token->oauth_token_secret;
			$user_profile = $twitterObj->get_accountVerify_credentials()->response;
			$twtToken = $token->oauth_token;
			$twtSecret = $token->oauth_token_secret;
		}
        
		$response['user_profile'] = (isset($user_profile)) ? $user_profile : '';
		$response['user_profile']['accessToken'] = (isset($twtToken)) ? $twtToken : '';
		$response['user_profile']['accessSecret'] = (isset($twtSecret)) ? $twtSecret : '';
        
		return $response;
	}
    
	/**
	 *
	 *
	 * @return array
	 */
	function gmail() {
		App::import('Vendor', 'Users.openid/Lightopenid');

		$openid = new Lightopenid($_SERVER['SERVER_NAME']);
        $response = array();
                
		if($openid->mode == 'cancel') {
			/* Do nothing user canceled authentication */
		} elseif(isset($_GET['openid_mode'])) {
			$ret = $openid->getAttributes();
            
			if(isset($ret['contact/email']) && $openid->validate()) {
				$response['email'] = $ret['contact/email'];
				$response['first_name'] = $ret['namePerson/first'];
				$response['last_name'] = $ret['namePerson/last'];
				$response['name'] = $ret['namePerson/first']." ".$ret['namePerson/last'];
				$response['location'] = (isset($ret['contact/country/home'])) ? $ret['contact/country/home'] : "";
			}
		} else {
			$openid->identity = "https://www.google.com/accounts/o8/id";
			$openid->required = array('contact/email', 'namePerson', 'person/gender', 'contact/country/home', 'namePerson/first', 'namePerson/last', 'pref/language');
			$openid->returnUrl = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'gmail'), true);//SITE_URL.'login/gmail';
			$response['url'] = $openid->authUrl();
		}
		return $response;
	}
    
	/**
	 *
	 *
	 * @return array
	 */
	function linkedin() {
		App::import("Vendor", "Users.linkedin/linkedin_3.2.0.class");
		$response = array();
		$user_profile = array();
		$ldnToken = '';
		$ldnSecret = '';
		$API_CONFIG = array('appKey' => LINKEDIN_API_KEY, 'appSecret' => LINKEDIN_SECRET_KEY, 'callbackUrl' => NULL );
        
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
			$protocol = 'https';
		} else {
			$protocol = 'http';
		}
        
		$API_CONFIG['callbackUrl'] = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'linkedin'), true). '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
		$OBJ_linkedin = new LinkedIn($API_CONFIG);
		
        // check for response from LinkedIn
		$_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
		
        if(!$_GET[LINKEDIN::_GET_RESPONSE]) {
			// LinkedIn hasn't sent us a response, the user is initiating the connection
			// send a request for a LinkedIn access token
			$response = $OBJ_linkedin->retrieveTokenRequest();
			if($response['success'] === TRUE) {
				// store the request token
				$_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
				// redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
				$response['url'] = LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token'];
			} else {
				// bad token request
				$response['Request_Token_Failed_Response']=$response;
				$response['Request_Token_Failed_Linkedin']=$OBJ_linkedin;
			}
		} else {
			// LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
			$response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier']);
			if($response['success'] === TRUE) {
				// the request went through without an error, gather user's 'access' tokens
				$_SESSION['oauth']['linkedin']['access'] = $response['linkedin'];
				// set the user as authorized for future quick reference
				$_SESSION['oauth']['linkedin']['authorized'] = TRUE;
				// redirect the user back to the demo page
				//header('Location: ' . $_SERVER['PHP_SELF']);
				$response = $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url)');
				if($response['success'] === TRUE) {
					$user_profile = new SimpleXMLElement($response['linkedin']);
					$ldnSecret=$_SESSION['oauth']['linkedin']['request']['oauth_token_secret'];
					$ldnToken=$_SESSION['oauth']['linkedin']['request']['oauth_token'];
				} else {
					// request failed
					$user_profile='';
					$ldnSecret=$_SESSION['oauth']['linkedin']['request']['oauth_token_secret'];
					$ldnToken=$_SESSION['oauth']['linkedin']['request']['oauth_token'];
				}
			} else {
				// bad token access
				$response['Request_Token_Failed_Response']=$response;
				$response['Request_Token_Failed_Linkedin']=$OBJ_linkedin;
			}
		}
		$response['user_profile']=$user_profile;
		return $response;
	}
    
	/**
	 *
	 *
	 * @return array
	 */
	function foursquare() {
		App::import("Vendor", "Users.foursquare/EpiCurl");
		App::import("Vendor", "Users.foursquare/EpiFoursquare");
        
		$response = array();
		$foursquareObj = new EpiFoursquare(FOURSQUARE_CLIENT_ID, FOURSQUARE_CLIENT_SECRET);
		$redirectUri = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'foursquare'), true);
        
		if(!isset($_GET['code']) && !isset($_SESSION['fs_access_token'])) {
			$url = $foursquareObj->getAuthorizeUrl($redirectUri);
			$response['url'] = $url;
		} else {
			if(!isset($_SESSION['fs_access_token'])) {
				$token = $foursquareObj->getAccessToken($_GET['code'], $redirectUri);
				//setcookie('fs_access_token', $token->access_token);
				$_SESSION['fs_access_token'] = $token->access_token;
			}
			$foursquareObj->setAccessToken($_SESSION['fs_access_token']);
			$foursquareInfo = $foursquareObj->get('/users/self');
			$user_profile= (array) $foursquareInfo->response;
			$fsToken=$_SESSION['fs_access_token'];
		}
		$response['user_profile'] = (isset($user_profile)) ? $user_profile : '';
		$response['user_profile']['accessToken'] = (isset($fsToken)) ? $fsToken : '';
        
		return $response;
	}
    
	/**
	 *
	 *
	 * @return array
	 */
	function yahoo() {
		App::import('Vendor', 'Users.openid/Lightopenid');
        
		$response = array();
		$openid = new Lightopenid($_SERVER['SERVER_NAME']);

		if($openid->mode == 'cancel') {
			/* Do nothing user canceled authentication */
		} elseif(isset($_GET['openid_mode'])) {
			$ret = $openid->getAttributes();
			if(isset($ret['contact/email']) && $openid->validate()) {
				$response['email'] = $ret['contact/email'];
				$response['name'] = $ret['namePerson'];
                
				if($ret['person/gender'] == "F")
					$response['gender'] = 'female';
				else
					$response['gender'] = 'male';
                    
				$name = explode(' ', $ret['namePerson']);
				$response['first_name'] = $name[0];
				$last_name = '';
                
				if(isset($name[2])) {
					unset($name[0]);
					$last_name = implode(' ', $name);
				} else if(isset($name[1])) {
					$last_name = $name[1];
				}
                
				$response['last_name'] = $last_name;
			}
		} else {
			$openid->identity = "http://me.yahoo.com/";
			$openid->required = array('contact/email', 'namePerson', 'person/gender');
			$openid->returnUrl = Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'yahoo'), true);
			$response['url']=$openid->authUrl();
		}
		return $response;
	}
	
	/**
	 * Used to delete user session and cookie
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->deleteActivity( $this->User->id() );
		Cache::delete('user_' . $this->User->id(), 'users');
		$this->Cookie->delete('Authorization');
		
		$this->__clearSession();
	}
	
	/**
	 * Used to delete social network session
	 *
	 * @access public
	 * @return void
	 */
	private function __clearSession() {
		$this->Session->delete('Authorization');
		$this->Session->delete("fb_".FACEBOOK_APP_ID."_code");
		$this->Session->delete("fb_".FACEBOOK_APP_ID."_access_token");
		$this->Session->delete("fb_".FACEBOOK_APP_ID."_user_id");
		$this->Session->delete("ot");
		$this->Session->delete("ots");
		$this->Session->delete("oauth.linkedin");
		$this->Session->delete("fs_access_token");
		$this->Session->delete("G_token");
	}
	
	/**
	 * Used to get login as guest
	 *
	 * @access private
	 * @return array
	 */
	private function __useGuestAccount() {
		return $this->login('guest');
	}
	
	/**
	 * Used to update update activities of user or a guest
	 *
	 * @access private
	 * @return void
	 */
	private function updateActivity($c, $actionUrl) {		
		if( !in_array($actionUrl, explode(', ', USERS_NOT_AIMED_ACTIONS)) ) {
			$useragent = $this->Session->read('Config.userAgent');
			$user_id = $this->User->id();
			$last_action = $this->Session->read('Config.time');
			$last_url = $c->here;
			$user_browser = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : "";
			$ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : "";

			App::import("Model", "Users.UserActivity");
			$activityModel = new UserActivity();
			$activityModel->id = null;
			$activity = $activityModel->findByUseragent($useragent);
			
            if(!empty($activity['UserActivity']['logout'])) {
				$c->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'));
			}
            
			if(!empty($res['UserActivity']['deleted'])) {
				$c->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout'));
			}
            
			$status = ($user_id) ? 1 : 0;
			$activity['UserActivity']['useragent'] = $useragent;
			$activity['UserActivity']['user_id'] = $user_id;
			$activity['UserActivity']['last_action'] = $last_action;
			$activity['UserActivity']['last_url'] = $last_url;
            $activity['UserActivity']['params'] = json_encode($c->request->params);
			$activity['UserActivity']['user_browser'] = $user_browser;
			$activity['UserActivity']['ip_address'] = $ip;
			$activity['UserActivity']['status'] = $status;
			unset($activity['UserActivity']['modified']);
			$activityModel->save($activity, false);
		}
	}
	
	/**
	 * Used to delete activity after logout
	 *
	 * @access public
	 * @return void
	 */
	public function deleteActivity( $user_id ) {
		if(!empty($user_id)) {
			App::import("Model", "Users.UserActivity");
			$activityModel = new UserActivity();
			$activityModel->deleteAll(array('UserActivity.user_id' => $user_id), false);
		}
	}
}