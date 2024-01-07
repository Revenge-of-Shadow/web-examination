<?php
require_once("../connect/entities.php");

$missing = @$_GET['missing'];
$mfieldlist = explode(" ", $missing);
$mfieldkeys = array_flip($mfieldlist);
$display_form = TRUE;

// TODO differentiate between add-* and edit-message once editing is allowed
if(@$edit_id) {
    $stmt = $mysqli->prepare("SELECT title, message_text FROM message WHERE id=? AND user_id=? AND NOT removed");
    $stmt->bind_param("ii", $edit_id, $login_id);
    $stmt->execute();
    if(($result = $stmt->get_result()) && ($row = $result->fetch_assoc())) {
        extract($row);
        ?><form action="edit-message-action.php" method="POST">
        <input type="hidden" name="edit_id" value="<?=$edit_id?>"><?php
    } else {
        $display_form = FALSE;
    }
} else {
    ?><form action="add-<?=$topic_id?'message':'topic'?>-action.php" method="POST"><?php
    $title = "";
    $message_text = "";
}
if($display_form) { // use case: message has not been found, belongs to another user or has been removed
?>
<input type="hidden" name="topic_id" value="<?=$topic_id?>">
<?php
if(@$parent_id) {
    ?><input type="hidden" name="parent_id" value="<?=$parent_id?>"><?php
}
?>
<table>
    <tr><td align="right">Subject:</td><td>
        <?php
            if(array_key_exists('title', $mfieldkeys)){
                ?>
                <label class="errmsg">You forgot to enter the message title</label>
                <br/>
                <?php
            }
        ?>
        <input type="input" name="title" class="title_input" value="<?=htmlentities($title)?>">
    </td></tr>
    <tr><td align="right">Message:</td><td>
        <?php
            if(array_key_exists('message_text', $mfieldkeys)){
                ?>
                <label class="errmsg">You forgot to enter the message text</label>
                <br/>
                <?php
            }
        ?>
        <textarea name="message_text" class="lines_input"><?=htmlentities($message_text)?></textarea>
    </td></tr>
    <tr><td/><td>
        <button type="reset" class="smaller_btn">Silentium!</button>
        <button type="submit" class="larger_btn">Urbi et orbi!</button>
    </td></tr>
</table>
</form>
<?php
}
?>
