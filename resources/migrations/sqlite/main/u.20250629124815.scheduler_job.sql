CREATE TABLE scheduler_jobs
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    deleted BOOLEAN NOT NULL,
    status VARCHAR(255) NOT NULL, 
    error VARCHAR(255) NULL, 
    scheduler_id CHAR(36) NOT NULL, 
    date_start DATETIME NULL, 
    date_end DATETIME NULL, 
    PRIMARY KEY (id)
);