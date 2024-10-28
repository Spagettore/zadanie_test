CREATE TABLE `article` (
	`id` INT(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
	`header` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_bin',
	`anounce` TEXT NOT NULL COLLATE 'utf8mb4_bin',
	`description` TEXT NOT NULL COLLATE 'utf8mb4_bin',
	`date` DATE NOT NULL,
	`tag_id` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `article_header_unique` (`header`) USING BTREE,
	INDEX `article_tag_key` (`tag_id`) USING BTREE,
	CONSTRAINT `article_tag_key` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8mb4_bin'
ENGINE=InnoDB
;