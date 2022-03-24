-- Tell mysql which database we're using
USE ServicesApi;

-- Create the initial services table
CREATE TABLE IF NOT EXISTS ServiceCategory (
    service_id INT AUTO_INCREMENT NOT NULL,
    ref VARCHAR(32),
    centre TEXT,
    service TEXT,
    country CHAR(4),
    PRIMARY KEY(service_id)
);

-- Populate with service data records
INSERT INTO `ServiceCategory` 
    VALUES (1,'APPLAB1','Aperture Science','Portal Technology','fr'),
    (2,'BMELAB1','Black Mesa','Interdimensional Travel','de'),
    (3,'BMELAB2','Black Mesa Second Site','Interdimensional Travel','DE'),
    (4,'WEYLAB1','Weyland Yutani Research','Xeno-biology','gb'),
    (5,'BLULAB3','Blue Sun R&D','Behaviour Modification','cz'),
    (6,'TYRLAB2','Tyrell Research','Synthetic Consciousness','GB');