<?php

require_once("src/bootstrap.php");

$ctrl = new Controller;

//Log the user out
$ctrl->Auth()->logout();

//Redirect to home
header('location: index.php');
exit;
