<?php
$missing = $_GET['missing'];
$failed = $_GET['session_mismatch'];
$mfieldlist = explode(" ", $missing);
$mfieldkeys = array_flip($mfieldlist);

if($failed) {
    ?>
    <p class="errmsg">You must be logged in in order to add topics.</p>
    <?php
}
?>
<!-- Conceptual structure -->
<form action="add-topic-action.php" method="post">
    <?php
    if(array_key_exists('topic_title', $mfieldkeys)){
        ?>
        <label class="errmsg">'Title' field needs to be filled in.</label>
        <br/>
        <?php
    }?>
    <label for="topic_title">Topic title:    </label>
    <input name="topic_title" type="text" id="title">
    <?php
    if(array_key_exists('topic_message', $mfieldkeys)){
        ?>
        <label class="errmsg">'Text' field needs to be filled in.</label>
        <br/>
        <?php
    }?>
    <label for="topic_text">Starter message text:    </label>
    <input name="topic_text" type="text" id="title">
    <br/>
    <button type="submit">Add topic.</button>
</form>