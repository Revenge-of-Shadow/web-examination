<?php
$collision = @$_GET['collision'];
$missing = @$_GET['missing'];
$mfieldlist = explode(" ", $missing);
$mfieldkeys = array_flip($mfieldlist);

?>
<!DOCTYPE html>
<html>
    <head>
            <title>Register page</title>
            <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body style="text-align:center">
        <form action="register-action.php" method="post">
            <?php
            if(array_key_exists('new_login', $mfieldkeys)){
                ?>
                <label class="errmsg">'Login' field needs to be filled in</label>
                <br/>
                <?php
            }
            if($collision){
                ?>
                <label class="errmsg">Login already exists; choose a different login name</label>
                <br/>
                <?php
            }?>
            <label for="new_login">Your login:</label>
            <input name="new_login" id="login" type="text">
            <br/>
            <?php
            if(array_key_exists('nickname', $mfieldkeys)){
                ?>
                <label class="errmsg">'Nickname' field needs to be filled in</label>
                <br/>
                <?php
            }?>
            <label for="nickname">Your nickname:</label>
            <input name="nickname" autocomplete="username" id="nickname" type="text">
            <br/>
            <?php
            require("../fragments/password-entry.php");
            ?>
            <button type="submit">Register.</button>
        </form>
    </body>
</html>
