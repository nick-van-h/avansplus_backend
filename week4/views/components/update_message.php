<form action="interface/update_message.php" method="post">
    <div>
        <label for="title">Title</label><input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="message">Message</label><textarea id="message" name="message" rows="10" required></textarea>
    </div>
    <input type="submit" value="Submit">
    <input type="hidden" id="post-id" name="post-id" value="">
</form>