<?php
require_once("session.php");

$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['PHP_SELF'];
$extra="";

$faulty_fields = array();
if (!$_POST["topic_title"]) {
    $faulty_fields[] = 'topic_title';
}
if (!$_POST["topic_text"]) {
    $faulty_fields[] = 'topic_text';
}
if (!empty($faulty_fields)) {
    $extra = '?missing='.join('+', $faulty_fields);
}
else {
    extract($_POST);

    $mysqli = mysqli_connect(hostname, user, password, database);

    $stmt = $mysqli->prepare("SELECT id FROM user WHERE login=?");
    $stmt->bind_param("s", $_COOKIE["login"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row=mysqli_fetch_row($result)) {
        $timestamp = date_timestamp_get();
        $stmt = $mysqli->prepare("INSERT INTO message" .
            "(message_text, title, user_id, removed, sent_time) "
            . "VALUES (?, ?, ?, FALSE, ?);");
        $stmt->bind_param("ssss", $topic_text, $topic_title, $row[0], $timestamp);
        $stmt->execute();

        //  This can not fail, right?

        $stmt = $mysqli->prepare("SELECT id FROM message WHERE sent_time=? AND title=?");
        $stmt->bind_param("ss", $timestamp, $topic_title);
        $stmt->execute();
        $result = $stmt->get_result();

        if($row=mysqli_fetch_row($result)){
            $stmt = $mysqli->prepare("UPDATE message SET topic_id=?, parent_id=? WHERE id=?;");
            $stmt->bind_param("ddd", $row[0], $row[0], $row[0]);
            $stmt->execute();

            //  We good?
        }else{
            //  Topic sending has fail'd. Too bad.
        }
    }
    else{
        //  Login not found. I am concentrated on other parts now.
    }

    $stmt->close();
    $mysqli->close();
}
header("Location: http://$host$uri$extra");
