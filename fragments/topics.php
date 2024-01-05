<?php
if(@$_GET['errno']) {
    ?><label class="errmsg">For some reason, topic posting did not work. Retry later.</label><?php
}

if($result = $mysqli->query(
    "SELECT message.*, user.nickname FROM message INNER JOIN user ON user.id=user_id WHERE message.id=topic_id")) {
?><dl><?php
while($row = $result->fetch_assoc()) {
    extract($row, EXTR_OVERWRITE | EXTR_PREFIX_ALL, "m");
    ?><dt class="topic_title"><a href="index.php?topic_id=<?=$m_topic_id?>"><?=empty($m_title)?"(no title)":$m_title?></a></dt>
    <dd class="topic_antics">Created by: <?=$m_nickname?></dd><?php
}
?></dl><?php
}
?>
