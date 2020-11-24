CREATE TABLE IF NOT EXISTS Reviews  (
	ReviewID int NOT NULL,
    ProductID int NOT NULL,
    UserID int NOT NULL,
    Rating int NOT NULL,
    Text varchar(1000) NOT NULL,
    PRIMARY KEY (ReviewID),
    FOREIGN KEY (ProductID) REFERENCES StockItems(StockItemID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);
