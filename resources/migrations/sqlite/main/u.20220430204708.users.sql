CREATE TABLE users 
(
    id CHAR(36) NOT NULL,
    email VARCHAR(254) NOT NULL, 
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_role VARCHAR(50) NOT NULL, 
    PRIMARY KEY (id)
);

