create table if not exists `model`
(
    `modelID` int AUTO_INCREMENT,
    `model` VARCHAR(100) UNIQUE,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    PRIMARY KEY(`modelID`)
)