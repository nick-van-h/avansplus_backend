<?php

require_once("src/bootstrap.php");

$ctrl = new Controller;

//Load the page
$ctrl->view("manage_users.php", "Manage users");
