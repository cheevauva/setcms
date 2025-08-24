CREATE TABLE user_sessions 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    deleted BOOLEAN NOT NULL,
    device VARCHAR(50) NOT NULL,
    user_id CHAR(36) DEFAULT NULL,
    date_expiries DATETIME NOT NULL, 
    PRIMARY KEY (id)
);
