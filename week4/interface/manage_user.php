<?php

require_once("../src/bootstrap.php");


//Get username/password from form
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

//Update the database
$ctrl = new Controller;
$result = $ctrl->Db()->update_user($username, $password, $role);

//Redirect the user back to the page
$redirect = 'location: ' . base_url() . '/manage_users.php';
header($redirect);
