<?php

require_once("src/bootstrap.php");

$ctrl = new Controller;
$ctrl->view("manage_users.php", "Manage users");
