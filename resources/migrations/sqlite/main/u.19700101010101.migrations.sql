CREATE TABLE IF NOT EXISTS migrations 
(
    version VARCHAR(191) NOT NULL,
    executed_at DATETIME DEFAULT NULL ,
    execution_time INTEGER DEFAULT NULL ,
    PRIMARY KEY (version)
);

