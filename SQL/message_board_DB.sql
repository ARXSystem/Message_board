CREATE DATABASE message_board_DB;
CREATE TABLE message_board_DB.message_data (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY ,
    title VARCHAR(100),
    message VARCHAR (100),
    writer VARCHAR(50),
    img_url VARCHAR(100),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);