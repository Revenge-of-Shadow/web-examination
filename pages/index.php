<!DOCTYPE html>
<html>
    <head>
            <title>PHP Test</title>
    </head>
    <body style="text-align:center">
        <h1><?php echo $_SERVER['HTTP_USER_AGENT']; ?></h1>
        
        <form action="action.php" method="post">
    	    <label for="name">Your name:</label>
    	    <input name="name" id="name" type="text">
    	    
    	    <label for "age">Your age:</label>
    	    <input name="age" id="age" type="number">
    	    
    	    <button type="submit">Submit</button>
    	</form>
    </body>
</html>