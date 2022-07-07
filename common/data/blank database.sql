-- MySQL dump 10.13  Distrib 5.7.9, for Win32 (AMD64)
--
-- Host: AFG Globaldb.chgflc1foln5.us-west-2.rds.amazonaws.com    Database: AFG Global_usa_new
-- ------------------------------------------------------
-- Server version 5.6.37-log

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
INSERT INTO `auth_assignment` VALUES ('admin_GA','438',1516023225),('admin_LA','437',1516023260),('admin_NY','439',1516023090),('admin_TX','440',1516023050),('customer','460',1528461781),('customer','461',1528461788),('customer','462',1528461795),('customer','463',1528461801),('customer','464',1528461806),('customer','468',1528532254),('customer','473',1528533838),('customer','476',1528534131),('customer','478',1528534668),('customer','479',1528534734),('customer','482',1528535121),('customer','483',1528535548),('customer','484',1528616114),('customer','486',1529734092),('customer','487',1530703726),('customer','491',1530774016),('customer','492',1530774323),('customer','493',1530777132),('customer','497',1531032339),('customer','498',1531033803),('super_admin','1',1510833715);
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
INSERT INTO `auth_item_child` VALUES ('super_admin','/*'),('super_admin','/admin/*'),('super_admin','/admin/assignment/*'),('super_admin','/admin/assignment/assign'),('super_admin','/admin/assignment/index'),('super_admin','/admin/assignment/revoke'),('super_admin','/admin/assignment/view'),('super_admin','/admin/default/*'),('super_admin','/admin/default/index'),('super_admin','/admin/menu/*'),('super_admin','/admin/menu/create'),('super_admin','/admin/menu/delete'),('super_admin','/admin/menu/index'),('super_admin','/admin/menu/update'),('super_admin','/admin/menu/view'),('super_admin','/admin/permission/*'),('super_admin','/admin/permission/assign'),('super_admin','/admin/permission/create'),('super_admin','/admin/permission/delete'),('super_admin','/admin/permission/index'),('super_admin','/admin/permission/remove'),('super_admin','/admin/permission/update'),('super_admin','/admin/permission/view'),('super_admin','/admin/role/*'),('super_admin','/admin/role/assign'),('super_admin','/admin/role/create'),('super_admin','/admin/role/delete'),('super_admin','/admin/role/index'),('super_admin','/admin/role/remove'),('super_admin','/admin/role/update'),('super_admin','/admin/role/view'),('super_admin','/admin/route/*'),('super_admin','/admin/route/assign'),('super_admin','/admin/route/create'),('super_admin','/admin/route/index'),('super_admin','/admin/route/refresh'),('super_admin','/admin/route/remove'),('super_admin','/admin/rule/*'),('super_admin','/admin/rule/create'),('super_admin','/admin/rule/delete'),('super_admin','/admin/rule/index'),('super_admin','/admin/rule/update'),('super_admin','/admin/rule/view'),('super_admin','/admin/user/*'),('super_admin','/admin/user/activate'),('super_admin','/admin/user/change-password'),('super_admin','/admin/user/delete'),('super_admin','/admin/user/index'),('super_admin','/admin/user/login'),('super_admin','/admin/user/logout'),('super_admin','/admin/user/request-password-reset'),('super_admin','/admin/user/reset-password'),('super_admin','/admin/user/signup'),('super_admin','/admin/user/view'),('admin_NY','/condition/*'),('admin_TX','/condition/*'),('super_admin','/condition/*'),('super_admin','/condition/create'),('super_admin','/condition/delete'),('super_admin','/condition/index'),('super_admin','/condition/update'),('super_admin','/condition/view'),('admin_GA','/consignee/*'),('admin_NY','/consignee/*'),('admin_TX','/consignee/*'),('super_admin','/consignee/*'),('super_admin','/consignee/create'),('admin_GA','/consignee/customer-consignee'),('admin_LA','/consignee/customer-consignee'),('super_admin','/consignee/customer-consignee'),('super_admin','/consignee/delete'),('admin_GA','/consignee/getuserconsignee'),('admin_LA','/consignee/getuserconsignee'),('super_admin','/consignee/getuserconsignee'),('super_admin','/consignee/index'),('super_admin','/consignee/update'),('super_admin','/consignee/view'),('admin_GA','/customer/*'),('admin_LA','/customer/*'),('admin_TX','/customer/*'),('super_admin','/customer/*'),('admin_GA','/customer/allcustomer'),('admin_LA','/customer/allcustomer'),('admin_NY','/customer/allcustomer'),('super_admin','/customer/allcustomer'),('admin_NY','/customer/create'),('super_admin','/customer/create'),('super_admin','/customer/delete'),('admin_GA','/customer/getcontainercustomer'),('admin_LA','/customer/getcontainercustomer'),('admin_NY','/customer/getcontainercustomer'),('super_admin','/customer/getcontainercustomer'),('admin_GA','/customer/getcustomer'),('admin_LA','/customer/getcustomer'),('admin_NY','/customer/getcustomer'),('super_admin','/customer/getcustomer'),('admin_NY','/customer/index'),('super_admin','/customer/index'),('customer','/customer/insert'),('super_admin','/customer/insert'),('admin_GA','/customer/selectedcustomer'),('admin_LA','/customer/selectedcustomer'),('admin_NY','/customer/selectedcustomer'),('super_admin','/customer/selectedcustomer'),('super_admin','/customer/update'),('admin_NY','/customer/view'),('super_admin','/customer/view'),('admin_LA','/debug/*'),('super_admin','/debug/*'),('admin_LA','/debug/default/*'),('super_admin','/debug/default/*'),('admin_LA','/debug/default/db-explain'),('super_admin','/debug/default/db-explain'),('admin_LA','/debug/default/download-mail'),('super_admin','/debug/default/download-mail'),('admin_LA','/debug/default/index'),('super_admin','/debug/default/index'),('admin_LA','/debug/default/toolbar'),('super_admin','/debug/default/toolbar'),('admin_LA','/debug/default/view'),('super_admin','/debug/default/view'),('admin_LA','/debug/user/*'),('super_admin','/debug/user/*'),('admin_LA','/debug/user/reset-identity'),('super_admin','/debug/user/reset-identity'),('admin_LA','/debug/user/set-identity'),('super_admin','/debug/user/set-identity'),('admin_GA','/dock-receipt/*'),('admin_NY','/dock-receipt/*'),('admin_TX','/dock-receipt/*'),('super_admin','/dock-receipt/*'),('super_admin','/dock-receipt/create'),('super_admin','/dock-receipt/delete'),('super_admin','/dock-receipt/index'),('super_admin','/dock-receipt/update'),('super_admin','/dock-receipt/view'),('admin_GA','/export-images/*'),('admin_NY','/export-images/*'),('admin_TX','/export-images/*'),('super_admin','/export-images/*'),('admin_NY','/export-images/create'),('super_admin','/export-images/create'),('admin_NY','/export-images/delete'),('super_admin','/export-images/delete'),('admin_NY','/export-images/index'),('super_admin','/export-images/index'),('admin_NY','/export-images/update'),('super_admin','/export-images/update'),('admin_NY','/export-images/view'),('super_admin','/export-images/view'),('admin_GA','/export/*'),('admin_NY','/export/*'),('admin_TX','/export/*'),('super_admin','/export/*'),('admin_LA','/export/allexport'),('super_admin','/export/allexport'),('admin_LA','/export/close-conversatition'),('customer','/export/close-conversatition'),('super_admin','/export/close-conversatition'),('admin_LA','/export/create'),('super_admin','/export/create'),('admin_LA','/export/customcoverlettermodal'),('customer','/export/customcoverlettermodal'),('super_admin','/export/customcoverlettermodal'),('super_admin','/export/delete'),('admin_LA','/export/dockmodal'),('customer','/export/dockmodal'),('super_admin','/export/dockmodal'),('admin_LA','/export/dockpdf'),('customer','/export/dockpdf'),('super_admin','/export/dockpdf'),('admin_LA','/export/hustomcoverlettermodal'),('customer','/export/hustomcoverlettermodal'),('super_admin','/export/hustomcoverlettermodal'),('admin_LA','/export/index'),('super_admin','/export/index'),('admin_LA','/export/ladingmodal'),('customer','/export/ladingmodal'),('super_admin','/export/ladingmodal'),('admin_LA','/export/landingpdf'),('customer','/export/landingpdf'),('super_admin','/export/landingpdf'),('admin_LA','/export/manifestmodal'),('customer','/export/manifestmodal'),('super_admin','/export/manifestmodal'),('admin_LA','/export/manifestpdf'),('customer','/export/manifestpdf'),('super_admin','/export/manifestpdf'),('admin_LA','/export/nonhazmodal'),('customer','/export/nonhazmodal'),('super_admin','/export/nonhazmodal'),('admin_LA','/export/notes'),('customer','/export/notes'),('super_admin','/export/notes'),('admin_LA','/export/notesmodal'),('customer','/export/notesmodal'),('super_admin','/export/notesmodal'),('admin_LA','/export/update'),('super_admin','/export/update'),('admin_LA','/export/upload-notes'),('admin_LA','/export/uploadinvoice'),('admin_TX','/export/uploadinvoice'),('customer','/export/uploadinvoice'),('super_admin','/export/uploadinvoice'),('admin_LA','/export/view'),('super_admin','/export/view'),('admin_GA','/features/*'),('admin_NY','/features/*'),('admin_TX','/features/*'),('super_admin','/features/*'),('super_admin','/features/create'),('super_admin','/features/delete'),('super_admin','/features/index'),('super_admin','/features/update'),('super_admin','/features/view'),('super_admin','/gii/*'),('super_admin','/gii/default/*'),('super_admin','/gii/default/action'),('super_admin','/gii/default/diff'),('super_admin','/gii/default/index'),('super_admin','/gii/default/preview'),('super_admin','/gii/default/view'),('super_admin','/gridview/*'),('super_admin','/gridview/export/*'),('super_admin','/gridview/export/download'),('admin_GA','/houstan-custom-cover-letter/*'),('super_admin','/houstan-custom-cover-letter/*'),('super_admin','/houstan-custom-cover-letter/create'),('super_admin','/houstan-custom-cover-letter/delete'),('super_admin','/houstan-custom-cover-letter/index'),('super_admin','/houstan-custom-cover-letter/update'),('super_admin','/houstan-custom-cover-letter/view'),('admin_NY','/images/*'),('admin_TX','/images/*'),('super_admin','/images/*'),('super_admin','/images/create'),('super_admin','/images/delete'),('super_admin','/images/index'),('super_admin','/images/update'),('super_admin','/images/view'),('admin_LA','/invoice/*'),('admin_TX','/invoice/*'),('super_admin','/invoice/*'),('admin_TX','/invoice/create'),('super_admin','/invoice/create'),('admin_LA','/invoice/customerinvoice'),('admin_TX','/invoice/customerinvoice'),('customer','/invoice/customerinvoice'),('super_admin','/invoice/customerinvoice'),('admin_TX','/invoice/delete'),('super_admin','/invoice/delete'),('admin_TX','/invoice/index'),('customer','/invoice/index'),('super_admin','/invoice/index'),('admin_TX','/invoice/paid'),('customer','/invoice/paid'),('super_admin','/invoice/paid'),('admin_TX','/invoice/partial-paid'),('customer','/invoice/partial-paid'),('super_admin','/invoice/partial-paid'),('admin_TX','/invoice/unpaid'),('customer','/invoice/unpaid'),('super_admin','/invoice/unpaid'),('admin_TX','/invoice/update'),('super_admin','/invoice/update'),('admin_TX','/invoice/view'),('customer','/invoice/view'),('super_admin','/invoice/view'),('admin_GA','/notification/*'),('admin_LA','/notification/*'),('admin_NY','/notification/*'),('admin_TX','/notification/*'),('super_admin','/notification/*'),('super_admin','/notification/create'),('super_admin','/notification/delete'),('admin_GA','/notification/index'),('admin_LA','/notification/index'),('admin_NY','/notification/index'),('admin_TX','/notification/index'),('customer','/notification/index'),('super_admin','/notification/index'),('super_admin','/notification/update'),('admin_GA','/notification/view'),('admin_LA','/notification/view'),('admin_NY','/notification/view'),('admin_TX','/notification/view'),('customer','/notification/view'),('super_admin','/notification/view'),('admin_GA','/pricing/*'),('admin_LA','/pricing/*'),('admin_NY','/pricing/*'),('admin_TX','/pricing/*'),('super_admin','/pricing/*'),('super_admin','/pricing/create'),('super_admin','/pricing/delete'),('customer','/pricing/index'),('super_admin','/pricing/index'),('super_admin','/pricing/update'),('customer','/pricing/view'),('super_admin','/pricing/view'),('admin_GA','/site/*'),('admin_NY','/site/*'),('admin_TX','/site/*'),('customer','/site/*'),('super_admin','/site/*'),('admin_LA','/site/ajax'),('super_admin','/site/ajax'),('admin_GA','/site/ajaxcustomer'),('admin_LA','/site/ajaxcustomer'),('super_admin','/site/ajaxcustomer'),('admin_GA','/site/customer'),('admin_LA','/site/customer'),('super_admin','/site/customer'),('admin_GA','/site/customeradmin'),('admin_LA','/site/customeradmin'),('super_admin','/site/customeradmin'),('super_admin','/site/delete-image'),('admin_LA','/site/error'),('super_admin','/site/error'),('admin_GA','/site/inboxdetail'),('admin_LA','/site/inboxdetail'),('super_admin','/site/inboxdetail'),('admin_LA','/site/index'),('super_admin','/site/index'),('admin_LA','/site/login'),('super_admin','/site/login'),('admin_LA','/site/logout'),('super_admin','/site/logout'),('admin_LA','/site/mailbox'),('super_admin','/site/mailbox'),('admin_GA','/site/statusexel'),('admin_GA','/site/statuspdf'),('admin_LA','/site/statuspdf'),('super_admin','/site/statuspdf'),('admin_GA','/site/statuspdfcustomer'),('admin_LA','/site/statuspdfcustomer'),('super_admin','/site/statuspdfcustomer'),('super_admin','/towing-request/*'),('super_admin','/towing-request/create'),('super_admin','/towing-request/delete'),('super_admin','/towing-request/index'),('super_admin','/towing-request/update'),('super_admin','/towing-request/view'),('admin_TX','/user/*'),('super_admin','/user/*'),('admin_GA','/user/create'),('super_admin','/user/create'),('super_admin','/user/delete'),('admin_GA','/user/index'),('admin_NY','/user/index'),('super_admin','/user/index'),('admin_NY','/user/search'),('super_admin','/user/search'),('admin_GA','/user/update'),('super_admin','/user/update'),('admin_GA','/user/view'),('admin_NY','/user/view'),('super_admin','/user/view'),('admin_GA','/vehicle-condition/*'),('super_admin','/vehicle-condition/*'),('super_admin','/vehicle-condition/create'),('super_admin','/vehicle-condition/delete'),('super_admin','/vehicle-condition/index'),('super_admin','/vehicle-condition/update'),('super_admin','/vehicle-condition/view'),('admin_GA','/vehicle-export/*'),('admin_NY','/vehicle-export/*'),('admin_TX','/vehicle-export/*'),('customer','/vehicle-export/*'),('super_admin','/vehicle-export/*'),('admin_GA','/vehicle-export/container-images'),('admin_LA','/vehicle-export/container-images'),('admin_TX','/vehicle-export/container-images'),('customer','/vehicle-export/container-images'),('super_admin','/vehicle-export/container-images'),('admin_TX','/vehicle-export/create'),('super_admin','/vehicle-export/create'),('super_admin','/vehicle-export/delete'),('admin_LA','/vehicle-export/index'),('admin_TX','/vehicle-export/index'),('customer','/vehicle-export/index'),('super_admin','/vehicle-export/index'),('admin_TX','/vehicle-export/update'),('super_admin','/vehicle-export/update'),('admin_GA','/vehicle-export/vehicle-images'),('admin_LA','/vehicle-export/vehicle-images'),('admin_TX','/vehicle-export/vehicle-images'),('customer','/vehicle-export/vehicle-images'),('super_admin','/vehicle-export/vehicle-images'),('admin_LA','/vehicle-export/view'),('admin_TX','/vehicle-export/view'),('customer','/vehicle-export/view'),('super_admin','/vehicle-export/view'),('admin_GA','/vehicle-features/*'),('super_admin','/vehicle-features/*'),('super_admin','/vehicle-features/create'),('super_admin','/vehicle-features/delete'),('super_admin','/vehicle-features/index'),('super_admin','/vehicle-features/update'),('super_admin','/vehicle-features/view'),('admin_GA','/vehicle/*'),('admin_NY','/vehicle/*'),('admin_TX','/vehicle/*'),('super_admin','/vehicle/*'),('admin_LA','/vehicle/allvehicle'),('super_admin','/vehicle/allvehicle'),('admin_LA','/vehicle/close-conversatition'),('customer','/vehicle/close-conversatition'),('super_admin','/vehicle/close-conversatition'),('admin_LA','/vehicle/conditionreport'),('customer','/vehicle/conditionreport'),('super_admin','/vehicle/conditionreport'),('admin_LA','/vehicle/create'),('super_admin','/vehicle/create'),('super_admin','/vehicle/delete'),('admin_LA','/vehicle/download-images'),('customer','/vehicle/download-images'),('super_admin','/vehicle/download-images'),('admin_LA','/vehicle/frontsearch'),('super_admin','/vehicle/frontsearch'),('admin_LA','/vehicle/getexport_vehicle'),('customer','/vehicle/getexport_vehicle'),('super_admin','/vehicle/getexport_vehicle'),('admin_LA','/vehicle/image-delete'),('admin_LA','/vehicle/index'),('customer','/vehicle/index'),('super_admin','/vehicle/index'),('admin_LA','/vehicle/mpdf'),('customer','/vehicle/mpdf'),('super_admin','/vehicle/mpdf'),('admin_LA','/vehicle/notes'),('customer','/vehicle/notes'),('super_admin','/vehicle/notes'),('admin_LA','/vehicle/notesmodal'),('customer','/vehicle/notesmodal'),('super_admin','/vehicle/notesmodal'),('admin_LA','/vehicle/search-vin'),('super_admin','/vehicle/search-vin'),('admin_LA','/vehicle/update'),('super_admin','/vehicle/update'),('admin_LA','/vehicle/upload-notes'),('admin_LA','/vehicle/vehicledetail'),('customer','/vehicle/vehicledetail'),('super_admin','/vehicle/vehicledetail'),('admin_LA','/vehicle/view'),('customer','/vehicle/view'),('super_admin','/vehicle/view');
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
  `added_by_role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_consignee_customer1_idx` (`customer_user_id`),
  CONSTRAINT `fk_consignee_customer1` FOREIGN KEY (`customer_user_id`) REFERENCES `customer` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consignee`
--

LOCK TABLES `consignee` WRITE;
/*!40000 ALTER TABLE `consignee` DISABLE KEYS */;
INSERT INTO `consignee` VALUES (12,462,'AFG Global UAE','12TH FLOOR CENTURION STAR','TOWER PORT SAEED, ','DUBAI','UAE','','','+971-4224-9714–715',NULL,'2018-05-29 05:00:34',NULL,1,'\0',NULL),(13,NULL,'AMAYA USED CARS TR','INDUSTRIAL AREA NO. 2','','SHARJAH','','','81566','+971-508844894',NULL,'2018-06-23 06:08:52',NULL,1,'\0',NULL),(28,493,'SHABIR AHMAD NOOR AHMAD  ','131 E. GARDENA BLVD.','','CARSON,','CA 90247 ','','','310-593-9604 ','2018-07-05 07:52:12','2018-07-05 07:52:12',1,1,'\0','super_admin');
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
  `added_by_role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_table1_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (437,'LA OFFICE ADMIN','LA','','131 East Gardena,  BoulevardCarson, CA 90247','','CARSON','CA 90247','','07114','','2018-01-15 13:22:14','2018-06-21 08:08:38',1,1,'\0','LAADMIN0001','','','',NULL),(438,'GA@AFG Globalworldwide.com','GA','+1-912-826-0265','AFG Global Georgia 146 Commerce Court Rincon, 31326 ','','Georgia','','USA','31326','','2018-01-15 13:24:13','2018-06-21 08:05:05',1,1,'\0','GAOFFICE20018','','','',NULL),(439,'NJ@AFG Globalworldwide.com','NJ','+1-862-237-7066','AFG Global World Wide New Jersey 810 Frelinghuysen Ave Newark 07114','','New Jersey ','','USA','','','2018-01-15 13:26:33','2018-06-21 08:25:16',1,1,'\0','NJOFFICE20018','','','',NULL),(440,'TX@AFG Globalworldwide.com','TX','+1-713-631-1560',' AFG Global Texas 7801 Parkhurst Dr.Houston, 77028 ','','Texas','','USA','','','2018-01-15 13:28:55','2018-07-04 13:35:48',1,1,'\0','TXOFFICE20018','','','',NULL),(497,'SHAH JAHAN','AMAYA USED CAR GENERAL TRADING LLC','+1310-593-9604','131 E GARDENA BLVD ','IND# SHARJAH UAE','CARSON  ','CA ','','','','2018-07-08 06:45:39','2018-07-08 06:55:36',1,1,'\0','900635','','','+971-555688330','super_admin');
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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_documents`
--

LOCK TABLES `customer_documents` WRITE;
/*!40000 ALTER TABLE `customer_documents` DISABLE KEYS */;

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
  `added_by_role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `export`
--

LOCK TABLES `export` WRITE;
/*!40000 ALTER TABLE `export` DISABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `export_images`
--

LOCK TABLES `export_images` WRITE;
/*!40000 ALTER TABLE `export_images` DISABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;

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
  `added_by_role` varchar(64) DEFAULT NULL,
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
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_payment`
--

DROP TABLE IF EXISTS `invoice_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `export_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `paid_amount` double NOT NULL,
  `remaining_amount` double NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` varchar(256) DEFAULT NULL,
  `added_by_role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_payment`
--

LOCK TABLES `invoice_payment` WRITE;
/*!40000 ALTER TABLE `invoice_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_payment` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note`
--

LOCK TABLES `note` WRITE;
/*!40000 ALTER TABLE `note` DISABLE KEYS */;

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
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `expire_date` date DEFAULT NULL,
  `added_by_role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_notification_user1_idx` (`user_id`),
  CONSTRAINT `fk_notification_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;

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
  `added_by_role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pricing`
--

LOCK TABLES `pricing` WRITE;
/*!40000 ALTER TABLE `pricing` DISABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `towing_request`
--

LOCK TABLES `towing_request` WRITE;
/*!40000 ALTER TABLE `towing_request` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=499 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','St2LDq2QmntotE7KRc_TxcJQYii4-6Yy','$2y$13$MIApGH2IKQJy2RjMqvrL4OeEjAEC6FjbMmZ1/La9anu.AX5Jjj.RG',NULL,'admin@gmail.com',10,NULL,NULL,NULL,0,0,'131 E. Gardena Blvd','','Carson','CA','90247','(310) 593-9604','(310) 532-8557','Mir Sharq'),(437,'LA@AFG Globalworldwide.com','mSK1xHDZWL9MbZ9ZbZnVzItHqvvx2nOA','$2y$13$lF0xPcCQzYRqXP6UtiXZ..FP5cC1ozuHcewSjpOhuQSbV4nEzl4V.',NULL,'LA@AFG Globalworldwide.com',10,'2018-01-15 13:22:13','2018-01-15 13:22:13',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(438,'GA@AFG Globalworldwide.com','FkJIkvWypiThoULv5qUnZO0q-x6rlmm6','$2y$13$aURVH6EPI7RiJU18bVxSq.na1Hf8bc4VU.PKdLNwhtKBGornRlyw6',NULL,'GA@AFG Globalworldwide.com',10,'2018-01-15 13:24:13','2018-01-15 13:24:13',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(439,'NJ@AFG Globalworldwide.com','blaYDmpfoIiSHJpvrGkbUVtiEVL5oVP8','$2y$13$C2chfvEN.jzAIu9yULvY1ObOsWfF.fSEzKwGBT/ckye5wmlmH0c/S',NULL,'NJ@AFG Globalworldwide.com',10,'2018-01-15 13:26:33','2018-01-15 13:26:33',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(440,'TX@AFG Globalworldwide.com','f3TtAyplJN1lOBk3QoSsstofsllE2heB','$2y$13$G9yO8tdA95OemwZzH5dqp.gPsVRFyIhHoP2r7pK62hOx4xa5AHxyy',NULL,'TX@AFG Globalworldwide.com',10,'2018-01-15 13:28:55','2018-01-15 13:28:55',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
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
  `added_by_role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vehicle_customer1_idx` (`customer_user_id`),
  KEY `fk_vehicle_towing_request1_idx` (`towing_request_id`),
  CONSTRAINT `fk_vehicle_customer1` FOREIGN KEY (`customer_user_id`) REFERENCES `customer` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_vehicle_towing_request1` FOREIGN KEY (`towing_request_id`) REFERENCES `towing_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1555 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_condition`
--

LOCK TABLES `vehicle_condition` WRITE;
/*!40000 ALTER TABLE `vehicle_condition` DISABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_export`
--

LOCK TABLES `vehicle_export` WRITE;
/*!40000 ALTER TABLE `vehicle_export` DISABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_features`
--

LOCK TABLES `vehicle_features` WRITE;
/*!40000 ALTER TABLE `vehicle_features` DISABLE KEYS */;

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

-- Dump completed on 2018-07-09 12:34:24
