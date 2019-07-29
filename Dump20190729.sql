-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dev_gcrm
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(40) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branch`
--

LOCK TABLES `branch` WRITE;
/*!40000 ALTER TABLE `branch` DISABLE KEYS */;
INSERT INTO `branch` VALUES (1,'main',0),(3,'eligendi',0),(5,'adipisci',0),(9,'Di &co',1);
/*!40000 ALTER TABLE `branch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `byname` varchar(20) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `telegram` varchar(30) DEFAULT NULL,
  `max_debt` decimal(10,2) DEFAULT '0.00',
  `password` varchar(20) DEFAULT NULL,
  `pay_page` tinyint(1) NOT NULL DEFAULT '1',
  `pay_in_debt` tinyint(1) NOT NULL DEFAULT '1',
  `payment_system` tinyint(1) NOT NULL DEFAULT '1',
  `login` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`client_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (55,26,'Юрчик-наталья','Наталья','','','','Жена и брат Саши из купидиона, каменец-подольского','',0.00,'',0,0,0,''),(56,26,'','Аркадий','438472','','','Карликовый армян','',0.00,'',0,0,0,'438472'),(57,26,'Луганский','Дима','862117','','','С него надо бы в дальнейшем давать откат Леше1','',0.00,'',0,0,0,'862117'),(58,26,'Киев (Игоря)','Богдан','110642','','','старый клиент Игоря','',0.00,'',0,0,0,'110642'),(59,26,'','Саша Полтава','706154','','','','',0.00,'',0,0,0,'706154'),(60,26,'','Дима Мельник','326087','','','старый клиент Игоря','',30000.00,'14Za166Or1va2r',1,1,0,'326087'),(61,26,'','Женя Осинский (Игоря)','303242','','','','',0.00,'6vr3eOv6Z2Z234',0,0,0,'303242'),(62,26,'','Гарик и Анна','467343','','','Армян на анаболиках из Ильичевска','',0.00,'',0,0,0,'467343'),(63,26,'Ден игровой','Ира (клиент Игоря))','900652','','','','',0.00,'',0,0,0,'900652'),(64,26,'','Гена 2 (другой)','974358','','','','',0.00,'',0,0,0,'974358'),(65,26,'','Вова белка','167408','','','','',0.00,'',0,0,0,'167408'),(66,26,'','Сева Днепр','800445','','','','',0.00,'',0,0,0,'800445'),(67,26,'','Юра (раньше с Дено)','576210','','','','',0.00,'',0,0,0,'576210'),(68,26,'','Вадим Ровно','530870','','','','',0.00,'',0,0,0,'530870'),(69,26,'','Саша север','136455','','','','',0.00,'',0,0,0,'136455'),(70,26,'','Дима Анжела (славянск)','475684','','','','',0.00,'',0,0,0,'475684'),(71,26,'','Дима Говорова','234822','','','','',0.00,'',0,0,0,'234822'),(72,26,'','Дима Каминский','518870','','','','',0.00,'',0,0,0,'518870'),(73,26,'','Сергей Ильичевск (булавин)','564753','','','','',0.00,'',0,0,0,'564753'),(74,26,'','Алена Додашвили','483723','','','','',0.00,'',0,0,0,'483723'),(75,26,'','Андрей Миргород','583504','','','','',0.00,'',0,0,0,'583504');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debt_history`
--

DROP TABLE IF EXISTS `debt_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `debt_history` (
  `debt_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `debt_sum` decimal(20,2) NOT NULL,
  `date` datetime NOT NULL,
  `fiat_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`debt_history_id`),
  KEY `client_id` (`client_id`),
  KEY `user_id` (`user_id`),
  KEY `fiat_id` (`fiat_id`),
  CONSTRAINT `debt_history_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  CONSTRAINT `debt_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `debt_history_ibfk_3` FOREIGN KEY (`fiat_id`) REFERENCES `fiats` (`fiat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debt_history`
--

LOCK TABLES `debt_history` WRITE;
/*!40000 ALTER TABLE `debt_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `debt_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fiats`
--

DROP TABLE IF EXISTS `fiats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `fiats` (
  `fiat_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `name` varchar(5) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  PRIMARY KEY (`fiat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiats`
--

LOCK TABLES `fiats` WRITE;
/*!40000 ALTER TABLE `fiats` DISABLE KEYS */;
INSERT INTO `fiats` VALUES (1,983,'Ггр','UAH'),(2,870,'Руб','RUR');
/*!40000 ALTER TABLE `fiats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `income_history`
--

DROP TABLE IF EXISTS `income_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `income_history` (
  `income_id` int(11) NOT NULL AUTO_INCREMENT,
  `sum` decimal(15,2) NOT NULL,
  `fiat` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`income_id`),
  KEY `fiat` (`fiat`),
  KEY `user_id` (`user_id`),
  KEY `owner_id` (`owner_id`) USING BTREE,
  CONSTRAINT `income_history_ibfk_1` FOREIGN KEY (`fiat`) REFERENCES `fiats` (`fiat_id`),
  CONSTRAINT `income_history_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `income_history_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `income_history`
--

LOCK TABLES `income_history` WRITE;
/*!40000 ALTER TABLE `income_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `income_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `methods_of_obtaining`
--

DROP TABLE IF EXISTS `methods_of_obtaining`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `methods_of_obtaining` (
  `method_id` int(11) NOT NULL AUTO_INCREMENT,
  `method_name` varchar(40) NOT NULL,
  `participates_in_balance` smallint(6) NOT NULL DEFAULT '1',
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`method_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `methods_of_obtaining_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `methods_of_obtaining`
--

LOCK TABLES `methods_of_obtaining` WRITE;
/*!40000 ALTER TABLE `methods_of_obtaining` DISABLE KEYS */;
INSERT INTO `methods_of_obtaining` VALUES (1,'234',0,0,5),(2,'123',0,0,3),(3,'Карта Ди',1,1,9),(4,'ЯД',0,1,9),(5,'Карта Саши',0,1,9),(6,'Карта Игоря',0,1,9),(7,'Карта Малой',0,1,9);
/*!40000 ALTER TABLE `methods_of_obtaining` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `vg_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sum_vg` decimal(10,0) NOT NULL,
  `real_out_percent` float(15,2) NOT NULL,
  `sum_currency` decimal(15,2) NOT NULL,
  `method_id` int(11) DEFAULT '1',
  `rollback_sum` decimal(15,2) NOT NULL,
  `rollback_1` float(15,2) NOT NULL,
  `date` datetime NOT NULL,
  `callmaster` int(11) DEFAULT NULL,
  `order_debt` int(11) NOT NULL DEFAULT '0',
  `description` varchar(500) DEFAULT NULL,
  `fiat_id` int(11) NOT NULL DEFAULT '1',
  `loginByVg` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `vg_id` (`vg_id`,`client_id`),
  KEY `client_id` (`client_id`),
  KEY `callmaster` (`callmaster`),
  KEY `fiat_id` (`fiat_id`),
  KEY `method_id` (`method_id`),
  CONSTRAINT `Order_ibfk_1` FOREIGN KEY (`vg_id`) REFERENCES `virtualgood` (`vg_id`),
  CONSTRAINT `Order_ibfk_4` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`callmaster`) REFERENCES `clients` (`client_id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`fiat_id`) REFERENCES `fiats` (`fiat_id`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`method_id`) REFERENCES `methods_of_obtaining` (`method_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outgo`
--

DROP TABLE IF EXISTS `outgo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `outgo` (
  `outgo_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_as_owner_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `fiat_id` int(11) DEFAULT '1',
  `outgo_type_id` varchar(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `sum` decimal(11,2) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`outgo_id`),
  KEY `branch_id` (`branch_id`),
  KEY `fiat_id` (`fiat_id`),
  KEY `project_id` (`project_id`),
  KEY `outgo_type_id` (`outgo_type_id`),
  KEY `user_id` (`user_id`),
  KEY `user_as_owner_id` (`user_as_owner_id`),
  CONSTRAINT `outgo_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `outgo_ibfk_2` FOREIGN KEY (`fiat_id`) REFERENCES `fiats` (`fiat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `outgo_ibfk_3` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `outgo_ibfk_4` FOREIGN KEY (`outgo_type_id`) REFERENCES `outgo_types` (`outgo_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `outgo_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `outgo_ibfk_6` FOREIGN KEY (`user_as_owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outgo`
--

LOCK TABLES `outgo` WRITE;
/*!40000 ALTER TABLE `outgo` DISABLE KEYS */;
/*!40000 ALTER TABLE `outgo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outgo_types`
--

DROP TABLE IF EXISTS `outgo_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `outgo_types` (
  `outgo_type_id` varchar(11) NOT NULL,
  `outgo_name` varchar(40) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`outgo_type_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `outgo_types_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outgo_types`
--

LOCK TABLES `outgo_types` WRITE;
/*!40000 ALTER TABLE `outgo_types` DISABLE KEYS */;
INSERT INTO `outgo_types` VALUES ('1','root_type',1,1),('100','test',1,0),('101','Сотрудники',9,1),('10100','Диана',9,1),('10101','Алена',9,1),('10102','Телефон и связь',9,1),('102','IT',9,1),('10200','Новый юнити проект',9,1),('1020000','Юнити прогеры',9,1),('10201','Гриша',9,1);
/*!40000 ALTER TABLE `outgo_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outgo_types_relative`
--

DROP TABLE IF EXISTS `outgo_types_relative`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `outgo_types_relative` (
  `parent_id` varchar(11) NOT NULL,
  `son_id` varchar(11) NOT NULL,
  PRIMARY KEY (`parent_id`,`son_id`),
  KEY `son_id` (`son_id`),
  CONSTRAINT `outgo_types_relative_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `outgo_types` (`outgo_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `outgo_types_relative_ibfk_2` FOREIGN KEY (`son_id`) REFERENCES `outgo_types` (`outgo_type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outgo_types_relative`
--

LOCK TABLES `outgo_types_relative` WRITE;
/*!40000 ALTER TABLE `outgo_types_relative` DISABLE KEYS */;
INSERT INTO `outgo_types_relative` VALUES ('1','100'),('1','101'),('101','10100'),('101','10101'),('101','10102'),('1','102'),('102','10200'),('10200','1020000'),('102','10201');
/*!40000 ALTER TABLE `outgo_types_relative` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `fiat_id` int(11) NOT NULL,
  `sum` decimal(15,2) NOT NULL,
  `client_rollback_id` int(11) DEFAULT NULL,
  `client_debt_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `client_debt_id` (`client_debt_id`),
  KEY `client_rollback_id` (`client_rollback_id`),
  KEY `branch_id` (`branch_id`),
  KEY `fiat_id` (`fiat_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`client_debt_id`) REFERENCES `clients` (`client_id`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`client_rollback_id`) REFERENCES `clients` (`client_id`),
  CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  CONSTRAINT `payments_ibfk_4` FOREIGN KEY (`fiat_id`) REFERENCES `fiats` (`fiat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(40) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`project_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (2,'Юнити суперпроект',9,1);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rollback_paying`
--

DROP TABLE IF EXISTS `rollback_paying`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `rollback_paying` (
  `rollack_paying_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `rollback_sum` decimal(10,2) NOT NULL,
  `date` datetime NOT NULL,
  `fiat_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`rollack_paying_id`),
  UNIQUE KEY `rollack_paying_id` (`rollack_paying_id`),
  UNIQUE KEY `rollack_paying_id_2` (`rollack_paying_id`),
  KEY `user_id` (`user_id`),
  KEY `client_id` (`client_id`),
  KEY `Rollback_paying_ibfk_22` (`fiat_id`),
  CONSTRAINT `Rollback_paying_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `Rollback_paying_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  CONSTRAINT `Rollback_paying_ibfk_22` FOREIGN KEY (`fiat_id`) REFERENCES `fiats` (`fiat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rollback_paying`
--

LOCK TABLES `rollback_paying` WRITE;
/*!40000 ALTER TABLE `rollback_paying` DISABLE KEYS */;
/*!40000 ALTER TABLE `rollback_paying` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shares`
--

DROP TABLE IF EXISTS `shares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `shares` (
  `shares_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `user_as_owner_id` int(11) NOT NULL,
  `sum` decimal(15,2) NOT NULL,
  `share_percent` decimal(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`shares_id`),
  KEY `owner_id` (`user_as_owner_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `shares_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `shares_ibfk_3` FOREIGN KEY (`user_as_owner_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shares`
--

LOCK TABLES `shares` WRITE;
/*!40000 ALTER TABLE `shares` DISABLE KEYS */;
/*!40000 ALTER TABLE `shares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(15) NOT NULL,
  `role` varchar(30) NOT NULL,
  `branch_id` int(30) NOT NULL,
  `pass_hash` varchar(100) DEFAULT NULL,
  `login` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `is_owner` tinyint(1) NOT NULL DEFAULT '0',
  `telegram` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Devonic','Hammes','admin',3,'$2y$10$2zCpMmzWdYudw5LkeSSq7.ZK26fup.eAU5h3aZk3WyOHZU/J/1EP2','admin',0,1,NULL),(3,'Ivah','Braun','moder',9,'$2y$10$2zCpMmzWdYudw5LkeSSq7.ZK26fup.eAU5h3aZk3WyOHZU/J/1EP2','moder',1,0,NULL),(26,'Диана','Диана','agent',9,'$2y$10$7w2HaKnLAgkvkpJaS70JCO00BsCVctIRiTs6hw4n1hcGhjGI1ODzi','Diana',1,0,'@'),(27,'Саша','Саша','admin',9,'$2y$10$sbWsKwGbM2nWj0VgU5u5HO9T9QyBdb6yDlc.C4c3toGlfNAEmu87e','Sasha',1,1,'@deaxo'),(28,'Игорь','Игорь','admin',9,'$2y$10$BHg7EcxqCwK/v.qsfMO9DOeHIR1zinO3S79kJNw9XhELuJRAemzVq','Igor1',1,1,'');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vg_data`
--

DROP TABLE IF EXISTS `vg_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `vg_data` (
  `vg_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `vg_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `api_url_regexp` varchar(300) DEFAULT NULL,
  `access_key` varchar(100) DEFAULT NULL,
  `out_percent` decimal(15,2) NOT NULL,
  `in_percent` decimal(15,2) NOT NULL,
  PRIMARY KEY (`vg_data_id`),
  KEY `vg_id` (`vg_id`),
  KEY `branch_id` (`branch_id`),
  CONSTRAINT `vg_data_ibfk_1` FOREIGN KEY (`vg_id`) REFERENCES `virtualgood` (`vg_id`),
  CONSTRAINT `vg_data_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vg_data`
--

LOCK TABLES `vg_data` WRITE;
/*!40000 ALTER TABLE `vg_data` DISABLE KEYS */;
INSERT INTO `vg_data` VALUES (1,1,5,'soma','https://chcgreen.net/api/transfer/?tr=%idtransact%&key=92csra1smk6gnbmlvjcubg2u5eqg3qo&login=%clientlogin%&sum=%sum%','31231232131',10.00,7.00),(2,2,5,'orkwood','https://chcgreen.net/api/transfer/?tr=%idtransact%&key=92csra1smk6gnbmlvjcubg2u5eqg3qo&login=%clientlogin%&sum=%sum%','wqewerwerwelkjkj',12.00,8.00),(3,1,1,'testvgInye','http://xn----7sbbfomhdsismqf5b9o.com.ua/','3123123',133.00,9.00),(4,1,1,'testvgInye2','http://xn----7sbbfomhdsismqf5b9o.com.ua/','3123123',1.00,6.00),(5,2,3,'test2vg','','',12.00,11.00),(6,4,9,'Chcgreen грн 0','https://chcgreen.net/api/transfer/?tr=%idtransact%&key=pdq9uv7b2ujt7tevsgvh079n0me7jqv5&login=%clientlogin%&sum=%sum%','joachiqmf21mrrp5ji8aqjns4hbvqg4n00thceqbtl4g26e5g6ieq2vm21ij27nm',7.00,5.00),(7,4,9,'chcgreen грн 1','https://chcgreen.net/api/transfer/?tr=%idtransact%&key=cm8jr8ui3bo3aldbme4e4ongeb27478i&login=%clientlogin%&sum=%sum%','j2amm63gj6a98bqihmi819o9tdbu9spu15aakchnogv0fd4bmj2jri6boes02ojm',7.00,5.00),(8,5,9,'chcblack грн без картинки','','',7.00,5.00),(9,5,9,'chcblack грн с картинкой','','',7.00,5.00),(10,6,9,'chcblack + locker','','',8.00,5.00),(11,7,9,'SimpleGame','','',8.00,0.00),(12,8,9,'superomatic.biz','','',8.00,6.00),(13,9,9,'superomatic.win','','',6.00,0.00),(14,10,9,'global gslots.win','','',6.50,0.00),(15,11,9,'global globalpay.win','','',6.50,0.00),(16,12,9,'stargame lotoslots.org','','',7.00,0.00),(17,13,9,'stargame lotstar','','',7.00,0.00);
/*!40000 ALTER TABLE `vg_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `virtualgood`
--

DROP TABLE IF EXISTS `virtualgood`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `virtualgood` (
  `vg_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`vg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `virtualgood`
--

LOCK TABLES `virtualgood` WRITE;
/*!40000 ALTER TABLE `virtualgood` DISABLE KEYS */;
INSERT INTO `virtualgood` VALUES (1,'testvg'),(2,'test2vg'),(4,'Champion green'),(5,'Champion Black'),(6,'chcblack + locker'),(7,'SimpleGame'),(8,'superomatic.biz'),(9,'superomatic.win'),(10,'global gslots.win'),(11,'global globalpay.win'),(12,'stargame lotoslots.org'),(13,'stargame lotstar');
/*!40000 ALTER TABLE `virtualgood` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-29 22:03:30
