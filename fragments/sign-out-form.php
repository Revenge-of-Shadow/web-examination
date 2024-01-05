<form action="sign-out-action.php" method="post">
    <?php
    if($admin) {
        ?><a href="users.php">Manage users</a><?php
    }
    ?>
    Logged-in user: <strong><?=$nickname?></strong>
    <button type="submit" name="submit" style="background-color: red">Sign out.</button>
    <a href="user-actions.php">More...</a>
</form>
