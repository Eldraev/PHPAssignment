<?php

// This only works for Julian Calenders with 12 months and 7 week days
// Also only supports english language right now
// 
// This class is used to obtain the server time and format it in a nice looking way

class ServerTime {
	private $dateday;
	private $month;
	private $year;
	private $hour;
	private $minute;
	private $second;
	
	public function __construct() {
		$this->dateday = getdate()['mday'];
		$this->month = getdate()['mon'];
		$this->year = getdate()['year'];
		$this->hour = getdate()['hours'];
		$this->minute = getdate()['minutes'];
		$this->second = getdate()['seconds'];
		
		$this->day = date('l', strtotime( $this->year.'-'.$this->month.'-'.$this->dateday));
	}
	
	public function getTimeString() {
		$dateEnding = $this->getEnding();
		
		$availableMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		
		$timeString = $this->day.', the '.$this->dateday.$dateEnding.' of '.$availableMonths[$this->month-1].' '.$this->year.', The time is '.$this->hour.':'.$this->minute.':'.$this->second;

		return $timeString;
	}
	
	private function getEnding() {
		if($this->dateday % 10 == 1)
			return 'st';
		else if($this->dateday % 10 == 2)
			return 'nd';
		else if($this->dateday % 10 == 3)
			return 'rd';
		else
			return 'th';
	}
}