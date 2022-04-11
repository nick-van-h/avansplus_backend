<h1>Create new message</h1>
<form action="interface/create_message.php" method="post">
    <div>
        <label for="title">Title</label><input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="message">Message</label><textarea id="message" name="message" rows="10" required></textarea>
    </div>
    <input type="submit" value="Submit">
</form>
<div class="form-submit-result">
    <?php
    if (!empty($_SESSION['message'])) {
        echo ($_SESSION['message']);
        $_SESSION['message'] = '';
    };
    ?>
</div>