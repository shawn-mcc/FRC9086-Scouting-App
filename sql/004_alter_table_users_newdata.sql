/* 
This is an alter table statement. Commands we run in SQL are permanant - so we can't modify 001 anymore
to add new columns - so we have to create a new file and use ALTER to add new fields.

Note that if you create new columns to a table with data already in it, it will default the new 
columns for the existing data to NULL. If you specify a NOT NULL column, it will corrupt rows that 
already have data in it unless you specify a DEFAULT value.
*/
ALTER TABLE `Users` ADD COLUMN `last_name` VARCHAR(30) NOT NULL DEFAULT 'N/A' AFTER `first_name`;

ALTER TABLE `Users` ADD COLUMN `student_id` INT AFTER `last_name`;
