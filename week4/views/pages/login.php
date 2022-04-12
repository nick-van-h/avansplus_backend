<h1>Login</h1>
<form action="interface/login_user.php" method="post">
    <div>
        <label for="username">Username</label><input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password</label><input type="password" id="password" name="password" required>
    </div>
    <input type="submit" value="Submit">
</form>
<div class="form-submit-result">
    <?php
    //Display the message if there is any and reset the message so that it disappears on reaload and/or can be used for next action
    if (!empty($_SESSION['message'])) {
        echo ($_SESSION['message']);
        $_SESSION['message'] = '';
    };
    ?>
</div>