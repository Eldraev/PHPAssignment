<?php

require_once($_SERVER['DOCUMENT_ROOT'].'view/LoginView.php');
require_once($_SERVER['DOCUMENT_ROOT'].'view/DateTimeView.php');
require_once($_SERVER['DOCUMENT_ROOT'].'view/LayoutView.php');
require_once($_SERVER['DOCUMENT_ROOT'].'view/RegisterView.php');
require_once($_SERVER['DOCUMENT_ROOT'].'model/ServerTime.php');
require_once($_SERVER['DOCUMENT_ROOT'].'model/User.php');
require_once($_SERVER['DOCUMENT_ROOT'].'model/UserDB.php');

class LoginController {
	
	private $name;		// used to determine if the put in name should be rendered again
	private $udb;		// user database
	private $isLoggedIn;
	private $view;
	private $dtView;
	private $logView;
	private $regView;
	private $msg;		// message to be shown (e.g. in case of errors)
	
	public function __construct(LoginView $lv, LayoutView $v, DateTimeView $dtv, RegisterView $rv) {
		$this->udb = new UserDB();
		$this->msg = '';
		$this->view = $v;
		$this->dtView = $dtv;
		$this->logView = $lv;
		$this->regView = $rv;
		$this->isLoggedIn = $this->checkLogin();
		$this->checkRegistration();
		
		$this->render();
	}
	
	private function checkRegistration() {
		// Check if we transition from the login to the registration
		if($this->logView->getRequestRegister() != '') {
			$_SESSION['reg'] = 'register';
			return;
		}
		// Check if we want to register
		if($this->regView->getRequestRegister() != '' AND $_SESSION['reg'] == 'register') {
			$InputName = $this->regView->getRequestUserName();
			$InputPassword = $this->regView->getRequestPassword();
			$InputPassAgain = $this->regView->getRequestPassAgain();
			// Check if the user can be register DATABASE!!
			// Check for too short input
			if(strlen($InputName) < 3)
				$this->msg = "Username has too few characters, at least 3 characters.<br>";
			else if(strlen($InputPassword) < 6)
				$this->msg = $this->msg.'Password has too few characters, at least 6 characters.<br>';
			// Check if the password is repeated correctly
			else if($InputPassword != $InputPassAgain)
				$this->msg = $this->msg.'Passwords do not match.<br>';
			// Check if the name contains not allowed symbols
			else if(strstr($InputName,'<') != FALSE)
				$this->msg = $this->msg.'Username contains invalid characters.<br>';
			// Check if the user already exists in the database
			else if($this->udb->indexInDB(new User($InputName,$InputPassword)) != -1)
				$this->msg = $this->msg.'User exists, pick another username.<br>';
			else {
				// Passed all previous checks -> can be used now
				$this->udb->saveUserInDB(new User($InputName,$InputPassword));
				$this->msg = 'Registered new user.';
				$_SESSION['reg'] = '';
				
			}
			$this->name = $InputName;
		}
		// If we don't want to register check if we want to return to login
		else if($this->view->getRequestLogin() != '')
			$_SESSION['reg'] = '';
	}
	
	private function checkLogin() {
		// Get the login information
		$InputName = $this->logView->getRequestUserName();
		$InputPassword = $this->logView->getRequestPassword();
		$InputUser = new User($InputName,$InputPassword);
	
		// First check if the user is currently logging out
		if($this->logView->getRequestLogout() == 'logout') {
			// Check if the user is already logged out and if so don't allow logout
			if(!empty($_SESSION['uname']) && !empty($_SESSION['pw'])) {
				$this->msg = 'Bye bye!';
				$_SESSION['uname'] = '';
				$_SESSION['pw'] = '';
			}
			return false;
		}
		
		// Then check if the user is already logged in using session variables
		if(isset($_SESSION['uname']) && isset($_SESSION['pw'])) {
			if(!empty($_SESSION['uname']) && !empty($_SESSION['pw'])) {
				$this->msg = '';
				return true;
			}
		}
		
		// If the user is not already logged in check for a login attempt
		
		// Check for missing username
		if($InputName == '') {
			if($this->logView->getRequestLogin() == 'login') {
				$this->msg = 'Username is missing';
				return false;
			}
		}
		
		// Check for missing password
		if($InputPassword == '') {
			if($this->logView->getRequestLogin() == 'login') {
				$this->msg = 'Password is missing';
				return false;
			}
		}
		
		// Check if entered login information fits with a user
		if($this->udb->indexInDB($InputUser)!= -1) {
			$index = $this->udb->indexInDB($InputUser);
			if($this->udb->getPassword($index) == $InputPassword) {
				if($this->logView->getRequestLogin() == 'login')
					$this->msg = 'Welcome';
				$_SESSION['uname'] = $InputName;
				$_SESSION['pw'] = $InputPassword;
				return true;
			}
			// THIS COULD BE ADDED IF MORE DETAILS ON THE LOGIN FAIL SHOULD BE GIVEN
			//if($this->logView->getRequestLogin() == 'login') {
			//	$this->msg = 'Incorrect Password';
			//	return false;
			//}
		}
		
		// Since none of the above checks succeeded it must be a failed login attempt
		if($this->logView->getRequestLogin() == 'login') 
			$this->msg = 'Wrong name or password';
		return false;
	}
	
	private function render() {
		// Create new server time object
		$serTime = new ServerTime();
		// Set the date time view to display the Server Time
		$this->dtView->setTimeString($serTime->getTimeString());
		// Render the page
		$this->view->render($this->isLoggedIn, $this->logView, $this->dtView, $this->msg, $this->regView, $this->name);
	}
	
	
	
}
