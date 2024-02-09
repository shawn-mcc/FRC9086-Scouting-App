
CREATE TABLE IF NOT EXISTS `ScoutRobotData` (
`id` INT NOT NULL AUTO_INCREMENT,
`auto_stratgy` Varchar (250) NOT NULL,
`load_ground` Tinyint NOT NULL,
`load_source` Tinyint NOT NULL,
`source_amp` Tinyint NOT NULL,
`score_speaker` Tinyint NOT NULL,
`onstage` Tinyint NOT NULL,
`score_trap` Tinyint NOT NUll, 
`notes` Varchar (500) NOT NULL,
`scout` INT NOT NULL,
`team` INT NOT NULL,
`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
Primary Key(`id`),
Foreign Key (`scout`) REFERENCES `Users`(`id`),
Foreign Key (`team`) REFERENCES `Teams`(`id`)
)