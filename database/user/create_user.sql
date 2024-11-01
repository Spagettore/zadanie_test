CREATE TABLE `user` (
	`id` INT(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_bin',
	`registration_date` DATE NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `user_name_unique` (`name`) USING BTREE
)
COLLATE='utf8mb4_bin'
ENGINE=InnoDB
;