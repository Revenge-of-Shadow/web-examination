USE forum;

CREATE TABLE user(
id INT AUTO_INCREMENT PRIMARY KEY,
login VARCHAR(32) UNIQUE,
nickname TINYTEXT,
hash VARCHAR(32), 
admin BOOL,
disabled BOOL
);

CREATE TABLE message(
id INT AUTO_INCREMENT PRIMARY KEY,
message_text TEXT,
title TINYTEXT,
user_id INT,
parent_id INT NULL,
topic_id INT NULL,
removed BOOL,
sent_time DATETIME,
edit_time TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES user(id),
FOREIGN KEY (parent_id) REFERENCES message(id),
FOREIGN KEY (topic_id) REFERENCES message(id)
);

SELECT * FROM user;
ALTER TABLE user MODIFY COLUMN hash VARCHAR(80) NOT NULL;
ALTER TABLE user ADD COLUMN session_secret VARCHAR(80);