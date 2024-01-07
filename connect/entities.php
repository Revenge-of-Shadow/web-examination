<?php
require_once("../connect/database.php");

function display_message($data_row) {
    global $admin, $login_id;
    extract($data_row, EXTR_OVERWRITE | EXTR_PREFIX_ALL, "m");
    $is_topic = !$m_parent_id;
    $m_removed |= $m_disabled;
    $uname_class = "username";
    if($m_removed) {
        $m_title = "(removed message)";
        $uname_class = "deadname";
    }
    $block_class = $is_topic ? "topic" : "reply";
    $title_class = $block_class."_title";
    $lines_class = $block_class."_lines";
    echo "<hr>\n";
    if(!$m_removed) {
        echo "<div class=msg_actions>";
        if($m_message_id != $m_topic_id) {
            echo "<a href='reply-to.php?parent_id=$m_message_id'><img src='../images/reply.png'></a>";
        }
        if($login_id == $m_user_id) {
            echo "<a href='reply-to.php?edit_id=$m_message_id'><img src='../images/edit.png'></a>";
        }
        if($admin || $login_id == $m_user_id) {
            echo "<a href='reply-to.php?edit_id=$m_message_id&del=1'><img src='../images/delete.png'></a>";
        }
        echo "</div>\n";
    }
    echo "<div class=$title_class><a class=$uname_class name=$m_message_id href='user.php?id=$m_user_id'>$m_nickname</a>:\n";
    echo "<strong>$m_title</strong>\n";
    if($m_parent_id && $m_parent_id != $m_topic_id && !@$m_orphan) {
        echo "[to: <a href='reply-to.php?parent_id=$m_parent_id'>$m_parent</a>]";
    }
    echo "</div>\n";
    if(!$m_removed) {
        $lines = str_replace("\n", "<br>", $m_message_text);
        echo "<blockquote class=$lines_class>$lines</blockquote>\n";
    }
    echo "<div class=times>\n";
    echo "Created: $m_sent_time\n";
    if($m_sent_time != $m_edit_time) {
        echo "Modified: $m_edit_time";
    }
    echo "</div>\n";
}

function msg_query() {
    // slightly more elegant than a constant definition
    return "SELECT message.*, message.id AS message_id, user.*,
            threads.title AS parent, threads.removed AS orphan FROM message
            LEFT JOIN message AS threads ON threads.id=message.parent_id
            INNER JOIN user ON user.id=message.user_id WHERE ";
}

function display_message_by_id($id) {
    global $mysqli;
    $stmt = $mysqli->prepare(msg_query() . " message.id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if(($result = $stmt->get_result()) && ($row = $result->fetch_assoc())) {
        display_message($row);
    }
    return $row['topic_id'];
}

function display_message_by_topic_id($topic_id) {
    global $mysqli;
    global $offset;
    $page_size = page_size; // bind_param requires passing by reference (not possible with constants)
    $stmt = $mysqli->prepare(msg_query() . " message.topic_id=? AND message.id!=message.topic_id LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $topic_id, $page_size, $offset);
    $stmt->execute();

    if($result = $stmt->get_result()) {
        while($row = $result->fetch_assoc()) {
            display_message($row);
        }
    }
}
?>