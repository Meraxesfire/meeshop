-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: meeshop_test
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `meeshop_test`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `meeshop_test` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `meeshop_test`;

--
-- Table structure for table `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_venta` int NOT NULL,
  `id_producto` int unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_venta` (`id_venta`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ventas`
--

LOCK TABLES `detalle_ventas` WRITE;
/*!40000 ALTER TABLE `detalle_ventas` DISABLE KEYS */;
INSERT INTO `detalle_ventas` VALUES (1,1,1,1,0.00),(2,1,5,1,0.00),(3,2,4,1,0.00),(4,3,4,1,0.00),(5,4,4,1,0.00),(6,5,4,1,0.00),(7,6,4,2,0.00),(8,7,7,3,13.50),(9,8,1,1,12.60),(10,9,1,1,12.60),(11,10,1,1,12.60),(12,11,22,2,29.00),(13,12,22,2,29.00),(14,13,4,1,17.50),(15,14,12,1,4.50),(16,15,22,1,14.50),(17,16,22,1,14.50),(18,17,22,1,14.50),(19,18,22,1,14.50),(20,19,22,1,14.50),(21,20,22,1,14.50),(22,21,22,1,14.50),(23,22,22,1,14.50),(24,23,4,1,17.50),(25,24,4,1,17.50),(26,25,4,1,17.50),(27,26,29,1,20.57),(28,27,14,1,2.00),(29,28,14,1,2.00),(30,29,4,1,17.50),(31,30,22,1,14.50),(32,31,37,2,16.94),(33,31,35,1,8.47),(34,32,37,2,16.94),(35,32,35,1,8.47),(36,33,37,2,24.20),(37,34,37,2,24.20),(38,35,37,1,12.10),(39,36,37,1,12.10),(40,37,37,2,24.20),(41,38,30,1,12.10),(42,38,37,1,12.10),(43,39,37,1,12.10),(44,40,37,2,24.20),(45,41,37,1,12.10),(46,42,37,2,24.20),(47,43,37,1,12.10),(48,44,37,1,12.10),(49,45,37,1,12.10),(50,46,37,1,12.10),(51,47,37,1,12.10),(52,48,37,1,12.10),(53,49,37,1,12.10),(54,50,37,1,12.10),(55,51,37,1,12.10),(56,52,37,1,12.10),(57,53,37,1,12.10),(58,54,37,1,12.10),(59,55,37,1,12.10),(60,56,37,1,12.10),(61,57,7,1,4.50),(62,58,22,1,14.50),(63,59,38,1,2.42),(64,60,38,1,2.42),(65,61,38,1,2.42),(66,62,38,1,2.42),(67,63,38,1,2.42),(68,64,38,1,2.42),(69,65,38,1,2.42),(70,66,38,1,2.42),(71,67,38,1,2.42),(72,68,38,2,4.84),(73,69,38,1,2.42),(74,70,39,1,6.05),(75,71,39,1,6.05),(76,72,38,1,2.42),(77,73,39,1,6.05),(78,74,38,1,2.42),(79,75,39,1,6.05),(80,76,39,1,6.05),(81,77,39,1,6.05),(82,78,39,1,6.05),(83,79,38,1,2.42),(84,80,38,1,2.42),(85,81,38,1,2.42),(86,82,38,1,2.42),(87,83,39,1,6.05),(88,84,38,1,2.42),(89,85,39,1,6.05),(90,86,38,1,2.42),(91,87,38,1,2.42),(92,88,39,1,6.05),(93,89,39,1,6.05),(94,90,39,1,6.05),(95,91,39,1,6.05),(96,92,39,1,6.05),(97,93,38,1,2.42),(98,94,39,1,6.05),(99,95,39,1,6.05),(100,96,39,1,6.05),(101,97,39,2,12.10),(102,97,38,1,2.42),(103,98,39,1,6.05),(104,99,38,1,2.42),(105,99,37,1,12.10),(106,100,38,1,2.42),(107,101,38,1,2.42),(108,101,39,1,6.05),(109,102,39,1,6.05),(110,102,38,1,2.42),(111,103,38,2,4.84),(112,104,31,1,2.42),(113,104,39,1,6.05),(114,104,38,1,2.42),(115,105,39,1,6.05),(116,105,38,1,2.42),(117,106,38,2,4.84),(118,107,35,1,8.47),(119,107,32,1,8.47),(120,112,39,1,6.05),(121,115,6,1,10.90),(122,116,39,1,6.05),(123,116,38,1,2.42),(124,121,39,1,6.05),(125,122,39,1,6.05),(126,123,40,1,5.45),(127,124,40,1,5.45),(128,125,40,2,10.89),(129,126,41,2,12.10),(130,126,40,1,5.45),(131,127,40,2,10.89),(132,128,40,1,5.45),(133,128,41,1,6.05),(134,128,39,1,6.05),(135,129,12,1,4.50),(136,130,40,2,10.89),(137,131,41,1,6.05),(138,132,40,2,10.89),(139,135,40,1,5.45),(140,138,40,1,5.45),(141,139,29,1,20.57),(142,140,1,1,12.60),(143,140,6,1,10.90),(144,141,6,1,10.90),(145,141,5,3,41.85),(146,141,39,1,6.05),(147,142,4,1,17.50),(148,142,38,2,4.84),(149,142,39,2,12.10),(150,143,30,1,6.05),(151,143,29,1,20.57),(152,143,40,4,21.78),(153,144,40,2,10.89),(154,144,41,2,12.10),(155,145,40,3,16.34),(156,146,40,2,10.89),(157,146,41,1,6.05),(158,147,39,1,6.05),(159,147,40,3,16.34),(160,148,38,4,9.68),(161,148,41,4,24.20);
/*!40000 ALTER TABLE `detalle_ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleadas`
--

DROP TABLE IF EXISTS `empleadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleadas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'id_unico',
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'nombre_completo',
  `usuario` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'nombre_usuario',
  `contraseña` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `id_empresa` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_empresa` (`id_empresa`),
  CONSTRAINT `fk_id_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleadas`
--

LOCK TABLES `empleadas` WRITE;
/*!40000 ALTER TABLE `empleadas` DISABLE KEYS */;
INSERT INTO `empleadas` VALUES (1,'Isabel Caro Morillo','isabelcaro','isabel1234',1,1),(2,'','Marina Ramos Gueva','Marina1234',1,1),(3,'','GloriaPrado','Gloria1234',1,1),(4,'','SandraSanjuan','Sandra1234',1,1),(5,'','EstrellaPerez','Estrella1234',1,1),(6,'','GertruLopez','Gertru1234',1,1),(7,'','CeliaNavarro','Celia1234',1,1),(8,'admin','admin','admin',1,1),(9,'Alicia Fuertes','AliF','Ali1234',1,1);
/*!40000 ALTER TABLE `empleadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id_empresa',
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'nombre_empresa',
  `cif` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'cif_empresa',
  `telefono` int NOT NULL COMMENT 'teléfono_empresa',
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'email_empresa',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'ATRAYANA S.A','PU335346',663474447,'atrayanaceramica@gmail.com');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'id_producto',
  `EAN` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'nombre_producto',
  `categoria` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'categoria_producto',
  `precio` decimal(10,2) NOT NULL COMMENT 'precio_producto',
  `stock` int NOT NULL COMMENT 'stock_producto',
  `activo` tinyint(1) DEFAULT '1',
  `iva` decimal(2,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `EAN` (`EAN`),
  UNIQUE KEY `EAN_2` (`EAN`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'2147483647','BOTA SIN TACHUELA C14','accesorios',12.60,-2,1,NULL),(4,'123456789','BOTIN DE ANTELINA','ropa',17.50,0,1,NULL),(5,'3456789322','SANDALIA RAFIA Y ANTEL','zapatos',13.95,-3,1,NULL),(6,'4467789932','SANDALIA CANGREJERA C45','zapatos',10.90,-1,1,NULL),(7,'4534534346','ANILLO GATO','joyeria',4.50,1,1,NULL),(12,'3345567789','CADENA ACERO','joyeria',4.50,1,1,NULL),(14,'2234456680','PINZA PELO HAWAII','accesorios',2.00,2,1,NULL),(22,'12345665867','PRUEBA 95','ropa',14.50,1,1,NULL),(27,'1233344556','PRUEBA 3','accesorios',445.00,2,1,NULL),(28,'33344455567','PRUEBA4','ropa',100.00,2,1,21),(29,'446655778','PRUEBA 5','accesorios',17.00,0,1,21),(30,'1234567776','PRUEBA 6.1','joyeria',5.00,1,1,21),(31,'5577888997','PRUEBA 7','ropa',2.00,1,1,21),(32,'445886679','PRUEBA 9','ropa',7.00,1,1,21),(34,'556772840','PRUEBA 10','joyeria',3.00,1,1,21),(35,'4467909432','PRUEBA 11','accesorios',7.00,1,1,21),(36,'1234765480','PRUEBA 12','ropa',65.00,1,1,21),(37,'4456632728','PRUEBA 13','ropa',10.00,1,1,21),(38,'456738829','PRUEBA 14','joyeria',2.00,59,1,21),(39,'55544422211','PRUEBA 15','zapatos',5.00,56,1,21),(40,'553422876','PRUEBA 16','zapatos',4.50,102,1,21),(41,'556785324','PRUEBA 17','joyeria',5.00,34,1,21);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id_venta',
  `id_empleada` int unsigned NOT NULL COMMENT 'foreign_key_empleadasid',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(10,2) NOT NULL COMMENT 'precio_total_venta',
  PRIMARY KEY (`id`),
  KEY `id_empleada` (`id_empleada`),
  CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_empleada`) REFERENCES `empleadas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (1,1,'2026-04-13 09:49:00',0.00),(2,1,'2026-04-13 09:50:34',0.00),(3,1,'2026-04-13 09:50:35',0.00),(4,1,'2026-04-13 09:52:51',0.00),(5,1,'2026-04-13 09:54:08',0.00),(6,1,'2026-04-13 10:02:42',35.00),(7,1,'2026-04-13 10:04:14',13.50),(8,1,'2026-04-13 10:05:52',12.60),(9,1,'2026-04-13 10:05:53',12.60),(10,1,'2026-04-13 10:06:26',12.60),(11,1,'2026-04-13 10:06:37',29.00),(12,1,'2026-04-13 10:07:55',29.00),(13,1,'2026-04-13 10:52:00',17.50),(14,1,'2026-04-13 10:53:58',4.50),(15,1,'2026-04-13 14:04:36',14.50),(16,1,'2026-04-13 14:08:39',14.50),(17,1,'2026-04-13 14:11:03',14.50),(18,1,'2026-04-13 14:11:05',14.50),(19,1,'2026-04-13 14:11:05',14.50),(20,1,'2026-04-13 14:11:05',14.50),(21,1,'2026-04-13 14:12:11',14.50),(22,1,'2026-04-13 14:35:51',14.50),(23,1,'2026-04-13 14:37:49',17.50),(24,1,'2026-04-13 14:38:56',17.50),(25,1,'2026-04-13 14:44:08',17.50),(26,1,'2026-04-13 14:44:23',20.57),(27,1,'2026-04-13 14:51:26',2.00),(28,1,'2026-04-13 14:52:01',2.00),(29,1,'2026-04-13 14:53:55',17.50),(30,1,'2026-04-13 14:56:18',14.50),(31,1,'2026-04-13 15:10:30',32.67),(32,1,'2026-04-13 15:11:56',32.67),(33,1,'2026-04-13 15:13:34',24.20),(34,1,'2026-04-13 15:16:18',24.20),(35,1,'2026-04-13 15:18:50',12.10),(36,1,'2026-04-13 15:20:09',12.10),(37,1,'2026-04-13 15:24:21',24.20),(38,1,'2026-04-13 15:28:04',18.15),(39,1,'2026-04-13 16:28:43',12.10),(40,1,'2026-04-13 16:30:28',24.20),(41,1,'2026-04-13 16:31:28',12.10),(42,1,'2026-04-13 17:08:48',24.20),(43,1,'2026-04-14 07:35:54',12.10),(44,1,'2026-04-14 07:44:23',12.10),(45,1,'2026-04-14 07:45:44',12.10),(46,1,'2026-04-14 08:00:26',12.10),(47,1,'2026-04-14 08:05:09',12.10),(48,1,'2026-04-14 08:18:40',12.10),(49,1,'2026-04-14 09:18:32',12.10),(50,1,'2026-04-14 09:25:19',12.10),(51,1,'2026-04-14 09:25:49',12.10),(52,1,'2026-04-14 09:28:36',12.10),(53,1,'2026-04-14 09:55:56',12.10),(54,1,'2026-04-14 09:57:09',12.10),(55,1,'2026-04-14 09:57:39',12.10),(56,1,'2026-04-14 10:07:17',12.10),(57,1,'2026-04-14 10:10:37',4.50),(58,1,'2026-04-14 10:27:48',14.50),(59,1,'2026-04-14 10:48:05',2.42),(60,1,'2026-04-14 10:48:50',2.42),(61,1,'2026-04-14 10:49:10',2.42),(62,1,'2026-04-14 10:49:22',2.42),(63,1,'2026-04-14 10:49:35',2.42),(64,1,'2026-04-14 10:49:58',2.42),(65,1,'2026-04-14 11:18:41',2.42),(66,1,'2026-04-14 11:20:21',2.42),(67,1,'2026-04-14 11:21:28',2.42),(68,1,'2026-04-14 11:22:16',4.84),(69,1,'2026-04-14 12:59:16',2.42),(70,1,'2026-04-14 14:08:43',6.05),(71,1,'2026-04-14 14:15:36',6.05),(72,1,'2026-04-14 14:17:34',2.42),(73,1,'2026-04-14 14:18:01',6.05),(74,1,'2026-04-14 14:26:42',2.42),(75,1,'2026-04-14 14:29:20',6.05),(76,1,'2026-04-14 14:30:05',6.05),(77,1,'2026-04-14 14:50:50',6.05),(78,1,'2026-04-14 18:00:30',6.05),(79,1,'2026-04-14 18:10:15',2.42),(80,1,'2026-04-14 18:11:20',2.42),(81,1,'2026-04-14 18:13:53',2.42),(82,1,'2026-04-14 18:16:02',2.42),(83,1,'2026-04-15 13:43:44',6.05),(84,1,'2026-04-15 14:33:48',2.42),(85,1,'2026-04-15 14:35:33',6.05),(86,1,'2026-04-15 14:36:00',2.42),(87,1,'2026-04-15 14:36:19',2.42),(88,1,'2026-04-15 14:41:48',6.05),(89,1,'2026-04-15 14:50:27',6.05),(90,1,'2026-04-15 15:03:18',6.05),(91,1,'2026-04-15 15:04:57',6.05),(92,1,'2026-04-15 15:22:26',6.05),(93,1,'2026-04-15 15:25:33',2.42),(94,1,'2026-04-15 15:28:41',6.05),(95,1,'2026-04-15 15:45:08',6.05),(96,1,'2026-04-15 15:52:32',6.05),(97,1,'2026-04-15 16:07:51',14.52),(98,1,'2026-04-15 16:11:44',6.05),(99,1,'2026-04-15 16:14:31',14.52),(100,1,'2026-04-15 16:21:07',2.42),(101,1,'2026-04-15 17:09:02',8.47),(102,1,'2026-04-15 17:22:26',8.47),(103,1,'2026-04-15 17:22:35',4.84),(104,1,'2026-04-15 18:13:15',10.89),(105,1,'2026-04-15 18:22:27',8.47),(106,1,'2026-04-15 18:23:14',4.84),(107,1,'2026-04-15 18:23:46',16.94),(112,1,'2026-04-15 18:25:44',6.05),(115,1,'2026-04-15 18:26:29',10.90),(116,1,'2026-04-15 18:26:51',8.47),(121,1,'2026-04-21 13:12:50',6.05),(122,1,'2026-04-21 13:26:01',6.05),(123,1,'2026-04-21 13:55:57',5.45),(124,1,'2026-04-21 13:56:06',5.45),(125,1,'2026-04-21 13:57:17',10.89),(126,1,'2026-04-21 13:57:44',17.55),(127,1,'2026-04-21 13:59:11',10.89),(128,1,'2026-04-21 13:59:20',17.55),(129,1,'2026-04-21 18:25:52',4.50),(130,1,'2026-04-21 18:32:53',10.89),(131,8,'2026-04-22 18:37:11',6.05),(132,3,'2026-04-22 18:57:23',10.89),(135,8,'2026-04-23 18:24:47',5.45),(138,8,'2026-04-23 18:34:02',5.45),(139,8,'2026-04-23 18:34:09',20.57),(140,1,'2026-05-14 07:24:38',23.50),(141,1,'2026-05-23 10:56:20',58.80),(142,1,'2026-05-27 18:59:24',34.44),(143,1,'2026-05-28 07:26:30',48.40),(144,1,'2026-06-05 07:35:54',22.99),(145,1,'2026-06-05 07:36:02',16.34),(146,1,'2026-06-06 12:43:13',16.94),(147,1,'2026-06-12 15:21:59',22.39),(148,1,'2026-06-13 14:16:59',33.88);
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'meeshop_test'
--

--
-- Dumping routines for database 'meeshop_test'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-10 20:46:12
