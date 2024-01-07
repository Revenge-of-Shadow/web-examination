CREATE DATABASE forum;
USE forum;

CREATE TABLE user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(32) UNIQUE,
    nickname TINYTEXT,
    hash VARCHAR(80) NOT NULL,
    session_secret VARCHAR(80),
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
    edit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (parent_id) REFERENCES message(id),
    FOREIGN KEY (topic_id) REFERENCES message(id)
);

SET SQL_SAFE_UPDATES = 0;