<?php
require_once("../connect/database.php");

unset($login); // first assume no active session
unset($login_id); // ditto
$pretended_login = @$_COOKIE['login'];
$pretended_shash = @$_COOKIE['session_hash'];

$literal_abracadabra = "at434wry3e5";

function salted_password_hash($password) {
    $random_val = rand(4096, 65535);
    $salt = dechex($random_val);
    $hash = hash(
        "sha256",
        $salt.$password
    );

    return $salt."$".$hash;
}

if($pretended_login && $pretended_shash) {
    $stmt = $mysqli->prepare("SELECT id AS user_id, session_secret, admin, nickname FROM user"
            ." WHERE login=? AND disabled=FALSE and NOT ISNULL(session_secret)");
    $stmt->bind_param("s", $pretended_login);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()) {
        extract($row, EXTR_OVERWRITE);
        $session_hash = hash(
            "sha256",
            $session_secret.$literal_abracadabra.$pretended_login
        );
        if($session_hash === $pretended_shash) {
            $login = $pretended_login;
            $login_id = $user_id;
        }
    }
}

?>
