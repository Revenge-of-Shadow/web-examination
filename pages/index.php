<!DOCTYPE html>
<html lang="en">
    <head>
	<title>Main forum page</title>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body><?php
require_once("../connect/session.php");
require("../fragments/sign-out-form.php");

$topic_id = 0 + @$_GET['topic_id'];

if($admin) {
    ?><div><a href="users.php">Manage users</a></div><?php
}

if(@$topic_id) {
    ?><div id="topic-section"><?php
        // limit, link to full index.php
        require("../fragments/topics.php");
    ?><a href="?">All topics</a>
    </div>
    <div id="chat-section"><?php
        require("../fragments/messages.php");
} else {
    ?><h1>Existing topics</h3>
    <div><?php
    require("../fragments/topics.php");
}

if(@$login) {
    ?><hr><?php
    // create a new topic or message
    if(@$topic_id) {
        echo "<h3>New message:</h3>";
    } else {
        echo "<h2>New topic:</h2>";
    }

    require("../fragments/add-message-form.php");
}

?></div></body>
</html>
