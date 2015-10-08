<?php

class RegisterView {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passAgain = 'RegisterView::PassAgain';
	private static $messageId = 'RegisterView::Message';
	private static $login = 'RegisterView::Login';

	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a registration attempt has been determined
	 *
	 * @return  void BUT writes to standard output!
	 */
	public function response($isLoggedIn, $msg, $name) {
		$message = $msg;
		
		$response = $this->generateRegisterFormHTML($message, $name);
		
		return $response;
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @param $name, Name that might need to be displayed
	* @return  void, BUT writes to standard output!
	*/
	private function generateRegisterFormHTML($message, $name) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Register a new User - enter username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'.$name.'" />
					<br>
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<br>
					<label for="' . self::$password . '">Repeat Password :</label>
					<input type="password" id="' . self::$passAgain . '" name="' . self::$passAgain . '" />
					<br>
					<input type="submit" name="' . self::$register . '" value="Register"/>
				</fieldset>
			</form>
		';
	}
	
	public function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
		if(isset($_REQUEST[RegisterView::$name]))
			return $_REQUEST[RegisterView::$name];
	}
	
	public function getRequestPassword() {
		//RETURN REQUEST VARIABLE: PASSWORD
		if(isset($_REQUEST[RegisterView::$password]))
			return $_REQUEST[RegisterView::$password];
	}
	
	public function getRequestPassAgain() {
		//RETURN REQUEST VARIABLE: PASSAGAIN
		if(isset($_REQUEST[RegisterView::$passAgain]))
			return $_REQUEST[RegisterView::$passAgain];
	}
	
	public function getRequestRegister() {
		//RETURN REQUEST VARIABLE: REGISTER
		if(isset($_REQUEST[RegisterView::$register]))
			return $_REQUEST[RegisterView::$register];
	}
	
}
