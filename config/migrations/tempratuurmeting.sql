CREATE TABLE IF NOT EXISTS temperatuurmeting (
    metingID int NOT NULL AUTO_INCREMENT,
    temperatuur varchar(45) NOT NULL, /*in celcius*/
    meting_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (metingID)
);


CREATE TABLE IF NOT EXISTS tempguid(
    current_guid VARCHAR(255) NOT NULL
);