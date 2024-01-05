<?php
define ("hostname", "localhost", true);
define ("user", "moderator", true);
define ("password", "6503916162", true);
define ("database", "forum", true);

function db_connect() {
#The arguments are hostname, user, password and (optionally) database to use.
    return mysqli_connect(hostname, user, password, database);
}

$mysqli = db_connect();
?>
