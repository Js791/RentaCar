create table if not exists `brand`
(
    `brandID` int AUTO_INCREMENT,
    `brand` VARCHAR(100) UNIQUE,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    PRIMARY KEY(`brandID`)
)