CREATE TABLE templates 
(
    id CHAR(36) NOT NULL, 
    slug VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL, 
    template CLOB NOT NULL,
    PRIMARY KEY (id)
);

