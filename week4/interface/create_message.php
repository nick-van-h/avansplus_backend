<?php

require_once("../src/bootstrap.php");


//Get username/password from form
$title = $_POST['title'];
$message = $_POST['message'];

//Update the database
$ctrl = new Controller;
$result = $ctrl->Db()->create_new_message($ctrl->Auth()->get_username(), $title, $message);

//Redirect the user back to the page
$redirect = 'location: ' . base_url() . '/create_message.php';
header($redirect);
