<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('controller/LoginController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$rv = new RegisterView();
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();

//Create Controller and hand over view objects
$controller = new LoginController($v,$lv,$dtv, $rv);
