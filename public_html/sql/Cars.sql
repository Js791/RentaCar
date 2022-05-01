Create Table if not exists `Cars`
(
    carID int auto_increment,
    description text,
    brandID int,
    priceID int,
    modelID int,
    stock int DEFAULT 1,
    image text,
    visibility boolean,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    PRIMARY KEY(`carID`),
    FOREIGN Key(`brandID`) REFERENCES brand(`brandID`),
    FOREIGN Key(`modelID`) REFERENCES model(`modelID`),
    FOREIGN Key(`priceID`) REFERENCES prices(`priceID`)
)