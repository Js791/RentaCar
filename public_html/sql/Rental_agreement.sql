create table if not exists `rental_agreement`
(
    rental_id int AUTO_INCREMENT,
    address VARCHAR(100),
    name VARCHAR(50),
    days int,
    car_id int,
    card VARCHAR(15),
    Driver_L VARCHAR(15),
    DL_photo text,
    created TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    PRIMARY Key(`rental_id`),
    FOREIGN Key(`car_id`) REFERENCES Cars(`carID`)
)