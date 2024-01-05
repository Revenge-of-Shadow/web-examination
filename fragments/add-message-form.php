<?php
require_once("../connect/entities.php");

$missing = @$_GET['missing'];
$mfieldlist = explode(" ", $missing);
$mfieldkeys = array_flip($mfieldlist);
?>
<form action="add-<?=$topic_id?'message':'topic'?>-action.php" method="POST">
<input type="hidden" name="topic_id" value="<?=$topic_id?>">
<?php
// FIXME/WIP most of the below block will be moved around -- it's not needed in index.php
if(@$topic_id) {
    echo "<h3>In topic:</h3>";
    display_message_by_id($topic_id);
    echo "<hr>";
} else {
    echo "<h2>New topic:</h2>";
}
if(@$parent_id && $parent_id != $topic_id) {
    echo "<h4>Responding to:</h4>";
    display_message_by_id($parent_id);
    echo "<hr>";
}
// -- end of FIXME/WIP
?></div>
<table>
    <tr><td align="right">Subject:</td><td>
        <?php
            if(array_key_exists('message_text', $mfieldkeys)){
                ?>
                <label class="errmsg">You forgot to enter the message title</label>
                <br/>
                <?php
            }
        ?>
        <input type="input" name="title" class="title_input">
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
        <textarea name="message_text" class="lines_input"></textarea>
    </td></tr>
    <tr><td/><td>
        <button type="reset" class="smaller_btn">Silentium!</button>
        <button type="submit" class="larger_btn">Urbi et orbi!</button>
    </td></tr>
</table>
</form>
