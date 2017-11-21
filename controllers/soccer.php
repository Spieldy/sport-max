<?php

require_once 'models/user.php';


class Controller_Soccer
{

	public function calendar() {
		include 'views/soccer/calendar.php';
	}

	public function results() {
		include 'views/soccer/results.php';
	}

	public function classment() {
		include 'views/soccer/classment.php';
	}

	public function teams() {
		include 'views/soccer/teams.php';
	}	
}