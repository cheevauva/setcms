CREATE TABLE users 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL,
    date_modified DATETIME NOT NULL,
    created_by CHAR(36) NOT NULL, 
    assigned_by CHAR(36) NOT NULL, 
    modified_by CHAR(36) NOT NULL, 
    deleted BOOLEAN NOT NULL,
    email VARCHAR(254) NOT NULL, 
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    "role" VARCHAR(50) NOT NULL, 
    extra CLOB DEFAULT '{}'  NOT NULL,
    PRIMARY KEY (id)
);

