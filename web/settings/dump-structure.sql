-- ----------------------------
--  Table structure 
-- ----------------------------

DROP TABLE IF EXISTS `banners_logs`;
CREATE TABLE `banners_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` char(15) NOT NULL,
  `user_agent` varchar(256) NOT NULL,
  `page_url` varchar(256) NOT NULL,
  `user_hash` char(32) NOT NULL,
  `views_count` int(10) unsigned NOT NULL,
  `view_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL, 
  `request` text DEFAULT NULL,
  `server` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_banners_logs_user_hash` (`user_hash`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
