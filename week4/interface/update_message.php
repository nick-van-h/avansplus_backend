<?php

require_once("../src/bootstrap.php");


//Get username/password from form
$title = $_POST['title'];
$message = $_POST['message'];
$postId = $_POST['post-id'];

//Update the database
$ctrl = new Controller;
$result = $ctrl->Db()->update_message($ctrl->Auth()->get_username(), $postId, $title, $message);

$_SESSION['message'] = '';

//Redirect the user back to the page
$redirect = 'location: ' . base_url() . '/index.php';
header($redirect);
