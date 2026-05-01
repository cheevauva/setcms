CREATE TABLE menu 
(
    id CHAR(36) NOT NULL, 
    label VARCHAR(255) NOT NULL,
    route VARCHAR(255) NOT NULL,
    params CLOB NOT NULL,
    PRIMARY KEY (id)
);

