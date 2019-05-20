-- ----------------------------
-- Table structure for crm_admin_user_role
-- ----------------------------
DROP TABLE IF EXISTS `crm_admin_user_role`;
CREATE TABLE `crm_admin_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='用户角色关联表';

-- ----------------------------
-- Table structure for crm_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `crm_admin_user`;
CREATE TABLE `crm_admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '登陆的用户名',
  `email` varchar(32) NOT NULL DEFAULT '' COMMENT 'email',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '电话号码',
  `password` char(60) NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 => 启用 0=>禁用',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='管理员信息表';

-- ----------------------------
-- Table structure for crm_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `crm_admin_role`;
CREATE TABLE `crm_admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态 1=>启用 0=>禁用',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unk_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';


-- ----------------------------
-- Table structure for crm_admin_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `crm_admin_role_permission`;
CREATE TABLE `crm_admin_role_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `permission_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`),
  KEY `idx_permission_id` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='角色权限关联表';


-- ----------------------------
-- Table structure for crm_admin_permission
-- ----------------------------
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_parent_id` (`parent_id`),
  KEY `idx_path` (`path`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';













