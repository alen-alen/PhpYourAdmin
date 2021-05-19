-- MariaDB dump 10.19  Distrib 10.4.18-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: denis
-- ------------------------------------------------------
-- Server version	10.4.18-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `type_sort` varchar(64) DEFAULT NULL,
  `belongesToType` int(10) unsigned DEFAULT NULL,
  `belongesToSubType` int(10) unsigned DEFAULT NULL,
  `mainType` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_belonges_to` (`belongesToType`),
  KEY `type_belonges_to_sub` (`belongesToSubType`),
  KEY `type_belonges_to_main` (`mainType`),
  CONSTRAINT `type_belonges_to` FOREIGN KEY (`belongesToType`) REFERENCES `types` (`id`),
  CONSTRAINT `type_belonges_to_main` FOREIGN KEY (`mainType`) REFERENCES `types` (`id`),
  CONSTRAINT `type_belonges_to_sub` FOREIGN KEY (`belongesToSubType`) REFERENCES `types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'FrontEnd','main',NULL,NULL,NULL),(2,'BackEnd','main',NULL,NULL,NULL),(3,'Angular','mid',NULL,NULL,1),(4,'AngularJs','sub',3,NULL,1),(5,'Angular2','sub',3,NULL,1),(6,'React','mid',NULL,NULL,1),(7,'React native','sub',6,NULL,1),(8,'Vue','mid',NULL,NULL,1),(9,'PHP','mid',NULL,NULL,2),(10,'Symfony','sub',9,NULL,2),(11,'Silex','min',9,10,2),(12,'Laravel','sub',9,NULL,2),(13,'Lumen','min',9,12,2),(14,'NodeJs','mid',NULL,NULL,2),(15,'Express','sub',14,NULL,2),(16,'NestJs','sub',14,NULL,2);
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `type_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emial_unique` (`email`),
  KEY `type_id_fk` (`type_id`),
  CONSTRAINT `type_id_fk` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Alen','alen-ziberi@hotmail.com','alen123',3),(2,'Brainster','brainster@mail.com','$2y$10$KH3DTlNH/rKpryuFuQpPu.fJAAwmXxL4yGqaqd.5nQb9Icqi1c81u',13),(3,'admin','admin@admin.com','$2y$10$13cNLpjziqiWirFZfRpyiuBM4NzK9Z1AIU9O93vnmaQFjly.VCQFO',9),(4,'elena','elena@elena.com','$2y$10$NMI5Gg1uhChMQr6YErIQau8vvYOUkbuz3iDmavw.aEDU.tVQkG70y',2),(5,'test1','email@test.com','testPass',3),(6,'asd','asd','password',2);
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

-- Dump completed on 2021-05-19 16:10:09
