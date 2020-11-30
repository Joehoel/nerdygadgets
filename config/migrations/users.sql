CREATE TABLE IF NOT EXISTS Users (
    UserID int NOT NULL AUTO_INCREMENT,
    Email varchar(45) NOT NULL,
    FirstName varchar(45) NOT NULL,
    LastName varchar(45) NOT NULL,
    Password char(60) NOT NULL,
    /* Hashed */
    PhoneNumber int NOT NULL,
    Adress varchar(45) NOT NULL,
    /* Format->"<street>, <huisnummer>" */
    City varchar(45) NOT NULL,
    Country varchar(45) NOT NULL,
    PostalCode varchar(20) NOT NULL,
    Company varchar(45),
    PRIMARY KEY (UserID)
);
