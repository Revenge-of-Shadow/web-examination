<!DOCTYPE html>
<html lang="en">
    <head>
	<title>Front page and attributions</title>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body><?php
require_once("../connect/session.php");

$topic_id = 0 + @$_GET['topic_id'];

if(@$login) {
    // sign out
    require("../fragments/sign-out-form.php");
} else {
    ?>You are currently logged out. <a href="sign-in.php">Sign in</a> or <a href="register.php">sign up</a>.<?php
}

if(@$topic_id) {
    require("../fragments/messages.php");
} else {
    require("../fragments/topics.php");
}

if(@$login) {
    // create a new topic or message
    require("../fragments/add-message-form.php");
}

?></body>
</html>
