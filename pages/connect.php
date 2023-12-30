<?php
print_r($_COOKIE);
require_once("session.php");
$mysqli = mysqli_connect(hostname, user, password, database);
$result = mysqli_query($mysqli, "SELECT * FROM user");
print_r("<table><tr><th>id</th><th>login</th><th>nickname</th><th>hash</th><th>admin</th><th>disabled</th></tr>");
while($row = mysqli_fetch_assoc($result)){
    print_r("<tr><td>"."***"."</td><td>".$row["login"]."</td><td>".$row["nickname"]."</td><td>".$row["hash"]."</td><td>");
    print_r('<img src="'.($row["admin"]?"../admin.png":"../basic.png").'" width=128/>');
    print_r("</td><td>".$row["disabled"]."</td></tr>");
}
print_r("</table>");
