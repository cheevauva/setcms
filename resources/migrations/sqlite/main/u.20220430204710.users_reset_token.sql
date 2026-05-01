CREATE TABLE users_reset_token 
(
    id CHAR(36) NOT NULL, 
    user_id CHAR(36) NOT NULL, 
    token CHAR(36) NOT NULL, 
    date_expired DATETIME NOT NULL, 
    PRIMARY KEY (id)
);
