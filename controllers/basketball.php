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

  public function classment() {
    include 'views/basketball/title.php';
    include 'views/basketball/classment.php';
  }

  public function teams() {
    include 'views/basketball/title.php';
    include 'views/basketball/teams.php';
  } 
  
}