-- Create the initial services table
CREATE TABLE IF NOT EXISTS ServiceCategory (
    service_id INT AUTO_INCREMENT NOT NULL,
    ref VARCHAR(32),
    centre TEXT,
    service TEXT,
    country CHAR(4),
    PRIMARY KEY(service_id)
);

-- Load the provided sample data to the initialised table
LOAD DATA INFILE '/var/lib/mysql/data/services.csv'
INTO TABLE ServiceCategory
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS(
    `service_id`,`Ref`,`Centre`,`Service`,`Country`
);