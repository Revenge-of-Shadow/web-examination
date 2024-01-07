<?php
// process user actions

require_once("../connect/session.php");

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = "users.php";

$user_id = 0 + @$_POST['user_id'];

if($user_id && ($user_id != $login_id)) {
    if(array_key_exists("appoint", $_POST)) {
        $new_role = !!$_POST['appoint']; // force 0 or 1
        $stmt = $mysqli->prepare("UPDATE user SET admin=? WHERE id=?");
        $stmt->bind_param("ii", $new_role, $user_id);
        $stmt->execute();
    } else if(array_key_exists("disable", $_POST)) {
        $disabled = !!$_POST['disable']; // force 0 or 1
        if($disabled) {
            $stmt = $mysqli->prepare("UPDATE user SET disabled=TRUE, admin=FALSE WHERE id=?");
            $stmt->bind_param("i", $user_id);
        } else {
            $stmt = $mysqli->prepare("UPDATE user SET disabled=FALSE WHERE id=?");
            $stmt->bind_param("i", $user_id);
        }
    }
}

if($stmt) {
    $stmt->execute();
    if($mysqli->errno) {
        $extra = "user.php?id=$user_id";
    }
}

header("Location: http://$host$uri/$extra");

?>