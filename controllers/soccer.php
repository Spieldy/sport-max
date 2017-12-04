<?php

require_once 'models/user.php';


class Controller_Soccer
{

	public function calendar() {
		include 'views/soccer/title.php';
		include 'views/soccer/calendar.php';
	}

	public function results() {
		include 'views/soccer/title.php';
		include 'views/soccer/results.php';
	}

	public function standing() {
		include 'views/soccer/title.php';
		include 'views/soccer/standing.php';
	}

	public function teams() {
		include 'views/soccer/title.php';
		include 'views/soccer/teams.php';
	}	
}