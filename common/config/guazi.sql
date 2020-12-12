


-- 增加发布字段
alter table `sf_video` add `publish_clients` varchar(128) NOT NULL DEFAULT '' COMMENT '发布端 ,拼接' after `category_ids`;

-- 增加站点区域限制字段
alter table `sf_setting_system` add `area_limit` varchar(32) NOT NULL DEFAULT '1,2,3,4,5' COMMENT '站点适用区域 ,拼接' after `site_name`;

-- 增加ip记录表
CREATE TABLE `sf_ip_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `area` varchar(32) NOT NULL DEFAULT '' COMMENT '国家或地区',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(64) NOT NULL DEFAULT '' COMMENT '城市',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ip地址记录';


