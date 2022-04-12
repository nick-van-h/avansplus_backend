<?php

require_once("src/bootstrap.php");

$ctrl = new Controller;

//Redirect the user back to home if already logged in
if ($ctrl->Auth()->user_is_logged_in()) {
    header("location: index.php");
    exit;
}

//Load the page
$ctrl->view("login.php", "Login");
