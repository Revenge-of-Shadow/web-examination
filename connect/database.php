<?php
define ("hostname", "localhost", true);
define ("user", "moderator", true);
define ("password", "6503916162", true);
define ("database", "forum", true);

define("page_size", 20); // whenever a list is displayed paged, display 20 items on a single page
define("reply_to", "Re: "); // prepend to message title when the title is omitted

function db_connect() {
#The arguments are hostname, user, password and (optionally) database to use.
    return mysqli_connect(hostname, user, password, database);
}

$mysqli = db_connect();
$mysqli->query("SET SQL_SAFE_UPDATES = 0");
?>
