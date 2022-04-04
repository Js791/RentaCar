Create table if not exists `Users`
( 
    `id` int not null AUTO_INCREMENT,
    `name` VARCHAR(100) not null,
    `email` VARCHAR(100) not null,
    `pass` VARCHAR(100) not null,
    `created` TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    primary key (`id`),
    UNIQUE key (`email`)
)