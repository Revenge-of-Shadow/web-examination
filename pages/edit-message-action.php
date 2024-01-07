<?php
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

require_once("../connect/session.php");
$extra = "index.php";

if($edit_id = 0 + $_POST['edit_id']) {
    $extra = "reply-to.php?edit_id=$edit_id";
    $faulty_fields = array();
    if(!($title = @$_POST['title'])) {
        $faulty_fields[] = 'title';
    }
    if(!($message_text = @$_POST['message_text'])) {
        $faulty_fields[] = 'message_text';
    }
    if($faulty_fields) {
        $extra .= '&missing='.join('+', $faulty_fields);
    } else {
        // edit; on success, go to topic
        $stmt = $mysqli->prepare("UPDATE message SET title=?, message_text=? WHERE id=? AND user_id=?");
        $stmt->bind_param("ssii", $title, $message_text, $edit_id, $login_id);
        $stmt->execute();

        if(!$mysqli->errno) {
            $extra = "index.php";
            $stmt = $mysqli->prepare("SELECT topic_id FROM message WHERE id=?");
            $stmt->bind_param("i", $edit_id);
            $stmt->execute();
            if(($result = $stmt->get_result()) && ($row = $result->fetch_row())) {
                $topic_id = 0 + $row[0];
                $extra .= "?topic_id=$topic_id";
            }
        }
    }
}

header("Location: http://$host$uri/$extra");
?>