CREATE TABLE menu 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    deleted BOOLEAN NOT NULL, 
    label VARCHAR(255) NOT NULL,
    route VARCHAR(255) NOT NULL,
    params CLOB NOT NULL,
    PRIMARY KEY (id)
);

