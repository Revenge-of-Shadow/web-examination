<?php
$passmatch = @$_GET['passmatch'];

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
<input name="password" id="new_password" autocomplete="new-password" type="password">
<br/>
<label for="password">Retype password:</label>
<input name="passcopy" id="copy_password" autocomplete="new-password" type="password">
<br/>
