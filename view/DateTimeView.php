<?php

class DateTimeView {

	private $timeString;

	public function show() {

		return '<p>' . $this->timeString . '</p>';
	}
	
	public function setTimeString($tstr) {
		$this->timeString = $tstr;
	}
}