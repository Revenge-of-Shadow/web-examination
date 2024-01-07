<!DOCTYPE html>
<html lang="en">
    <head>
	<title>Message post/edit page</title>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body><?php
require_once("../connect/session.php");
require_once("../connect/entities.php");
require("../fragments/sign-out-form.php");

$edit_id = 0 + @$_GET['edit_id'];
$del_msg = 0 + @$_GET['del'];
$may_edit = FALSE;

if($edit_id) {
    $stmt = $mysqli->prepare("SELECT * FROM message WHERE id=?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();

    if(($result = $stmt->get_result()) && ($row = $result->fetch_assoc())) {
        extract($row);
        if($del_msg && $admin) {
            $may_edit = TRUE; // an administrator can delete, but not edit
        }
        else if($user_id != $login_id) {
            ?><label class="errmsg">A topic or message can only be edited by its author.</label><?php
        } else {
            $may_edit = TRUE;
        }
    } else {
        ?><label class="errmsg">No message with ID <?=$edit_id?> exists.</label><?php
    }
} else {
    $topic_id = 0 + @$_GET['topic_id'];
    $parent_id = 0 + @$_GET['parent_id'];
}

if(@$parent_id && !@$topic_id) {
    $stmt = $mysqli->prepare("SELECT topic_id FROM message WHERE id=?");
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    if(($result = $stmt->get_result()) && ($row = $result->fetch_row())) {
        $topic_id = $row[0];
    }
}
if(@$topic_id) {
    echo "<h3>In topic (<a href='index.php?topic_id=$topic_id'>back to topic</a>):</h3>";
    display_message_by_id($topic_id);
    echo "<hr>";
}
if(@$parent_id && $parent_id != $topic_id) {
    echo "<h4>Responding to:</h4>";
    display_message_by_id($parent_id);
    echo "<hr>";
}
if($may_edit) {
    if($topic_id == $edit_id) {
        if($del_msg) echo "<h4>ATTENTION: DELETING ENTIRE TOPIC!</h4>";
    } else {
        echo "<h4>Original text:</h4>";
        display_message_by_id($edit_id);
    }
    echo "<hr>";
    if($del_msg) {
        // delete message form
        ?><form action="delete-message-action.php" method="POST">
            <input type="hidden" name="edit_id" value="<?=$edit_id?>">
            <button type="submit" class="smaller_btn">Delete</button>
        </form><?php
    } else {
        // fields will be populated with edit_id
        require("../fragments/add-message-form.php");
    }
}
else {
    require("../fragments/add-message-form.php");
}

?></body>
</html>
