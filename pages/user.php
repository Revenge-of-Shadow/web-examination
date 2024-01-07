<!DOCTYPE html>
<html lang="en">
<head>
	<title>User profile page</title>
        <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php
require_once("../connect/session.php");
require("../fragments/sign-out-form.php");

$missing = @$_GET['missing'];
$mfieldlist = explode(" ", $missing);
$mfieldkeys = array_flip($mfieldlist);
?>
<a href="index.php">Back to forum</a>
<?php
if(array_key_exists("id", $_GET)) {
    $id = 0 + $_GET['id'];
} else {
    $id = 0 + $login_id;
}
if($admin) {
?> | <a href="users.php">To user list</a><?php
}
$stmt = $mysqli->prepare("SELECT admin as user_admin, disabled, login as username, nickname FROM user WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
if($result = $stmt->get_result()) {
    extract($result->fetch_assoc());

    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM message WHERE user_id=? AND id=topic_id");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $top_cnt = $stmt->get_result()->fetch_row()[0];

    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM message WHERE user_id=? AND id!=topic_id");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $rpl_cnt = $stmt->get_result()->fetch_row()[0];

    ?>
    <h2><?=$nickname?></h2>
    <ul>
        <li>Login name: <?=$username?></li>
        <li>Topics: <?=$top_cnt?></li>
        <li>Replies: <?=$rpl_cnt?></li>
    </ul>

    <?php
    if($login_id == $id) {
        // self
        ?>This is you!
        <blockquote><form action="change-password-action.php" method="POST">
            <input type="hidden" name="user_id" value="<?=$id?>"/>
            <?php
            require("../fragments/password-entry.php");
        ?><button type="submit">Change password.</button></form></blockquote>
        <?php
    } else if($admin) {
        // admin
        ?><h3>Administrative actions</h3>
        <blockquote>
        <?php if(!$disabled) { ?>
        <form action="user-actions.php" method="POST">
            <input type="hidden" name="user_id" value="<?=$id?>"/>
            <input type="hidden" name="appoint" value="<?=!$user_admin?>"/>
            <button type="submit"><?=$user_admin?"Demote":"Promote"?></button>
        </form>
        <?php } ?>
        <form action="user-actions.php" method="POST">
            <input type="hidden" name="user_id" value="<?=$id?>"/>
            <input type="hidden" name="disable" value="<?=!$disabled?>"/>
            <button type="submit"><?=$disabled?"Restore":"Expel"?></button>
        </form>
        </blockquote>
        <?php
    }
}
?>
</body>
</html>
