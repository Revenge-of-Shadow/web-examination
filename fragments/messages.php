<?php
// known: $topic_id, $offset
require_once("../connect/entities.php");

display_message_by_id($topic_id);
?><hr><?php

// paging ...
$stmt = $mysqli->prepare("SELECT COUNT(id) FROM message WHERE topic_id=? AND message.id!=topic_id");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$total = $stmt->get_result()->fetch_row()[0];

if($total) {
    $last_link = "index.php?topic_id=$topic_id";
    if($total > page_size) {
        // display paging; if offset is unset, display last 20
        $hasoff = array_key_exists("offset", $_GET);
        $offset = $hasoff ? 0 + $_GET["offset"] : $total - page_size;
        ?><div class="pagenos"><a <?php if($hasoff) {
            ?> href="<?=$last_link?>" <?php 
        } ?>>last page</a><?php
        $page_off = $offset - 1;
        $page_off -= ($page_off % page_size);
        while($page_off >= 0) {
            ?> | <a <?php if($offset != $page_off) {
                ?> href="<?=$last_link."&offset=".$page_off?><?php 
            } ?>"><?=($page_off+page_size)?>-<?=($page_off+1)?></a><?php
            $page_off -= page_size;
        }
        ?></div><?php
    }
    display_message_by_topic_id($topic_id, 0 + @$offset);
}
?>