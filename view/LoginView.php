<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $register = 'LoginView::Register';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($isLoggedIn, $msg, $name) {
		$message = $msg;
		if($isLoggedIn == true)
			$response = $this->generateLogoutButtonHTML($message);
		else
			$response = $this->generateLoginFormHTML($message,$name);
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message,$name) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'.$name.'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
					
					<input type="submit" name="' . self::$register . '" value="Register new user"/>
				</fieldset>
			</form>
		';
	}
	
	public function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
		if(isset($_REQUEST[LoginView::$name]))
			return $_REQUEST[LoginView::$name];
	}
	
	public function getRequestPassword() {
		//RETURN REQUEST VARIABLE: PASSWORD
		if(isset($_REQUEST[LoginView::$password]))
			return $_REQUEST[LoginView::$password];
	}
	
	public function getRequestLogin() {
		//RETURN REQUEST VARIABLE: LOGIN
		if(isset($_REQUEST[LoginView::$login]))
			return $_REQUEST[LoginView::$login];
	}
	
	public function getRequestLogout() {
		//RETURN REQUEST VARIABLE: LOGOUT
		if(isset($_REQUEST[LoginView::$logout]))
			return $_REQUEST[LoginView::$logout];
	}
	
	public function getRequestRegister() {
		//RETURN REQUEST VARIABLE: REGISTER
		if(isset($_REQUEST[LoginView::$register]))
			return $_REQUEST[LoginView::$register];
	}
	
}
