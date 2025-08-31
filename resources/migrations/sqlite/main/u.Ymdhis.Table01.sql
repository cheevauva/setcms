CREATE TABLE Table01 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    deleted BOOLEAN NOT NULL, 
    field01 VARCHAR(255) NOT NULL, 
    PRIMARY KEY (id)
);


