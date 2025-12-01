CREATE TABLE pages 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    created_by CHAR(36) NOT NULL, 
    assigned_by CHAR(36) NOT NULL, 
    modified_by CHAR(36) NOT NULL, 
    deleted BOOLEAN NOT NULL, 
    slug VARCHAR(255) NOT NULL, 
    title VARCHAR(255) NOT NULL, 
    content CLOB NOT NULL,
    PRIMARY KEY (id)
);
