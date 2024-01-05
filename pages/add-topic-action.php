<?php
// incoming fields ($_POST):
// title
// message_text

// incoming session variables:
// user_id := login_id

// defaults:
// removed := FALSE
// sent_time := NOW()

// outcomes:
// success -> navigate to new topic page
// failure -> navigate to the topic list

require_once("../connect/session.php");

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = "index.php";

$faulty_fields = array();
if(!($title = @$_POST['title'])) {
    $faulty_fields[] = 'title';
}
if(!($message_text = @$_POST['message_text'])) {
    $faulty_fields[] = 'message_text';
}
if($faulty_fields) {
    $extra = 'index.php'.'?missing='.join('+', $faulty_fields);
}
else if(@$login_id) {
    $stmt = $mysqli->prepare(
        "INSERT INTO message(user_id, title, message_text, removed, sent_time) VALUES (?, ?, ?, FALSE, NOW())");
    $stmt->bind_param("iss", $login_id, $title, $message_text);
    $stmt->execute();

    if(!$mysqli->errno){
        // catch up topic_id
        $topic_id = $mysqli->insert_id;
        // The following statement _usually_ modifies a single row, but since it's not dependent on the topic_id,
        // it doesn't matter if it occasionally adjusts someone else's added topic (or if the topic just added is
        // adjusted by someone else). What matters is that when we redirect, the topic just added will already be
        // adjusted.
        $mysqli->query("UPDATE message SET topic_id=id WHERE ISNULL(topic_id)");
    }
    if(!$mysqli->errno){
        $extra = "index.php?topic_id=$topic_id";
    } else {
        $extra = "index.php?errno=" . $mysqli->errno;
    }
}

header("Location: http://$host$uri/$extra");

?>
