CREATE TABLE IF NOT EXISTS  `Roles`(
    /* Holds info about roles that users can have. */
    `id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(20) NOT NULL UNIQUE, /* You can also define unique variables in-line */
    `description` VARCHAR(250) DEFAULT '',
    `is_active`  TINYINT(1) DEFAULT 1 NOT NULL,
    `created`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `modified`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (`id`)
)