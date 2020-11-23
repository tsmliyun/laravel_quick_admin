
DROP TABLE IF EXISTS `crm_admin_permission`;

CREATE TABLE `crm_admin_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `icon` varchar(50) NOT NULL DEFAULT '',
  `path` varchar(50) NOT NULL DEFAULT '' COMMENT '路由',
  `is_menu` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否是菜单,1=>是,0=>否',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `level` tinyint(4) NOT NULL DEFAULT 0 COMMENT '等级',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态 1=>启用 0=>禁用',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_parent_id` (`parent_id`),
  KEY `idx_path` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

LOCK TABLES `crm_admin_permission` WRITE;
/*!40000 ALTER TABLE `crm_admin_permission` DISABLE KEYS */;

INSERT INTO `crm_admin_permission` (`id`, `parent_id`, `title`, `icon`, `path`, `is_menu`, `sort`, `level`, `status`, `created_at`, `updated_at`)
VALUES
	(23,0,'管理员管理','','',1,0,1,1,'2019-05-20 18:37:40','2019-05-20 18:37:40'),
	(24,23,'管理员列表','','admin/admin/lists',1,1,2,1,'2019-05-20 18:38:31','2019-05-20 18:38:31'),
	(25,23,'角色管理','','admin/role/lists',1,2,2,1,'2019-05-20 18:38:59','2019-05-20 18:38:59'),
	(26,23,'权限管理','','admin/permission/lists',1,3,2,1,'2019-05-20 18:39:36','2019-05-20 18:39:36'),
	(27,24,'添加管理员','','admin/admin/create',0,0,3,1,'2019-05-20 18:41:44','2019-05-20 18:41:44'),
	(28,24,'编辑管理员','','admin/admin/edit',0,0,3,1,'2019-05-20 18:42:33','2019-05-20 18:42:33'),
	(29,25,'新增角色','','admin/role/create',0,0,3,1,'2019-05-20 18:43:42','2019-05-20 18:46:29'),
	(30,25,'编辑角色','','admin/role/edit',0,0,3,1,'2019-05-20 18:44:21','2019-05-20 18:46:30'),
	(36,25,'赋权','','admin/role/permission',0,0,3,1,'2019-05-20 18:46:49','2019-05-20 19:00:29'),
	(37,25,'赋权-提交','','admin/role/updatePermission',1,0,3,1,'2019-05-20 18:47:10','2019-05-20 18:47:10'),
	(31,26,'新增权限','','admin/permission/create',0,0,3,1,'2019-05-20 18:46:49','2019-05-20 19:00:29'),
	(32,26,'编辑权限','','admin/permission/edit',1,0,3,1,'2019-05-20 18:47:10','2019-05-20 18:47:10'),
	(33,0,'首页','','admin/index',0,0,1,1,'2019-05-20 23:51:37','2019-05-20 23:51:47'),
	(34,26,'新增权限-提交','','admin/permission/store',0,0,3,1,'2019-05-21 14:38:36','2019-05-21 14:38:36'),
	(35,26,'编辑权限-提交','','admin/permission/update',0,0,3,1,'2019-05-21 14:38:57','2019-05-21 14:38:57');

/*!40000 ALTER TABLE `crm_admin_permission` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table crm_admin_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `crm_admin_role`;

CREATE TABLE `crm_admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态 1=>启用 0=>禁用',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unk_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

LOCK TABLES `crm_admin_role` WRITE;
/*!40000 ALTER TABLE `crm_admin_role` DISABLE KEYS */;

INSERT INTO `crm_admin_role` (`id`, `name`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'超级管理员',1,'2019-05-06 18:52:06','2019-05-07 16:56:26'),
	(2,'普通管理员',1,'2019-05-06 18:52:29','2019-05-06 18:52:29'),
	(8,'开发',1,'2019-05-20 16:50:40','2019-05-20 16:50:40');

/*!40000 ALTER TABLE `crm_admin_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table crm_admin_role_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `crm_admin_role_permission`;

CREATE TABLE `crm_admin_role_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `permission_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`),
  KEY `idx_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色权限关联表';

LOCK TABLES `crm_admin_role_permission` WRITE;
/*!40000 ALTER TABLE `crm_admin_role_permission` DISABLE KEYS */;

INSERT INTO `crm_admin_role_permission` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`)
VALUES
	(12,2,20,'2019-05-20 18:04:36','2019-05-20 18:04:36'),
	(13,2,21,'2019-05-20 18:04:36','2019-05-20 18:04:36'),
	(14,2,22,'2019-05-20 18:04:36','2019-05-20 18:04:36'),
	(26,1,23,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(27,1,24,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(28,1,27,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(29,1,28,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(30,1,25,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(31,1,29,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(32,1,30,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(33,1,26,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(34,1,31,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(35,1,32,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(36,1,34,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(37,1,35,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(38,1,33,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(39,1,36,'2019-05-21 14:39:34','2019-05-21 14:39:34'),
	(40,1,37,'2019-05-21 14:39:34','2019-05-21 14:39:34');

/*!40000 ALTER TABLE `crm_admin_role_permission` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table crm_admin_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `crm_admin_user`;

CREATE TABLE `crm_admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '登陆的用户名',
  `email` varchar(32) NOT NULL DEFAULT '' COMMENT 'email',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '电话号码',
  `password` char(60) NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 => 启用 0=>禁用',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员信息表';

LOCK TABLES `crm_admin_user` WRITE;
/*!40000 ALTER TABLE `crm_admin_user` DISABLE KEYS */;

INSERT INTO `crm_admin_user` (`id`, `username`, `email`, `phone`, `password`, `status`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(27,'li12312','1234@qq.com','15111179935','$2y$10$LFQrR5PWcsxSTYhNYG1tK.IipQHjiJsVakluH4F0iDK50rtUTMVfq',1,'2019-05-20 00:17:56','2019-05-20 11:45:59',NULL);

/*!40000 ALTER TABLE `crm_admin_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table crm_admin_user_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `crm_admin_user_role`;

CREATE TABLE `crm_admin_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户角色关联表';

LOCK TABLES `crm_admin_user_role` WRITE;
/*!40000 ALTER TABLE `crm_admin_user_role` DISABLE KEYS */;

INSERT INTO `crm_admin_user_role` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`)
VALUES
	(1,13,1,'2019-05-07 15:45:55','2019-05-07 15:45:55'),
	(9,1,1,'2019-05-07 16:33:18','2019-05-07 16:33:18'),
	(13,27,1,'2019-05-20 10:37:04','2019-05-20 10:37:04');

/*!40000 ALTER TABLE `crm_admin_user_role` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
