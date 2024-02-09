CREATE TABLE IF NOT EXISTS  `matchData`(
    `id` INT AUTO_INCREMENT NOT NULL,
    `red_1` INT NOT NULL,
    `red_2` INT NOT NULL,
    `red_3` INT NOT NULL,
    `blue_1` INT NOT NULL,
    `blue_2` INT NOT NULL,
    `blue_3` INT NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (`red_1`) REFERENCES `ScoutMatchData`(`id`),
    FOREIGN KEY (`red_2`) REFERENCES `ScoutMatchData`(`id`),
    FOREIGN KEY (`red_3`) REFERENCES `ScoutMatchData`(`id`),
    FOREIGN KEY (`blue_1`) REFERENCES `ScoutMatchData`(`id`),
    FOREIGN KEY (`blue_2`) REFERENCES `ScoutMatchData`(`id`),
    FOREIGN KEY (`blue_3`) REFERENCES `ScoutMatchData`(`id`),
    PRIMARY KEY (`id`)
)