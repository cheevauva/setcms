CREATE TABLE captcha 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    deleted BOOLEAN NOT NULL, 
    is_used INTEGER NOT NULL, 
    is_solved INTEGER NOT NULL, 
    text VARCHAR(50) NOT NULL, 
    solve_attempts INTEGER NOT NULL, 
    date_expiried DATETIME NOT NULL, 
    PRIMARY KEY (id)
);
