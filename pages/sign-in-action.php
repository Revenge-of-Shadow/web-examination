<?php
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$faulty_fields = array();
if (!@$_POST["login"]) {
    $faulty_fields[] = 'login';
}
if (!@$_POST["password"]) {
    $faulty_fields[] = 'password';
}
if (!empty($faulty_fields)) {
    $extra = 'sign-in.php'.'?missing='.join('+', $faulty_fields);
}
else{
    require_once("../connect/session.php");
    $original_login = @$login;
    extract($_POST);

    $stmt = $mysqli->prepare("SELECT hash FROM user WHERE login=? AND disabled=FALSE");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if(!$row=mysqli_fetch_row($result)){
        $extra = 'sign-in.php'
            .'?failed=1';
    }else{
        $hash = $row[0];
        $fingerprint = explode('$', $hash);
        $salt = $fingerprint[0];
        $hashed_original = $fingerprint[1];
        $hashed_password = hash(
            "sha256",
            $salt.$password
        );

        if(strcmp($hashed_password, $hashed_original)){
            //  If they are not identical. 1 / -1.
            $extra = 'sign-in.php'
                .'?failed=1'
                ;
        }
        else{
            $session_secret = time().rand(4096, 65535);
            $session_hash = hash(
                "sha256",
                $session_secret.$literal_abracadabra.$login
            );

            $stmt = $mysqli->prepare("UPDATE user SET session_secret = ? WHERE login=?");
            if($original_login != $login) {
                $backtrack = "alias:$login";
                $stmt->bind_param("ss", $backtrack, $original_login);
                $stmt->execute();            
            }
            $stmt->bind_param("ss",  $session_secret, $login);
            $stmt->execute();

            $expiration_time = 0; // to persist: time() + (something reasonable, e.g. 86400 aka 1 day);
            setcookie("login", $login, $expiration_time);
            setcookie("session_hash", $session_hash, $expiration_time);

            $extra = 'index.php';
        }

        $stmt->close();
        $mysqli->close();
    }
}
header("Location: http://$host$uri/$extra");
?>
