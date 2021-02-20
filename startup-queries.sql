CREATE DATABASE `pineapple_db`;

CREATE TABLE `pineapple_db`.`emails` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(60) NOT NULL,
    `created_date` TIMESTAMP NOT NULL,
    `is_subscribed` BIT DEFAULT 1,
    `provider` VARCHAR(60) NOT NULL,
    PRIMARY KEY (`id`)
);

alter table `pineapple_db`.`emails` AUTO_INCREMENT=1001;

INSERT INTO `pineapple_db`.`emails` (email, provider)
VALUES ("bob@gmail.com", "Gmail"), ("dylan@yahoo.com", "Yahoo"), ("mr.smith@outlook.com", "Outlook"), ("john@outlook", "Outlook");