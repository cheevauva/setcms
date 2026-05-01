CREATE TABLE emails 
(
    id CHAR(36) NOT NULL,
    from_addr VARCHAR(255) NOT NULL,
    to_addr VARCHAR(255) NOT NULL, 
    subject VARCHAR(255) NOT NULL, 
    status VARCHAR(50) DEFAULT 'new'  NOT NULL, 
    date_sent DATETIME DEFAULT NULL , 
    body CLOB NOT NULL, 
    PRIMARY KEY (id)
);
