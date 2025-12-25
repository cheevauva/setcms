CREATE TABLE schedulers 
(
    id CHAR(36) NOT NULL, 
    entity_type VARCHAR NOT NULL, 
    date_created DATETIME NOT NULL, 
    date_modified DATETIME NOT NULL, 
    deleted BOOLEAN NOT NULL,
    job VARCHAR(255) NOT NULL, 
    cron_expression VARCHAR(255) NOT NULL, 
    is_active BOOLEAN NOT NULL,
    is_safe_run BOOLEAN NOT NULL,
    date_start DATETIME NULL, 
    date_end DATETIME NULL, 
    PRIMARY KEY (id)
);

