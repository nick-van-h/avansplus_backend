<h1>Manage users</h1>
<h3>Create or update user properties</h3>
<form action="interface/manage_user.php" method="post">
    <div><label for="username">Username</label><input type="text" name="username" id="username"></div>
    <div><label for="password">Password</label><input type="text" name="password" id="password"></div>
    <div><label for="role">Role</label><select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="user" selected>User</option>
            <option value="guest">Guest</option>
        </select></div>
    <input type="submit" value="Submit">
</form>
<div class="form-submit-result">
    <?php
    if (!empty($_SESSION['message'])) {
        echo ($_SESSION['message']);
        $_SESSION['message'] = '';
    }
    ?>
</div>
<h3>List of all existing users</h3>
<table>
    <tr>
        <th>Username</th>
        <th>Role</th>
    </tr>
    <?php
    $ctrl = new Controller;
    $ctrl->Db()->get_all_users();
    ?>
</table>