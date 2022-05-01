Create table if not exists `prices`
(
    `priceID` int AUTO_INCREMENT,
    `price` DECIMAL(7,2),
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    PRIMARY KEY(`priceID`)
)