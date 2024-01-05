<?php
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

require_once("../connect/session.php");

if($login) {
    $stmt = $mysqli->prepare("UPDATE user SET session_secret = NULL WHERE login=?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
}

header("Location: http://$host$uri/sign-in.php");
?>
