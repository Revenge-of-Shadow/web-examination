<!DOCTYPE html>
<html lang="en">
<head>
	<title>Main admin page</title>
        <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php
require_once("../connect/session.php");
require("../fragments/sign-out-form.php");
?>
<a href="index.php">Back to forum</a>
<?php
if($admin) { // user management is an admin-only function
?>
<h1>User list</h1>
<table>
    <tr>
        <th>id</th>
        <th>login</th>
        <th>nickname</th>
        <th>role</th>
        <th>status</th>
        <th>session</th>
    </tr>
<?php
$result = $mysqli->query("SELECT * FROM user");
while($row = $result->fetch_assoc()){
    extract($row, EXTR_OVERWRITE);
    ?><tr>
        <td><a href="user.php?id=<?=$id?>"><?=$id?></a></td>
        <td><a href="user.php?id=<?=$id?>"><?=$login?></a></td>
        <td><a href="user.php?id=<?=$id?>"><?=$nickname?></a></td>
        <td><img
            src="<?=$admin?"../images/admin.png":"../images/basic.png"?>"
            alt="<?=$admin?"Admin":"Layman"?>"
        /></td>
        <td><img
            src="<?=$disabled?"../images/banned.png":"../images/enabled.png"?>"
            alt="<?=$disabled?"Banned":"Active"?>"
        /></td>
        <td><img
            src="<?=$session_secret?"../images/online.png":"../images/offline.png"?>"
            alt="<?=$session_secret?"Logged in":"Logged out"?>"
        /></td>
    </tr><?php
}
?></table>
<?php
} else {
    echo "<div>No administrative functions available.</div>";
}
?>
</body>
</html>
