<?php

$ctrl = new Controller;

?>

<h1>Message board</h1>
<?php
if (!$ctrl->Auth()->user_is_logged_in()) {
    echo ("<p>Please log in to view the message board</p>");
} else {
    if ($ctrl->Auth()->user_is_guest()) {
        echo ("<p>Guests are only eligible to view the latest message</p>");
    }
    echo ("<hr>");
    $ctrl->get_message_board();
}
