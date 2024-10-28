CREATE TABLE `authors` (
	`id` INT(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
	`article_id` INT(11) UNSIGNED NOT NULL,
	`author_id` INT(11) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `author_article_unique` (`article_id`, `author_id`) USING BTREE,
	INDEX `author_key` (`author_id`) USING BTREE,
	INDEX `article_key` (`article_id`) USING BTREE,
	CONSTRAINT `article_author_key` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `author_key` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8mb4_bin'
ENGINE=InnoDB
;