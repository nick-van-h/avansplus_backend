<?php

require_once("src/bootstrap.php");

$ctrl = new Controller;

if (!$ctrl->Auth()->user_is_logged_in()) {
    header("location: index.php");
    exit;
}

$ctrl->view("create_message.php", "Create new message");
