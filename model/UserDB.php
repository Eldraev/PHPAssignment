<?php

// acts as the database for all users
// uses a unsecured text file as database... probably not the best idea if you made a real server
// TODO should be exchanged for mySQL or something along those lines later on

class UserDB {

	private $userArray = array();
	
	public function __construct() {
		// open the file
		$filetxt = file_get_contents($_SERVER['DOCUMENT_ROOT'].'model/UserDB.txt');
		// read through the file to get the users
		for($i=0; $i<strlen($filetxt);$i++) {
			$currStr = substr($filetxt, $i, 1);
			$currName = '';
			$currPW = '';
			// check for indicator of the beginning of a user
			if($currStr == '>') {
				// Read in the complete username
				while($i<200) {
					$i++;
					$currStr = substr($filetxt, $i, 1);
					//check for indicator that the username ended
					if($currStr == '/') {
						break;
					}
					$currName = $currName.$currStr;
				}
				// Read in the complete password
				while($i<200) {
					$i++;
					$currStr = substr($filetxt, $i, 1);
					//check for indicator that the user ended or that the file is at its end
					if($currStr == '<' || $i>=strlen($filetxt)) {
						break;
					}
					$currPW = $currPW.$currStr;
				}
				// add a new user to the array
				if(!empty($currName) AND !empty($currPW))
				$this->userArray[] = new User($currName, $currPW);
			}
		}
	}
	
	public function getNumberOfUsers() {
		return count($this->userAray);
	}
	
	public function getUserName($index) {
		return $this->userArray[$index]->getUserName();
	}

	public function getPassword($index) {
		return $this->userArray[$index]->getPassword();
	}
	
	public function indexInDB(User $u) {
		foreach($this->userArray as $index => $user) {
			if($u->isSame($user))
				return $index;
		}
		return -1;
	}
	
	public function saveUserInDB(User $u) {
		// write all users in the database into the file again 
		// TODO should probably check for access violation later on for many connections (to be determined in stress/load testing)
		$this->userArray[] = $u;
		$dbFile = fopen($_SERVER['DOCUMENT_ROOT'].'model/UserDB.txt','w');
		foreach($this->userArray as $user) {
				fwrite($dbFile, '<>'.$user->getUserName().'/'.$user->getPassword());
		}
		fwrite($dbFile, '<>');
		fclose($dbFile);
	}
	
}
