CREATE TABLE IF NOT EXISTS `Users` ( /* Note that SQL variables are contained within `grave marks` (the key to the left of the number 1 on your keyboard) NOT 'apostrophes' */
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(15) NOT NULL,
    `password` VARCHAR(120) NOT NULL,
    `first_name` VARCHAR(30) NOT NULL,
    `grade` VARCHAR(10) NOT NULL,
    `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`), /* This is the primary key, which is a unique identifier for each row in the table. Every table MUST have a single primary key (a form of ID number is almost always used as a primany key).*/
    UNIQUE (`username`) /* This is a unique key, which means that no two rows can have the same value for this field, but we don't use it as a primary key for security reasons. */
)/* This is a (single) SQL command. It checks to make sure a Table named 'Users' doesn't already exist, and creates one if not with the following fields and variable types. */