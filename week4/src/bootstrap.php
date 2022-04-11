<?php

//Display errors
ini_set('display_errors', 1);

//Start the session
session_start();

//Include config and functions
require_once('config.php');
require_once('functions.php');

//Include required classes
require_once('Authenticator.php');
require_once('DatabaseAbstract.php');
require_once('Database.php');

require_once('Controller.php');
