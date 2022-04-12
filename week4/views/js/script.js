/**
 * Get the current post title and message
 * Load the form template and replace the post
 * Update the form elements with the title and message
 */
function updateMessage(id) {
    elm = $("#message-" + id);
    title = elm.find("h3")[0].innerHTML;
    message = elm.find("p")[0].innerHTML;
    elm.load("views/components/update_message.php", function () {
        elm.find("#title").val(title);
        elm.find("#message").val(message);
        elm.find("#post-id").val(id);
    });
}
