<?php

require_once 'models/user.php';


class Controller_Football
{

	public function calendar() {
		include 'views/football/title.php';
		include 'views/football/calendar.php';
	}

	public function results() {
		include 'views/football/title.php';
		include 'views/football/results.php';
	}

	public function standing() {
		include 'views/football/title.php';
		include 'views/football/standing.php';
	}

	public function teams() {
		include 'views/football/title.php';
		include 'views/football/teams.php';
	}
	
}