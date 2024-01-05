<?php
$collision = @$_GET['collision'];
$passmatch = @$_GET['passmatch'];
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
            if(array_key_exists('login', $mfieldkeys)){
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
            <label for="login">Your login:</label>
            <input name="login" id="login" type="text">
            <br/>
            <?php
            if(array_key_exists('nickname', $mfieldkeys)){
                ?>
                <label class="errmsg">'Nickname' field needs to be filled in</label>
                <br/>
                <?php
            }?>
            <label for="nickname">Your nickname:</label>
            <input name="nickname" id="nickname" type="text">
            <br/>
            <?php
            if(array_key_exists('password', $mfieldkeys)){
                ?>
                <label class="errmsg">'Password' field needs to be filled in</label>
                <br/>
                <?php
            }
            if($passmatch){
                ?>
                <label class="errmsg">Passwords must match</label>
                <br/>
                <?php
            }?>
            <label for="password">Your password:</label>
            <input name="password" id="password" type="password">
            <br/>
            <label for="password">Retype password:</label>
            <input name="passcopy" id="password" type="password">
            <br/>
            <button type="submit">Register.</button>
        </form>
    </body>
</html>
