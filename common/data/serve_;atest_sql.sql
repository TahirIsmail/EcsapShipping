-- MySQL dump 10.13  Distrib 5.7.9, for Win32 (AMD64)
--
-- Host: AFG Globaldb.chgflc1foln5.us-west-2.rds.amazonaws.com    Database: AFG Globalworldwideusa
-- ------------------------------------------------------
-- Server version	5.6.37-log

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
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin_GA','438',1516023225),('admin_LA','437',1516023260),('admin_NY','439',1516023090),('admin_TX','440',1516023050),('customer','460',1528461781),('customer','461',1528461788),('customer','462',1528461795),('customer','463',1528461801),('customer','464',1528461806),('customer','468',1528532254),('customer','473',1528533838),('customer','476',1528534131),('customer','478',1528534668),('customer','479',1528534734),('customer','482',1528535121),('customer','483',1528535548),('customer','484',1528616114),('super_admin','1',1510833715);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('/*',2,NULL,NULL,NULL,1508394217,1508394217),('/admin/*',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/assignment/*',2,NULL,NULL,NULL,1508394213,1508394213),('/admin/assignment/assign',2,NULL,NULL,NULL,1508394213,1508394213),('/admin/assignment/index',2,NULL,NULL,NULL,1508394213,1508394213),('/admin/assignment/revoke',2,NULL,NULL,NULL,1508394213,1508394213),('/admin/assignment/view',2,NULL,NULL,NULL,1508394213,1508394213),('/admin/default/*',2,NULL,NULL,NULL,1508394213,1508394213),('/admin/default/index',2,NULL,NULL,NULL,1508394213,1508394213),('/admin/menu/*',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/menu/create',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/menu/delete',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/menu/index',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/menu/update',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/menu/view',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/permission/*',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/permission/assign',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/permission/create',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/permission/delete',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/permission/index',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/permission/remove',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/permission/update',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/permission/view',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/role/*',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/role/assign',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/role/create',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/role/delete',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/role/index',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/role/remove',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/role/update',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/role/view',2,NULL,NULL,NULL,1508394214,1508394214),('/admin/route/*',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/route/assign',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/route/create',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/route/index',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/route/refresh',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/route/remove',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/rule/*',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/rule/create',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/rule/delete',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/rule/index',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/rule/update',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/rule/view',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/*',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/activate',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/change-password',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/delete',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/index',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/login',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/logout',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/request-password-reset',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/reset-password',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/signup',2,NULL,NULL,NULL,1508394215,1508394215),('/admin/user/view',2,NULL,NULL,NULL,1508394215,1508394215),('/condition/*',2,NULL,NULL,NULL,1510727998,1510727998),('/condition/create',2,NULL,NULL,NULL,1510727998,1510727998),('/condition/delete',2,NULL,NULL,NULL,1510727998,1510727998),('/condition/index',2,NULL,NULL,NULL,1510727997,1510727997),('/condition/update',2,NULL,NULL,NULL,1510727998,1510727998),('/condition/view',2,NULL,NULL,NULL,1510727997,1510727997),('/consignee/*',2,NULL,NULL,NULL,1510727998,1510727998),('/consignee/create',2,NULL,NULL,NULL,1510727998,1510727998),('/consignee/customer-consignee',2,NULL,NULL,NULL,1513353062,1513353062),('/consignee/delete',2,NULL,NULL,NULL,1510727998,1510727998),('/consignee/getuserconsignee',2,NULL,NULL,NULL,1512555379,1512555379),('/consignee/index',2,NULL,NULL,NULL,1510727998,1510727998),('/consignee/update',2,NULL,NULL,NULL,1510727998,1510727998),('/consignee/view',2,NULL,NULL,NULL,1510727998,1510727998),('/customer/*',2,NULL,NULL,NULL,1508394216,1508394216),('/customer/allcustomer',2,NULL,NULL,NULL,1513353062,1513353062),('/customer/create',2,NULL,NULL,NULL,1508394216,1508394216),('/customer/delete',2,NULL,NULL,NULL,1508394216,1508394216),('/customer/getcontainercustomer',2,NULL,NULL,NULL,1512555379,1512555379),('/customer/getcustomer',2,NULL,NULL,NULL,1510727998,1510727998),('/customer/index',2,NULL,NULL,NULL,1508394216,1508394216),('/customer/insert',2,NULL,NULL,NULL,1521014083,1521014083),('/customer/selectedcustomer',2,NULL,NULL,NULL,1513353062,1513353062),('/customer/update',2,NULL,NULL,NULL,1508394216,1508394216),('/customer/view',2,NULL,NULL,NULL,1508394216,1508394216),('/debug/*',2,NULL,NULL,NULL,1508394216,1508394216),('/debug/default/*',2,NULL,NULL,NULL,1508394216,1508394216),('/debug/default/db-explain',2,NULL,NULL,NULL,1508394215,1508394215),('/debug/default/download-mail',2,NULL,NULL,NULL,1508394216,1508394216),('/debug/default/index',2,NULL,NULL,NULL,1508394216,1508394216),('/debug/default/toolbar',2,NULL,NULL,NULL,1508394216,1508394216),('/debug/default/view',2,NULL,NULL,NULL,1508394216,1508394216),('/debug/user/*',2,NULL,NULL,NULL,1508394216,1508394216),('/debug/user/reset-identity',2,NULL,NULL,NULL,1508394216,1508394216),('/debug/user/set-identity',2,NULL,NULL,NULL,1508394216,1508394216),('/dock-receipt/*',2,NULL,NULL,NULL,1510727999,1510727999),('/dock-receipt/create',2,NULL,NULL,NULL,1510727999,1510727999),('/dock-receipt/delete',2,NULL,NULL,NULL,1510727999,1510727999),('/dock-receipt/index',2,NULL,NULL,NULL,1510727999,1510727999),('/dock-receipt/update',2,NULL,NULL,NULL,1510727999,1510727999),('/dock-receipt/view',2,NULL,NULL,NULL,1510727999,1510727999),('/export-images/*',2,NULL,NULL,NULL,1510728001,1510728001),('/export-images/create',2,NULL,NULL,NULL,1510728000,1510728000),('/export-images/delete',2,NULL,NULL,NULL,1510728001,1510728001),('/export-images/index',2,NULL,NULL,NULL,1510728000,1510728000),('/export-images/update',2,NULL,NULL,NULL,1510728000,1510728000),('/export-images/view',2,NULL,NULL,NULL,1510728000,1510728000),('/export/*',2,NULL,NULL,NULL,1510728000,1510728000),('/export/allexport',2,NULL,NULL,NULL,1513353062,1513353062),('/export/close-conversatition',2,NULL,NULL,NULL,1523965710,1523965710),('/export/create',2,NULL,NULL,NULL,1510728000,1510728000),('/export/customcoverlettermodal',2,NULL,NULL,NULL,1513353062,1513353062),('/export/delete',2,NULL,NULL,NULL,1510728000,1510728000),('/export/dockmodal',2,NULL,NULL,NULL,1513353062,1513353062),('/export/dockpdf',2,NULL,NULL,NULL,1510728000,1510728000),('/export/hustomcoverlettermodal',2,NULL,NULL,NULL,1513353062,1513353062),('/export/image-delete',2,NULL,NULL,NULL,1526385297,1526385297),('/export/index',2,NULL,NULL,NULL,1510728000,1510728000),('/export/ladingmodal',2,NULL,NULL,NULL,1513353062,1513353062),('/export/landingpdf',2,NULL,NULL,NULL,1512555379,1512555379),('/export/manifestmodal',2,NULL,NULL,NULL,1513353062,1513353062),('/export/manifestpdf',2,NULL,NULL,NULL,1510728000,1510728000),('/export/nonhazmodal',2,NULL,NULL,NULL,1513353062,1513353062),('/export/notes',2,NULL,NULL,NULL,1514462421,1514462421),('/export/notesmodal',2,NULL,NULL,NULL,1514460210,1514460210),('/export/update',2,NULL,NULL,NULL,1510728000,1510728000),('/export/upload-notes',2,NULL,NULL,NULL,1526385297,1526385297),('/export/uploadinvoice',2,NULL,NULL,NULL,1510728000,1510728000),('/export/view',2,NULL,NULL,NULL,1510728000,1510728000),('/features/*',2,NULL,NULL,NULL,1510728001,1510728001),('/features/create',2,NULL,NULL,NULL,1510728001,1510728001),('/features/delete',2,NULL,NULL,NULL,1510728001,1510728001),('/features/index',2,NULL,NULL,NULL,1510728001,1510728001),('/features/update',2,NULL,NULL,NULL,1510728001,1510728001),('/features/view',2,NULL,NULL,NULL,1510728001,1510728001),('/gii/*',2,NULL,NULL,NULL,1508394216,1508394216),('/gii/default/*',2,NULL,NULL,NULL,1508394216,1508394216),('/gii/default/action',2,NULL,NULL,NULL,1508394216,1508394216),('/gii/default/diff',2,NULL,NULL,NULL,1508394216,1508394216),('/gii/default/index',2,NULL,NULL,NULL,1508394216,1508394216),('/gii/default/preview',2,NULL,NULL,NULL,1508394216,1508394216),('/gii/default/view',2,NULL,NULL,NULL,1508394216,1508394216),('/gridview/*',2,NULL,NULL,NULL,1512555379,1512555379),('/gridview/export/*',2,NULL,NULL,NULL,1512555379,1512555379),('/gridview/export/download',2,NULL,NULL,NULL,1512555379,1512555379),('/houstan-custom-cover-letter/*',2,NULL,NULL,NULL,1510728002,1510728002),('/houstan-custom-cover-letter/create',2,NULL,NULL,NULL,1510728001,1510728001),('/houstan-custom-cover-letter/delete',2,NULL,NULL,NULL,1510728001,1510728001),('/houstan-custom-cover-letter/index',2,NULL,NULL,NULL,1510728001,1510728001),('/houstan-custom-cover-letter/update',2,NULL,NULL,NULL,1510728001,1510728001),('/houstan-custom-cover-letter/view',2,NULL,NULL,NULL,1510728001,1510728001),('/images/*',2,NULL,NULL,NULL,1510728002,1510728002),('/images/create',2,NULL,NULL,NULL,1510728002,1510728002),('/images/delete',2,NULL,NULL,NULL,1510728002,1510728002),('/images/index',2,NULL,NULL,NULL,1510728002,1510728002),('/images/update',2,NULL,NULL,NULL,1510728002,1510728002),('/images/view',2,NULL,NULL,NULL,1510728002,1510728002),('/invoice/*',2,NULL,NULL,NULL,1512555380,1512555380),('/invoice/create',2,NULL,NULL,NULL,1512555380,1512555380),('/invoice/customerinvoice',2,NULL,NULL,NULL,1513353062,1513353062),('/invoice/delete',2,NULL,NULL,NULL,1512555380,1512555380),('/invoice/index',2,NULL,NULL,NULL,1512555380,1512555380),('/invoice/paid',2,NULL,NULL,NULL,1514297976,1514297976),('/invoice/partial-paid',2,NULL,NULL,NULL,1523253920,1523253920),('/invoice/unpaid',2,NULL,NULL,NULL,1514297976,1514297976),('/invoice/update',2,NULL,NULL,NULL,1512555380,1512555380),('/invoice/view',2,NULL,NULL,NULL,1512555380,1512555380),('/notification/*',2,NULL,NULL,NULL,1516718477,1516718477),('/notification/create',2,NULL,NULL,NULL,1516718476,1516718476),('/notification/delete',2,NULL,NULL,NULL,1516718476,1516718476),('/notification/index',2,NULL,NULL,NULL,1516718476,1516718476),('/notification/update',2,NULL,NULL,NULL,1516718476,1516718476),('/notification/view',2,NULL,NULL,NULL,1516718476,1516718476),('/pricing/*',2,NULL,NULL,NULL,1523965710,1523965710),('/pricing/create',2,NULL,NULL,NULL,1523965710,1523965710),('/pricing/delete',2,NULL,NULL,NULL,1523965710,1523965710),('/pricing/index',2,NULL,NULL,NULL,1523965710,1523965710),('/pricing/update',2,NULL,NULL,NULL,1523965710,1523965710),('/pricing/view',2,NULL,NULL,NULL,1523965710,1523965710),('/site/*',2,NULL,NULL,NULL,1508394217,1508394217),('/site/ajax',2,NULL,NULL,NULL,1512555380,1512555380),('/site/ajaxcustomer',2,NULL,NULL,NULL,1512555380,1512555380),('/site/customer',2,NULL,NULL,NULL,1510728002,1510728002),('/site/customeradmin',2,NULL,NULL,NULL,1508394216,1508394216),('/site/delete-image',2,NULL,NULL,NULL,1528371949,1528371949),('/site/error',2,NULL,NULL,NULL,1508394216,1508394216),('/site/inboxdetail',2,NULL,NULL,NULL,1508394216,1508394216),('/site/index',2,NULL,NULL,NULL,1508394216,1508394216),('/site/login',2,NULL,NULL,NULL,1508394217,1508394217),('/site/logout',2,NULL,NULL,NULL,1508394217,1508394217),('/site/mailbox',2,NULL,NULL,NULL,1508394216,1508394216),('/site/statusexel',2,NULL,NULL,NULL,1526385297,1526385297),('/site/statuspdf',2,NULL,NULL,NULL,1512555380,1512555380),('/site/statuspdfcustomer',2,NULL,NULL,NULL,1512555380,1512555380),('/towing-request/*',2,NULL,NULL,NULL,1510728002,1510728002),('/towing-request/create',2,NULL,NULL,NULL,1510728002,1510728002),('/towing-request/delete',2,NULL,NULL,NULL,1510728002,1510728002),('/towing-request/index',2,NULL,NULL,NULL,1510728002,1510728002),('/towing-request/update',2,NULL,NULL,NULL,1510728002,1510728002),('/towing-request/view',2,NULL,NULL,NULL,1510728002,1510728002),('/user/*',2,NULL,NULL,NULL,1508394217,1508394217),('/user/create',2,NULL,NULL,NULL,1508394217,1508394217),('/user/delete',2,NULL,NULL,NULL,1508394217,1508394217),('/user/index',2,NULL,NULL,NULL,1508394217,1508394217),('/user/search',2,NULL,NULL,NULL,1508394217,1508394217),('/user/update',2,NULL,NULL,NULL,1508394217,1508394217),('/user/view',2,NULL,NULL,NULL,1508394217,1508394217),('/vehicle-condition/*',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle-condition/create',2,NULL,NULL,NULL,1510728002,1510728002),('/vehicle-condition/delete',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle-condition/index',2,NULL,NULL,NULL,1510728002,1510728002),('/vehicle-condition/update',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle-condition/view',2,NULL,NULL,NULL,1510728002,1510728002),('/vehicle-export/*',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-export/container-images',2,NULL,NULL,NULL,1521014083,1521014083),('/vehicle-export/create',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-export/delete',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-export/index',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-export/update',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-export/vehicle-images',2,NULL,NULL,NULL,1521014083,1521014083),('/vehicle-export/view',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-features/*',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-features/create',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-features/delete',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-features/index',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-features/update',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle-features/view',2,NULL,NULL,NULL,1510728004,1510728004),('/vehicle/*',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle/allvehicle',2,NULL,NULL,NULL,1513353062,1513353062),('/vehicle/close-conversatition',2,NULL,NULL,NULL,1523965710,1523965710),('/vehicle/conditionreport',2,NULL,NULL,NULL,1513353062,1513353062),('/vehicle/create',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle/delete',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle/download-images',2,NULL,NULL,NULL,1523965710,1523965710),('/vehicle/frontsearch',2,NULL,NULL,NULL,1516718471,1516718471),('/vehicle/getexport_vehicle',2,NULL,NULL,NULL,1512555380,1512555380),('/vehicle/image-delete',2,NULL,NULL,NULL,1526385297,1526385297),('/vehicle/index',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle/mpdf',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle/notes',2,NULL,NULL,NULL,1521014083,1521014083),('/vehicle/notesmodal',2,NULL,NULL,NULL,1521014083,1521014083),('/vehicle/search-vin',2,NULL,NULL,NULL,1512555380,1512555380),('/vehicle/test',2,NULL,NULL,NULL,1526385297,1526385297),('/vehicle/update',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle/upload-notes',2,NULL,NULL,NULL,1526385297,1526385297),('/vehicle/vehicledetail',2,NULL,NULL,NULL,1510728003,1510728003),('/vehicle/view',2,NULL,NULL,NULL,1510728003,1510728003),('admin_GA',1,NULL,NULL,NULL,1513944324,1513944324),('admin_LA',1,NULL,NULL,NULL,1510827049,1510827049),('admin_NY',1,NULL,NULL,NULL,1513944363,1513944363),('admin_TX',1,NULL,NULL,NULL,1513944401,1513944401),('customer',1,NULL,NULL,NULL,1508412760,1508412760),('super_admin',1,NULL,NULL,NULL,1510833648,1510833648);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('super_admin','/*'),('super_admin','/admin/*'),('super_admin','/admin/assignment/*'),('super_admin','/admin/assignment/assign'),('super_admin','/admin/assignment/index'),('super_admin','/admin/assignment/revoke'),('super_admin','/admin/assignment/view'),('super_admin','/admin/default/*'),('super_admin','/admin/default/index'),('super_admin','/admin/menu/*'),('super_admin','/admin/menu/create'),('super_admin','/admin/menu/delete'),('super_admin','/admin/menu/index'),('super_admin','/admin/menu/update'),('super_admin','/admin/menu/view'),('super_admin','/admin/permission/*'),('super_admin','/admin/permission/assign'),('super_admin','/admin/permission/create'),('super_admin','/admin/permission/delete'),('super_admin','/admin/permission/index'),('super_admin','/admin/permission/remove'),('super_admin','/admin/permission/update'),('super_admin','/admin/permission/view'),('super_admin','/admin/role/*'),('super_admin','/admin/role/assign'),('super_admin','/admin/role/create'),('super_admin','/admin/role/delete'),('super_admin','/admin/role/index'),('super_admin','/admin/role/remove'),('super_admin','/admin/role/update'),('super_admin','/admin/role/view'),('super_admin','/admin/route/*'),('super_admin','/admin/route/assign'),('super_admin','/admin/route/create'),('super_admin','/admin/route/index'),('super_admin','/admin/route/refresh'),('super_admin','/admin/route/remove'),('super_admin','/admin/rule/*'),('super_admin','/admin/rule/create'),('super_admin','/admin/rule/delete'),('super_admin','/admin/rule/index'),('super_admin','/admin/rule/update'),('super_admin','/admin/rule/view'),('super_admin','/admin/user/*'),('super_admin','/admin/user/activate'),('super_admin','/admin/user/change-password'),('super_admin','/admin/user/delete'),('super_admin','/admin/user/index'),('super_admin','/admin/user/login'),('super_admin','/admin/user/logout'),('super_admin','/admin/user/request-password-reset'),('super_admin','/admin/user/reset-password'),('super_admin','/admin/user/signup'),('super_admin','/admin/user/view'),('admin_NY','/condition/*'),('admin_TX','/condition/*'),('super_admin','/condition/*'),('super_admin','/condition/create'),('super_admin','/condition/delete'),('super_admin','/condition/index'),('super_admin','/condition/update'),('super_admin','/condition/view'),('admin_NY','/consignee/*'),('admin_TX','/consignee/*'),('super_admin','/consignee/*'),('super_admin','/consignee/create'),('admin_GA','/consignee/customer-consignee'),('admin_LA','/consignee/customer-consignee'),('super_admin','/consignee/customer-consignee'),('super_admin','/consignee/delete'),('admin_GA','/consignee/getuserconsignee'),('admin_LA','/consignee/getuserconsignee'),('super_admin','/consignee/getuserconsignee'),('super_admin','/consignee/index'),('super_admin','/consignee/update'),('super_admin','/consignee/view'),('admin_GA','/customer/*'),('admin_LA','/customer/*'),('admin_TX','/customer/*'),('super_admin','/customer/*'),('admin_GA','/customer/allcustomer'),('admin_LA','/customer/allcustomer'),('admin_NY','/customer/allcustomer'),('super_admin','/customer/allcustomer'),('admin_NY','/customer/create'),('super_admin','/customer/create'),('super_admin','/customer/delete'),('admin_GA','/customer/getcontainercustomer'),('admin_LA','/customer/getcontainercustomer'),('admin_NY','/customer/getcontainercustomer'),('super_admin','/customer/getcontainercustomer'),('admin_GA','/customer/getcustomer'),('admin_LA','/customer/getcustomer'),('admin_NY','/customer/getcustomer'),('super_admin','/customer/getcustomer'),('admin_NY','/customer/index'),('super_admin','/customer/index'),('customer','/customer/insert'),('super_admin','/customer/insert'),('admin_GA','/customer/selectedcustomer'),('admin_LA','/customer/selectedcustomer'),('admin_NY','/customer/selectedcustomer'),('super_admin','/customer/selectedcustomer'),('super_admin','/customer/update'),('admin_NY','/customer/view'),('super_admin','/customer/view'),('admin_LA','/debug/*'),('super_admin','/debug/*'),('admin_LA','/debug/default/*'),('super_admin','/debug/default/*'),('admin_LA','/debug/default/db-explain'),('super_admin','/debug/default/db-explain'),('admin_LA','/debug/default/download-mail'),('super_admin','/debug/default/download-mail'),('admin_LA','/debug/default/index'),('super_admin','/debug/default/index'),('admin_LA','/debug/default/toolbar'),('super_admin','/debug/default/toolbar'),('admin_LA','/debug/default/view'),('super_admin','/debug/default/view'),('admin_LA','/debug/user/*'),('super_admin','/debug/user/*'),('admin_LA','/debug/user/reset-identity'),('super_admin','/debug/user/reset-identity'),('admin_LA','/debug/user/set-identity'),('super_admin','/debug/user/set-identity'),('admin_GA','/dock-receipt/*'),('admin_NY','/dock-receipt/*'),('admin_TX','/dock-receipt/*'),('super_admin','/dock-receipt/*'),('super_admin','/dock-receipt/create'),('super_admin','/dock-receipt/delete'),('super_admin','/dock-receipt/index'),('super_admin','/dock-receipt/update'),('super_admin','/dock-receipt/view'),('admin_GA','/export-images/*'),('admin_NY','/export-images/*'),('admin_TX','/export-images/*'),('super_admin','/export-images/*'),('admin_NY','/export-images/create'),('super_admin','/export-images/create'),('admin_NY','/export-images/delete'),('super_admin','/export-images/delete'),('admin_NY','/export-images/index'),('super_admin','/export-images/index'),('admin_NY','/export-images/update'),('super_admin','/export-images/update'),('admin_NY','/export-images/view'),('super_admin','/export-images/view'),('admin_GA','/export/*'),('admin_NY','/export/*'),('admin_TX','/export/*'),('super_admin','/export/*'),('admin_LA','/export/allexport'),('super_admin','/export/allexport'),('admin_LA','/export/close-conversatition'),('customer','/export/close-conversatition'),('super_admin','/export/close-conversatition'),('admin_LA','/export/create'),('super_admin','/export/create'),('admin_LA','/export/customcoverlettermodal'),('customer','/export/customcoverlettermodal'),('super_admin','/export/customcoverlettermodal'),('super_admin','/export/delete'),('admin_LA','/export/dockmodal'),('customer','/export/dockmodal'),('super_admin','/export/dockmodal'),('admin_LA','/export/dockpdf'),('customer','/export/dockpdf'),('super_admin','/export/dockpdf'),('admin_LA','/export/hustomcoverlettermodal'),('customer','/export/hustomcoverlettermodal'),('super_admin','/export/hustomcoverlettermodal'),('admin_LA','/export/index'),('super_admin','/export/index'),('admin_LA','/export/ladingmodal'),('customer','/export/ladingmodal'),('super_admin','/export/ladingmodal'),('admin_LA','/export/landingpdf'),('customer','/export/landingpdf'),('super_admin','/export/landingpdf'),('admin_LA','/export/manifestmodal'),('customer','/export/manifestmodal'),('super_admin','/export/manifestmodal'),('admin_LA','/export/manifestpdf'),('customer','/export/manifestpdf'),('super_admin','/export/manifestpdf'),('admin_LA','/export/nonhazmodal'),('customer','/export/nonhazmodal'),('super_admin','/export/nonhazmodal'),('admin_LA','/export/notes'),('customer','/export/notes'),('super_admin','/export/notes'),('admin_LA','/export/notesmodal'),('customer','/export/notesmodal'),('super_admin','/export/notesmodal'),('admin_LA','/export/update'),('super_admin','/export/update'),('admin_LA','/export/upload-notes'),('admin_LA','/export/uploadinvoice'),('customer','/export/uploadinvoice'),('super_admin','/export/uploadinvoice'),('admin_LA','/export/view'),('super_admin','/export/view'),('admin_GA','/features/*'),('admin_NY','/features/*'),('admin_TX','/features/*'),('super_admin','/features/*'),('super_admin','/features/create'),('super_admin','/features/delete'),('super_admin','/features/index'),('super_admin','/features/update'),('super_admin','/features/view'),('super_admin','/gii/*'),('super_admin','/gii/default/*'),('super_admin','/gii/default/action'),('super_admin','/gii/default/diff'),('super_admin','/gii/default/index'),('super_admin','/gii/default/preview'),('super_admin','/gii/default/view'),('super_admin','/gridview/*'),('super_admin','/gridview/export/*'),('super_admin','/gridview/export/download'),('admin_GA','/houstan-custom-cover-letter/*'),('super_admin','/houstan-custom-cover-letter/*'),('super_admin','/houstan-custom-cover-letter/create'),('super_admin','/houstan-custom-cover-letter/delete'),('super_admin','/houstan-custom-cover-letter/index'),('super_admin','/houstan-custom-cover-letter/update'),('super_admin','/houstan-custom-cover-letter/view'),('admin_NY','/images/*'),('admin_TX','/images/*'),('super_admin','/images/*'),('super_admin','/images/create'),('super_admin','/images/delete'),('super_admin','/images/index'),('super_admin','/images/update'),('super_admin','/images/view'),('admin_LA','/invoice/*'),('super_admin','/invoice/*'),('super_admin','/invoice/create'),('admin_LA','/invoice/customerinvoice'),('customer','/invoice/customerinvoice'),('super_admin','/invoice/customerinvoice'),('super_admin','/invoice/delete'),('customer','/invoice/index'),('super_admin','/invoice/index'),('customer','/invoice/paid'),('super_admin','/invoice/paid'),('customer','/invoice/partial-paid'),('super_admin','/invoice/partial-paid'),('customer','/invoice/unpaid'),('super_admin','/invoice/unpaid'),('super_admin','/invoice/update'),('customer','/invoice/view'),('super_admin','/invoice/view'),('admin_GA','/notification/*'),('admin_LA','/notification/*'),('admin_NY','/notification/*'),('admin_TX','/notification/*'),('super_admin','/notification/*'),('super_admin','/notification/create'),('super_admin','/notification/delete'),('admin_GA','/notification/index'),('admin_LA','/notification/index'),('admin_NY','/notification/index'),('admin_TX','/notification/index'),('customer','/notification/index'),('super_admin','/notification/index'),('super_admin','/notification/update'),('admin_GA','/notification/view'),('admin_LA','/notification/view'),('admin_NY','/notification/view'),('admin_TX','/notification/view'),('customer','/notification/view'),('super_admin','/notification/view'),('admin_GA','/pricing/*'),('admin_LA','/pricing/*'),('admin_NY','/pricing/*'),('admin_TX','/pricing/*'),('super_admin','/pricing/*'),('super_admin','/pricing/create'),('super_admin','/pricing/delete'),('customer','/pricing/index'),('super_admin','/pricing/index'),('super_admin','/pricing/update'),('customer','/pricing/view'),('super_admin','/pricing/view'),('admin_GA','/site/*'),('admin_NY','/site/*'),('admin_TX','/site/*'),('customer','/site/*'),('super_admin','/site/*'),('admin_LA','/site/ajax'),('super_admin','/site/ajax'),('admin_GA','/site/ajaxcustomer'),('admin_LA','/site/ajaxcustomer'),('super_admin','/site/ajaxcustomer'),('admin_GA','/site/customer'),('admin_LA','/site/customer'),('super_admin','/site/customer'),('admin_GA','/site/customeradmin'),('admin_LA','/site/customeradmin'),('super_admin','/site/customeradmin'),('super_admin','/site/delete-image'),('admin_LA','/site/error'),('super_admin','/site/error'),('admin_GA','/site/inboxdetail'),('admin_LA','/site/inboxdetail'),('super_admin','/site/inboxdetail'),('admin_LA','/site/index'),('super_admin','/site/index'),('admin_LA','/site/login'),('super_admin','/site/login'),('admin_LA','/site/logout'),('super_admin','/site/logout'),('admin_LA','/site/mailbox'),('super_admin','/site/mailbox'),('admin_GA','/site/statusexel'),('admin_GA','/site/statuspdf'),('admin_LA','/site/statuspdf'),('super_admin','/site/statuspdf'),('admin_GA','/site/statuspdfcustomer'),('admin_LA','/site/statuspdfcustomer'),('super_admin','/site/statuspdfcustomer'),('super_admin','/towing-request/*'),('super_admin','/towing-request/create'),('super_admin','/towing-request/delete'),('super_admin','/towing-request/index'),('super_admin','/towing-request/update'),('super_admin','/towing-request/view'),('admin_TX','/user/*'),('super_admin','/user/*'),('admin_GA','/user/create'),('super_admin','/user/create'),('super_admin','/user/delete'),('admin_GA','/user/index'),('admin_NY','/user/index'),('super_admin','/user/index'),('admin_NY','/user/search'),('super_admin','/user/search'),('admin_GA','/user/update'),('super_admin','/user/update'),('admin_GA','/user/view'),('admin_NY','/user/view'),('super_admin','/user/view'),('admin_GA','/vehicle-condition/*'),('super_admin','/vehicle-condition/*'),('super_admin','/vehicle-condition/create'),('super_admin','/vehicle-condition/delete'),('super_admin','/vehicle-condition/index'),('super_admin','/vehicle-condition/update'),('super_admin','/vehicle-condition/view'),('admin_GA','/vehicle-export/*'),('admin_NY','/vehicle-export/*'),('admin_TX','/vehicle-export/*'),('customer','/vehicle-export/*'),('super_admin','/vehicle-export/*'),('admin_GA','/vehicle-export/container-images'),('admin_LA','/vehicle-export/container-images'),('customer','/vehicle-export/container-images'),('super_admin','/vehicle-export/container-images'),('super_admin','/vehicle-export/create'),('super_admin','/vehicle-export/delete'),('admin_LA','/vehicle-export/index'),('customer','/vehicle-export/index'),('super_admin','/vehicle-export/index'),('super_admin','/vehicle-export/update'),('admin_GA','/vehicle-export/vehicle-images'),('admin_LA','/vehicle-export/vehicle-images'),('customer','/vehicle-export/vehicle-images'),('super_admin','/vehicle-export/vehicle-images'),('admin_LA','/vehicle-export/view'),('customer','/vehicle-export/view'),('super_admin','/vehicle-export/view'),('admin_GA','/vehicle-features/*'),('super_admin','/vehicle-features/*'),('super_admin','/vehicle-features/create'),('super_admin','/vehicle-features/delete'),('super_admin','/vehicle-features/index'),('super_admin','/vehicle-features/update'),('super_admin','/vehicle-features/view'),('admin_GA','/vehicle/*'),('admin_NY','/vehicle/*'),('admin_TX','/vehicle/*'),('super_admin','/vehicle/*'),('admin_LA','/vehicle/allvehicle'),('super_admin','/vehicle/allvehicle'),('admin_LA','/vehicle/close-conversatition'),('customer','/vehicle/close-conversatition'),('super_admin','/vehicle/close-conversatition'),('admin_LA','/vehicle/conditionreport'),('customer','/vehicle/conditionreport'),('super_admin','/vehicle/conditionreport'),('admin_LA','/vehicle/create'),('super_admin','/vehicle/create'),('super_admin','/vehicle/delete'),('admin_LA','/vehicle/download-images'),('customer','/vehicle/download-images'),('super_admin','/vehicle/download-images'),('admin_LA','/vehicle/frontsearch'),('super_admin','/vehicle/frontsearch'),('admin_LA','/vehicle/getexport_vehicle'),('customer','/vehicle/getexport_vehicle'),('super_admin','/vehicle/getexport_vehicle'),('admin_LA','/vehicle/image-delete'),('admin_LA','/vehicle/index'),('customer','/vehicle/index'),('super_admin','/vehicle/index'),('admin_LA','/vehicle/mpdf'),('customer','/vehicle/mpdf'),('super_admin','/vehicle/mpdf'),('admin_LA','/vehicle/notes'),('customer','/vehicle/notes'),('super_admin','/vehicle/notes'),('admin_LA','/vehicle/notesmodal'),('customer','/vehicle/notesmodal'),('super_admin','/vehicle/notesmodal'),('admin_LA','/vehicle/search-vin'),('super_admin','/vehicle/search-vin'),('admin_LA','/vehicle/update'),('super_admin','/vehicle/update'),('admin_LA','/vehicle/upload-notes'),('admin_LA','/vehicle/vehicledetail'),('customer','/vehicle/vehicledetail'),('super_admin','/vehicle/vehicledetail'),('admin_LA','/vehicle/view'),('customer','/vehicle/view'),('super_admin','/vehicle/view');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `condition`
--

DROP TABLE IF EXISTS `condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `condition`
--

LOCK TABLES `condition` WRITE;
/*!40000 ALTER TABLE `condition` DISABLE KEYS */;
INSERT INTO `condition` VALUES (2,'FRONT WINDSHILED'),(3,'BONNET'),(4,'GRILL'),(5,'FRONT BUMPER'),(6,'FROTN HEAD LIGHT'),(7,'REAR WINDSHIELD'),(8,'TRUNK DOOR'),(9,'REAR BUMPER'),(10,'REAR BUMPER SUPPORT'),(11,'TAIL LAMP'),(12,'FRONT LEFT FENDER'),(13,'LEFT FRONT DOOR'),(14,'LEFT REAR DOOR'),(15,'LEFT REAR FENDER'),(16,'PILLAR'),(17,'ROOF'),(18,'RIGHT REAR FENDER'),(20,'RIGHT REAR DOOR'),(21,'RIGHT FRONT DOOR'),(22,'FRONT RIGHT FENDER'),(23,'FRONT TYRES');
/*!40000 ALTER TABLE `condition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consignee`
--

DROP TABLE IF EXISTS `consignee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consignee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_user_id` int(11) DEFAULT NULL,
  `consignee_name` varchar(45) DEFAULT NULL,
  `consignee_address_1` varchar(45) DEFAULT NULL,
  `consignee_address_2` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `zip_code` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `consignee_is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `fk_consignee_customer1_idx` (`customer_user_id`),
  CONSTRAINT `fk_consignee_customer1` FOREIGN KEY (`customer_user_id`) REFERENCES `customer` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consignee`
--

LOCK TABLES `consignee` WRITE;
/*!40000 ALTER TABLE `consignee` DISABLE KEYS */;
INSERT INTO `consignee` VALUES (12,462,'AFG Global UAE','12TH FLOOR CENTURION STAR','TOWER PORT SAEED, ','DUBAI','UAE','','','+971-4224-9714–715',NULL,'2018-05-29 05:00:34',NULL,1,'\0'),(13,NULL,'AMAYA USED CARS TR','INDUSTRIAL AREA NO. 2, BEHIND THE 1ST IND','','SHARJAH','','','81566','+971-508844894',NULL,'2018-06-09 05:22:10',NULL,1,'\0'),(14,464,'MASOOD AHMAD NOOR AHMAD ','20925 ROSCOE BLVD. NO.8 ','','CANOGA PARK CA ','','','','310-593-9604','2018-05-31 05:52:17','2018-05-31 05:52:17',1,1,'\0'),(15,NULL,'AFG Global SHIPPING LLC','1205 CENTURION STAR TOWER, DEIRA','','DUBAI','','UAE','','TEL: +97142249714, FAX: +9714224971','2018-05-31 05:54:00','2018-06-09 05:19:28',1,1,'\0'),(23,484,'GHULAM FAROOQ USED CARS TRADING LLC ','IND AREA #2','','SHARJAH','','UAE','','971526226629','2018-06-10 07:35:14','2018-06-13 06:16:33',1,1,'\0');
/*!40000 ALTER TABLE `consignee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(45) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `address_line_1` varchar(450) DEFAULT NULL,
  `address_line_2` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(450) DEFAULT NULL,
  `country` varchar(450) DEFAULT NULL,
  `zip_code` varchar(45) DEFAULT NULL,
  `tax_id` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `legacy_customer_id` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `trn` varchar(100) DEFAULT NULL,
  `phone_two` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_table1_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (437,'LA OFFICE ADMIN','LA','','131 East Gardena,  BoulevardCarson, CA 90247','','CARSON','CA 90247','','07114','','2018-01-15 13:22:14','2018-06-21 08:08:38',1,1,'\0','LAADMIN0001','','',''),(438,'GA@AFG Globalworldwide.com','GA','+1-912-826-0265','AFG Global Georgia 146 Commerce Court Rincon, 31326 ','','Georgia','','USA','31326','','2018-01-15 13:24:13','2018-06-21 08:05:05',1,1,'\0','GAOFFICE20018','','',''),(439,'NJ@AFG Globalworldwide.com','NJ','+1-862-237-7066','AFG Global World Wide New Jersey 810 Frelinghuysen Ave Newark 07114','','New Jersey ','','USA','','','2018-01-15 13:26:33','2018-06-21 08:25:16',1,1,'\0','NJOFFICE20018','','',''),(440,'TX@AFG Globalworldwideshipping.com','TX','+1-713-631-1560',' AFG Global Texas 7801 Parkhurst Dr.Houston, 77028 ',NULL,'Texas',NULL,'USA','','','2018-01-15 13:28:55','2018-01-15 13:28:55',1,1,'\0','TXOFFICE20018','',NULL,NULL),(460,'Izhar','Impulse Tech UAE','090029','','','Dubai','','','','9292938','2018-05-19 09:13:18','2018-05-19 09:13:18',1,1,'\0','10013','828828','8288828','929929929'),(461,'MR.NEMAT ULLAH','SAMAA AL KHALEEJ','+10000000000','131 E. GARDENA BLVD.	','SHARJAH 2','CARSON','CA 90247','US','','+97111111111','2018-05-20 05:26:28','2018-05-20 06:45:55',1,1,'\0','900684','310-593-9604','+11111111111','+97100000000'),(462,'ABDUL AHAD WAHIDI	','ABDUL AHAD WAHIDI	','','131 E. GARDENA BLVD.	','','CARSON','CA 90247','','','','2018-05-27 06:34:31','2018-05-27 06:34:31',1,1,'\0','900755','310-593-9604','',''),(463,'Ashfaq ahmad','impulae','0566029394','international city','','Dubai','Dubai','UAE','','1000120001','2018-05-30 18:29:21','2018-05-30 18:29:21',1,1,'\0','10001','','2000120001','0500000000'),(464,'MASOOD AHMAD NOOR AHMAD ','NOOR AL JABAL USED CARS TR.LLC','310-593-9604','131 E. GARDENA BLVD.	','SHARJAH INDUSTRIAL AREA #3','CA 90247','CA','U.S','91304','100358683900003','2018-05-31 05:47:51','2018-05-31 05:47:51',1,1,'\0','900765','','',''),(484,'GHULAM FAROOQ','GHULAM FAROOQ USED CARS TRADING LLC ','+10000000000','131 E. GARDENA BLVD.	','IND #2  SHARJAH UAE','CARSON','CA 90247','US','','','2018-06-10 07:35:14','2018-06-11 06:24:38',1,1,'\0','700004','','','');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_documents`
--

DROP TABLE IF EXISTS `customer_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(100) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `customer_user_id` int(11) NOT NULL,
  `thumbnail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer_documents_customer1_idx` (`customer_user_id`),
  CONSTRAINT `fk_customer_documents_customer1` FOREIGN KEY (`customer_user_id`) REFERENCES `customer` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_documents`
--

LOCK TABLES `customer_documents` WRITE;
/*!40000 ALTER TABLE `customer_documents` DISABLE KEYS */;
INSERT INTO `customer_documents` VALUES (2,'A_lQcEv8LcVeOWDYGXkZL6mSZnwZtjto.pdf',NULL,462,NULL),(5,'AQwgcJ8DoQe0rbql11y9dMQo1HYaSzTo.png',NULL,460,NULL),(23,'M5QKswnnmSvgSvYs_XJMyJ8GccTNIrKK.jpg',NULL,484,NULL),(26,'tFhzbcUYh5Trc4yAFJQ2tzXwqx7n_V6X.jpg',NULL,463,NULL),(27,'WsKWVK_b8GUp1P0p3QgFIfUun34EZPPq.png',NULL,461,NULL);
/*!40000 ALTER TABLE `customer_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dock_receipt`
--

DROP TABLE IF EXISTS `dock_receipt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dock_receipt` (
  `export_id` int(11) NOT NULL,
  `awb_number` varchar(45) DEFAULT NULL,
  `export_reference` varchar(200) DEFAULT NULL,
  `forwarding_agent` text,
  `domestic_routing_insctructions` text,
  `pre_carriage_by` varchar(450) DEFAULT NULL,
  `place_of_receipt_by_pre_carrier` varchar(45) DEFAULT NULL,
  `exporting_carrier` varchar(200) DEFAULT NULL,
  `final_destination` varchar(200) DEFAULT NULL,
  `loading_terminal` varchar(200) DEFAULT NULL,
  `container_type` varchar(45) DEFAULT NULL,
  `number_of_packages` varchar(45) DEFAULT NULL,
  `by` varchar(200) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `auto_recieving_date` date DEFAULT NULL,
  `auto_cut_off` date DEFAULT NULL,
  `vessel_cut_off` date DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  PRIMARY KEY (`export_id`),
  KEY `fk_dock_receipt_export1_idx` (`export_id`),
  CONSTRAINT `fk_dock_receipt_export1` FOREIGN KEY (`export_id`) REFERENCES `export` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dock_receipt`
--

LOCK TABLES `dock_receipt` WRITE;
/*!40000 ALTER TABLE `dock_receipt` DISABLE KEYS */;
INSERT INTO `dock_receipt` VALUES (7,'','','','','','','','','','','','',NULL,NULL,NULL,NULL,NULL),(8,'','','','','','','','','','','','',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dock_receipt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `export`
--

DROP TABLE IF EXISTS `export`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `export` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `export_date` date DEFAULT NULL,
  `loading_date` date DEFAULT NULL,
  `broker_name` varchar(450) DEFAULT NULL,
  `booking_number` varchar(45) DEFAULT NULL,
  `eta` date DEFAULT NULL,
  `ar_number` varchar(45) DEFAULT NULL,
  `xtn_number` varchar(45) DEFAULT NULL,
  `seal_number` varchar(45) DEFAULT NULL,
  `container_number` varchar(45) DEFAULT NULL,
  `cutt_off` date DEFAULT NULL,
  `vessel` varchar(45) DEFAULT NULL,
  `voyage` varchar(45) DEFAULT NULL,
  `terminal` varchar(45) DEFAULT NULL,
  `streamship_line` varchar(200) DEFAULT NULL,
  `destination` varchar(45) DEFAULT NULL,
  `itn` varchar(45) DEFAULT NULL,
  `contact_details` text,
  `special_instruction` text,
  `container_type` varchar(45) DEFAULT NULL,
  `port_of_loading` varchar(200) DEFAULT NULL,
  `port_of_discharge` varchar(200) DEFAULT NULL,
  `export_invoice` varchar(45) DEFAULT NULL,
  `bol_note` varchar(45) DEFAULT NULL,
  `export_is_deleted` bit(1) DEFAULT b'0',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_user_id` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `export`
--

LOCK TABLES `export` WRITE;
/*!40000 ALTER TABLE `export` DISABLE KEYS */;
INSERT INTO `export` VALUES (7,'2018-06-08','2018-06-05','Ishfaq','27737283782','2018-06-13','238287382Y3553','12000203','29399291','29919929299','2018-06-11','1233727YUD','203929','','','','','','','','','','VA8vrssMigpq4RZ4AJq9qNE8sHOlq0lb.pdf','','\0',1,1,'2018-06-11 06:53:42','2018-06-11 06:53:42','463'),(8,'2018-04-11','2018-04-20','AFG Global MARITIME INC','RICU42902400','2018-06-02','AR-0416418GFAROOQ161','204601491-2400','UL-1794536','TCNU6237377','2018-04-15','HAMBURG BRIDGE','051W','ITS','ONE','JEBEL ALI, UAE','X20180411652082','','','3','LOS ANGELES, CA','JEBEL ALI','8jZ9DCGY_v-oHBMsDnS2dYVI5aA8KUgT.pdf','','\0',1,1,'2018-06-11 07:43:22','2018-06-11 07:43:22','484');
/*!40000 ALTER TABLE `export` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `export_images`
--

DROP TABLE IF EXISTS `export_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `export_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `thumbnail` varchar(45) DEFAULT NULL,
  `export_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_export_images_export1_idx` (`export_id`),
  CONSTRAINT `fk_export_images_export1` FOREIGN KEY (`export_id`) REFERENCES `export` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `export_images`
--

LOCK TABLES `export_images` WRITE;
/*!40000 ALTER TABLE `export_images` DISABLE KEYS */;
INSERT INTO `export_images` VALUES (14,'Ue5m5bYs9Z5ssCk9M1fXwzqtfKLeuLrh.jpg','thumb-Ue5m5bYs9Z5ssCk9M1fXwzqtfKLeuLrh.jpg',7),(15,'h0hNY6uCGm7D32honfiL-kqTBIyeFa7_.jpg','thumb-h0hNY6uCGm7D32honfiL-kqTBIyeFa7_.jpg',7),(16,'ttHVwgDP6yB7eQfxJsWb1s5-G0e4EHvE.jpg','thumb-ttHVwgDP6yB7eQfxJsWb1s5-G0e4EHvE.jpg',7),(17,'fQKCYU6ksoHLbYWjJpZtzfbAuHsyFBk7.jpg','thumb-fQKCYU6ksoHLbYWjJpZtzfbAuHsyFBk7.jpg',7),(18,'FNpJ90qf41yGiJkqlppaD0JST6BkLEKL.jpg','thumb-FNpJ90qf41yGiJkqlppaD0JST6BkLEKL.jpg',7),(19,'2DXrFyCXAc3VFKPIcZFG8dK3CeINPMN2.jpeg','thumb-2DXrFyCXAc3VFKPIcZFG8dK3CeINPMN2.jpeg',8),(20,'I4SHf8qCIDdtdqS7pVHd1nAKd7NK0z8J.jpeg','thumb-I4SHf8qCIDdtdqS7pVHd1nAKd7NK0z8J.jpeg',8),(21,'Lhj40tlTBEhru0B2lBt0J8e51yxWTv7T.jpeg','thumb-Lhj40tlTBEhru0B2lBt0J8e51yxWTv7T.jpeg',8),(22,'9GE9MNlq0vpYMEQgp3NspPAUNA27g80r.jpeg','thumb-9GE9MNlq0vpYMEQgp3NspPAUNA27g80r.jpeg',8),(23,'2wrx9phF7wXUBSW_tSjLbOhBXeRqQxbr.jpeg','thumb-2wrx9phF7wXUBSW_tSjLbOhBXeRqQxbr.jpeg',8);
/*!40000 ALTER TABLE `export_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
INSERT INTO `features` VALUES (1,'Keys'),(3,'CD Changer'),(4,'GPS Navigation System'),(5,'Spare Tire/Jack'),(6,'Wheel Covers'),(7,'Radio'),(8,'CD Player'),(10,'Mirror'),(11,'Speaker'),(12,'Other...');
/*!40000 ALTER TABLE `features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `houstan_custom_cover_letter`
--

DROP TABLE IF EXISTS `houstan_custom_cover_letter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `houstan_custom_cover_letter` (
  `export_id` int(11) NOT NULL,
  `vehicle_location` varchar(45) DEFAULT NULL,
  `exporter_id` varchar(45) DEFAULT NULL,
  `exporter_type_issuer` varchar(45) DEFAULT NULL,
  `transportation_value` varchar(45) DEFAULT NULL,
  `exporter_dob` varchar(45) DEFAULT NULL,
  `ultimate_consignee_dob` varchar(45) DEFAULT NULL,
  `consignee` varchar(450) DEFAULT NULL,
  `notify_party` varchar(450) DEFAULT NULL,
  `menifest_consignee` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`export_id`),
  KEY `fk_houstan_custom_cover_letter_export1_idx` (`export_id`),
  CONSTRAINT `fk_houstan_custom_cover_letter_export1` FOREIGN KEY (`export_id`) REFERENCES `export` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `houstan_custom_cover_letter`
--

LOCK TABLES `houstan_custom_cover_letter` WRITE;
/*!40000 ALTER TABLE `houstan_custom_cover_letter` DISABLE KEYS */;
INSERT INTO `houstan_custom_cover_letter` VALUES (7,'','','','','','','15','15','13'),(8,'','','','','','','23','15','');
/*!40000 ALTER TABLE `houstan_custom_cover_letter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `thumbnail` varchar(45) DEFAULT NULL,
  `normal` varchar(45) DEFAULT NULL,
  `vehicle_id` int(11) NOT NULL,
  `is_deleted` bit(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_images_vehicle1_idx` (`vehicle_id`),
  CONSTRAINT `fk_images_vehicle1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (31,'zyRO--BISX5ql2UHbnyAiIZdlxFjkElO.jpeg','thumb-zyRO--BISX5ql2UHbnyAiIZdlxFjkElO.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(32,'6oK0d59wFrfKF5KZIis-QOc9KBKsR4Hq.jpeg','thumb-6oK0d59wFrfKF5KZIis-QOc9KBKsR4Hq.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(33,'sd3-OAYNnzj2q7EvKuCuJTw3nPv1ZV78.jpeg','thumb-sd3-OAYNnzj2q7EvKuCuJTw3nPv1ZV78.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(34,'UCvHtkWQlHzhp__FFrMyoJVp2vDXPPnF.jpeg','thumb-UCvHtkWQlHzhp__FFrMyoJVp2vDXPPnF.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(35,'Q76BirZTcFSLTrgpj_Er9PyPOjD3k-bx.jpeg','thumb-Q76BirZTcFSLTrgpj_Er9PyPOjD3k-bx.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(36,'Tbkez_eOFNAhphtQcDm4m7BnliLWY1U7.jpeg','thumb-Tbkez_eOFNAhphtQcDm4m7BnliLWY1U7.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(37,'kNaGFJ2EPsssq4lxgPeOMNT2KKQjrfey.jpeg','thumb-kNaGFJ2EPsssq4lxgPeOMNT2KKQjrfey.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(38,'M-c1gIl3DWMApS0O1pmK1J4bReTi2xbm.jpeg','thumb-M-c1gIl3DWMApS0O1pmK1J4bReTi2xbm.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(39,'OThF9R0jShgq5ZWwhSqHg7fPVN9CTPZW.jpeg','thumb-OThF9R0jShgq5ZWwhSqHg7fPVN9CTPZW.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(40,'B_ks5758Geipmq0rxiiTdiQuWPWlZkdz.jpeg','thumb-B_ks5758Geipmq0rxiiTdiQuWPWlZkdz.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(41,'pABJNu54-umcL7vYMpRZyzBM2omv7YC0.jpeg','thumb-pABJNu54-umcL7vYMpRZyzBM2omv7YC0.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(42,'tWAIC5v8kjV7oKPvGhHq2EySNFMzlNQo.jpeg','thumb-tWAIC5v8kjV7oKPvGhHq2EySNFMzlNQo.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(43,'MjyAmfa_vmMlwfc82C4F2Zen0AQQaRZf.jpeg','thumb-MjyAmfa_vmMlwfc82C4F2Zen0AQQaRZf.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(44,'W3BOlxNT5U0B1pDtXx5KQQQ1dvdNcL2L.jpeg','thumb-W3BOlxNT5U0B1pDtXx5KQQQ1dvdNcL2L.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(45,'nxdU0a10ktHK5RaLZ20Wu5bnsMegvPKg.jpeg','thumb-nxdU0a10ktHK5RaLZ20Wu5bnsMegvPKg.jpeg',NULL,3,NULL,'2018-05-20 05:53:17','2018-05-20 05:53:17',1,1),(46,'xXHyJOIqE5ZTRjAXZI7yRkmPgAfziEbx.jpeg','thumb-xXHyJOIqE5ZTRjAXZI7yRkmPgAfziEbx.jpeg',NULL,4,NULL,'2018-05-20 05:57:24','2018-05-20 05:57:24',1,1),(47,'aOS0jRwPcSgrCmvxBuItlLmZP3jB1-LD.jpg','thumb-aOS0jRwPcSgrCmvxBuItlLmZP3jB1-LD.jpg',NULL,5,NULL,'2018-05-27 06:37:43','2018-05-27 06:37:43',1,1),(48,'yvRiEAnt3bbskevi84m4XyZDveLCK4Ev.jpg','thumb-yvRiEAnt3bbskevi84m4XyZDveLCK4Ev.jpg',NULL,6,NULL,'2018-05-27 06:40:05','2018-05-27 06:40:05',1,1),(49,'iu3fi7xqv9_ptSNPv98_nqfuEeVhhY9D.jpg','thumb-iu3fi7xqv9_ptSNPv98_nqfuEeVhhY9D.jpg',NULL,7,NULL,'2018-05-27 06:42:17','2018-05-27 06:42:17',1,1),(50,'iAPNNiHGErJn33L-JU-Y4L6DeH0zuzXh.jpg','thumb-iAPNNiHGErJn33L-JU-Y4L6DeH0zuzXh.jpg',NULL,8,NULL,'2018-05-27 06:45:05','2018-05-27 06:45:05',1,1),(51,'_0nq7zsQy9HQF3l39pqPbwbuo3Lu0Djt.PNG','thumb-_0nq7zsQy9HQF3l39pqPbwbuo3Lu0Djt.PNG',NULL,9,NULL,'2018-05-27 06:47:51','2018-05-27 06:47:51',1,1),(52,'PDpD6n38FBW-riom15iSXJceG-mOc23B.jpg','thumb-PDpD6n38FBW-riom15iSXJceG-mOc23B.jpg',NULL,10,NULL,'2018-05-27 06:50:45','2018-05-27 06:50:45',1,1),(53,'lXuklm_GqOChbpIYNqCbfRmNMBlxcKXm.jpg','thumb-lXuklm_GqOChbpIYNqCbfRmNMBlxcKXm.jpg',NULL,11,NULL,'2018-05-27 06:53:46','2018-05-27 06:53:46',1,1),(54,'V9kcDf_jT1lWSgddBbSLdtg6tko-wbT5.jpg','thumb-V9kcDf_jT1lWSgddBbSLdtg6tko-wbT5.jpg',NULL,12,NULL,'2018-05-27 06:56:43','2018-05-27 06:56:43',1,1),(55,'FQd_cHaFnSoESCEu50Q3LALl_AU2PoH9.PNG','thumb-FQd_cHaFnSoESCEu50Q3LALl_AU2PoH9.PNG',NULL,13,NULL,'2018-05-27 07:01:03','2018-05-27 07:01:03',1,1),(56,'kBpln7KP2qssjiA-8wN6sCMz2-5GX-lw.jpg','thumb-kBpln7KP2qssjiA-8wN6sCMz2-5GX-lw.jpg',NULL,14,NULL,'2018-05-27 07:03:28','2018-05-27 07:03:28',1,1),(57,'s8wYF9gstCEmPeIDCNdlDDhWbCDI2CxA.jpg','thumb-s8wYF9gstCEmPeIDCNdlDDhWbCDI2CxA.jpg',NULL,15,NULL,'2018-05-27 07:06:18','2018-05-27 07:06:18',1,1),(58,'aq8iLBG_nqFBS-nBNeowXBy0hcCa8-3a.jpg','thumb-aq8iLBG_nqFBS-nBNeowXBy0hcCa8-3a.jpg',NULL,16,NULL,'2018-05-27 07:09:33','2018-05-27 07:09:33',1,1),(59,'9UqhOFMg5KIC6UIadq2cuwvah_HoF7Dy.jpg','thumb-9UqhOFMg5KIC6UIadq2cuwvah_HoF7Dy.jpg',NULL,17,NULL,'2018-05-27 07:12:40','2018-05-27 07:12:40',1,1),(60,'sWpNRHBHf2Ki4Dm1XrnadjLRe7TlheSe.PNG','thumb-sWpNRHBHf2Ki4Dm1XrnadjLRe7TlheSe.PNG',NULL,18,NULL,'2018-05-27 07:15:00','2018-05-27 07:15:00',1,1),(61,'GnwF3EtUIX-_eFHeiGZHQPfarQ2EXFLd.jpg','thumb-GnwF3EtUIX-_eFHeiGZHQPfarQ2EXFLd.jpg',NULL,19,NULL,'2018-05-27 07:19:15','2018-05-27 07:19:15',1,1),(62,'sRqzCPlu_CjtANLsmcNOCu_74WgDvDTr.jpg','thumb-sRqzCPlu_CjtANLsmcNOCu_74WgDvDTr.jpg',NULL,20,NULL,'2018-05-30 18:35:43','2018-05-30 18:35:43',1,1),(63,'-Ys3cwKzR7XR8e4UoBTCHYYX0poqnWHT.png','thumb--Ys3cwKzR7XR8e4UoBTCHYYX0poqnWHT.png',NULL,21,NULL,'2018-05-31 06:01:20','2018-05-31 06:01:20',1,1),(64,'ngA-eW2QFMcqq3lGaOzh62qtWJ7V4W_u.png','thumb-ngA-eW2QFMcqq3lGaOzh62qtWJ7V4W_u.png',NULL,22,NULL,'2018-05-31 06:21:31','2018-05-31 06:21:31',1,1),(65,'EFqhy9BeoKJoRH2QWSir98oG3hPuWb8N.png','thumb-EFqhy9BeoKJoRH2QWSir98oG3hPuWb8N.png',NULL,22,NULL,'2018-05-31 06:21:31','2018-05-31 06:21:31',1,1),(66,'PwWca3Qw_QhTZmjRy5NrD8AtZ-wkbkw9.png','thumb-PwWca3Qw_QhTZmjRy5NrD8AtZ-wkbkw9.png',NULL,22,NULL,'2018-05-31 06:21:31','2018-05-31 06:21:31',1,1),(67,'9W2ifzQU1PR2uczJ8QIUkZKsTuojkmYl.png','thumb-9W2ifzQU1PR2uczJ8QIUkZKsTuojkmYl.png',NULL,22,NULL,'2018-05-31 06:21:31','2018-05-31 06:21:31',1,1),(68,'uq6-c4BqMVhFpG_IJ45rCyD8SR_m47NE.png','thumb-uq6-c4BqMVhFpG_IJ45rCyD8SR_m47NE.png',NULL,23,NULL,'2018-05-31 06:25:26','2018-05-31 06:25:26',1,1),(69,'YwYEtYq8AQbKcLiQuZ-xmuR9X25wPIvo.png','thumb-YwYEtYq8AQbKcLiQuZ-xmuR9X25wPIvo.png',NULL,24,NULL,'2018-05-31 06:29:51','2018-05-31 06:29:51',1,1),(70,'wN1RRIIRr9GEm0YOU-MsFi61GjHzgp6a.png','thumb-wN1RRIIRr9GEm0YOU-MsFi61GjHzgp6a.png',NULL,1,NULL,'2018-06-07 12:31:37','2018-06-07 12:31:37',1,1),(71,'gPz7PZOjGMetsdL9h3DENP8-WZk9c7Oc.png','thumb-gPz7PZOjGMetsdL9h3DENP8-WZk9c7Oc.png',NULL,1,NULL,'2018-06-07 12:31:37','2018-06-07 12:31:37',1,1),(72,'qjwnF8z4cSl23unUhRasYDBTIcKWF8d8.png','thumb-qjwnF8z4cSl23unUhRasYDBTIcKWF8d8.png',NULL,1,NULL,'2018-06-09 09:13:13','2018-06-09 09:13:13',1,1),(73,'nI8h_oHe80R7VGbwHtVQEVUYrDlT3aLt.jpg','thumb-nI8h_oHe80R7VGbwHtVQEVUYrDlT3aLt.jpg',NULL,26,NULL,'2018-06-10 07:36:52','2018-06-10 07:36:52',1,1),(74,'G2y4uoDp9FBvEbW1Oqp-shYl1H4FMo8G.jpg','thumb-G2y4uoDp9FBvEbW1Oqp-shYl1H4FMo8G.jpg',NULL,20,NULL,'2018-06-11 05:55:30','2018-06-11 05:55:30',1,1),(76,'pszNcWqSPN1GROvA5KlzyDtGT171-zEJ.png','thumb-pszNcWqSPN1GROvA5KlzyDtGT171-zEJ.png',NULL,1,NULL,'2018-06-11 05:56:36','2018-06-11 05:56:36',1,1),(77,'6rrpmS7RhtIn_2GTWZg6y2pRwsk7hy2C.jpeg','thumb-6rrpmS7RhtIn_2GTWZg6y2pRwsk7hy2C.jpeg',NULL,27,NULL,'2018-06-11 07:24:59','2018-06-11 07:24:59',1,1),(78,'SIPWjKlSakSoBtFw9xba7WzO5rq8ZFjv.jpeg','thumb-SIPWjKlSakSoBtFw9xba7WzO5rq8ZFjv.jpeg',NULL,27,NULL,'2018-06-11 07:24:59','2018-06-11 07:24:59',1,1),(79,'ZtrNWrdhCgd1ruj6wpetIAzipxAYbE1e.jpeg','thumb-ZtrNWrdhCgd1ruj6wpetIAzipxAYbE1e.jpeg',NULL,27,NULL,'2018-06-11 07:24:59','2018-06-11 07:24:59',1,1),(80,'IEqrCqnzsXZTwv3TbnLs0xDJ1LO0SBbz.jpeg','thumb-IEqrCqnzsXZTwv3TbnLs0xDJ1LO0SBbz.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(81,'n-wmDG-FXtqd-RmgKVNSjcryqrDtT4Hq.jpeg','thumb-n-wmDG-FXtqd-RmgKVNSjcryqrDtT4Hq.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(82,'5W1cgDTTwht-jVKOyNX1rDL9CAr3kWrK.jpeg','thumb-5W1cgDTTwht-jVKOyNX1rDL9CAr3kWrK.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(83,'adJZ7SpUjcKBAs1soFpSdtFahUUWF1Jv.jpeg','thumb-adJZ7SpUjcKBAs1soFpSdtFahUUWF1Jv.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(84,'4diugWeDjQXhsL6Cd4lrOJ58Eg2WK5XG.jpeg','thumb-4diugWeDjQXhsL6Cd4lrOJ58Eg2WK5XG.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(85,'zh9dYR9EPLEUeWiRYltaDZs60pPtJ7PV.jpeg','thumb-zh9dYR9EPLEUeWiRYltaDZs60pPtJ7PV.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(86,'3PrGpzUtMdJrhnuFWLQHWkcH9YH0Z8jJ.jpeg','thumb-3PrGpzUtMdJrhnuFWLQHWkcH9YH0Z8jJ.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(87,'XFAOwU7tVCTBccfl8LQ6NVL4QVoEF1ub.jpeg','thumb-XFAOwU7tVCTBccfl8LQ6NVL4QVoEF1ub.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(88,'virCz-rokjbQhWgIaiqHSy5YV-IvETMl.jpeg','thumb-virCz-rokjbQhWgIaiqHSy5YV-IvETMl.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(89,'NzUBIPLhHlD75BU1195cplU34YxATojf.jpeg','thumb-NzUBIPLhHlD75BU1195cplU34YxATojf.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(90,'KAy-S33R6BndVw9MMzbG1nLF2DthXByJ.jpeg','thumb-KAy-S33R6BndVw9MMzbG1nLF2DthXByJ.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(91,'rSfW1JJrQswRJLfP-Wc8PJeTgcYkGISK.jpeg','thumb-rSfW1JJrQswRJLfP-Wc8PJeTgcYkGISK.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(92,'q-MgRd2wBEhP0Vg2BiD86bIma_2usdiR.jpeg','thumb-q-MgRd2wBEhP0Vg2BiD86bIma_2usdiR.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(93,'NSLZNRK4zYK3bd74AKeih3I80j4u8qC4.jpeg','thumb-NSLZNRK4zYK3bd74AKeih3I80j4u8qC4.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(94,'gyNqRvDNwY2Hjyt-0b4bDBOTZHYNFVJ8.jpeg','thumb-gyNqRvDNwY2Hjyt-0b4bDBOTZHYNFVJ8.jpeg',NULL,27,NULL,'2018-06-11 07:25:24','2018-06-11 07:25:24',1,1),(95,'1Yr13FJcRfT9iCOvBN666pmMRwHOiu0r.jpeg','thumb-1Yr13FJcRfT9iCOvBN666pmMRwHOiu0r.jpeg',NULL,28,NULL,'2018-06-11 07:31:16','2018-06-11 07:31:16',1,1),(96,'G76JEoWMO8RTDeSAT3dTJbUqLDN7I629.jpeg','thumb-G76JEoWMO8RTDeSAT3dTJbUqLDN7I629.jpeg',NULL,29,NULL,'2018-06-11 07:33:02','2018-06-11 07:33:02',1,1),(97,'ceugIFNGAGiwNX7v9WUPY8rRYC4VYs7b.jpeg','thumb-ceugIFNGAGiwNX7v9WUPY8rRYC4VYs7b.jpeg',NULL,29,NULL,'2018-06-11 07:33:02','2018-06-11 07:33:02',1,1),(100,'z2jm5ftiwibgHGh22zyGkICWUqEHDTNI.jpeg','thumb-z2jm5ftiwibgHGh22zyGkICWUqEHDTNI.jpeg',NULL,30,NULL,'2018-06-11 07:35:00','2018-06-11 07:35:00',1,1),(101,'F2-DbjUVW1mNpW3LtnAGHfx7vfML5To6.jpeg','thumb-F2-DbjUVW1mNpW3LtnAGHfx7vfML5To6.jpeg',NULL,30,NULL,'2018-06-11 07:35:00','2018-06-11 07:35:00',1,1);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `export_id` int(11) NOT NULL,
  `customer_user_id` int(11) NOT NULL,
  `consignee_id` int(11) DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `export_invoice` varchar(45) DEFAULT NULL,
  `note` text,
  `invoice_is_deleted` bit(1) DEFAULT b'0',
  `currency` varchar(45) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `before_discount` double DEFAULT NULL,
  `upload_invoice` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_export1_idx` (`export_id`),
  KEY `fk_invoice_consignee1_idx` (`consignee_id`),
  KEY `fk_invoice_customer1_idx` (`customer_user_id`),
  CONSTRAINT `fk_invoice_consignee1` FOREIGN KEY (`consignee_id`) REFERENCES `consignee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_invoice_customer1` FOREIGN KEY (`customer_user_id`) REFERENCES `customer` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_invoice_export1` FOREIGN KEY (`export_id`) REFERENCES `export` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` VALUES (6,7,461,NULL,36,36,NULL,'','\0',NULL,1,1,'2018-06-14 05:47:48','2018-06-11 06:58:21',NULL,36,'wrIYx8wSxqxXvwBK8bBxcjTg5fn4zLyq.pdf'),(7,8,484,NULL,13027.9,13027.9,NULL,'PAID TO AMIN ON 2ND JUNE','\0',NULL,1,1,'2018-06-11 08:29:26','2018-06-11 08:29:26',NULL,13027.9,'DEzbPOAYFwEAnhkGNX-a6a6l8U85kaac.jpg');
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1507543382),('m130524_201442_init',1507543389),('m140506_102106_rbac_init',1508174414),('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1508174415);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  `export_id` int(11) DEFAULT NULL,
  `imageurl` varchar(450) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_note_export1_idx` (`export_id`),
  CONSTRAINT `fk_note_export1` FOREIGN KEY (`export_id`) REFERENCES `export` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note`
--

LOCK TABLES `note` WRITE;
/*!40000 ALTER TABLE `note` DISABLE KEYS */;
INSERT INTO `note` VALUES (6,'test\r\n',NULL,'','2018-06-14 07:49:31','2018-06-14 07:49:31',484,484,26),(7,'eid days holidays?/',NULL,'','2018-06-14 07:49:48','2018-06-14 07:49:48',484,484,26);
/*!40000 ALTER TABLE `note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(65) DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `is_read` bit(1) DEFAULT NULL,
  `status` bit(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_notification_user1_idx` (`user_id`),
  CONSTRAINT `fk_notification_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (3,'EID MUBARAK','On Eid ul-Fitr, wish that Allah’s blessings light up the path and lead to happiness, peace and success. Happy Eid!',NULL,NULL,1,1,'2018-06-11 07:04:16','2018-06-11 07:04:16',1,'2018-06-18');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pricing`
--

DROP TABLE IF EXISTS `pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_file` varchar(200) NOT NULL,
  `month` varchar(45) DEFAULT NULL,
  `pricing_type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pricing`
--

LOCK TABLES `pricing` WRITE;
/*!40000 ALTER TABLE `pricing` DISABLE KEYS */;
INSERT INTO `pricing` VALUES (5,'hHD6KYtb_jaAssw2cZxWzVdc_hW12c6_.pdf','Jun-2018',2,1,1,1,'2018-06-11 06:59:26','2018-06-13 06:48:10','JUNE-2018'),(6,'Ikk6qYmUWQmtrDgToXf4bBkoE4oOuTi4.pdf','Jun-2018',1,1,1,1,'2018-06-11 07:00:22','2018-06-13 06:49:41','TOWING RATE JUNE-18');
/*!40000 ALTER TABLE `pricing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `towing_request`
--

DROP TABLE IF EXISTS `towing_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `towing_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condition` int(11) DEFAULT NULL,
  `damaged` int(11) DEFAULT NULL,
  `pictures` bit(1) DEFAULT NULL,
  `towed` bit(1) DEFAULT NULL,
  `title_recieved` bit(1) DEFAULT NULL,
  `title_recieved_date` date DEFAULT NULL,
  `title_number` varchar(450) DEFAULT NULL,
  `title_state` varchar(450) DEFAULT NULL,
  `towing_request_date` date DEFAULT NULL,
  `pickup_date` date DEFAULT NULL,
  `deliver_date` date DEFAULT NULL,
  `note` text,
  `title_type` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `towing_request`
--

LOCK TABLES `towing_request` WRITE;
/*!40000 ALTER TABLE `towing_request` DISABLE KEYS */;
INSERT INTO `towing_request` VALUES (1,0,0,'','','','2018-01-10','404146180163904','NC','2018-01-04',NULL,'2018-01-10','',1),(2,0,1,'','','','2018-01-17','770760340524247','SC','2018-01-09',NULL,'2018-01-17','NO KEYS',1),(3,0,1,'','','','2018-02-09','405637180232904','NC','2018-01-09',NULL,'2018-01-16','TITLE RCVD 2018-02-09',1),(4,1,1,'','','','2018-03-20','404435180601961','GA',NULL,NULL,'2018-03-20','',1),(5,0,1,'','','','2017-02-28','9550990','CA','2017-02-27','2017-02-27','2017-02-28','',1),(6,0,1,'','','','2017-02-28','9560806','CA','2017-02-27','2017-02-28','2017-02-28','',1),(7,1,1,'','','','2017-03-06','9544965','CA','2017-03-03','2017-03-03','2017-03-06','',1),(8,1,1,'','','','2017-03-22','9566278','CA','2017-03-13','2017-03-14','2017-03-15','',1),(9,1,1,'','','','2017-03-15','CA127737482CA','2017-03-14','2017-03-15','2017-03-15','2017-03-15','',1),(10,1,1,'','','','2017-03-17','9559892','CA','2017-03-16','2017-03-17','2017-03-17','',1),(11,1,1,'','','','2017-03-17','9607630CA','CA','2017-03-17','2017-03-17','2017-03-17','',1),(12,1,1,NULL,'\0','','2017-03-17','CA164408142','CA','2017-03-16','2017-03-17','2017-03-17','',1),(13,1,1,'','','','2017-03-21','9573064','CA','2017-03-20','2017-03-20','2017-03-21','',1),(14,1,1,'','','','2017-03-21','9546284','CA','2017-03-20','2017-03-20','2017-03-20','',1),(15,1,0,'','\0','','2017-03-22','CA124081419','CA','2017-03-21','2017-03-21','2017-03-22','',1),(16,1,1,'','','','2017-03-29','9566556','CA','2017-03-28','2017-03-29','2017-03-29','',1),(17,1,1,NULL,NULL,'','2017-04-05','9572148','CA','2017-03-31','2017-03-31','2017-04-05','',1),(18,1,1,'','','','2017-04-05','CA122908374','CA','2017-04-04','2017-04-04','2017-04-05','',1),(19,1,1,'','','','2017-03-08','9559173','CA','2017-03-06','2017-03-06','2017-03-08','',1),(20,1,1,'',NULL,'','2018-05-29','100','','2018-05-29','2018-05-29','2018-05-29','',1),(21,1,1,'','','','2018-04-17','F48188J','NY','2018-04-11','2018-04-12','2018-04-17','',1),(22,0,1,NULL,'\0','','2018-04-17','F30394J','NY','2018-04-12','2018-04-13','2018-04-17','',1),(23,1,1,'','','','2018-04-17','U752354','MD','2018-04-12','2018-04-13','2018-04-17','',1),(24,0,1,'','','','2018-04-17','U750782','MD','2018-04-12','2018-04-13',NULL,'',1),(25,1,1,NULL,'\0',NULL,NULL,'','',NULL,NULL,NULL,'',NULL),(26,0,1,'',NULL,'','2018-06-11','123456','TX',NULL,NULL,NULL,'',1),(27,1,1,'','','','2018-04-09','0058328','CA','2018-03-28','2018-03-29','2018-04-09','',1),(28,1,1,'','','','2018-06-11','123456','CA','2018-06-13','2018-06-14','2018-06-11','',1),(29,1,1,NULL,NULL,NULL,'2018-04-09','0058328','CA','2018-03-28','2018-03-29','2018-04-09','',NULL),(30,1,1,NULL,'\0',NULL,NULL,'','',NULL,NULL,NULL,'',NULL);
/*!40000 ALTER TABLE `towing_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `address_line_1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip_code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=486 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','St2LDq2QmntotE7KRc_TxcJQYii4-6Yy','$2y$13$MIApGH2IKQJy2RjMqvrL4OeEjAEC6FjbMmZ1/La9anu.AX5Jjj.RG',NULL,'admin@gmail.com',10,NULL,NULL,NULL,0,0,'131 E. Gardena Blvd','','Carson','CA','90247','(310) 593-9604','(310) 532-8557','Mir Sharq'),(437,'LA@AFG Globalworldwide.com','mSK1xHDZWL9MbZ9ZbZnVzItHqvvx2nOA','$2y$13$lF0xPcCQzYRqXP6UtiXZ..FP5cC1ozuHcewSjpOhuQSbV4nEzl4V.',NULL,'LA@AFG Globalworldwide.com',10,'2018-01-15 13:22:13','2018-01-15 13:22:13',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(438,'GA@AFG Globalworldwideshipping.com','FkJIkvWypiThoULv5qUnZO0q-x6rlmm6','$2y$13$IXaUFfC/8ktnK43/QkkLyuCnci5JbW4z2.RPgrdM7X4JJQvXBTOlq',NULL,'GA@AFG Globalworldwideshipping.com',10,'2018-01-15 13:24:13','2018-01-15 13:24:13',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(439,'NJ@AFG Globalworldwide.com','blaYDmpfoIiSHJpvrGkbUVtiEVL5oVP8','$2y$13$C2chfvEN.jzAIu9yULvY1ObOsWfF.fSEzKwGBT/ckye5wmlmH0c/S',NULL,'NJ@AFG Globalworldwide.com',10,'2018-01-15 13:26:33','2018-01-15 13:26:33',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(440,'TX@AFG Globalworldwideshipping.com','f3TtAyplJN1lOBk3QoSsstofsllE2heB','$2y$13$nphhjn0sSFjCQqJPma4SKuwuGzGYcvkx71WfKGw4tzv4GfC9ihJbK',NULL,'TX@AFG Globalworldwideshipping.com',10,'2018-01-15 13:28:55','2018-01-15 13:28:55',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(460,'izhar@impusetechuae.comd','PW0BrKoLXWczbjgKQUIoolWhgR8dF_5t','$2y$13$a/c56n2VxjcFlYpg2gxeLuBWGL1yUC0GhRxW2xlYkWktEmX15MTGS',NULL,'izhar@impusetechuae.comd',10,'2018-05-19 09:13:18','2018-05-19 09:13:18',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(461,'nematullah.noori2@yahoo.com','uHUJ-j4MYxNEyK5B3aaNoHFEGm-gqPYm','$2y$13$hjGNMHVaG3Ald4IZhPVcGucxihRIeiFzqfdeiBGAtuV/vHIyCgTsi',NULL,'nematullah.noori2@yahoo.com',10,'2018-05-20 05:26:28','2018-05-20 05:26:28',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(462,'abdulahadwahidi2016@gmail.com','NKe4SpKDqr-LyJnPZkTKatzxhNZYy9XC','$2y$13$ptaHtseEftZuqPZTb9uFUuhnrr/vfx85D9B8wzT0.SbCbcytkaxNW',NULL,'abdulahadwahidi2016@gmail.com',10,'2018-05-27 06:34:31','2018-05-27 06:34:31',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(463,'ehmad.ashfaq@gmail.com','yrb5V5iYhryQpa4J4xHhMtOeTq46chSE','$2y$13$j9dy0q/oYsh7l/gai73sbOF.x5XmnjeO/nxLDKQGQ8Ls6Cs1MiNWq',NULL,'ehmad.ashfaq@gmail.com',10,'2018-05-30 18:29:20','2018-05-30 18:29:20',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(464,'nooraljabal1133@gmail.com','tg_IfYpA0GkGwiWHvS_8uA6fBa1RUehE','$2y$13$glXpeBgN3Zt/s0N40Yok/.rnD/84WOz1aeLzF4.9UT435ckU6BZGq',NULL,'nooraljabal1133@gmail.com',10,'2018-05-31 05:47:51','2018-05-31 05:47:51',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(468,'testing@testing.com','UJ3_PSyatDdzef5DGG7AQl58uIUnBjuz','$2y$13$Bxb4N.rBoQMvuwpRcviKdOp49fx3fEhVowk7PCo9WUmw5ED9foVg6',NULL,'testing@testing.com',10,'2018-06-09 08:17:34','2018-06-09 08:17:34',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(473,'rajwabarocho@gmail.com','bTga_64PPkwDkd46sC_H4fRTI8nX9QTk','$2y$13$3dDQKdUAXVhJeQNMLyvsr.PwAbCVD/xm53CEYPdYpZjRKVTdxMhj.',NULL,'rajwabarocho@gmail.com',10,'2018-06-09 08:43:58','2018-06-09 08:43:58',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(476,'rajwabarocho@yahoo.com','7USmJdY2GnxmDCAuTfWo46PkAUll7fCm','$2y$13$QTqKdltZAq21aflP.JK91.3XMP6Dm2ro8lZtgPN/fo8VDLjDe93m6',NULL,'rajwabarocho@yahoo.com',10,'2018-06-09 08:48:51','2018-06-09 08:48:51',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(478,'rajwabarchaeckocho@gmail.com','YvDikLtoXgsKHvjuSlBLxey0DhG4EWuY','$2y$13$X5O.RLxCz.WPWYXBislvJOeGgdiTADQ5QhprTA3Vl7gxbU9toZklu',NULL,'rajwabarchaeckocho@gmail.com',10,'2018-06-09 08:57:48','2018-06-09 08:57:48',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(479,'masa@eee.com','l6kFGUc9QNWv0mqe2DpaD3Riz-d32y4X','$2y$13$PgP02fu8/98o5Fj30HqKm.R8xMKKbq6I2TJGxqT0Mj/mm93cUEUJy',NULL,'masa@eee.com',10,'2018-06-09 08:58:54','2018-06-09 08:58:54',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(482,'info@imulsetechuae.com','hKSkmeRmn6eAv0KWbEQt3qKxScZ8WREE','$2y$13$n2k8tzWqqUJzUv5xKbHpKeE6NEW.e3lU4szIadbcsdE2rBQPiBvyK',NULL,'info@imulsetechuae.com',10,'2018-06-09 09:05:21','2018-06-09 09:05:21',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(483,'mushahidh224@gmail.com','TwSzyxMZ6cTXJtQVZDmbOL64dDz1fgun','$2y$13$bZAP3fV0YMsAHGUH8FQQju8KvmbWYzkqmj4l7hK2KJ4V02VQT7wdm',NULL,'mushahidh224@gmail.com',10,'2018-06-09 09:12:28','2018-06-09 09:12:28',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(484,'Ghulam_kakar@yahoo.com','YU3MX-nzS5ZR4MUyjfPkeeJ-L6E1diew','$2y$13$R1BtEufQCIHtVr2Ys4mm3.zWc6mbkAd9rTnMWY5ejQ58fXW8348TW',NULL,'Ghulam_kakar@yahoo.com',10,'2018-06-10 07:35:14','2018-06-10 07:35:14',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hat_number` varchar(45) DEFAULT NULL,
  `year` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `model` varchar(45) DEFAULT NULL,
  `make` varchar(45) DEFAULT NULL,
  `vin` varchar(45) DEFAULT NULL,
  `weight` varchar(45) DEFAULT NULL,
  `pieces` varchar(45) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  `license_number` varchar(45) DEFAULT NULL,
  `towed_from` varchar(45) DEFAULT NULL,
  `lot_number` varchar(45) DEFAULT NULL,
  `towed_amount` double DEFAULT NULL,
  `storage_amount` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `check_number` int(11) DEFAULT NULL,
  `additional_charges` double DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `customer_user_id` int(11) NOT NULL,
  `towing_request_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `is_export` int(1) DEFAULT NULL,
  `title_amount` varchar(45) DEFAULT NULL,
  `container_number` varchar(45) DEFAULT NULL,
  `keys` bit(1) DEFAULT NULL,
  `vehicle_is_deleted` bit(1) DEFAULT b'0',
  `notes_status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_vehicle_customer1_idx` (`customer_user_id`),
  KEY `fk_vehicle_towing_request1_idx` (`towing_request_id`),
  CONSTRAINT `fk_vehicle_customer1` FOREIGN KEY (`customer_user_id`) REFERENCES `customer` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_vehicle_towing_request1` FOREIGN KEY (`towing_request_id`) REFERENCES `towing_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
INSERT INTO `vehicle` VALUES (1,'32R','2009','WHITE','COROLLA BASE','TOYOTA','JTDBL40E499031165','3585','1','1650','57167','NC-RALEIGH','49319757',225,NULL,4,NULL,NULL,'2',461,1,'2018-05-20 05:40:30','2018-06-11 07:45:40',1,1,1,'','29919929299','','\0',0),(2,'L087','2007','RED','SIENNA','TOYOTA','5TDZK23C17S035091','5690','1','1050','57167','SC-GREER','44151277',200,NULL,4,9355,NULL,'2',461,2,'2018-05-20 05:47:45','2018-05-20 05:47:45',1,1,NULL,'','MRKU2279388',NULL,'\0',0),(3,'412','2011','WHITE','COROLLA BASE`','TOYOTA','JTDBU4EEXB9138782','4200','1','2200','57167','NC-CHINA GROVE','47986447',240,NULL,2,9348,NULL,'2',461,3,'2018-05-20 05:53:17','2018-05-31 08:27:07',1,1,NULL,'','MRKU2279388',NULL,'',0),(4,'998`','2015','WHITE','CAMRY','TOYOTA','4T1BF1FK6FU101403','4630','1','5200','57167','ATLANTA,GA','26922728',190,NULL,4,10424,NULL,'2',461,4,'2018-05-20 05:57:24','2018-05-20 06:01:44',1,1,NULL,'','MRKU2279388','','\0',0),(5,'510','1998','WHITE','4RUNNER-HALFCUT','TOYOTA','JT3GN86R7W0058379','2625','1','425.00','159808','BAKERSFIELD-CA','19440387',190,NULL,4,30795,NULL,'1',462,5,'2018-05-27 06:37:42','2018-05-27 06:37:42',1,1,NULL,'','TCNU9991565','','\0',0),(6,'475','1999','WHITE','COROLLA-HALFCUT','TOYOTA','1NXBR32E66Z574110','1792','1','1400.00','159808','SUN VALLEY','20178607',125,NULL,4,30804,NULL,'1',462,6,'2018-05-27 06:40:05','2018-05-27 06:40:05',1,1,NULL,'','TCNU9991565','','\0',0),(7,'9245','2001','GREEN','4RUNNER-HALFCUT','TOYOTA','JT3GN86RX10199245','2625','1','479.00','159808','RANCHO CUCAMONGA-CA','20537037',100,30864,4,NULL,NULL,'1',462,7,'2018-05-27 06:42:17','2018-05-27 06:42:17',1,1,NULL,'','TCNU9991565','','\0',0),(8,'498','2001','SILVER','4RUNNER-HALFCUT','TOYOTA','JT3GN86R310194713','2625','1','800.00','159808','SAN DIEGO-CA','22135937',135,30981,4,NULL,NULL,'1',462,8,'2018-05-27 06:45:05','2018-05-27 10:25:10',1,1,NULL,'','TCNU9991565','','\0',0),(9,'440','2008','SILVER','SILVERSIENNA-HALFCUT','TOYOTA','5TDZK23C98S154993','2845','1','800.00','159808','SACRAMENTO-CA','23550007',245,NULL,4,30979,NULL,'1',462,9,'2018-05-27 06:47:51','2018-05-27 06:47:51',1,1,NULL,'','TCNU9991565','','\0',0),(10,'4917','2002','BLACK','BLACK4RUNNER-HALFCUT','TOYOTA','JT3GN86R520244917','2625','1','775','159808','COLTON CA','18855317',100,NULL,4,31011,NULL,'1',462,10,'2018-05-27 06:50:45','2018-05-27 06:50:45',1,1,NULL,'','TCNU9991565','','\0',0),(11,'428','2007','SILVER','AVALON-HALFCUT','TOYOTA','4T1BK36B37U187259','2282','1','1000.00','159808','FRESNO-CA44855386','44855386',220,NULL,4,31012,NULL,'1',462,11,'2018-05-27 06:53:45','2018-05-27 06:53:45',1,1,NULL,'','TCNU9991565','','\0',0),(12,'311','1994','GREEN','COROLLA-HALFCUT','TOYOTA','JT2AE09V1R0075171','1777','1','225.00','159808','SUN VALLEY','20260537',125,NULL,4,NULL,NULL,'1',462,12,'2018-05-27 06:56:43','2018-05-27 06:56:43',1,1,NULL,'','TCNU9991565','','\0',0),(13,'30','2000','SILVER','4RUNNER-HALFCUT','TOYOTA','JT3GM84R8Y0053183','2625','1','500.00','159808','VAN NUYS-CA','44111246',100,NULL,4,31045,NULL,'1',462,13,'2018-05-27 07:01:03','2018-05-27 07:01:03',1,1,NULL,'','TCNU9991565','','\0',0),(14,'H','2000','SILVER','4RUNNER-HALFCUT','TOYOTA','JT3GN87R6Y0142596','2625','1','850.00','159808','Willmington, CA','21021547',100,NULL,4,NULL,NULL,'1',462,14,'2018-05-27 07:03:28','2018-05-27 07:03:28',1,1,NULL,'31045','TCNU9991565','','\0',0),(15,'597','2000','RED','4RUNNER-HALFCUT','TOYOTA','JT3GN86R3Y0141083','2625','1','925.00','159808','VAN NUYS-CA','23241247',100,NULL,4,31058,NULL,'1',462,15,'2018-05-27 07:06:18','2018-05-27 07:06:18',1,1,NULL,'','TCNU9991565','','\0',0),(16,'6','2001','RED','4RUNNER-HALFCUT','TOYOTA','JT3GN86R210192631','2625','1','800','159808','LANCASTER, CA38711456','38711456',175,NULL,4,31135,NULL,'1',462,16,'2018-05-27 07:09:33','2018-05-27 07:09:33',1,1,NULL,'','TCNU9991565','','\0',0),(17,'530','2000','SILVER','4RUNNER-HALFCUT','TOYOTA','JT3HN86R4Y0286427','2625','1','650','','FRESNO-CA','23722337',220,NULL,4,31224,NULL,'1',462,17,'2018-05-27 07:12:40','2018-06-11 06:51:32',1,1,NULL,'','TCNU9991565','','\0',0),(18,'64','1998','GRAY','4RUNNER-HALFCUT','TOYOTA','JT3GN87R5W0082534','2625','1','800','159808','SAN DIEGO-CA','21176887',135,NULL,4,31225,NULL,'1',462,18,'2018-05-27 07:14:59','2018-05-27 07:14:59',1,1,NULL,'','TCNU9991565','','\0',0),(19,'507','2003','GRAY','4RUNNER-HALFCUT','TOYOTA','JTEZU14R038008126','2625','1','2100','159808','VAN NUYS-CA','20114387',100,NULL,4,30906,NULL,'1',462,19,'2018-05-27 07:19:15','2018-05-27 07:19:15',1,1,NULL,'','TCNU9991565','','\0',0),(20,'555','2018','Red','V8','Nissan','123456789','10','20000','','','','',NULL,NULL,4,NULL,NULL,'1',463,20,'2018-05-30 18:35:43','2018-06-14 06:22:25',1,1,NULL,'','','','\0',0),(21,'E45','2017','SILVER','CAMRY','TOYOTA','4T1BF1FK8HU324867','4200','1','','350306','LONG ISLAND-NY','21587725',225,NULL,4,NULL,NULL,'3',464,21,'2018-05-31 06:01:20','2018-05-31 06:01:20',1,1,NULL,'','TCLU9250333','','\0',0),(22,'E31','2017','SILVER','SENTRA','NISSAN','3N1AB7AP3HY207408','3770','1','3100','350306','NY-NEWBURGH','21870266',200,NULL,4,NULL,NULL,'3',464,22,'2018-05-31 06:21:31','2018-05-31 06:21:31',1,1,NULL,'','TCLU9250333',NULL,'\0',0),(23,'E21','2015','BLUE','MUSTANG','FORD','1FA6P8CF3F5399413','3501','1','','350306','METRO,DC','21687429',250,NULL,4,NULL,NULL,'3',464,23,'2018-05-31 06:25:25','2018-05-31 06:25:25',1,1,NULL,'','TCLU9250333','','\0',0),(24,'E23','2016','BLACK','MALIBU','CHEVROLET','1G1ZE5ST6GF310215','4427','1','','350306','METRO,DC','21879590',250,NULL,4,NULL,NULL,'3',464,24,'2018-05-31 06:29:51','2018-05-31 06:29:51',1,1,NULL,'','TCLU9250333','','\0',0),(25,'B40','2013','BLACK','ESCAPE','FORD','1FMCU9HX6DUC11382','','','','','','',500,20,4,NULL,NULL,'4',464,25,'2018-06-02 07:30:46','2018-06-02 07:30:46',1,1,NULL,'300','TCNU6791877',NULL,'',0),(26,'381','2014','WHITE','CAMRY','TOYOTA','4T1BF1FK9EU851697','1000','1','2000','','Texas','222215',250,40,4,NULL,50,'4',484,26,'2018-06-10 07:36:52','2018-06-11 06:29:45',1,1,NULL,'300','YMLU8412944','','\0',0),(27,'593','2013','BLUE','ES350','LEXUS','JTHBK1GG8D2034899','9498.00','1','','280973','SACRAMENTO-CA28','28159408',250,10,4,37130,100,'1',484,27,'2018-06-11 07:22:01','2018-06-11 07:38:36',1,1,1,'300','TCNU6237377','','\0',0),(28,'5321','2017','SILVER','ELANTRA','HYUNDAI','5NPD74LF9HH205321','3924','1','6163.00','280973','PHOENIX-AZ','25556738',250,120,4,37077,NULL,'1',484,28,'2018-06-11 07:31:16','2018-06-11 08:24:37',1,1,1,'3000','TCNU6237377','','\0',0),(29,'1846','2015','WHITE','GENESIS','HYUNDAI','KMHGN4JE4FU071846','5379','1','6600.00','83447','RIVERSIDE,CA','21749729',130,NULL,4,37111,NULL,'1',484,29,'2018-06-11 07:33:02','2018-06-11 07:39:55',1,1,1,'','TCNU6237377',NULL,'\0',0),(30,'552','2014','WHITE','E350','MERCEDES-BENZ','WDDHF5KB6EB019313','5071','1','12220.00','','RIVERSIDE,CA','',130,NULL,4,37051,NULL,'1',484,30,'2018-06-11 07:35:00','2018-06-11 07:35:00',1,1,1,'','TCNU6237377',NULL,'\0',0);
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_condition`
--

DROP TABLE IF EXISTS `vehicle_condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle_condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(45) DEFAULT NULL,
  `vehicle_id` int(11) NOT NULL,
  `condition_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vechile_condition_vehicle1_idx` (`vehicle_id`),
  KEY `fk_vehicle_condition_condition1_idx` (`condition_id`),
  CONSTRAINT `fk_vechile_condition_vehicle1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vehicle_condition_condition1` FOREIGN KEY (`condition_id`) REFERENCES `condition` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1261 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_condition`
--

LOCK TABLES `vehicle_condition` WRITE;
/*!40000 ALTER TABLE `vehicle_condition` DISABLE KEYS */;
INSERT INTO `vehicle_condition` VALUES (22,'S',2,2),(23,'DG',2,3),(24,'DG',2,4),(25,'DG',2,5),(26,'DG',2,6),(27,'S',2,7),(28,'DG',2,8),(29,'DG',2,9),(30,'S',2,10),(31,'S',2,11),(32,'S',2,12),(33,'S',2,13),(34,'DG',2,14),(35,'DG',2,15),(36,'S`',2,16),(37,'S',2,17),(38,'DG',2,18),(39,'DG',2,20),(40,'DG',2,21),(41,'DG',2,22),(42,'DG',2,23),(106,'DG',4,2),(107,'',4,3),(108,'',4,4),(109,'',4,5),(110,'',4,6),(111,'',4,7),(112,'',4,8),(113,'',4,9),(114,'',4,10),(115,'',4,11),(116,'',4,12),(117,'',4,13),(118,'',4,14),(119,'',4,15),(120,'',4,16),(121,'',4,17),(122,'',4,18),(123,'',4,20),(124,'',4,21),(125,'',4,22),(126,'',4,23),(127,'',5,2),(128,'SC',5,3),(129,'SC',5,4),(130,'',5,5),(131,'',5,6),(132,'',5,7),(133,'',5,8),(134,'',5,9),(135,'',5,10),(136,'',5,11),(137,'',5,12),(138,'',5,13),(139,'',5,14),(140,'',5,15),(141,'',5,16),(142,'',5,17),(143,'',5,18),(144,'',5,20),(145,'',5,21),(146,'',5,22),(147,'',5,23),(148,'',6,2),(149,'SC',6,3),(150,'',6,4),(151,'',6,5),(152,'',6,6),(153,'',6,7),(154,'',6,8),(155,'',6,9),(156,'',6,10),(157,'',6,11),(158,'',6,12),(159,'',6,13),(160,'',6,14),(161,'',6,15),(162,'',6,16),(163,'',6,17),(164,'',6,18),(165,'',6,20),(166,'',6,21),(167,'',6,22),(168,'',6,23),(169,'',7,2),(170,'SC',7,3),(171,'',7,4),(172,'',7,5),(173,'',7,6),(174,'',7,7),(175,'',7,8),(176,'',7,9),(177,'',7,10),(178,'',7,11),(179,'',7,12),(180,'',7,13),(181,'',7,14),(182,'',7,15),(183,'',7,16),(184,'',7,17),(185,'',7,18),(186,'',7,20),(187,'',7,21),(188,'',7,22),(189,'',7,23),(211,'',9,2),(212,'',9,3),(213,'',9,4),(214,'DG',9,5),(215,'',9,6),(216,'',9,7),(217,'',9,8),(218,'',9,9),(219,'',9,10),(220,'',9,11),(221,'',9,12),(222,'',9,13),(223,'',9,14),(224,'',9,15),(225,'',9,16),(226,'',9,17),(227,'',9,18),(228,'',9,20),(229,'',9,21),(230,'',9,22),(231,'',9,23),(232,'',10,2),(233,'DG',10,3),(234,'',10,4),(235,'',10,5),(236,'',10,6),(237,'',10,7),(238,'',10,8),(239,'',10,9),(240,'',10,10),(241,'',10,11),(242,'',10,12),(243,'',10,13),(244,'',10,14),(245,'',10,15),(246,'',10,16),(247,'',10,17),(248,'',10,18),(249,'',10,20),(250,'',10,21),(251,'',10,22),(252,'',10,23),(253,'',11,2),(254,'',11,3),(255,'',11,4),(256,'',11,5),(257,'DG',11,6),(258,'',11,7),(259,'',11,8),(260,'',11,9),(261,'',11,10),(262,'',11,11),(263,'',11,12),(264,'',11,13),(265,'',11,14),(266,'',11,15),(267,'',11,16),(268,'',11,17),(269,'',11,18),(270,'',11,20),(271,'',11,21),(272,'',11,22),(273,'',11,23),(274,'DG',12,2),(275,'',12,3),(276,'',12,4),(277,'',12,5),(278,'',12,6),(279,'',12,7),(280,'',12,8),(281,'',12,9),(282,'',12,10),(283,'',12,11),(284,'',12,12),(285,'',12,13),(286,'',12,14),(287,'',12,15),(288,'',12,16),(289,'',12,17),(290,'',12,18),(291,'',12,20),(292,'',12,21),(293,'',12,22),(294,'',12,23),(295,'',13,2),(296,'DG',13,3),(297,'',13,4),(298,'',13,5),(299,'',13,6),(300,'',13,7),(301,'',13,8),(302,'',13,9),(303,'',13,10),(304,'',13,11),(305,'',13,12),(306,'',13,13),(307,'',13,14),(308,'',13,15),(309,'',13,16),(310,'',13,17),(311,'',13,18),(312,'',13,20),(313,'',13,21),(314,'',13,22),(315,'',13,23),(316,'',14,2),(317,'DG',14,3),(318,'',14,4),(319,'',14,5),(320,'',14,6),(321,'',14,7),(322,'',14,8),(323,'',14,9),(324,'',14,10),(325,'',14,11),(326,'',14,12),(327,'',14,13),(328,'',14,14),(329,'',14,15),(330,'',14,16),(331,'',14,17),(332,'',14,18),(333,'',14,20),(334,'',14,21),(335,'',14,22),(336,'',14,23),(337,'DG',15,2),(338,'',15,3),(339,'',15,4),(340,'',15,5),(341,'',15,6),(342,'',15,7),(343,'',15,8),(344,'',15,9),(345,'',15,10),(346,'',15,11),(347,'',15,12),(348,'',15,13),(349,'',15,14),(350,'',15,15),(351,'',15,16),(352,'',15,17),(353,'',15,18),(354,'',15,20),(355,'',15,21),(356,'',15,22),(357,'',15,23),(358,'',16,2),(359,'DG',16,3),(360,'',16,4),(361,'',16,5),(362,'',16,6),(363,'',16,7),(364,'',16,8),(365,'',16,9),(366,'',16,10),(367,'',16,11),(368,'',16,12),(369,'',16,13),(370,'',16,14),(371,'',16,15),(372,'',16,16),(373,'',16,17),(374,'',16,18),(375,'',16,20),(376,'',16,21),(377,'',16,22),(378,'',16,23),(400,'',18,2),(401,'DG',18,3),(402,'',18,4),(403,'',18,5),(404,'',18,6),(405,'',18,7),(406,'',18,8),(407,'',18,9),(408,'',18,10),(409,'',18,11),(410,'',18,12),(411,'',18,13),(412,'',18,14),(413,'',18,15),(414,'',18,16),(415,'',18,17),(416,'',18,18),(417,'',18,20),(418,'',18,21),(419,'',18,22),(420,'',18,23),(421,'',19,2),(422,'',19,3),(423,'DG',19,4),(424,'',19,5),(425,'',19,6),(426,'',19,7),(427,'',19,8),(428,'',19,9),(429,'',19,10),(430,'',19,11),(431,'',19,12),(432,'',19,13),(433,'',19,14),(434,'',19,15),(435,'',19,16),(436,'',19,17),(437,'',19,18),(438,'',19,20),(439,'',19,21),(440,'',19,22),(441,'',19,23),(505,'',8,2),(506,'',8,3),(507,'DG',8,4),(508,'',8,5),(509,'',8,6),(510,'',8,7),(511,'',8,8),(512,'',8,9),(513,'',8,10),(514,'',8,11),(515,'',8,12),(516,'',8,13),(517,'',8,14),(518,'',8,15),(519,'',8,16),(520,'',8,17),(521,'',8,18),(522,'',8,20),(523,'',8,21),(524,'',8,22),(525,'',8,23),(631,'DG',21,2),(632,'',21,3),(633,'',21,4),(634,'',21,5),(635,'',21,6),(636,'',21,7),(637,'',21,8),(638,'',21,9),(639,'',21,10),(640,'',21,11),(641,'',21,12),(642,'',21,13),(643,'',21,14),(644,'',21,15),(645,'',21,16),(646,'',21,17),(647,'',21,18),(648,'',21,20),(649,'',21,21),(650,'',21,22),(651,'',21,23),(652,'',22,2),(653,'SC',22,3),(654,'',22,4),(655,'',22,5),(656,'',22,6),(657,'',22,7),(658,'',22,8),(659,'',22,9),(660,'',22,10),(661,'',22,11),(662,'',22,12),(663,'',22,13),(664,'',22,14),(665,'',22,15),(666,'',22,16),(667,'',22,17),(668,'',22,18),(669,'',22,20),(670,'',22,21),(671,'',22,22),(672,'',22,23),(673,'',23,2),(674,'',23,3),(675,'',23,4),(676,'',23,5),(677,'',23,6),(678,'',23,7),(679,'',23,8),(680,'',23,9),(681,'',23,10),(682,'',23,11),(683,'',23,12),(684,'',23,13),(685,'',23,14),(686,'',23,15),(687,'',23,16),(688,'',23,17),(689,'',23,18),(690,'',23,20),(691,'',23,21),(692,'',23,22),(693,'',23,23),(694,'',24,2),(695,'',24,3),(696,'',24,4),(697,'DG',24,5),(698,'',24,6),(699,'',24,7),(700,'',24,8),(701,'',24,9),(702,'',24,10),(703,'',24,11),(704,'',24,12),(705,'',24,13),(706,'',24,14),(707,'',24,15),(708,'',24,16),(709,'',24,17),(710,'',24,18),(711,'',24,20),(712,'',24,21),(713,'',24,22),(714,'',24,23),(715,'DG',3,2),(716,'',3,3),(717,'',3,4),(718,'',3,5),(719,'',3,6),(720,'',3,7),(721,'',3,8),(722,'',3,9),(723,'',3,10),(724,'',3,11),(725,'',3,12),(726,'',3,13),(727,'',3,14),(728,'',3,15),(729,'',3,16),(730,'',3,17),(731,'',3,18),(732,'',3,20),(733,'',3,21),(734,'',3,22),(735,'',3,23),(736,'',25,2),(737,'',25,3),(738,'',25,4),(739,'',25,5),(740,'',25,6),(741,'',25,7),(742,'',25,8),(743,'',25,9),(744,'',25,10),(745,'',25,11),(746,'',25,12),(747,'',25,13),(748,'',25,14),(749,'',25,15),(750,'',25,16),(751,'',25,17),(752,'',25,18),(753,'',25,20),(754,'',25,21),(755,'',25,22),(756,'',25,23),(925,'',26,2),(926,'',26,3),(927,'',26,4),(928,'',26,5),(929,'',26,6),(930,'',26,7),(931,'',26,8),(932,'',26,9),(933,'',26,10),(934,'',26,11),(935,'',26,12),(936,'',26,13),(937,'',26,14),(938,'',26,15),(939,'',26,16),(940,'',26,17),(941,'',26,18),(942,'',26,20),(943,'',26,21),(944,'',26,22),(945,'',26,23),(946,'',17,2),(947,'DG',17,3),(948,'',17,4),(949,'',17,5),(950,'',17,6),(951,'',17,7),(952,'',17,8),(953,'',17,9),(954,'',17,10),(955,'',17,11),(956,'',17,12),(957,'',17,13),(958,'',17,14),(959,'',17,15),(960,'',17,16),(961,'',17,17),(962,'',17,18),(963,'',17,20),(964,'',17,21),(965,'',17,22),(966,'',17,23),(1114,'',30,2),(1115,'',30,3),(1116,'',30,4),(1117,'',30,5),(1118,'',30,6),(1119,'',30,7),(1120,'',30,8),(1121,'',30,9),(1122,'',30,10),(1123,'',30,11),(1124,'',30,12),(1125,'',30,13),(1126,'',30,14),(1127,'',30,15),(1128,'',30,16),(1129,'',30,17),(1130,'',30,18),(1131,'',30,20),(1132,'',30,21),(1133,'',30,22),(1134,'',30,23),(1177,'',27,2),(1178,'SC',27,3),(1179,'SC',27,4),(1180,'SC',27,5),(1181,'',27,6),(1182,'',27,7),(1183,'SC',27,8),(1184,'SC',27,9),(1185,'SC',27,10),(1186,'',27,11),(1187,'DG',27,12),(1188,'DG',27,13),(1189,'DG',27,14),(1190,'',27,15),(1191,'',27,16),(1192,'',27,17),(1193,'SC',27,18),(1194,'SC',27,20),(1195,'SC',27,21),(1196,'SC',27,22),(1197,'',27,23),(1198,'',29,2),(1199,'',29,3),(1200,'',29,4),(1201,'',29,5),(1202,'',29,6),(1203,'',29,7),(1204,'',29,8),(1205,'',29,9),(1206,'',29,10),(1207,'',29,11),(1208,'',29,12),(1209,'',29,13),(1210,'',29,14),(1211,'',29,15),(1212,'',29,16),(1213,'',29,17),(1214,'',29,18),(1215,'',29,20),(1216,'',29,21),(1217,'',29,22),(1218,'',29,23),(1219,'DG',1,2),(1220,'DG',1,3),(1221,'DG',1,4),(1222,'DG',1,5),(1223,'DG',1,6),(1224,'S',1,7),(1225,'S',1,8),(1226,'S',1,9),(1227,'S',1,10),(1228,'S',1,11),(1229,'DG',1,12),(1230,'DG',1,13),(1231,'S',1,14),(1232,'S',1,15),(1233,'S',1,16),(1234,'S',1,17),(1235,'DG',1,18),(1236,'S',1,20),(1237,'',1,21),(1238,'',1,22),(1239,'',1,23),(1240,'',28,2),(1241,'',28,3),(1242,'',28,4),(1243,'',28,5),(1244,'',28,6),(1245,'',28,7),(1246,'',28,8),(1247,'',28,9),(1248,'',28,10),(1249,'',28,11),(1250,'',28,12),(1251,'',28,13),(1252,'',28,14),(1253,'',28,15),(1254,'',28,16),(1255,'',28,17),(1256,'',28,18),(1257,'',28,20),(1258,'',28,21),(1259,'',28,22),(1260,'',28,23);
/*!40000 ALTER TABLE `vehicle_condition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_export`
--

DROP TABLE IF EXISTS `vehicle_export`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle_export` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `export_id` int(11) NOT NULL,
  `customer_user_id` int(11) NOT NULL,
  `custom_duty` double DEFAULT NULL,
  `clearance` double DEFAULT NULL,
  `towing` double DEFAULT NULL,
  `shipping` double DEFAULT NULL,
  `storage` double DEFAULT NULL,
  `local` double DEFAULT NULL,
  `others` double DEFAULT NULL,
  `additional` double DEFAULT NULL,
  `vat` double DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `title` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `vehicle_export_is_deleted` bit(1) DEFAULT b'0',
  `notes_status` int(1) DEFAULT '0',
  `exchange_rate` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vehicle_export_vehicle1_idx` (`vehicle_id`),
  KEY `fk_vehicle_export_export1_idx` (`export_id`),
  KEY `fk_vehicle_export_customer1_idx` (`customer_user_id`),
  CONSTRAINT `fk_vehicle_export_customer1` FOREIGN KEY (`customer_user_id`) REFERENCES `customer` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vehicle_export_export1` FOREIGN KEY (`export_id`) REFERENCES `export` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vehicle_export_vehicle1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_export`
--

LOCK TABLES `vehicle_export` WRITE;
/*!40000 ALTER TABLE `vehicle_export` DISABLE KEYS */;
INSERT INTO `vehicle_export` VALUES (67,1,7,461,NULL,NULL,0,NULL,0,12,12,12,0,'36',0,NULL,'\0',0,0),(68,28,8,484,NULL,NULL,250,NULL,120,0,0,100,0,'12467.9',3000,NULL,'\0',0,3.67),(69,29,8,484,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'\0',0,NULL),(70,30,8,484,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'\0',0,NULL),(71,27,8,484,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'\0',0,NULL);
/*!40000 ALTER TABLE `vehicle_export` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_features`
--

DROP TABLE IF EXISTS `vehicle_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vehicle_features_features1_idx` (`features_id`),
  KEY `fk_vehicle_features_vehicle1_idx` (`vehicle_id`),
  CONSTRAINT `fk_vehicle_features_features1` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vehicle_features_vehicle1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_features`
--

LOCK TABLES `vehicle_features` WRITE;
/*!40000 ALTER TABLE `vehicle_features` DISABLE KEYS */;
INSERT INTO `vehicle_features` VALUES (6,2,8,1),(7,2,10,1),(8,2,11,1),(22,4,1,1),(23,4,11,1),(24,4,12,1),(25,5,1,1),(26,5,7,1),(27,5,12,1),(28,6,1,1),(29,7,1,1),(30,7,6,1),(31,7,11,1),(33,9,1,1),(34,9,7,1),(35,10,1,1),(36,11,1,1),(37,11,8,1),(38,12,1,1),(39,12,7,1),(40,13,1,1),(41,13,11,1),(42,14,1,1),(43,15,1,1),(44,15,7,1),(45,15,11,1),(46,16,1,1),(49,18,1,1),(50,19,1,1),(54,8,1,1),(100,21,1,1),(101,22,1,1),(102,22,6,1),(103,23,1,1),(104,24,1,1),(105,24,6,1),(106,3,1,1),(107,3,7,1),(108,3,8,1),(109,3,10,1),(110,3,11,1),(111,25,1,1),(148,26,1,1),(149,17,1,1),(150,17,6,1),(178,30,1,1),(179,30,6,1),(190,27,1,1),(191,27,6,1),(192,27,7,1),(193,27,8,1),(194,27,11,1),(195,29,1,1),(196,1,1,1),(197,1,7,1),(198,1,8,1),(199,1,10,1),(200,1,11,1),(201,28,1,1);
/*!40000 ALTER TABLE `vehicle_features` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-21 14:35:47
