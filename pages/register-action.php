<?php
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

    $faulty_fields = array();
    if (!$_POST["login"]) {
        $faulty_fields[] = 'login';
    }
    if (!$_POST["nickname"]) {
        $faulty_fields[] = 'nickname';
    }
    if (!$_POST["password"]) {
        $faulty_fields[] = 'password';
    }

    if (!empty($faulty_fields)) {
        $extra = 'register.php'.'?missing='.join('+', $faulty_fields);
    }

    else{
        extract($_POST);

        $random_val = rand(4096, 65535);
        $salt = dechex($random_val);
        $hash = hash(
            "sha256",
            $salt.$password,
            false,
            []
        );

        $hash = $salt."$".$hash;

        require_once("database.php");
        $mysqli = mysqli_connect(hostname, user, password, database);


        $stmt = $mysqli->prepare("INSERT INTO user (login, nickname, hash, admin, disabled) VALUES (?, ?, ?, FALSE, FALSE)");
        $stmt->bind_param("sss", $login, $nickname, $hash);
        $stmt->execute();


        if($mysqli->errno != 0){
            $count_stmt = $mysqli->prepare("SELECT COUNT(*) FROM user WHERE login=?;");
            $count_stmt->bind_param("s", $login);
            $count_stmt->execute();

            $extra = 'register.php'
                .'?errno='.$mysqli->errno
                .'&collision='.mysqli_fetch_row($count_stmt->get_result())[0];
        }
        else{
            $extra = 'sign-in.php';
        }


        $stmt->close();
        $mysqli->close();
    }
    header("Location: http://$host$uri/$extra");
