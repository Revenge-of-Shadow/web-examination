<?php
require_once("database.php");

$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['PHP_SELF'];
$extra = "?session_mismatch=";

$literal_abracadabra = "at434wry3e5";

$read_login = $_COOKIE["login"];
$read_session_hash = $_COOKIE["session_hash"];

$mysqli = mysqli_connect(hostname, user, password, database);
$stmt = $mysqli->prepare("SELECT session_secret FROM user WHERE login=?");
$stmt->bind_param("s", $read_login);
$stmt->execute();
$result = $stmt->get_result();


if($row=mysqli_fetch_row($result)){
    $table_ss = $row[0];

    $new_session_hash = hash("sha256", $table_ss.$literal_abracadabra.$read_login);

    $extra = $extra.strcmp($new_session_hash, $read_session_hash);

    $stmt->close();
    $mysqli->close();
}
else{
    $extra = $extra."2";
}
header("Location: http://$host$uri$extra");


