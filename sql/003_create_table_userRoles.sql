CREATE TABLE IF NOT EXISTS `UserRoles` (
    /* Holds info about which users have which roles. We do this to be able to eaisly toggle roles on and off.
    You can read more about relational databases here: https://en.wikipedia.org/wiki/Relational_database */
    `id` INT AUTO_INCREMENT NOT NULL,
    `user_id` INT NOT NULL,
    `role_id` INT NOT NULL,
    `is_active` TINYINT(1) DEFAULT 1 NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`), /* This is a foreign key, which means that the value of this variable must match the value of the primary key of another table. */
    FOREIGN KEY (`role_id`) REFERENCES `Roles`(`id`)
)