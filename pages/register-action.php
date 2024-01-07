<?php
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

    $faulty_fields = array();
    if (!@$_POST["new_login"]) {
        $faulty_fields[] = 'new_login';
    }
    if (!@$_POST["nickname"]) {
        $faulty_fields[] = 'nickname';
    }
    if (!@$_POST["password"]) {
        $faulty_fields[] = 'password';
    }

    if (!empty($faulty_fields)) {
        $extra = 'register.php'.'?missing='.join('+', $faulty_fields);
    } else if($_POST['password'] != @$_POST['passcopy']) {
        $extra = 'register.php?passmatch=1';
    } else{
        extract($_POST);
        require_once("../connect/session.php");
        $hash = salted_password_hash($password);

        $ucres = $mysqli->query("SELECT COUNT(id) FROM user");
        $user_count = $ucres->fetch_row()[0];
        $make_admin = !$user_count; // first user becomes admin

        $stmt = $mysqli->prepare("INSERT INTO user (login, nickname, hash, admin, disabled) VALUES (?, ?, ?, ?, FALSE)");
        $stmt->bind_param("sssi", $new_login, $nickname, $hash, $make_admin);
        $stmt->execute();


        if($mysqli->errno){
            $errno = $mysqli->errno;
            $count_stmt = $mysqli->prepare("SELECT COUNT(*) FROM user WHERE login=?;");
            $count_stmt->bind_param("s", $new_login);
            $count_stmt->execute();

            $extra = 'register.php'
                .'?errno='.$errno
                .'&collision='.mysqli_fetch_row($count_stmt->get_result())[0];
        }
        else{
            $extra = 'sign-in.php';
        }


        $stmt->close();
        $mysqli->close();
    }
    header("Location: http://$host$uri/$extra");
?>
