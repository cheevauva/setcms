CREATE TABLE users_reset_token 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    deleted BOOLEAN NOT NULL, 
    user_id CHAR(36) NOT NULL, 
    token CHAR(36) NOT NULL, 
    date_expired DATETIME NOT NULL, 
    PRIMARY KEY (id)
);
