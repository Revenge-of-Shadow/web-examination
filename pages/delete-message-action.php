<?php
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

require_once("../connect/session.php");
$extra = "index.php";

if($edit_id = 0 + @$_POST['edit_id']) {
    $stmt = $mysqli->prepare("SELECT user_id, topic_id FROM message WHERE id=?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    if(($result = $stmt->get_result()) && ($row = $result->fetch_assoc())) {
        extract($row, EXTR_OVERWRITE); // user_id, topic_id
        if($admin || ($user_id == $login_id)) {
            // proceed with deletion
            if($edit_id == $topic_id) {
                // delete entire topic
                $mysqli->begin_transaction();
                $stmt = $mysqli->prepare("UPDATE message SET parent_id=NULL WHERE topic_id=?");
                $stmt->bind_param("i", $topic_id);
                $stmt->execute();
                $stmt = $mysqli->prepare("DELETE IGNORE FROM message WHERE topic_id=?");
                $stmt->bind_param("i", $topic_id);
                $stmt->execute();
                $stmt = $mysqli->prepare("UPDATE message SET topic_id=NULL WHERE id=?");
                $stmt->bind_param("i", $topic_id);
                $stmt->execute();
                $stmt = $mysqli->prepare("DELETE FROM message WHERE id=?");
                $stmt->bind_param("i", $topic_id);
                $stmt->execute();
                $mysqli->commit();
                if($mysqli->errno) {
                    $extra .= "?topic_id=$topic_id";
                }
            } else {
                // try deleting a single message; if fails, then try soft delete
                $stmt = $mysqli->prepare("DELETE FROM message WHERE id=?");
                $stmt->bind_param("i", $edit_id);
                $stmt->execute();
                if($mysqli->errno) {
                    // soft delete
                    $stmt = $mysqli->prepare("UPDATE message SET removed=TRUE WHERE id=?");
                    $stmt->bind_param("i", $edit_id);
                    $stmt->execute();
                }
                $extra .= "?topic_id=$topic_id";
            }
        }
    }
}

header("Location: http://$host$uri/$extra");
?>