-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: shop
-- ------------------------------------------------------
-- Server version	5.1.73

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresss`
--

CREATE DATABASE IF EXISTS `SHOP`;

USE SHOP;

DROP TABLE IF EXISTS `addresss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresss` (
  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `address_name` char(20) NOT NULL DEFAULT '',
  `address_location` char(130) NOT NULL DEFAULT '',
  `phone` char(12) NOT NULL DEFAULT '',
  `qq` char(12) NOT NULL DEFAULT '',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresss`
--

LOCK TABLES `addresss` WRITE;
/*!40000 ALTER TABLE `addresss` DISABLE KEYS */;
INSERT INTO `addresss` VALUES (2,1,'工贸','工贸','34234535','455646546',0);
/*!40000 ALTER TABLE `addresss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `begs`
--

DROP TABLE IF EXISTS `begs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `begs` (
  `beg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `beg_title` char(60) NOT NULL DEFAULT '',
  `beg_desc` varchar(150) NOT NULL DEFAULT '',
  `price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00',
  `qq` char(12) NOT NULL DEFAULT '',
  `phone` char(12) NOT NULL DEFAULT '',
  `address` varchar(130) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `stop_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_full` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`beg_id`),
  KEY `user_id` (`user_id`),
  KEY `is_full` (`is_full`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `begs`
--

LOCK TABLES `begs` WRITE;
/*!40000 ALTER TABLE `begs` DISABLE KEYS */;
INSERT INTO `begs` VALUES (1,2,'dandan','乐视2','乐视2s杀杀杀杀杀杀杀杀杀杀杀杀杀杀杀sssss','1000.00','1113465296','17817939577','工贸校园一站式楼下交易',1462238502,0,1462216902,1),(2,2,'dandan','滴滴答答','打打打打答复打打发达打发个反反复复凤飞飞打打打打打','1000.00','11112222222','11111111111','工贸校园一站式楼下交易',1462238831,0,1462217231,0),(3,3,'wangwencan','测试测试测试测试','测试测试测试测试测试测试测试测试测试测试','55.00','','12345678912','工贸校园一站式楼下交易',1462246497,0,1464924897,0);
/*!40000 ALTER TABLE `begs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bugs`
--

DROP TABLE IF EXISTS `bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bugs` (
  `bug_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `content` varchar(200) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_full` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bug_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bugs`
--

LOCK TABLES `bugs` WRITE;
/*!40000 ALTER TABLE `bugs` DISABLE KEYS */;
INSERT INTO `bugs` VALUES (1,2,'dandan','，，，，，，，，，，',1462238296,0);
/*!40000 ALTER TABLE `bugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorys`
--

DROP TABLE IF EXISTS `categorys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorys` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` char(6) NOT NULL DEFAULT '',
  `cat_desc` char(30) NOT NULL DEFAULT '',
  `grade` smallint(5) unsigned NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorys`
--

LOCK TABLES `categorys` WRITE;
/*!40000 ALTER TABLE `categorys` DISABLE KEYS */;
INSERT INTO `categorys` VALUES (1,'文具','文具描述',16,1459484036,1),(2,'图书','图书描述',15,1459484036,1),(3,'化妆品','化妆品描述',14,1459484036,1),(4,'服饰','服饰描述',13,1459484036,1),(5,'箱包','箱包描述',12,1459484036,1),(6,'鞋靴','鞋靴描述',11,1459484036,1),(7,'运动户外','运动户外描述',10,1459484036,1),(8,'生活用品','生活用品描述',9,1459484036,1),(9,'电子用品','电子用品描述',8,1459484036,1),(10,'虚拟物品','虚拟物品描述',7,1459484036,1),(11,'礼品卡卷','礼品卡卷',6,1459484036,1),(12,'食品','食品描述',5,1459484036,1),(13,'特产','特产描述',4,1459484036,1),(14,'五金','五金描述',3,1459484036,1),(15,'乐器','乐器描述',2,1459484036,1),(16,'其它','其它描述',1,1459484036,1);
/*!40000 ALTER TABLE `categorys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collect_goods`
--

DROP TABLE IF EXISTS `collect_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collect_goods` (
  `collect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `shop_price` decimal(7,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`collect_id`),
  KEY `good_id` (`good_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collect_goods`
--

LOCK TABLES `collect_goods` WRITE;
/*!40000 ALTER TABLE `collect_goods` DISABLE KEYS */;
INSERT INTO `collect_goods` VALUES (4,5,1,1462293035,'50.00'),(5,2,1,1462439503,'999.00'),(7,9,10,1462753839,'500.00');
/*!40000 ALTER TABLE `collect_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(10) unsigned NOT NULL DEFAULT '0',
  `beg_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lost_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `raply_name` char(20) NOT NULL DEFAULT '',
  `raply_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` char(100) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `good_id` (`good_id`),
  KEY `beg_id` (`beg_id`),
  KEY `lost_id` (`lost_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,3,0,0,'dandan',2,'',0,'3rerere',1462236197),(2,3,0,0,'wangwencan',3,'dandan',2,'1',1462237157),(3,4,0,0,'dandan',2,'',0,'。。。。。。。',1462237321),(4,3,0,0,'dandan',2,'wangwencan',3,'2',1462237349),(5,4,0,0,'hookidea',1,'dandan',2,'成色如何？',1462245034),(6,3,0,0,'wangwencan',3,'dandan',2,'傻了\r\n',1462246070),(7,3,0,0,'hookidea',1,'wangwencan',3,'傻逼',1462246466),(8,0,3,0,'wangwencan',3,'',0,'545+45\r\n',1462246512),(9,0,3,0,'wangwencan',3,'',0,'47945646464646',1462246544),(10,0,3,0,'wangwencan',3,'wangwencan',3,'11111111111111111111111111111',1462246599),(11,0,3,0,'wangwencan',3,'wangwencan',3,'11111111111111111111',1462246602),(12,0,3,0,'wangwencan',3,'wangwencan',3,'11111111111111111111111111111111111',1462246605),(13,0,3,0,'wangwencan',3,'wangwencan',3,'1是是是是是是是是是是是是是',1462246610),(14,0,3,0,'wangwencan',3,'wangwencan',3,'是11是 是1  额额额额额额额额额额额饿啊法师打发傻傻的',1462246620),(15,2,0,0,'hookidea',1,'',0,'好好干归属感',1462418176),(16,2,0,0,'hookidea',1,'',0,'淡淡的凤飞飞',1462418194),(17,2,0,0,'hookidea',1,'',0,'老了老了',1462439475),(18,2,0,0,'hookidea',1,'hookidea',1,'好',1462463249);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_verify`
--

DROP TABLE IF EXISTS `email_verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_verify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `hash` char(30) NOT NULL DEFAULT '',
  `fail_time` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_verify`
--

LOCK TABLES `email_verify` WRITE;
/*!40000 ALTER TABLE `email_verify` DISABLE KEYS */;
INSERT INTO `email_verify` VALUES (2,1,'7z9dscb6F5QZBuEo28qlOeWx1tpyXH',1462326676,0);
/*!40000 ALTER TABLE `email_verify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `good_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `good_sn` char(15) NOT NULL DEFAULT '',
  `good_name` char(60) NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `shop_price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00',
  `promote_price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00',
  `good_desc` varchar(150) NOT NULL DEFAULT '',
  `good_number` smallint(5) unsigned NOT NULL DEFAULT '1',
  `collect_num` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb_img` char(70) NOT NULL DEFAULT '',
  `qq` char(12) NOT NULL DEFAULT '',
  `phone` char(12) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_check` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_on_sale` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_chaffer` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_promote` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_lift` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_switch` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `keywords` varchar(30) NOT NULL DEFAULT '',
  `address` varchar(130) NOT NULL DEFAULT '',
  `switch` varchar(30) NOT NULL DEFAULT '',
  `sales_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`good_id`),
  KEY `cat_id` (`cat_id`),
  KEY `good_sn` (`good_sn`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `is_delete` (`is_delete`),
  KEY `is_on_sale` (`is_on_sale`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (1,9,'G20160502186383','我又来测试了',1,'hookidea','888.00','0.00','我又来测试了我又来测试了我又来测试了我又来测试了',9,0,'/Uploads/Images/Good/2016/05/02/230_760012.jpeg','','3424234243',1462184160,1,0,0,1,1,0,0,1,'电脑，手机，笔记本','工贸校园一站式楼下交易','MAC',0),(2,9,'G20160502185407','又来了。。。。。',1,'hookidea','999.00','0.00','又来了。。。。。又来了。。。。。又来了。。。。。',9,1,'/Uploads/Images/Good/2016/05/02/230_477244.png','45345345345','',1462184223,1,0,0,1,1,0,0,1,'测试','工贸校园一站式楼下交易','啥都行',0),(3,9,'G20160503071632','开工了，，，，，，',1,'hookidea','888.00','8.00','开工了，，，，，，开工了，，，，，，开工了，，，，，，开工了，，，，，，开工了，，，，，，开工了，，，，，，',10,0,'/Uploads/Images/Good/2016/05/03/230_432915.png','34234234','1111111111',1462233012,1,0,0,1,1,1,0,1,'测试','工贸校园一站式楼下交易','电脑',0),(4,16,'G20160503097035','口罩',2,'dandan','10.00','8.00','DIY白色口罩，带有图纹的口罩，，，，，，，，',10,0,'/Uploads/Images/Good/2016/05/03/230_992958.jpeg','1113465296','17817939577',1462237218,0,0,0,1,0,1,0,1,'口罩','工贸校园一站式楼下交易','手套',0),(5,1,'G20160503117245','测试测试测试测试',3,'wangwencan','50.00','0.00','测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试',9,1,'/Uploads/Images/Good/2016/05/03/230_869571.jpeg','','12345678912',1462245651,1,0,0,1,1,0,0,1,'测试测试','工贸校园一站式楼下交易','测试测试',0),(6,2,'G20160504141217','web性能实践日志',4,'huahua','20.00','10.00','web性能实践日志，好书！web性能实践日志，好书！web性能实践日志，好书！',1,0,'/Uploads/Images/Good/2016/05/04/230_570695.jpeg','1694208780','18819213354',1462343517,1,0,0,1,1,1,0,1,'web性能实践日志','工贸校园一站式楼下交易','',0),(7,12,'G20160504165264','测试测试',6,'wangwen','11.00','0.00','测试测试测试测试测试测试测试测试测试测试测试',1,0,'/Uploads/Images/Good/2016/05/04/230_317183.jpeg','','12345678911',1462350316,1,0,0,1,1,0,0,1,'吃的。','工贸校园一站式楼下交易','测试测试',0),(8,2,'G20160504169644','电脑',5,'123456789','2000.00','1500.00','胡明明嘻嘻婆婆POS你嘻嘻嘻嘻嘻给第二排ppssppMSN色色press哦我per热Mrs二',0,0,'/Uploads/Images/Good/2016/05/04/230_517430.jpeg','939154063','13763045006',1462350503,1,0,0,1,1,1,0,1,'电脑','工贸校园一站式楼下交易','不知道',0),(9,9,'G20160508211509','机械键盘',9,'q123456','500.00','0.00','九成新机械键盘红轴，买后可给你一个敲键盘的快感，可事全宿舍为你而疯狂。',1,1,'/Uploads/Images/Good/2016/05/08/230_259605.jpeg','','13763045006',1462715451,1,0,0,1,1,0,0,1,'键盘','工贸校园一站式楼下交易','手机或山地越野车',0);
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `handles`
--

DROP TABLE IF EXISTS `handles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `handles` (
  `handle_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `action` char(4) NOT NULL DEFAULT '',
  `controller` char(4) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`handle_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `handles`
--

LOCK TABLES `handles` WRITE;
/*!40000 ALTER TABLE `handles` DISABLE KEYS */;
/*!40000 ALTER TABLE `handles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `image_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `save_path` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`image_id`),
  KEY `good_id` (`good_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,0,1,'/Uploads/Images/Head/0.png'),(2,1,0,'/Uploads/Images/Good/2016/05/02/550_760012.jpeg'),(3,1,0,'/Uploads/Images/Good/2016/05/02/550_855996.png'),(4,2,0,'/Uploads/Images/Good/2016/05/02/550_477244.png'),(5,2,0,'/Uploads/Images/Good/2016/05/02/550_740912.jpeg'),(6,3,0,'/Uploads/Images/Good/2016/05/03/550_432915.png'),(7,3,0,'/Uploads/Images/Good/2016/05/03/550_498032.png'),(8,0,2,'/Uploads/Images/Head/0.png'),(9,0,3,'/Uploads/Images/Head/3H9015308382.jpeg'),(10,4,0,'/Uploads/Images/Good/2016/05/03/550_992958.jpeg'),(11,5,0,'/Uploads/Images/Good/2016/05/03/550_869571.jpeg'),(12,0,4,'/Uploads/Images/Head/0.png'),(13,6,0,'/Uploads/Images/Good/2016/05/04/550_570695.jpeg'),(14,0,5,'/Uploads/Images/Head/0.png'),(15,0,6,'/Uploads/Images/Head/0.png'),(16,7,0,'/Uploads/Images/Good/2016/05/04/550_317183.jpeg'),(17,8,0,'/Uploads/Images/Good/2016/05/04/550_517430.jpeg'),(18,8,0,'/Uploads/Images/Good/2016/05/04/550_634771.jpeg'),(19,0,7,'/Uploads/Images/Head/0.png'),(20,0,8,'/Uploads/Images/Head/0.png'),(21,0,9,'/Uploads/Images/Head/0.png'),(22,9,0,'/Uploads/Images/Good/2016/05/08/550_259605.jpeg'),(23,0,10,'/Uploads/Images/Head/0.png');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `letters`
--

DROP TABLE IF EXISTS `letters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `letters` (
  `letter_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `raply_id` int(10) unsigned NOT NULL DEFAULT '0',
  `raply_name` char(20) NOT NULL DEFAULT '',
  `content` varchar(100) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`letter_id`),
  KEY `user_id` (`user_id`),
  KEY `raply_id` (`raply_id`),
  KEY `is_read` (`is_read`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `letters`
--

LOCK TABLES `letters` WRITE;
/*!40000 ALTER TABLE `letters` DISABLE KEYS */;
INSERT INTO `letters` VALUES (1,3,'wangwencan',1,'hookidea','测试',1462246173,1),(2,3,'wangwencan',1,'hookidea','78156\r\n',1462246455,1);
/*!40000 ALTER TABLE `letters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lifts`
--

DROP TABLE IF EXISTS `lifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lifts` (
  `lift_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lift_id`),
  KEY `user_id` (`user_id`),
  KEY `good_id` (`good_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lifts`
--

LOCK TABLES `lifts` WRITE;
/*!40000 ALTER TABLE `lifts` DISABLE KEYS */;
/*!40000 ALTER TABLE `lifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `losts`
--

DROP TABLE IF EXISTS `losts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `losts` (
  `lost_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `lost_title` char(60) NOT NULL DEFAULT '',
  `lost_desc` varchar(150) NOT NULL DEFAULT '',
  `qq` char(12) NOT NULL DEFAULT '',
  `phone` char(12) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_full` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lost_id`),
  KEY `user_id` (`user_id`),
  KEY `is_full` (`is_full`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `losts`
--

LOCK TABLES `losts` WRITE;
/*!40000 ALTER TABLE `losts` DISABLE KEYS */;
INSERT INTO `losts` VALUES (1,2,'dandan','篮球场捡到一部手机','乐视1S太子妃，土豪金，，，，，，    ','1113465296','17817939577',1462238604,0);
/*!40000 ALTER TABLE `losts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(20) NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `content` varchar(100) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`message_id`),
  KEY `user_id` (`user_id`),
  KEY `is_read` (`is_read`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'商品交换提醒',1,'hookidea','用户 “ <b> dandan </b> ” 申请与您的商品<b></b>做商品交换，立即去看看？',0,1,3,'/Switch/showSwitch/switch_id/1'),(2,'商品交换提醒',2,'dandan','您的商品交换申请提交成功，我们已经通知对方，请耐心等待对方处理！',0,1,3,''),(3,'商品交换提醒',1,'hookidea','用户 “ <b> wangwencan </b> ” 申请与您的商品<b>又来了。。。。。</b>做商品交换，立即去看看？',1462245733,1,3,'/Switch/showSwitch/type/1/switch_id/2'),(4,'商品交换提醒',3,'wangwencan','您的商品交换申请提交成功，我们已经通知对方，请耐心等待对方处理！',1462245733,1,3,'/Switch/showSwitch/type/0/switch_id/2'),(5,'下单提醒',1,'hookidea','您于2016-05-04 10:31:40提交了新订单，订单总金额为￥50元',1462329100,1,2,'/Order/showOrder/order_id/1'),(6,'商品被购买提醒',3,'wangwencan','您的商品于2016-05-04 10:31:40被用户hookidea所购买，订单总金额为￥50元',1462329100,1,2,'/Order/showOrder/order_id/1'),(7,'商品交换提醒',5,'123456789','用户 “ <b> hookidea </b> ” 申请与您的商品<b></b>做商品交换，立即去看看？',1462351774,1,3,'/Switch/showSwitch/type/1/switch_id/3'),(8,'商品交换提醒',1,'hookidea','您的商品交换申请提交成功，我们已经通知对方，请耐心等待对方处理！',1462351774,1,3,'/Switch/showSwitch/type/0/switch_id/3'),(9,'商品交换提醒',6,'wangwen','用户 “ <b> 123456789 </b> ” 申请与您的商品<b></b>做商品交换，立即去看看？',1462352978,0,3,'/Switch/showSwitch/type/1/switch_id/4'),(10,'商品交换提醒',5,'123456789','您的商品交换申请提交成功，我们已经通知对方，请耐心等待对方处理！',1462352978,1,3,'/Switch/showSwitch/type/0/switch_id/4'),(11,'回复提醒',1,'hookidea','用户 “ <b> hookidea </b> ” 对您的商品回复了，立即去看看？',1462418176,1,5,'/Good/showGood/good_id/2'),(12,'回复提醒',1,'hookidea','用户 “ <b> hookidea </b> ” 对您的商品回复了，立即去看看？',1462418194,1,5,'/Good/showGood/good_id/2'),(13,'回复提醒',1,'hookidea','用户 “ <b> hookidea </b> ” 对您的商品回复了，立即去看看？',1462439475,1,5,'/Good/showGood/good_id/2'),(14,'回复提醒',1,'hookidea','用户 “ <b> hookidea </b> ” 对您的评论回复了，立即去看看？',1462463249,1,5,'/Good/showGood/good_id/2');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_goods`
--

DROP TABLE IF EXISTS `order_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(7,2) NOT NULL DEFAULT '0.00',
  `num` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_goods`
--

LOCK TABLES `order_goods` WRITE;
/*!40000 ALTER TABLE `order_goods` DISABLE KEYS */;
INSERT INTO `order_goods` VALUES (1,5,1,'50.00',1);
/*!40000 ALTER TABLE `order_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_infos`
--

DROP TABLE IF EXISTS `order_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_infos` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` char(15) NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `seller_id` int(10) unsigned NOT NULL DEFAULT '0',
  `seller_name` char(20) NOT NULL DEFAULT '',
  `total_price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `address_location` char(130) NOT NULL DEFAULT '',
  `address_name` char(20) NOT NULL DEFAULT '',
  `phone` char(12) NOT NULL DEFAULT '',
  `qq` char(12) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_sn` (`order_sn`),
  KEY `user_id` (`user_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_infos`
--

LOCK TABLES `order_infos` WRITE;
/*!40000 ALTER TABLE `order_infos` DISABLE KEYS */;
INSERT INTO `order_infos` VALUES (1,'O20160504101439',1,'hookidea',3,'wangwencan','50.00','工贸','工贸','34234535','',1462329100,1);
/*!40000 ALTER TABLE `order_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reals`
--

DROP TABLE IF EXISTS `reals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reals` (
  `real_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `real_name` varchar(20) NOT NULL DEFAULT '',
  `real_number` varchar(18) NOT NULL DEFAULT '',
  `real_location` varchar(50) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `phone` char(12) NOT NULL DEFAULT '',
  `qq` char(12) NOT NULL DEFAULT '',
  `is_full` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`real_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reals`
--

LOCK TABLES `reals` WRITE;
/*!40000 ALTER TABLE `reals` DISABLE KEYS */;
/*!40000 ALTER TABLE `reals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `role_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` char(10) NOT NULL DEFAULT '',
  `is_root` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `login_bg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment_manage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `good_getlist` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `good_add` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `good_edit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `good_onsale` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `good_promote` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `good_check` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `good_lift` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `good_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `category_manage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_getlist` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_getnotreal` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_add` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_edit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_check` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_real` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_seal` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role_manage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `order_manage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `system_manage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bug_manage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'root',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),(2,'普通用户',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `switchs`
--

DROP TABLE IF EXISTS `switchs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `switchs` (
  `switch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `switch_sn` char(15) NOT NULL DEFAULT '',
  `user_good_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(20) NOT NULL DEFAULT '',
  `raply_good_id` int(10) unsigned NOT NULL DEFAULT '0',
  `raply_id` int(10) unsigned NOT NULL DEFAULT '0',
  `raply_name` char(20) NOT NULL DEFAULT '',
  `num` smallint(5) unsigned NOT NULL DEFAULT '1',
  `address_location` char(130) NOT NULL DEFAULT '',
  `address_name` char(20) NOT NULL DEFAULT '',
  `phone` char(12) NOT NULL DEFAULT '',
  `qq` char(12) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`switch_id`),
  UNIQUE KEY `switch_sn` (`switch_sn`),
  KEY `user_id` (`user_id`),
  KEY `raply_id` (`raply_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `switchs`
--

LOCK TABLES `switchs` WRITE;
/*!40000 ALTER TABLE `switchs` DISABLE KEYS */;
INSERT INTO `switchs` VALUES (1,'S20160503099854',4,2,'dandan',1,1,'hookidea',1,'504','---11111','17817939577','',1462237563,1),(2,'S20160503116299',5,3,'wangwencan',2,1,'hookidea',1,'工贸一站式','王文灿','12345678912','',1462245733,1),(3,'S20160504163170',1,1,'hookidea',8,5,'123456789',1,'工贸','公司','2225225522','',1462351774,1),(4,'S20160504175970',8,5,'123456789',7,6,'wangwen',1,'地黑色','毁灭破','13763045006','',1462352978,0);
/*!40000 ALTER TABLE `switchs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` smallint(5) unsigned NOT NULL DEFAULT '2',
  `user_name` char(20) NOT NULL DEFAULT '',
  `password` char(60) NOT NULL DEFAULT '',
  `email` char(30) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `seal_stop` int(10) unsigned NOT NULL DEFAULT '0',
  `sales_num` int(10) unsigned NOT NULL DEFAULT '0',
  `is_seal` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_check` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_real` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,2,'hookidea','$2y$10$6J1wUUqW2q.QOTDx9F7WyeJ2y/ezPh5UlYU80UbDG5aUKsColjT8.','hookidea@qq.com',1462183986,0,0,0,0,0,0),(2,2,'dandan','$2y$10$nWQuLcymr1orhcMR40NCTe1Pe123e1BELVD7aQ67whzRcQHRWT6cy','1113465296@qq.com',1462236166,0,0,0,0,0,0),(3,2,'wangwencan','$2y$10$PGrM.tKsqMo/Y5379NlZke6A8JKk97jV1YQyeoBV8osKpo4/W.UUm','928807662@qq.com',1462236832,0,0,0,1,0,0),(4,2,'huahua','$2y$10$BlCPslv03fJoUAhr0kito.UlLDx.hVqfZNWCgLW/0o4XOpBkAJV3u','1694208780@qq.com',1462342313,0,0,0,0,0,0),(5,2,'123456789','$2y$10$KHcrQ/DddjUi.t/EcmYC9..099a6xgcptXG0uVy80DlfWf6JDXSjC','563576965@qq.com',1462349699,0,0,0,0,0,0),(6,2,'wangwen','$2y$10$mmMev68gTid4z1NtIewMnuaNhj5QwBpZTdBQfUt0z7WigBIbeBOX2','928807662@qq.com',1462350199,0,0,0,0,0,0),(7,2,'cesusu','$2y$10$Biyk62ZSRxCkGF/23GbK2OB9suGrcaD55omub4DpBeQ6rQM6dm0L6','928807662@qq.com',1462714195,0,0,0,0,0,0),(8,2,'a123456','$2y$10$yKe5hbRvl0.lfdV2ezl5pe3IhhhJqy5NHZgQot62SJUxUWcUuhsQ2','765792679@qq.com',1462714618,0,0,0,0,0,0),(9,2,'q123456','$2y$10$GMrbrDGE4YVpTrGfXeQNvO8PnZDSIdWH5jOV.L/Ceh4eE7NeZ6ApS','456785268@qq.com',1462715186,0,0,0,0,0,0),(10,2,'qqq123456','$2y$10$Q1nd1jR8W3NAm6vwYs7RVuUtVMnwANC5fnxM09aQMWw.pd83ceEXC','123456789@qq.com',1462753830,0,0,0,0,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-09 12:14:00
