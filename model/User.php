<?php

// This class stores user information and should normally be exchanged for a database

class User {

	private $password;
	private $username;
	
	public function __construct($u, $p) {
		$this->password = $p;
		$this->username = $u;
	}
	
	public function getUserName() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}
}