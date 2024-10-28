CREATE TABLE `sections` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`section_id` INT(10) UNSIGNED NOT NULL,
	`article_id` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `section_article_unique` (`section_id`, `article_id`) USING BTREE,
	INDEX `article_section_key` (`article_id`) USING BTREE,
	INDEX `section_article_key` (`section_id`) USING BTREE,
	CONSTRAINT `article_section_key` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `section_article_key` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8mb4_bin'
ENGINE=InnoDB
;