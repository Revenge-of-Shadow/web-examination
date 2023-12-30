<?php
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = "sign-in.php";

require_once("session.php");

if(!$_GET["session_mismatch"]){
    //  Clear the session secret.
}
header("Location: http://$host$uri/$extra");