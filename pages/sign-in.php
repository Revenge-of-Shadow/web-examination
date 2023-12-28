<?php
$missing = $_GET['missing'];
$failed = $_GET['failed'];
$mfieldlist = explode(" ", $missing);
$mfieldkeys = array_flip($mfieldlist);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign-in page</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body style="text-align:center">
<?php
    if($failed) {
?>
    <p class="errmsg">Given combination of the login name and the password you entered matches no registered user.</p>
<?php
}
?>
<form action="sign-in-action.php" method="post">
    <?php
    if(array_key_exists('login', $mfieldkeys)){
        ?>
        <label class="errmsg">'Login' field needs to be filled in</label>
        <br/>
        <?php
    }?>
    <label for="login">Your login:</label>
    <input name="login" id="login" type="text">
    <br/>
    <?php
    if(array_key_exists('password', $mfieldkeys)){
        ?>
        <label class="errmsg">'Password' field needs to be filled in</label>
        <br/>
        <?php
    }?>
    <label for="password">Your password:</label>
    <input name="password" id="password" type="password">
    <br/>
    <button type="submit">Sign in.</button>
</form>
</body>
</html>