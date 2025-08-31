CREATE TABLE posts
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    deleted BOOLEAN NOT NULL, 
    slug VARCHAR(255),
    title VARCHAR(255), 
    message CLOB NOT NULL,
    PRIMARY KEY (id)
);
