<?php

require_once("../src/bootstrap.php");


//Get username/password from form
$username = $_POST['username'];
$password = $_POST['password'];

//Try to login the user
$ctrl = new Controller;
$ctrl->Auth()->login_user($username, $password);

//Redirect the user based on the success of login
if ($ctrl->Auth()->user_is_logged_in) {
    header('location: ' . base_url() . '/index.php');
} else {
    header('location: ' . base_url() . '/login.php');
}
