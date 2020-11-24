CREATE TABLE IF NOT EXISTS Users (
	UserID int NOT NULL,
    Email varchar(45) NOT NULL,
    Password varchar(45) NOT NULL, # Hashed
    PhoneNumber int NOT NULL,
    Adress varchar(45) NOT NULL, # Format -> "<street>, <huisnummer>"
    City varchar(45) NOT NULL,
    PostalCode varchar(20) NOT NULL,
    Company varchar(45),
    PRIMARY KEY (UserID)
);

