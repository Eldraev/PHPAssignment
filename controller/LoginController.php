<?php

require_once($_SERVER['DOCUMENT_ROOT'].'view/LoginView.php');
require_once($_SERVER['DOCUMENT_ROOT'].'view/DateTimeView.php');
require_once($_SERVER['DOCUMENT_ROOT'].'view/LayoutView.php');
require_once($_SERVER['DOCUMENT_ROOT'].'model/ServerTime.php');
require_once($_SERVER['DOCUMENT_ROOT'].'model/User.php');

class LoginController {
	
	private $isLoggedIn;
	private $view;
	private $dtView;
	private $logView;
	private $msg;
	
	private $user; //This should be exchanged for a database later on
	
	public function __construct(LoginView $lv, LayoutView $v, DateTimeView $dtv) {
		$this->view = $v;
		$this->dtView = $dtv;
		$this->logView = $lv;
		$this->user = new User('Admin', 'Password');
		$this->isLoggedIn = $this->checkLogin();
		
		$this->render();
	}
	
	private function checkLogin() {
		// Get the login information
		$InputName = $this->logView->getRequestUserName();
		$UserName = $this->user->getUserName();
		$InputPassword = $this->logView->getRequestPassword();
		$Password = $this->user->getPassword();
	
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
			if($_SESSION['uname'] == $UserName && $_SESSION['pw'] == $Password) {
				$this->msg = '';
				return true;
			}
		}
		
		// If the user is not already logged in check for a login attempt
		
		// Check for missing username
		if($InputName == '') {
			if($this->logView->getRequestLogin() == 'login') {
				$this->msg = 'Name is missing';
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
		
		// Check if entered login information fits with a user (currently only one user available)
		if($UserName == $InputName) {
			if($Password == $InputPassword) {
				if($this->logView->getRequestLogin() == 'login')
					$this->msg = 'Welcome';
				$_SESSION['uname'] = $InputName;
				$_SESSION['pw'] = $Password;
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
		$this->view->render($this->isLoggedIn, $this->logView, $this->dtView, $this->msg);
	}
	
	
	
}