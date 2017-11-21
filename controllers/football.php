<?php

require_once 'models/user.php';


class Controller_Football
{

		public function calendar() {
		include 'views/football/calendar.php';
	}

	public function results() {
		include 'views/football/results.php';
	}

	public function classment() {
		include 'views/football/classment.php';
	}

	public function teams() {
		include 'views/football/teams.php';
	}
	
}