<?php
// incoming fields ($_POST):
// title
// message_text
// topic_id
// parent_id

// incoming session variables:
// user_id := login_id

// defaults:
// removed := FALSE
// sent_time := NOW()

// outcomes:
// success -> navigate to end of topic
// failure -> navigate to end of topic

require_once("../connect/session.php");

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = "index.php";

$faulty_fields = array();
if(!($topic_id = 0 + @$_POST['topic_id'])) {
    $extra = "index.php"; // can only be an internal error; topic unknown => redirect to topic list
} else {
    $parent_id = 0 + @$_POST['parent_id'];
    $reply_to_id = $parent_id ? $parent_id : $topic_id;
    $stmt = $mysqli->prepare("SELECT title FROM message WHERE id=?");
    $stmt->bind_param("i", $reply_to_id);
    $stmt->execute();
    if(($result = $stmt->get_result()) && ($row = $result->fetch_assoc())) {
        if(!($title = @$_POST['title'])) {
            // don't set $faulty_fields[] = 'title';
            // instead, fix it for the user: apply "Re: "
            $title = reply_to . $row['title'];
        }
        if(!$topic_id) {
            $topic_id = 0 + $row['topic_id'];
        }
    }
    if(!($message_text = @$_POST['message_text'])) {
        $faulty_fields[] = 'message_text';
    }
    if($parent_id) {
        $extra = "reply-to.php?parent_id=$parent_id";
    } else {
        $extra = "index.php?topic_id=$topic_id";
    }
    if($faulty_fields) {
        $extra = $extra.'&missing='.join('+', $faulty_fields);
    }
    else if(@$login_id) {
        $stmt = $mysqli->prepare(
            "INSERT INTO message(user_id, topic_id, parent_id, title, message_text, removed, sent_time) VALUES (?, ?, ?, ?, ?, FALSE, NOW())");
        $stmt->bind_param("iiiss", $login_id, $topic_id, $reply_to_id, $title, $message_text);
        $stmt->execute();
        if(!$mysqli->errno) {
            $extra = "index.php?topic_id=$topic_id";
        }
    }
}

header("Location: http://$host$uri/$extra");

?>
