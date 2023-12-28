<?php
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$faulty_fields = array();
if (!$_POST["login"]) {
    $faulty_fields[] = 'login';
}
if (!$_POST["password"]) {
    $faulty_fields[] = 'password';
}
if (!empty($faulty_fields)) {
    $extra = 'sign-in.php'.'?missing='.join('+', $faulty_fields);
}
else{
    extract($_POST);

    require_once("database.php");
    $mysqli = mysqli_connect(hostname, user, password, database);


    $stmt = $mysqli->prepare("SELECT hash FROM user WHERE login=? AND disabled=FALSE");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if(!$row=mysqli_fetch_assoc($result)){
        $extra = 'sign-in.php'
            .'?failed=1';
    }else{
        $hash = $row[0];
        $hashed_original = explode('$', $hash)[1];
        $hashed_password = hash(
            "sha256",
            $password,
            false,
            []
        );
        if(strcmp($hashed_password, $hashed_original)){
            //  If they are not identical. 1 / -1.
            $extra = 'sign-in.php'
                .'?failed=1';
        }
        else{
            $extra = 'connect.php';
            //  Are we to append the is_logged_in to the URL or something?
        }

        $stmt->close();
        $mysqli->close();
    }
}
header("Location: http://$host$uri/$extra");
