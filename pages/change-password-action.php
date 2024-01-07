<?php
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

    require_once("../connect/session.php");
    if($_POST['user_id'] != $login_id) {
        exit(); // abundance of caution
    }

    $extra = "user.php?id=$login_id";
    $password = $_POST['password'];
    $passcopy = $_POST['passcopy'];
    if($password != $passcopy) {
        $extra .= "&passmatch=1";
    } else if(empty($password)) {
        $extra .= "&missing=password";
    } else {
        $hash = salted_password_hash($password);

        $stmt = $mysqli->prepare("UPDATE user SET hash=?");
        $stmt->bind_param("s", $hash);
        $stmt->execute();
        // can't fail, but just in case it does, report some error
        if($mysql->errno) {
            $extra .= "&passmatch=1";
        }
    }

    header("Location: http://$host$uri/$extra");
?>