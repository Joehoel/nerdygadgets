CREATE TABLE Users (
	UserID int NOT NULL,
    Email varchar(45) NOT NULL,
    Password varchar(45) NOT NULL, # Hashed
    PhoneNumber int,
    StreetAdress varchar(45) NOT NULL,
    PostalCode varchar(20) NOT NULL,
    Company varchar(45),
    PRIMARY KEY (UserID)
);

CREATE TABLE Reviews (
	ReviewID int NOT NULL,
    ProductID int NOT NULL,
    UserID int NOT NULL,
    Rating int NOT NULL,
    Text varchar(1000) NOT NULL,
    PRIMARY KEY (ReviewID),
    FOREIGN KEY (ProductID) REFERENCES StockItems(StockItemID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);
