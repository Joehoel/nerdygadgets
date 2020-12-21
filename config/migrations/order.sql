DROP TABLE `weborders`;
CREATE TABLE `weborders` (
	OrderID INT(11) PRIMARY KEY AUTO_INCREMENT,
    UserID INT(11),
    PaymentMethod varchar(45) NOT NULL,
    BankName varchar(45),
    CartCVC varchar(45),
    CartHolder varchar(45),
    ExpDate varchar(45),
    TotalPrice FLOAT NOT NULL,
    OrderDate datetime DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (UserID) REFERENCES users(UserID)
);

DROP TABLE `weborderlines`;
CREATE TABLE `weborderlines` (
	OrderlineID INT(11) AUTO_INCREMENT,
	OrderID INT(11) NOT NULL,
    ProductID INT(11) NOT NULL,
    PRIMARY KEY (OrderlineID),
    FOREIGN KEY (OrderID) REFERENCES weborders(OrderID),
    FOREIGN KEY (ProductID) REFERENCES stockitems(StockItemID)
);
