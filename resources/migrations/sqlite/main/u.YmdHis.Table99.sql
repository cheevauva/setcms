CREATE TABLE Table99 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    created_by CHAR(36) NOT NULL, 
    assigned_by CHAR(36) NOT NULL, 
    modified_by CHAR(36) NOT NULL, 
    deleted BOOLEAN NOT NULL, 
    field99 VARCHAR(255) NOT NULL, 
    PRIMARY KEY (id)
);

