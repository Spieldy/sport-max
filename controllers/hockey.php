<?php


require_once 'models/user.php';

class Controller_Hockey
{

	public function calendar() {
		include 'views/hockey/title.php';
		include 'views/hockey/calendar.php';
	}

	public function results() {
		include 'views/hockey/title.php';
		include 'views/hockey/results.php';
	}

	public function standing() {
		include 'views/hockey/title.php';
		include 'views/hockey/standing.php';
	}

	public function teams() {
		include 'views/hockey/title.php';
		include 'views/hockey/teams.php';
	}

}