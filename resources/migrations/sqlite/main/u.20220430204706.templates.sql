CREATE TABLE templates 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    deleted BOOLEAN NOT NULL,
    slug VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL, 
    template CLOB NOT NULL,
    PRIMARY KEY (id)
);

