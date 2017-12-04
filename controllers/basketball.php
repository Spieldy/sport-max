<?php

require_once 'models/user.php';


class Controller_Basketball
{

  public function calendar() {
    include 'views/basketball/title.php';
    include 'views/basketball/calendar.php';
  }

  public function results() {
    include 'views/basketball/title.php';
    include 'views/basketball/results.php';
  }

  public function standing() {
    include 'views/basketball/title.php';
    include 'views/basketball/standing.php';
  }

  public function teams() {
    include 'views/basketball/title.php';
    include 'views/basketball/teams.php';
  } 
  
}