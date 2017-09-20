/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50622
Source Host           : localhost:3306
Source Database       : yaf

Target Server Type    : MYSQL
Target Server Version : 50622
File Encoding         : 65001

Date: 2017-09-20 17:54:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sdb_admin
-- ----------------------------
DROP TABLE IF EXISTS `sdb_admin`;
CREATE TABLE `sdb_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  PRIMARY KEY (`id`),
  KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sdb_admin
-- ----------------------------
INSERT INTO `sdb_admin` VALUES ('1', 'admin', '96e79218965eb72c92a549dd5a330112');
INSERT INTO `sdb_admin` VALUES ('2', 'geladd', '96e79218965eb72c92a549dd5a330112');

-- ----------------------------
-- Table structure for sdb_kvstore
-- ----------------------------
DROP TABLE IF EXISTS `sdb_kvstore`;
CREATE TABLE `sdb_kvstore` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '序号',
  `prefix` varchar(255) NOT NULL COMMENT 'kvstore类型',
  `key` varchar(255) NOT NULL COMMENT 'kvstore存储的键值',
  `value` longtext COMMENT 'kvstore存储值',
  `dateline` int(10) unsigned DEFAULT NULL COMMENT '存储修改时间',
  `ttl` int(10) unsigned DEFAULT '0' COMMENT '过期时间,0代表不过期',
  PRIMARY KEY (`id`),
  KEY `ind_prefix` (`prefix`),
  KEY `ind_key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sdb_kvstore
-- ----------------------------
INSERT INTO `sdb_kvstore` VALUES ('5', 'login', '6c5a20c45542a4d87ce6974379a67fbd', 'a:2:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:32:\"96e79218965eb72c92a549dd5a330112\";}', '1505900647', '1505922247');
INSERT INTO `sdb_kvstore` VALUES ('6', 'login', '28c9fef9250a98736e40c45e20f55b3f', '', '1', '2');
