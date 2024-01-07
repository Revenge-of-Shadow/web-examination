<?php
if(@$login) {
    ?>
    <form action="sign-out-action.php" method="post">
        Logged-in user: <strong><?=$nickname?></strong>
        <button type="submit" name="submit" style="background-color: red">Sign out.</button>
        <a href="user.php">Your profile</a>
    </form>
    <?php
} else {
    ?>You are currently logged out. <a href="sign-in.php">Sign in</a> or <a href="register.php">sign up</a>.<?php
}
?>