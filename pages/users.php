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
require_once("../connect/session.php");

$result = $mysqli->query("SELECT * FROM user");
while($row = $result->fetch_assoc()){
    extract($row);
    ?><tr>
        <td><?=$id?></td><td><?=$login?></td><td><?=$nickname?></td>
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
