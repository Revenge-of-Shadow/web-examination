USE forum;

 INSERT INTO user (login, nickname, hash, admin, disabled)
 VALUES ("motherloving", "Wilford Warfstache", "sp$63247afc6192a", TRUE, FALSE);

UPDATE user 
SET nickname = "djohn"
WHERE id = 1;

UPDATE user 
SET hash = "sp$d63247afc6192"
WHERE id = 1;

UPDATE user 
SET hash = "sp$d63247afc6192"
WHERE id = 1;

UPDATE user 
SET admin = TRUE
WHERE id = 1;

UPDATE user 
SET admin = FALSE
WHERE id = 1;

UPDATE user 
SET disabled = TRUE, admin = false
WHERE id = 1;

SELECT * FROM user WHERE disabled = FALSE;
SELECT * FROM user WHERE disabled = FALSE AND admin = TRUE;