<?php

require_once("src/bootstrap.php");

$ctrl = new Controller;

$ctrl->Auth()->logout();

header('location: index.php');
exit;
