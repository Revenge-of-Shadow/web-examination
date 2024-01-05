<?php
require_once("../connect/database.php");

function display_message($data_row) {
    global $admin;
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
    echo "<div class=$title_class><a class=$uname_class name=$m_message_id";
    if($admin) {
        // link to user permissions page
        echo " href='user.php?id=$m_user_id'";
    }
    echo ">$m_nickname</a>: <strong>$m_title</strong>";
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

function display_message_by_id($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT message.*, message.id AS message_id, user.* FROM message INNER JOIN user ON user.id=user_id WHERE message.id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if(($result = $stmt->get_result()) && ($row = $result->fetch_assoc())) {
        display_message($row);
    }
}
?>