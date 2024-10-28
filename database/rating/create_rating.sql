CREATE TABLE `rating` (
	`id` INT(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`article_id` INT(10) UNSIGNED NOT NULL,
	`rate` INT(10) UNSIGNED ZEROFILL NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `user_article_unique` (`user_id`, `article_id`) USING BTREE,
	INDEX `article_rating_key` (`article_id`) USING BTREE,
	INDEX `user_rating_key` (`user_id`) USING BTREE,
	CONSTRAINT `article_rating_key` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `user_rating_key` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `check_rating` CHECK (`rate` <= 10)
)
COLLATE='utf8mb4_bin'
ENGINE=InnoDB
;