/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `16_activity` */

DROP TABLE IF EXISTS `16_activity`;

CREATE TABLE `16_activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `publisher_id`  int(11) DEFAULT NULL,
  `publisher_name` varchar(50) DEFAULT NULL,
  `status` smallint(6) DEFAULT 1,
  `apply_start_time` date DEFAULT NULL,
  `apply_end_time` date DEFAULT NULL,
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `created_time` datetime DEFAULT NULL,
  `modified_time` datetime DEFAULT NULL,
  `view_count` int(11) DEFAULT 0,
  `attend_count` int(11) DEFAULT 0,
  `follow_count` int(11) DEFAULT 0,
  `book_id` int(11) DEFAULT 0 COMMENT '相关的书ID',
  `area-0` int(11) DEFAULT NULL COMMENT '学校ID',
  `area-1` int(11) DEFAULT NULL COMMENT '区ID',
  `area-2` int(11) DEFAULT 0 COMMENT '市ID',
  `area-3` int(11) DEFAULT 0 COMMENT '省份',
  `area-4` int(11) DEFAULT 0 COMMENT '中国',
  PRIMARY KEY (`activity_id`)
) DEFAULT CHARSET=utf8;

/*Table structure for table `16_activity_attend` */

DROP TABLE IF EXISTS `16_activity_attend`;

CREATE TABLE `16_activity_attend` (
  `activity_attend_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `notified` tinyint(1) DEFAULT 0,
  `rate` tinyint(2) DEFAULT 0,
  `show_info` tinyint(1) DEFAULT 0,
  `say` varchar(200) DEFAULT NULL,
  `introduction` varchar(200) NOT NULL,
  PRIMARY KEY (`activity_attend_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_activity_attend` */

/*Table structure for table `16_activity_follow` */

DROP TABLE IF EXISTS `16_activity_follow`;

CREATE TABLE `16_activity_follow` (
  `activity_attention_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`activity_attention_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_activity_follow` */

/*Table structure for table `16_activity_comment` */

DROP TABLE IF EXISTS `16_activity_comment`;

CREATE TABLE `16_activity_comment` (
  `activity_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`activity_comment_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_activity_comment` */

/*Table structure for table `16_activity_tag` */

DROP TABLE IF EXISTS `16_activity_tag`;

CREATE TABLE `16_activity_tag` (
  `activity_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`activity_tag_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_activity_tag` */

/*Table structure for table `16_application_group` */

DROP TABLE IF EXISTS `16_application_group`;

CREATE TABLE `16_application_group` (
  `application_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` char(1) DEFAULT 'Y',
  `created_by` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_time` datetime DEFAULT NULL,
  PRIMARY KEY (`application_group_id`)
) AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `16_application_group` */

insert  into `16_application_group`(`application_group_id`,`code`,`name`,`status`,`created_by`,`created_time`,`modified_by`,`modified_time`) values (1,'administrator','Administrator','Y',-1,'2011-12-19 00:00:00',-1,'2011-12-19 00:00:00');

/*Table structure for table `16_application_user` */

DROP TABLE IF EXISTS `16_application_user`;

CREATE TABLE `16_application_user` (
  `application_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `application_group_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'Y',
  `created_by` int(11) DEFAULT '0',
  `created_time` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_time` datetime DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`application_user_id`)
) AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `16_application_user` */

/*Table structure for table `16_member` */

DROP TABLE IF EXISTS `16_member`;

CREATE TABLE `16_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(50) NOT NULL,
  `password` char(32) DEFAULT NULL,
  `member_type` char(3) NOT NULL COMMENT 'stu学生 | org学生组织 | chr公益组织 | com公司',
  `status` int(4) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT '/asset/img/default/portrait.jpg',
  `name` varchar(20) NOT NULL COMMENT '姓名或组织名称',
  `principal` varchar(255) DEFAULT NULL COMMENT '机构负责人',
  `gender` char(1) DEFAULT NULL COMMENT '性别',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `school_id` int(11) DEFAULT NULL COMMENT '学校ID',
  `school_name` varchar(50) DEFAULT NULL COMMENT '学校名',
  `qq` varchar(15) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `organisation` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `description` varchar(255) DEFAULT NULL COMMENT '简介',
  `content` text COMMENT '富文本简介',
  `created_time` datetime DEFAULT NULL COMMENT '创建时间',
  `modified_time` datetime DEFAULT NULL COMMENT '修改时间',
  `last_ip` varchar(20) DEFAULT NULL COMMENT '最后登录ip',
  `accept_notification` tinyint(1) DEFAULT 1,
  `area-0` int(11) DEFAULT NULL COMMENT '学校ID',
  `area-1` int(11) DEFAULT NULL COMMENT '区ID',
  `area-2` int(11) DEFAULT 0 COMMENT '市ID',
  `area-3` int(11) DEFAULT 0 COMMENT '省份',
  `area-4` int(11) DEFAULT 0 COMMENT '中国',
  PRIMARY KEY (`member_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_member` */

INSERT INTO `16_member` (`member_id`, `account`, `member_type`) VALUES (0, 'dummy','dummy');

/*Table structure for table `16_book` */

DROP TABLE IF EXISTS `16_book`;

CREATE TABLE `16_book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `author_name` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `created_time` datetime DEFAULT NULL,
  `modified_time` datetime DEFAULT NULL,
  `like_count` int(11) DEFAULT 0,
  `view_count` int(11) DEFAULT 0,
  PRIMARY KEY (`book_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_book` */

/*Table structure for table `16_book_tag` */

DROP TABLE IF EXISTS `16_book_tag`;

CREATE TABLE `16_book_tag` (
  `book_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`book_tag_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_book_tag` */

/*Table structure for table `16_book_comment` */

DROP TABLE IF EXISTS `16_book_comment`;

CREATE TABLE `16_book_comment` (
  `book_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`book_comment_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_book_comment` */

/*Table structure for table `16_book_visit` */

DROP TABLE IF EXISTS `16_book_visit`;

CREATE TABLE `16_book_visit` (
  `book_visit_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `visited_time` datetime NOT NULL,
  PRIMARY KEY (`book_visit_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_book_visit` */

/*Table structure for table `16_feedback` */

DROP TABLE IF EXISTS `16_feedback`;

CREATE TABLE `16_feedback` (
  `member_id` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `message` text
) DEFAULT CHARSET=utf8;

/*Data for the table `16_feedback` */

/*Table structure for table `16_member_friend` */

DROP TABLE IF EXISTS `16_member_friend`;

CREATE TABLE `16_member_friend` (
  `member_friend_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `approved`  tinyint(1)  DEFAULT 0,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`member_friend_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_member_friend` */

/*Table structure for table `16_member_message` */

DROP TABLE IF EXISTS `16_member_message`;

CREATE TABLE `16_member_message` (
  `member_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `content` text,
  `created_time` datetime DEFAULT NULL,
  `group` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`member_message_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_member_message` */

/*Table structure for table `16_member_like_book` */

DROP TABLE IF EXISTS `16_member_like_book`;

CREATE TABLE `16_member_like_book` (
  `member_like_book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`member_like_book_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_member_like_book` */

/*Table structure for table `16_member_tag` */

DROP TABLE IF EXISTS `16_member_tag`;

CREATE TABLE `16_member_tag` (
  `member_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`member_tag_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_member_tag` */

/*Table structure for table `16_member_visit` */

DROP TABLE IF EXISTS `16_member_visit`;

CREATE TABLE `16_member_visit` (
  `member_id` int(11) DEFAULT NULL,
  `visitor_id` int(11) DEFAULT NULL,
  `visit_time` datetime DEFAULT NULL
) DEFAULT CHARSET=utf8;

/*Data for the table `16_member_visit` */

/*Table structure for table `16_member_findpass` */

DROP TABLE IF EXISTS `16_member_findpass`;

CREATE TABLE `16_member_findpass` (
  `member_id` int(11) DEFAULT NULL,
   `vcode` varchar(50) DEFAULT NULL,
   `valid` tinyint(4) DEFAULT NULL
) DEFAULT CHARSET=utf8;

/*Data for the table `16_member_findpass` */

/*Table structure for table `16_news_feed` */

DROP TABLE IF EXISTS `16_news_feed`;

CREATE TABLE `16_news_feed` (
   `news_feed_id` int(11) NOT NULL AUTO_INCREMENT,
   `member_id` int(11) DEFAULT NULL,
   `target_id` int(11) DEFAULT NULL,
   `type` varchar(50) DEFAULT NULL,
   `activity_id` int(11) DEFAULT 0,
   `book_id` int(11) DEFAULT 0,
   `created_time` datetime DEFAULT NULL,
   PRIMARY KEY (`news_feed_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_news_feed` */

/*Table structure for table `16_public_area` */

DROP TABLE IF EXISTS `16_public_area`;

CREATE TABLE `16_public_area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `has_city` char(1) DEFAULT 'Y',
  PRIMARY KEY (`area_id`)
) AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `16_public_area` */

insert  into `16_public_area`(`area_id`,`name`,`type`,`parent_id`,`has_city`) values (1,'北京市','province',0,'N'),(2,'东城区','area',1,'Y'),(3,'西城区','area',1,'Y'),(4,'崇文区','area',1,'Y'),(5,'宣武区','area',1,'Y'),(6,'朝阳区','area',1,'Y'),(7,'丰台区','area',1,'Y'),(8,'石景山区','area',1,'Y'),(9,'海淀区','area',1,'Y'),(10,'门头沟区','area',1,'Y'),(11,'房山区','area',1,'Y'),(12,'通州区','area',1,'Y'),(13,'顺义区','area',1,'Y'),(14,'昌平区','area',1,'Y'),(15,'大兴区','area',1,'Y'),(16,'怀柔区','area',1,'Y'),(17,'平谷区','area',1,'Y'),(18,'密云县','area',1,'Y'),(19,'延庆县','area',1,'Y'),(20,'上海市','province',0,'N'),(21,'黄浦区','area',20,'Y'),(22,'徐汇区','area',20,'Y'),(23,'长宁区','area',20,'Y'),(24,'静安区','area',20,'Y'),(25,'普陀区','area',20,'Y'),(26,'闸北区','area',20,'Y'),(27,'虹口区','area',20,'Y'),(28,'杨浦区','area',20,'Y'),(29,'闵行区','area',20,'Y'),(30,'宝山区','area',20,'Y'),(31,'嘉定区','area',20,'Y'),(32,'浦东新区','area',20,'Y'),(33,'金山区','area',20,'Y'),(34,'松江区','area',20,'Y'),(35,'青浦区','area',20,'Y'),(36,'奉贤区','area',20,'Y'),(37,'崇明县','area',20,'Y');

/*Table structure for table `16_public_school` */

DROP TABLE IF EXISTS `16_public_school`;

CREATE TABLE `16_public_school` (
  `school_id` int(11) NOT NULL AUTO_INCREMENT,
  `province` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`school_id`)
) AUTO_INCREMENT=727 DEFAULT CHARSET=utf8;

/*Data for the table `16_public_school` */

insert  into `16_public_school`(`school_id`,`province`,`city`,`area`,`type`,`name`) values (1,1,NULL,2,'middle_sch','北京八十五中'),(2,1,NULL,2,'middle_sch','北京一六六中'),(3,1,NULL,2,'middle_sch','北京一二五中'),(4,1,NULL,2,'middle_sch','北京二十四中'),(5,1,NULL,2,'middle_sch','北京一七七中'),(6,1,NULL,2,'middle_sch','北京六十五中'),(7,1,NULL,2,'middle_sch','北京一六三中'),(8,1,NULL,2,'middle_sch','北京五十四中'),(9,1,NULL,2,'middle_sch','交道口中学'),(10,1,NULL,2,'middle_sch','北京一二六中'),(11,1,NULL,2,'middle_sch','北京一九五中'),(12,1,NULL,2,'middle_sch','北京一六五中'),(13,1,NULL,2,'middle_sch','北京二十二中'),(14,1,NULL,2,'middle_sch','东直门中学'),(15,1,NULL,2,'middle_sch','北京二十五中'),(16,1,NULL,2,'middle_sch','北京一中'),(17,1,NULL,2,'middle_sch','北京二十一中'),(18,1,NULL,2,'middle_sch','东城师范学校'),(19,1,NULL,2,'middle_sch','北京五中分校'),(20,1,NULL,2,'middle_sch','北京二中分校'),(21,1,NULL,2,'middle_sch','新中街中学'),(22,1,NULL,2,'middle_sch','北京六十一中'),(23,1,NULL,2,'middle_sch','景山学校'),(24,1,NULL,2,'middle_sch','和平里中学'),(25,1,NULL,2,'middle_sch','北京一二八中'),(26,1,NULL,2,'middle_sch','北京一四二中'),(27,1,NULL,2,'middle_sch','北京五十五中'),(28,1,NULL,2,'middle_sch','北京一九六中'),(29,1,NULL,2,'middle_sch','中央工艺美术学院附属中学'),(30,1,NULL,2,'middle_sch','国子监中学（北京一四三中）'),(31,1,NULL,2,'middle_sch','北京七十九中'),(32,1,NULL,2,'middle_sch','北京一七一中'),(33,1,NULL,2,'middle_sch','北京一六四中'),(34,1,NULL,2,'middle_sch','地安门中学'),(35,1,NULL,2,'middle_sch','北京一九零中'),(36,1,NULL,2,'middle_sch','职工中学'),(37,1,NULL,2,'middle_sch','分司厅中学'),(38,1,NULL,2,'middle_sch','北京二十七中'),(39,1,NULL,2,'middle_sch','北京开发区实验学校'),(40,1,NULL,2,'middle_sch','和平北路学校'),(41,1,NULL,3,'middle_sch','北京三中'),(42,1,NULL,3,'middle_sch','北京师范大学附属实验中学分校'),(43,1,NULL,3,'middle_sch','北京九十八中'),(44,1,NULL,3,'middle_sch','裕中中学'),(45,1,NULL,3,'middle_sch','铁路三中'),(46,1,NULL,3,'middle_sch','北京三十三中'),(47,1,NULL,3,'middle_sch','北京五十六中'),(48,1,NULL,3,'middle_sch','北京二十九中'),(49,1,NULL,3,'middle_sch','丰盛中学'),(50,1,NULL,3,'middle_sch','北京一五六中'),(51,1,NULL,3,'middle_sch','北京四十四中'),(52,1,NULL,3,'middle_sch','北京一五四中'),(53,1,NULL,3,'middle_sch','北京八中'),(54,1,NULL,3,'middle_sch','北京三十五中'),(55,1,NULL,3,'middle_sch','铁路二中'),(56,1,NULL,3,'middle_sch','月坛中学'),(57,1,NULL,3,'middle_sch','北京三十一中'),(58,1,NULL,3,'middle_sch','鲁迅中学'),(59,1,NULL,3,'middle_sch','北京三十九中'),(60,1,NULL,3,'middle_sch','北京七中'),(61,1,NULL,3,'middle_sch','北京一六一中'),(62,1,NULL,3,'middle_sch','西城外国语学校'),(63,1,NULL,3,'middle_sch','北京四十一中'),(64,1,NULL,3,'middle_sch','西四中学'),(65,1,NULL,3,'middle_sch','北京一五九中'),(66,1,NULL,3,'middle_sch','北京十三中分校'),(67,1,NULL,3,'middle_sch','三帆中学'),(68,1,NULL,3,'middle_sch','北京二一四中'),(69,1,NULL,3,'middle_sch','汇才中学'),(70,1,NULL,3,'middle_sch','西城实验学校'),(71,1,NULL,3,'middle_sch','北京四中'),(72,1,NULL,3,'middle_sch','北京四十中'),(73,1,NULL,3,'middle_sch','北京十三中'),(74,1,NULL,3,'middle_sch','二龙路中学'),(75,1,NULL,3,'middle_sch','长安中学'),(76,1,NULL,3,'middle_sch','北京八中分校'),(77,1,NULL,3,'middle_sch','北京教育学院附属中学'),(78,1,NULL,3,'middle_sch','北京师范大学第二附属中学'),(79,1,NULL,4,'middle_sch','前门中学'),(80,1,NULL,4,'middle_sch','龙潭中学'),(81,1,NULL,4,'middle_sch','北京九十六中'),(82,1,NULL,4,'middle_sch','北京一零九中'),(83,1,NULL,4,'middle_sch','广渠门中学'),(84,1,NULL,4,'middle_sch','崇文实验中学'),(85,1,NULL,4,'middle_sch','汇文中学'),(86,1,NULL,4,'middle_sch','北京五十中'),(87,1,NULL,4,'middle_sch','北京一一四中'),(88,1,NULL,4,'middle_sch','永定门学校'),(89,1,NULL,4,'middle_sch','文汇中学'),(90,1,NULL,4,'middle_sch','前门外国语学校'),(91,1,NULL,4,'middle_sch','北京十一中'),(92,1,NULL,4,'middle_sch','北京五十中分校'),(93,1,NULL,4,'middle_sch','北京十一中分校'),(94,1,NULL,4,'middle_sch','北京一一五中'),(95,1,NULL,4,'middle_sch','崇文门中学'),(96,1,NULL,4,'middle_sch','北京九十中学'),(97,1,NULL,5,'middle_sch','回民学校'),(98,1,NULL,5,'middle_sch','北京六十六中'),(99,1,NULL,5,'middle_sch','前门西街中学'),(100,1,NULL,5,'middle_sch','育才学校'),(101,1,NULL,5,'middle_sch','北京六十二中'),(102,1,NULL,5,'middle_sch','南菜园中学'),(103,1,NULL,5,'middle_sch','广安中学'),(104,1,NULL,5,'middle_sch','北京四十三中'),(105,1,NULL,5,'middle_sch','北纬路中学'),(106,1,NULL,5,'middle_sch','徐悲鸿中学'),(107,1,NULL,5,'middle_sch','北京师范大学附属中学'),(108,1,NULL,5,'middle_sch','北京十四中'),(109,1,NULL,5,'middle_sch','北京十五中分校'),(110,1,NULL,5,'middle_sch','北京六十三中'),(111,1,NULL,5,'middle_sch','中国戏曲学院附属中学'),(112,1,NULL,5,'middle_sch','华夏女子中学'),(113,1,NULL,5,'middle_sch','北京教育学院宣武分院附属中学'),(114,1,NULL,5,'middle_sch','北京十四中分校'),(115,1,NULL,5,'middle_sch','宣武外国语实验学校'),(116,1,NULL,5,'middle_sch','一四零中学'),(117,1,NULL,6,'middle_sch','双桥中学'),(118,1,NULL,6,'middle_sch','定福庄中学'),(119,1,NULL,6,'middle_sch','草场地中学'),(120,1,NULL,6,'middle_sch','松榆里中学'),(121,1,NULL,6,'middle_sch','安慧北里中学'),(122,1,NULL,6,'middle_sch','垡头中学'),(123,1,NULL,6,'middle_sch','豆各庄中学'),(124,1,NULL,6,'middle_sch','中国旅游学院附属中学'),(125,1,NULL,6,'middle_sch','枣营中学'),(126,1,NULL,6,'middle_sch','团结湖三中'),(127,1,NULL,6,'middle_sch','白家庄中学'),(128,1,NULL,6,'middle_sch','樱花园中学'),(129,1,NULL,6,'middle_sch','八里庄三中'),(130,1,NULL,6,'middle_sch','五路居一中'),(131,1,NULL,6,'middle_sch','大望路中学'),(132,1,NULL,6,'middle_sch','北苑中学'),(133,1,NULL,6,'middle_sch','新源里中学'),(134,1,NULL,6,'middle_sch','酒仙桥一中'),(135,1,NULL,6,'middle_sch','北京十六中'),(136,1,NULL,6,'middle_sch','劲松二中'),(137,1,NULL,6,'middle_sch','北京工业大学附属中学'),(138,1,NULL,6,'middle_sch','十八里店中学'),(139,1,NULL,6,'middle_sch','北京一一九中'),(140,1,NULL,6,'middle_sch','北京七十一中'),(141,1,NULL,6,'middle_sch','高家园中学'),(142,1,NULL,6,'middle_sch','黑庄户中学'),(143,1,NULL,6,'middle_sch','陈经伦中学'),(144,1,NULL,6,'middle_sch','劲松三中'),(145,1,NULL,6,'middle_sch','奶子房中学'),(146,1,NULL,6,'middle_sch','清华大学附属中学'),(147,1,NULL,6,'middle_sch','高碑店中学'),(148,1,NULL,6,'middle_sch','慈云寺中学'),(149,1,NULL,6,'middle_sch','北京八十中管庄分校'),(150,1,NULL,6,'middle_sch','三里屯一中'),(151,1,NULL,6,'middle_sch','北京教科院附属中学'),(152,1,NULL,6,'middle_sch','首都师范大学附属实验学校'),(153,1,NULL,6,'middle_sch','北京化工大学附属中学'),(154,1,NULL,6,'middle_sch','北京九十四中'),(155,1,NULL,6,'middle_sch','北京八十中体育运动学校'),(156,1,NULL,6,'middle_sch','劲松四中'),(157,1,NULL,6,'middle_sch','忠德学校'),(158,1,NULL,6,'middle_sch','同仁中学'),(159,1,NULL,6,'middle_sch','朝阳外国语学校'),(160,1,NULL,6,'middle_sch','北京中医药学院附属中学'),(161,1,NULL,6,'middle_sch','望京实验学校'),(162,1,NULL,6,'middle_sch','拔萃双语学校'),(163,1,NULL,6,'middle_sch','北京八十中'),(164,1,NULL,6,'middle_sch','北京九十七中'),(165,1,NULL,6,'middle_sch','北京实验外国语学校'),(166,1,NULL,6,'middle_sch','北京十七中'),(167,1,NULL,6,'middle_sch','劲松一中'),(168,1,NULL,6,'middle_sch','中国建筑材料科学研究院附属中学'),(169,1,NULL,6,'middle_sch','东方德才学校'),(170,1,NULL,6,'middle_sch','呼家楼中学'),(171,1,NULL,6,'middle_sch','虎城中学'),(172,1,NULL,6,'middle_sch','爱迪外国语学校'),(173,1,NULL,6,'middle_sch','北京服装学院附属中学'),(174,1,NULL,6,'middle_sch','北京九十四中机场分校'),(175,1,NULL,6,'middle_sch','北京青年政治学院附属中学'),(176,1,NULL,6,'middle_sch','北京信息工程学院附属中学'),(177,1,NULL,6,'middle_sch','北京樱花园实验学校'),(178,1,NULL,6,'middle_sch','朝阳育人学校'),(179,1,NULL,6,'middle_sch','陈经纶中学'),(180,1,NULL,6,'middle_sch','陈经纶中学嘉铭分校'),(181,1,NULL,6,'middle_sch','垂杨柳中学'),(182,1,NULL,6,'middle_sch','东方培新学校'),(183,1,NULL,6,'middle_sch','和平街一中'),(184,1,NULL,6,'middle_sch','花家地西里中学'),(185,1,NULL,6,'middle_sch','华侨城黄冈中学'),(186,1,NULL,6,'middle_sch','金盏中学'),(187,1,NULL,6,'middle_sch','楼梓庄中学'),(188,1,NULL,6,'middle_sch','民族学校'),(189,1,NULL,6,'middle_sch','女子实验中学'),(190,1,NULL,6,'middle_sch','日坛中学'),(191,1,NULL,6,'middle_sch','世青中学'),(192,1,NULL,6,'middle_sch','新亚中学'),(193,1,NULL,6,'middle_sch','亚奥学校'),(194,1,NULL,6,'middle_sch','中国人民大学附属中学朝阳学校'),(195,1,NULL,6,'middle_sch','北京市体育场路中学'),(196,1,NULL,6,'middle_sch','陈经纶中学分校'),(197,1,NULL,6,'middle_sch','北京市日坛中学分校'),(198,1,NULL,6,'middle_sch','北京市第六十四中学'),(199,1,NULL,7,'middle_sch','太平桥中学'),(200,1,NULL,7,'middle_sch','左安门中学'),(201,1,NULL,7,'middle_sch','长辛店三中'),(202,1,NULL,7,'middle_sch','右安门三中'),(203,1,NULL,7,'middle_sch','丰台七中'),(204,1,NULL,7,'middle_sch','角门中学'),(205,1,NULL,7,'middle_sch','丰台八中'),(206,1,NULL,7,'middle_sch','首都医科大学附属中学'),(207,1,NULL,7,'middle_sch','郭公庄中学'),(208,1,NULL,7,'middle_sch','王佐学校'),(209,1,NULL,7,'middle_sch','看丹中学'),(210,1,NULL,7,'middle_sch','北京十八中'),(211,1,NULL,7,'middle_sch','丰台路中学'),(212,1,NULL,7,'middle_sch','长辛店一中'),(213,1,NULL,7,'middle_sch','三路居中学'),(214,1,NULL,7,'middle_sch','南苑中学'),(215,1,NULL,7,'middle_sch','芳星园中学'),(216,1,NULL,7,'middle_sch','丰台一中'),(217,1,NULL,7,'middle_sch','南顶中学'),(218,1,NULL,7,'middle_sch','东高地三中'),(219,1,NULL,7,'middle_sch','东铁匠营二中'),(220,1,NULL,7,'middle_sch','卢沟桥中学'),(221,1,NULL,7,'middle_sch','黄土岗中学'),(222,1,NULL,7,'middle_sch','中央音乐学院附属中学'),(223,1,NULL,7,'middle_sch','北京铁路职工子弟第五中学'),(224,1,NULL,7,'middle_sch','槐树岭学校'),(225,1,NULL,7,'middle_sch','云岗二中'),(226,1,NULL,7,'middle_sch','西罗园学校'),(227,1,NULL,7,'middle_sch','洋桥学校'),(228,1,NULL,7,'middle_sch','丰台二中'),(229,1,NULL,7,'middle_sch','航天中学'),(230,1,NULL,7,'middle_sch','北京十二中草桥分校'),(231,1,NULL,7,'middle_sch','首都师范大学附属丽泽中学'),(232,1,NULL,7,'middle_sch','北京十二中体育分校'),(233,1,NULL,7,'middle_sch','丰台实验学校'),(234,1,NULL,7,'middle_sch','大成学校'),(235,1,NULL,7,'middle_sch','东铁匠营一中'),(236,1,NULL,7,'middle_sch','北京十二中'),(237,1,NULL,7,'middle_sch','北京十中'),(238,1,NULL,7,'middle_sch','赵登禹中学'),(239,1,NULL,7,'middle_sch','北京八中怡海分校'),(240,1,NULL,7,'middle_sch','东高地外国语学校'),(241,1,NULL,7,'middle_sch','和义学校'),(242,1,NULL,7,'middle_sch','圣云中学'),(243,1,NULL,7,'middle_sch','右安门外国语学校'),(244,1,NULL,7,'middle_sch','云岗中学'),(245,1,NULL,8,'middle_sch','金顶街二中'),(246,1,NULL,8,'middle_sch','高井中学'),(247,1,NULL,8,'middle_sch','石景山区实验中学'),(248,1,NULL,8,'middle_sch','杨庄中学'),(249,1,NULL,8,'middle_sch','北京九中'),(250,1,NULL,8,'middle_sch','京源学校'),(251,1,NULL,8,'middle_sch','佳汇中学'),(252,1,NULL,8,'middle_sch','北京师范大学励耘实验学校'),(253,1,NULL,8,'middle_sch','北方工业大学附属中学'),(254,1,NULL,8,'middle_sch','北京教育学院石景山分院附属中学'),(255,1,NULL,8,'middle_sch','古城外国语学校'),(256,1,NULL,8,'middle_sch','华奥学校'),(257,1,NULL,8,'middle_sch','景山学校远洋分校'),(258,1,NULL,8,'middle_sch','蓝天二中'),(259,1,NULL,8,'middle_sch','蓝天一中'),(260,1,NULL,8,'middle_sch','礼文中学'),(261,1,NULL,8,'middle_sch','石景山中学'),(262,1,NULL,8,'middle_sch','台京学校'),(263,1,NULL,8,'middle_sch','天泰中学'),(264,1,NULL,8,'middle_sch','同文中学'),(343,1,NULL,9,'middle_sch','双榆树二中'),(344,1,NULL,9,'middle_sch','中国人民大学附属中学'),(345,1,NULL,9,'middle_sch','北京医学院附属中学'),(346,1,NULL,9,'middle_sch','育英学校'),(347,1,NULL,9,'middle_sch','科兴实验中学'),(348,1,NULL,9,'middle_sch','清河中学'),(349,1,NULL,9,'middle_sch','育鸿中学'),(350,1,NULL,9,'middle_sch','学院路中学'),(351,1,NULL,9,'middle_sch','上庄二中'),(352,1,NULL,9,'middle_sch','万泉河中学'),(353,1,NULL,9,'middle_sch','八一中学'),(354,1,NULL,9,'middle_sch','北京钢铁学院附属中学'),(355,1,NULL,9,'middle_sch','北京二十中'),(356,1,NULL,9,'middle_sch','北京石油学院附属中学'),(357,1,NULL,9,'middle_sch','北京四十七中'),(358,1,NULL,9,'middle_sch','十一学校'),(359,1,NULL,9,'middle_sch','北京大学附属中学'),(360,1,NULL,9,'middle_sch','立新学校'),(361,1,NULL,9,'middle_sch','苏家坨中学'),(362,1,NULL,9,'middle_sch','北京农业大学附属中学'),(363,1,NULL,9,'middle_sch','北京一零五中'),(364,1,NULL,9,'middle_sch','永丰中学'),(365,1,NULL,9,'middle_sch','建华实验学校'),(366,1,NULL,9,'middle_sch','中国科技大学附属中学'),(367,1,NULL,9,'middle_sch','北京一二三中'),(368,1,NULL,9,'middle_sch','北京二零六中'),(369,1,NULL,9,'middle_sch','温泉中学'),(370,1,NULL,9,'middle_sch','卫国中学'),(371,1,NULL,9,'middle_sch','明光中学'),(372,1,NULL,9,'middle_sch','上地实验学校'),(373,1,NULL,9,'middle_sch','知春里中学'),(374,1,NULL,9,'middle_sch','星星学校'),(375,1,NULL,9,'middle_sch','陶行知中学'),(376,1,NULL,9,'middle_sch','师达中学'),(377,1,NULL,9,'middle_sch','玉渊潭中学'),(378,1,NULL,9,'middle_sch','清华园兴起中学'),(379,1,NULL,9,'middle_sch','北京五十七中'),(380,1,NULL,9,'middle_sch','六一中学'),(381,1,NULL,9,'middle_sch','海淀教师进修学校附属实验学校'),(382,1,NULL,9,'middle_sch','海淀实验中学'),(383,1,NULL,9,'middle_sch','北京十九中'),(384,1,NULL,9,'middle_sch','北京航空航天大学附属中学'),(385,1,NULL,9,'middle_sch','首都师范大学第二附属中学'),(386,1,NULL,9,'middle_sch','北京一零一中'),(387,1,NULL,9,'middle_sch','尚丽外国语学校'),(388,1,NULL,9,'middle_sch','蓝靛厂中学'),(389,1,NULL,9,'middle_sch','北方交通大学附中'),(390,1,NULL,9,'middle_sch','中国地质大学附属中学'),(391,1,NULL,9,'middle_sch','永定路中学'),(392,1,NULL,9,'middle_sch','北京矿业学院附中'),(393,1,NULL,9,'middle_sch','翠微中学'),(394,1,NULL,9,'middle_sch','北京理工大学附属中学'),(395,1,NULL,9,'middle_sch','科迪实验中学'),(396,1,NULL,9,'middle_sch','海淀外国语实验学校'),(397,1,NULL,9,'middle_sch','北达资源中学'),(398,1,NULL,9,'middle_sch','北京大学附属中学香山学校'),(399,1,NULL,9,'middle_sch','北京六十七中'),(400,1,NULL,9,'middle_sch','北京师范大学第三附属中学'),(401,1,NULL,9,'middle_sch','清华国际学校'),(402,1,NULL,9,'middle_sch','北外附属外国语学校'),(403,1,NULL,9,'middle_sch','二十一世纪实验学校'),(404,1,NULL,9,'middle_sch','康福外国语学校'),(405,1,NULL,9,'middle_sch','上地中学'),(406,1,NULL,9,'middle_sch','上庄中学'),(407,1,NULL,9,'middle_sch','首都师范大学附属育新学校'),(408,1,NULL,9,'middle_sch','首都师范大学附属中学'),(409,1,NULL,9,'middle_sch','太平路中学'),(410,1,NULL,9,'middle_sch','万寿寺中学'),(411,1,NULL,9,'middle_sch','温泉二中'),(412,1,NULL,9,'middle_sch','北京世贤学院附属中学'),(413,1,NULL,9,'middle_sch','清华育才实验学校'),(414,1,NULL,9,'middle_sch','育强中学'),(415,1,NULL,9,'middle_sch','育英中学'),(416,1,NULL,9,'middle_sch','中关村外国语学校'),(417,1,NULL,9,'middle_sch','中关村中学'),(418,1,NULL,9,'middle_sch','北京理工大学附属中学分校'),(419,1,NULL,9,'middle_sch','方致实验学校'),(420,1,NULL,9,'middle_sch','海淀北部新区实验中学'),(421,1,NULL,10,'middle_sch','雁翅中学'),(422,1,NULL,10,'middle_sch','育新学校'),(423,1,NULL,10,'middle_sch','西辛房中学'),(424,1,NULL,10,'middle_sch','坡头中学'),(425,1,NULL,10,'middle_sch','清水中学'),(426,1,NULL,10,'middle_sch','首都师范大学附中永定分校'),(427,1,NULL,10,'middle_sch','三家店铁路中学'),(428,1,NULL,10,'middle_sch','斋堂中学'),(429,1,NULL,10,'middle_sch','新桥路中学'),(430,1,NULL,10,'middle_sch','军庄中学'),(431,1,NULL,10,'middle_sch','大峪中学分校'),(432,1,NULL,10,'middle_sch','妙峰山民族学校'),(433,1,NULL,10,'middle_sch','潭拓寺中学'),(434,1,NULL,10,'middle_sch','体育运动学校'),(435,1,NULL,10,'middle_sch','王平中学'),(436,1,NULL,11,'middle_sch','北京师范大学燕化附属中学'),(437,1,NULL,11,'middle_sch','长阳中学'),(438,1,NULL,11,'middle_sch','良乡中学'),(439,1,NULL,11,'middle_sch','电业中学'),(440,1,NULL,11,'middle_sch','中院中学'),(441,1,NULL,11,'middle_sch','良乡三中'),(442,1,NULL,11,'middle_sch','良乡二中'),(443,1,NULL,11,'middle_sch','青龙湖上万中学'),(444,1,NULL,11,'middle_sch','房山中学'),(445,1,NULL,11,'middle_sch','张坊中学'),(446,1,NULL,11,'middle_sch','石窝中学'),(447,1,NULL,11,'middle_sch','岳各庄中学'),(448,1,NULL,11,'middle_sch','韩村河中学'),(449,1,NULL,11,'middle_sch','北洛中学'),(450,1,NULL,11,'middle_sch','晨曦中学'),(451,1,NULL,11,'middle_sch','南梨园中学'),(452,1,NULL,11,'middle_sch','葫芦垡中学'),(453,1,NULL,11,'middle_sch','夏村中学'),(454,1,NULL,11,'middle_sch','石楼中学'),(455,1,NULL,11,'middle_sch','房山四中'),(456,1,NULL,11,'middle_sch','房山二中'),(457,1,NULL,11,'middle_sch','房山三中'),(458,1,NULL,11,'middle_sch','燕山向阳中学'),(459,1,NULL,11,'middle_sch','燕山前进中学'),(460,1,NULL,11,'middle_sch','燕山星城中学'),(461,1,NULL,11,'middle_sch','南召中学'),(462,1,NULL,11,'middle_sch','中国原子能研究院职工子弟中学'),(463,1,NULL,11,'middle_sch','良乡行宫园学校'),(464,1,NULL,11,'middle_sch','交道中学'),(465,1,NULL,11,'middle_sch','周口店中学'),(466,1,NULL,11,'middle_sch','坨里中学'),(467,1,NULL,11,'middle_sch','南尚乐中学'),(468,1,NULL,11,'middle_sch','琉璃河中学'),(469,1,NULL,11,'middle_sch','良乡四中'),(470,1,NULL,11,'middle_sch','河南中学'),(471,1,NULL,11,'middle_sch','北京煤矿机械厂职工子弟学校'),(472,1,NULL,11,'middle_sch','北潞园学校'),(473,1,NULL,11,'middle_sch','博文学校'),(474,1,NULL,11,'middle_sch','东凤中学'),(475,1,NULL,11,'middle_sch','窦店中学'),(476,1,NULL,11,'middle_sch','房山五中'),(477,1,NULL,11,'middle_sch','官道中学'),(478,1,NULL,11,'middle_sch','良乡五中'),(479,1,NULL,11,'middle_sch','青龙湖中学'),(480,1,NULL,11,'middle_sch','少林寺文武学校'),(481,1,NULL,11,'middle_sch','首都师范大学附属良乡实验学校'),(482,1,NULL,11,'middle_sch','吴天学校'),(483,1,NULL,11,'middle_sch','雨田实验中学'),(484,1,NULL,11,'middle_sch','长沟中学'),(485,1,NULL,12,'middle_sch','南刘中学'),(486,1,NULL,12,'middle_sch','玉桥中学'),(487,1,NULL,12,'middle_sch','梨园中学'),(488,1,NULL,12,'middle_sch','台湖学校'),(489,1,NULL,12,'middle_sch','大杜社中学'),(490,1,NULL,12,'middle_sch','陆辛庄中学'),(491,1,NULL,12,'middle_sch','牛堡屯学校'),(492,1,NULL,12,'middle_sch','于家务中学'),(493,1,NULL,12,'middle_sch','小务中学'),(494,1,NULL,12,'middle_sch','柴厂屯中学'),(495,1,NULL,12,'middle_sch','侯黄庄中学'),(496,1,NULL,12,'middle_sch','觅子店中学'),(497,1,NULL,12,'middle_sch','郎府中学'),(498,1,NULL,12,'middle_sch','胡各庄中学'),(499,1,NULL,12,'middle_sch','宋庄中学'),(500,1,NULL,12,'middle_sch','北苑学校'),(501,1,NULL,12,'middle_sch','北关中学'),(502,1,NULL,12,'middle_sch','通州六中'),(503,1,NULL,12,'middle_sch','龙旺庄中学'),(504,1,NULL,12,'middle_sch','次渠中学'),(505,1,NULL,12,'middle_sch','西集中学'),(506,1,NULL,12,'middle_sch','运河中学'),(507,1,NULL,12,'middle_sch','通州二中'),(508,1,NULL,12,'middle_sch','潞河中学'),(509,1,NULL,12,'middle_sch','永乐店中学'),(510,1,NULL,12,'middle_sch','通州四中'),(511,1,NULL,12,'middle_sch','北京二中通州分校'),(512,1,NULL,12,'middle_sch','潡县中学'),(513,1,NULL,12,'middle_sch','甘棠中学'),(514,1,NULL,12,'middle_sch','立华学校'),(515,1,NULL,12,'middle_sch','潞河国际教育学园'),(516,1,NULL,12,'middle_sch','潞河中学分校'),(517,1,NULL,12,'middle_sch','潞州中学'),(518,1,NULL,12,'middle_sch','时代中学'),(519,1,NULL,12,'middle_sch','树人瑞贝学校'),(520,1,NULL,12,'middle_sch','通州第一实验中学'),(521,1,NULL,12,'middle_sch','新未来实验学校'),(522,1,NULL,12,'middle_sch','育才学校通州分校'),(523,1,NULL,12,'middle_sch','月河中学'),(524,1,NULL,12,'middle_sch','自奋希望学校'),(525,1,NULL,13,'middle_sch','杨镇一中'),(526,1,NULL,13,'middle_sch','杨镇二中'),(527,1,NULL,13,'middle_sch','李遂中学'),(528,1,NULL,13,'middle_sch','高丽营学校'),(529,1,NULL,13,'middle_sch','北石槽中学'),(530,1,NULL,13,'middle_sch','板桥中学'),(531,1,NULL,13,'middle_sch','赵全营中学'),(532,1,NULL,13,'middle_sch','龙湾屯中学'),(533,1,NULL,13,'middle_sch','马坡中学'),(534,1,NULL,13,'middle_sch','顺义五中'),(535,1,NULL,13,'middle_sch','顺义八中'),(536,1,NULL,13,'middle_sch','木林中学'),(537,1,NULL,13,'middle_sch','力迈学校'),(538,1,NULL,13,'middle_sch','北小营中学'),(539,1,NULL,13,'middle_sch','尹家府中学'),(540,1,NULL,13,'middle_sch','大孙各庄中学'),(541,1,NULL,13,'middle_sch','赵各庄中学'),(542,1,NULL,13,'middle_sch','沙岭学校'),(543,1,NULL,13,'middle_sch','小店中学'),(544,1,NULL,13,'middle_sch','南彩学校'),(545,1,NULL,13,'middle_sch','沿河中学'),(546,1,NULL,13,'middle_sch','天竺中学'),(547,1,NULL,13,'middle_sch','牛栏山一中实验学校'),(548,1,NULL,13,'middle_sch','顺义二中'),(549,1,NULL,13,'middle_sch','顺义三中'),(550,1,NULL,13,'middle_sch','北务中学'),(551,1,NULL,13,'middle_sch','俸伯中学'),(552,1,NULL,13,'middle_sch','高丽营二中'),(553,1,NULL,13,'middle_sch','李桥中学'),(554,1,NULL,13,'middle_sch','南法信中学'),(555,1,NULL,13,'middle_sch','牛山二中'),(556,1,NULL,13,'middle_sch','牛山三中'),(557,1,NULL,13,'middle_sch','仁和学校'),(558,1,NULL,13,'middle_sch','圣苑一美语实验学校'),(559,1,NULL,13,'middle_sch','顺义十中'),(560,1,NULL,13,'middle_sch','顺义四中'),(561,1,NULL,13,'middle_sch','新英才学校'),(562,1,NULL,13,'middle_sch','张镇中学'),(563,1,NULL,14,'middle_sch','昌平四中'),(564,1,NULL,14,'middle_sch','昌平三中'),(565,1,NULL,14,'middle_sch','昌平五中'),(566,1,NULL,14,'middle_sch','北七家中学'),(567,1,NULL,14,'middle_sch','百善中学'),(568,1,NULL,14,'middle_sch','长陵中学'),(569,1,NULL,14,'middle_sch','黑山寨学校'),(570,1,NULL,14,'middle_sch','南口学校'),(571,1,NULL,14,'middle_sch','南邵中学'),(572,1,NULL,14,'middle_sch','上苑中学'),(573,1,NULL,14,'middle_sch','平西府中学'),(574,1,NULL,14,'middle_sch','燕丹学校'),(575,1,NULL,14,'middle_sch','满井中学'),(576,1,NULL,14,'middle_sch','大东流中学'),(577,1,NULL,14,'middle_sch','陈庄中学'),(578,1,NULL,14,'middle_sch','兴寿中学'),(579,1,NULL,14,'middle_sch','马池口中学'),(580,1,NULL,14,'middle_sch','中滩中学'),(581,1,NULL,14,'middle_sch','流村中学'),(582,1,NULL,14,'middle_sch','回龙观中学'),(583,1,NULL,14,'middle_sch','崔村中学'),(584,1,NULL,14,'middle_sch','下庄中学'),(585,1,NULL,14,'middle_sch','十三陵中学'),(586,1,NULL,14,'middle_sch','天通苑学校'),(587,1,NULL,14,'middle_sch','二一学校'),(588,1,NULL,14,'middle_sch','桃洼学校'),(589,1,NULL,14,'middle_sch','昌平实验中学'),(590,1,NULL,14,'middle_sch','亭自庄学校'),(591,1,NULL,14,'middle_sch','阳坊中学'),(592,1,NULL,14,'middle_sch','北京师范大学附属亚太实验学校'),(593,1,NULL,14,'middle_sch','天通苑中山实验学校'),(594,1,NULL,14,'middle_sch','小汤山中学'),(595,1,NULL,14,'middle_sch','沙河中学'),(596,1,NULL,14,'middle_sch','汇佳学校'),(597,1,NULL,14,'middle_sch','爱乐学校'),(598,1,NULL,14,'middle_sch','昌平二中'),(599,1,NULL,14,'middle_sch','昌平二中分校'),(600,1,NULL,14,'middle_sch','昌平一中分校'),(601,1,NULL,14,'middle_sch','南口铁道北中学'),(602,1,NULL,14,'middle_sch','前锋学校'),(603,1,NULL,15,'middle_sch','垡上中学'),(604,1,NULL,15,'middle_sch','黄村三中'),(605,1,NULL,15,'middle_sch','朱庄中学'),(606,1,NULL,15,'middle_sch','定福庄中学'),(607,1,NULL,15,'middle_sch','大辛庄中学'),(608,1,NULL,15,'middle_sch','狼垡中学'),(609,1,NULL,15,'middle_sch','长子营中学'),(610,1,NULL,15,'middle_sch','庞各庄中学'),(611,1,NULL,15,'middle_sch','榆垡中学'),(612,1,NULL,15,'middle_sch','凤河营中学'),(613,1,NULL,15,'middle_sch','经济开发区实验学校'),(614,1,NULL,15,'middle_sch','郭家务中学'),(615,1,NULL,15,'middle_sch','青云店中学'),(616,1,NULL,15,'middle_sch','黄村五中'),(617,1,NULL,15,'middle_sch','西红门中学'),(618,1,NULL,15,'middle_sch','红星中学'),(619,1,NULL,15,'middle_sch','孙村中学'),(620,1,NULL,15,'middle_sch','采育中学'),(621,1,NULL,15,'middle_sch','魏善庄中学'),(622,1,NULL,15,'middle_sch','旧宫中学'),(623,1,NULL,15,'middle_sch','亦庄中学'),(624,1,NULL,15,'middle_sch','德茂中学'),(625,1,NULL,15,'middle_sch','大兴七中'),(626,1,NULL,15,'middle_sch','大兴八中'),(627,1,NULL,15,'middle_sch','北京师范大学大兴附属中学'),(628,1,NULL,15,'middle_sch','北京十四中大兴安定分校'),(629,1,NULL,15,'middle_sch','北臧村中学'),(630,1,NULL,15,'middle_sch','大兴六中'),(631,1,NULL,15,'middle_sch','大兴三中'),(632,1,NULL,15,'middle_sch','大兴四中'),(633,1,NULL,15,'middle_sch','大兴五中'),(634,1,NULL,15,'middle_sch','大兴一中'),(635,1,NULL,15,'middle_sch','金海学校'),(636,1,NULL,15,'middle_sch','君谊中学'),(637,1,NULL,15,'middle_sch','礼贤民族中学'),(638,1,NULL,15,'middle_sch','太和中学'),(639,1,NULL,15,'middle_sch','体育运动学校'),(640,1,NULL,15,'middle_sch','兴海学校'),(641,1,NULL,16,'middle_sch','九渡河中学'),(642,1,NULL,16,'middle_sch','怀柔五中'),(643,1,NULL,16,'middle_sch','张各长中学'),(644,1,NULL,16,'middle_sch','喇叭沟门满族中学'),(645,1,NULL,16,'middle_sch','桥梓中学'),(646,1,NULL,16,'middle_sch','汤河口中学'),(647,1,NULL,16,'middle_sch','杨宋中学'),(648,1,NULL,16,'middle_sch','雁栖学校'),(649,1,NULL,16,'middle_sch','怀北学校'),(650,1,NULL,16,'middle_sch','长哨营满族中学'),(651,1,NULL,16,'middle_sch','怀柔四中'),(652,1,NULL,16,'middle_sch','怀柔三中'),(653,1,NULL,16,'middle_sch','庙城中学'),(654,1,NULL,16,'middle_sch','北房中学'),(655,1,NULL,16,'middle_sch','宝山中学'),(656,1,NULL,16,'middle_sch','渤海中学'),(657,1,NULL,16,'middle_sch','茶坞铁路中学'),(658,1,NULL,16,'middle_sch','体育运动学校'),(659,1,NULL,16,'middle_sch','中山第二实验学校'),(660,1,NULL,17,'middle_sch','峪口中学'),(661,1,NULL,17,'middle_sch','大华山中学'),(662,1,NULL,17,'middle_sch','南独乐河中学'),(663,1,NULL,17,'middle_sch','杨桥中学'),(664,1,NULL,17,'middle_sch','马坊中学'),(665,1,NULL,17,'middle_sch','平谷四中'),(666,1,NULL,17,'middle_sch','山东庄中学'),(667,1,NULL,17,'middle_sch','平谷五中'),(668,1,NULL,17,'middle_sch','张各庄中学'),(669,1,NULL,17,'middle_sch','平谷二中'),(670,1,NULL,17,'middle_sch','夏各庄联办中学'),(671,1,NULL,17,'middle_sch','黄松峪中学'),(672,1,NULL,17,'middle_sch','镇罗营中学'),(673,1,NULL,17,'middle_sch','马昌营中学'),(674,1,NULL,17,'middle_sch','门楼庄中学'),(675,1,NULL,17,'middle_sch','刘家河联办中学'),(676,1,NULL,17,'middle_sch','平谷三中'),(677,1,NULL,17,'middle_sch','平谷七中'),(678,1,NULL,17,'middle_sch','北京师范大学附属平谷中学'),(679,1,NULL,17,'middle_sch','金海湖二中'),(680,1,NULL,17,'middle_sch','金海湖一中'),(681,1,NULL,17,'middle_sch','平谷八中'),(682,1,NULL,17,'middle_sch','平谷九中'),(683,1,NULL,17,'middle_sch','平谷中学'),(684,1,NULL,18,'middle_sch','新城子中学'),(685,1,NULL,18,'middle_sch','密云五中'),(686,1,NULL,18,'middle_sch','密云三中'),(687,1,NULL,18,'middle_sch','北庄中学'),(688,1,NULL,18,'middle_sch','高岭中学'),(689,1,NULL,18,'middle_sch','新农村中学'),(690,1,NULL,18,'middle_sch','密云水库中学'),(691,1,NULL,18,'middle_sch','古北口中学'),(692,1,NULL,18,'middle_sch','穆家峪中学'),(693,1,NULL,18,'middle_sch','东邵渠中学'),(694,1,NULL,18,'middle_sch','密云四中'),(695,1,NULL,18,'middle_sch','太师庄中学'),(696,1,NULL,18,'middle_sch','不老屯中学'),(697,1,NULL,18,'middle_sch','大城子中学'),(698,1,NULL,18,'middle_sch','河南寨中学'),(699,1,NULL,18,'middle_sch','巨各庄中学'),(700,1,NULL,18,'middle_sch','密云六中'),(701,1,NULL,18,'middle_sch','十里堡中学'),(702,1,NULL,18,'middle_sch','西田各庄中学'),(703,1,NULL,19,'middle_sch','康庄中学'),(704,1,NULL,19,'middle_sch','张山营中学'),(705,1,NULL,19,'middle_sch','永宁中学'),(706,1,NULL,19,'middle_sch','八达岭中学'),(707,1,NULL,19,'middle_sch','下屯中学'),(708,1,NULL,19,'middle_sch','沈家营中学'),(709,1,NULL,19,'middle_sch','大榆树中学'),(710,1,NULL,19,'middle_sch','旧县中学'),(711,1,NULL,19,'middle_sch','香营学校'),(712,1,NULL,19,'middle_sch','新华民族中学'),(713,1,NULL,19,'middle_sch','刘斌堡中学'),(714,1,NULL,19,'middle_sch','靳家堡中学'),(715,1,NULL,19,'middle_sch','赵庄中学'),(716,1,NULL,19,'middle_sch','清泉铺中学'),(717,1,NULL,19,'middle_sch','井庄中学'),(718,1,NULL,19,'middle_sch','延庆中学'),(719,1,NULL,19,'middle_sch','十一学校'),(720,1,NULL,19,'middle_sch','体育运动学校'),(721,1,NULL,19,'middle_sch','延庆八中'),(722,1,NULL,19,'middle_sch','延庆二中'),(723,1,NULL,19,'middle_sch','延庆七中'),(724,1,NULL,19,'middle_sch','延庆三中'),(725,1,NULL,19,'middle_sch','延庆四中'),(726,1,NULL,3,'middle_sch','北京师范大学附属实验中学');

/*Table structure for table `16_running_value` */

DROP TABLE IF EXISTS `16_running_value`;

CREATE TABLE IF NOT EXISTS `16_running_value` (
  `running_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `value` text,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`running_value_id`)
) AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `16_running_value` */

INSERT INTO `16_running_value` (`running_value_id`, `code`, `value`, `description`) VALUES
  (1, 'limit_query', '10', '单页记录加载数量（如搜索结果）'),
  (2, 'limit_comment', '20', '单页回复加载数量'),
  (3, 'limit_message', '20', '留言板留言单页加载数量'),
  (4, 'svn_version', '1','SVN程序版本号');

/*Table structure for table `16_system_message` */

DROP TABLE IF EXISTS `16_system_message`;

CREATE TABLE `16_system_message` (
  `system_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `status` char(1) DEFAULT 'Y',
  `is_new` char(1) DEFAULT 'Y',
  PRIMARY KEY (`system_message_id`)
) DEFAULT CHARSET=utf8;

/*Data for the table `16_system_message` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
