/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.11-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: hosting_inventari
-- ------------------------------------------------------
-- Server version	10.11.11-MariaDB-0ubuntu0.24.04.2

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
-- Table structure for table `acciones_vm_log`
--

DROP TABLE IF EXISTS `acciones_vm_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `acciones_vm_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vm_id` int(11) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vm_id` (`vm_id`),
  CONSTRAINT `acciones_vm_log_ibfk_1` FOREIGN KEY (`vm_id`) REFERENCES `vms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acciones_vm_log`
--

LOCK TABLES `acciones_vm_log` WRITE;
/*!40000 ALTER TABLE `acciones_vm_log` DISABLE KEYS */;
INSERT INTO `acciones_vm_log` VALUES
(3,1,'parar','fallido','2025-04-10 18:22:02');
/*!40000 ALTER TABLE `acciones_vm_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES
(1,'Alberto','albert@gmail.com','$2y$10$yFdsImfBLq2R.7s99a.44etuZWcrXrUkmi6d9qL7b5RQfHN9nqqza','666555444','corehosto','2025-04-04 18:58:15'),
(2,'Albert Test','test@gmail.com','$2y$10$snMxBXNYLuV5fDFlcHIJPeDKZwrD66Vf2KF4r0JQCNJV5nYkHsORi','666555444','casa1232','2025-04-14 17:04:57'),
(3,'paupau','pau@pau.w','$2y$10$GpJR/UfMONCTag9zN2v3ZeyNvbSHHbBuEvgXqKN7AU2IGTvnXnsH.','wwww','w','2025-04-17 09:28:22'),
(5,'d','d@d','$2y$10$guDrtrvj9zBxwc758lwWueSqT9mGGzn85t5Lz8T1ryFEsT2MVX7zO',NULL,NULL,'2025-04-17 09:31:40'),
(7,'ee','ee@ee','$2y$10$S8FkXwy52co0rwyVF6/O0uPYGqr9.hpBVcyb3316FXnPCPqg7/7U6',NULL,NULL,'2025-04-17 09:33:14'),
(9,'prueba','prueba@com','$2y$10$kRq56XUReix9OyBRVk9ClO11rAtBuW33s2XGP77OeZ.yQdZHm.R6q',NULL,NULL,'2025-04-17 09:34:34'),
(10,'Final','final@test.com','$2y$10$0IDfewVuMXpA66jJA5c.oOOObezbGjHTHXEIPWqcAa3mP9JK3c5A.',NULL,NULL,'2025-04-17 11:37:09'),
(11,'Manel','manel@gmail.com','$2y$10$yMN8.14v8bWcYEqSWZ/vfOiflnxhEzasYM7KSqz4jvFEHvzA7wNxe',NULL,NULL,'2025-04-18 16:57:09'),
(12,'pau','pau@gmail.es','$2y$10$RbpkmAHXlRDsh4lNY9F/Nue0VbddJ2NfLY6CyyW.rtaXJQsWPMLF2','','','2025-04-18 17:34:46'),
(13,'pep','pep@gmail.com','$2y$10$BWD0EtZXlK9LDR7KSionCeKbRWZUYPzTigmnOHd6scAhj23vrOOWm',NULL,NULL,'2025-04-22 16:55:01'),
(14,'mariaaa','mariaaa@gmail.com','$2y$10$aGqafZj2tt.pzPN9zZzQdO7oRHH1FfnpIYvkgw9y7UmlSv8UI3GvO','567655666','hola','2025-04-22 17:00:16');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credenciales_servicios`
--

DROP TABLE IF EXISTS `credenciales_servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `credenciales_servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vm_id` int(11) NOT NULL,
  `hostname` varchar(100) DEFAULT NULL,
  `usuario_ftp` varchar(50) DEFAULT NULL,
  `password_ftp` varchar(100) DEFAULT NULL,
  `usuario_mysql` varchar(50) DEFAULT NULL,
  `password_mysql` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vm_id` (`vm_id`),
  CONSTRAINT `credenciales_servicios_ibfk_1` FOREIGN KEY (`vm_id`) REFERENCES `vms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credenciales_servicios`
--

LOCK TABLES `credenciales_servicios` WRITE;
/*!40000 ALTER TABLE `credenciales_servicios` DISABLE KEYS */;
INSERT INTO `credenciales_servicios` VALUES
(2,1,'ch-01','ch-01ftp','ch-01123','ch-01db','ch-01123'),
(18,21,'ch-02','ch-02ftp','ch-02123','ch-02db','ch-02123'),
(19,22,'ch-03','ch-03ftp','ch-03123','ch-03db','ch-03123'),
(28,31,'ch-04','ch-04ftp','ch-04123','ch-04db','ch-04123');
/*!40000 ALTER TABLE `credenciales_servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_estados_vm`
--

DROP TABLE IF EXISTS `historial_estados_vm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_estados_vm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vmid` int(11) NOT NULL,
  `estado_anterior` varchar(50) DEFAULT NULL,
  `estado_nuevo` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `vmid` (`vmid`),
  CONSTRAINT `historial_estados_vm_ibfk_1` FOREIGN KEY (`vmid`) REFERENCES `vms` (`vmid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_estados_vm`
--

LOCK TABLES `historial_estados_vm` WRITE;
/*!40000 ALTER TABLE `historial_estados_vm` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_estados_vm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ips_disponibles`
--

DROP TABLE IF EXISTS `ips_disponibles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ips_disponibles` (
  `ip` varchar(15) NOT NULL,
  `usada` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ips_disponibles`
--

LOCK TABLES `ips_disponibles` WRITE;
/*!40000 ALTER TABLE `ips_disponibles` DISABLE KEYS */;
INSERT INTO `ips_disponibles` VALUES
('172.16.56.151',1),
('172.16.56.152',1),
('172.16.56.153',1),
('172.16.56.154',1),
('172.16.56.155',1),
('172.16.56.156',1),
('172.16.56.157',1),
('172.16.56.158',1),
('172.16.56.159',1),
('172.16.56.160',1),
('172.16.56.161',1),
('172.16.56.162',1),
('172.16.56.163',1),
('172.16.56.164',1),
('172.16.56.165',1),
('172.16.56.166',1),
('172.16.56.167',1),
('172.16.56.168',1),
('172.16.56.169',0),
('172.16.56.170',0),
('172.16.56.171',0),
('172.16.56.172',0),
('172.16.56.173',0),
('172.16.56.174',0),
('172.16.56.175',0),
('172.16.56.176',0),
('172.16.56.177',0),
('172.16.56.178',0),
('172.16.56.179',0),
('172.16.56.180',0),
('172.16.56.181',0),
('172.16.56.182',0),
('172.16.56.183',0),
('172.16.56.184',0),
('172.16.56.185',0),
('172.16.56.186',0),
('172.16.56.187',0),
('172.16.56.188',0),
('172.16.56.189',0),
('172.16.56.190',0),
('172.16.56.191',0);
/*!40000 ALTER TABLE `ips_disponibles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modificaciones_vm`
--

DROP TABLE IF EXISTS `modificaciones_vm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `modificaciones_vm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vmid` int(11) NOT NULL,
  `nuevo_plan_id` int(11) DEFAULT NULL,
  `nuevo_disco_secundario_id` int(11) DEFAULT NULL,
  `estado` enum('pendiente','aplicado','rechazado') DEFAULT 'pendiente',
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `fecha_aplicacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vmid` (`vmid`),
  KEY `nuevo_plan_id` (`nuevo_plan_id`),
  KEY `nuevo_disco_secundario_id` (`nuevo_disco_secundario_id`),
  CONSTRAINT `modificaciones_vm_ibfk_1` FOREIGN KEY (`vmid`) REFERENCES `vms` (`vmid`),
  CONSTRAINT `modificaciones_vm_ibfk_2` FOREIGN KEY (`nuevo_plan_id`) REFERENCES `planes_recursos` (`id`),
  CONSTRAINT `modificaciones_vm_ibfk_3` FOREIGN KEY (`nuevo_disco_secundario_id`) REFERENCES `tramos_disco` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modificaciones_vm`
--

LOCK TABLES `modificaciones_vm` WRITE;
/*!40000 ALTER TABLE `modificaciones_vm` DISABLE KEYS */;
/*!40000 ALTER TABLE `modificaciones_vm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `php_sessions`
--

DROP TABLE IF EXISTS `php_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `php_sessions` (
  `id` varchar(128) NOT NULL,
  `data` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `php_sessions`
--

LOCK TABLES `php_sessions` WRITE;
/*!40000 ALTER TABLE `php_sessions` DISABLE KEYS */;
INSERT INTO `php_sessions` VALUES
('267c14abe89bd42d2af2119abef484f5','cliente_id|i:12;cliente_nombre|s:3:\"pau\";',1746028914),
('29dd015849b12fef9bb78db9f67bc207','cliente_id|i:2;cliente_nombre|s:11:\"Albert Test\";',1745775969),
('40abb6b951451ec5557f526bfc929d8b','cliente_id|i:2;cliente_nombre|s:11:\"Albert Test\";',1746029435),
('948628f9c75968de0b983327b4958799','cliente_id|i:2;cliente_nombre|s:11:\"Albert Test\";',1746028158),
('95effde6709835aaa6a236252bd54804','cliente_id|i:2;cliente_nombre|s:11:\"Albert Test\";',1746031075),
('a934ef2d0f95a78b8ed6152cefb903ae','cliente_id|i:1;cliente_nombre|s:7:\"Alberto\";',1746025773),
('b1c62facb320dd981078b2e941737c7c','cliente_id|i:1;cliente_nombre|s:7:\"Alberto\";',1746025591);
/*!40000 ALTER TABLE `php_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planes_recursos`
--

DROP TABLE IF EXISTS `planes_recursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `planes_recursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `cores` int(11) NOT NULL,
  `ram` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planes_recursos`
--

LOCK TABLES `planes_recursos` WRITE;
/*!40000 ALTER TABLE `planes_recursos` DISABLE KEYS */;
INSERT INTO `planes_recursos` VALUES
(1,'Plan Básico',2,4096,20.00,1),
(2,'Plan Medio',4,6144,30.00,1),
(3,'Plan Avanzado',6,8192,40.00,1);
/*!40000 ALTER TABLE `planes_recursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `redes`
--

DROP TABLE IF EXISTS `redes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `redes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('publica','privada') NOT NULL,
  `ip` varchar(15) NOT NULL,
  `en_uso` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `redes`
--

LOCK TABLES `redes` WRITE;
/*!40000 ALTER TABLE `redes` DISABLE KEYS */;
INSERT INTO `redes` VALUES
(1,'publica','172.16.56.150',1),
(2,'publica','172.16.56.151',1),
(3,'publica','172.16.56.152',1),
(4,'publica','172.16.56.153',1),
(5,'publica','172.16.56.154',0),
(6,'publica','172.16.56.155',0),
(7,'publica','172.16.56.156',0),
(8,'publica','172.16.56.157',0),
(9,'publica','172.16.56.158',0),
(10,'publica','172.16.56.159',0),
(11,'publica','172.16.56.160',0),
(12,'publica','172.16.56.161',0),
(13,'publica','172.16.56.162',0),
(14,'publica','172.16.56.163',0),
(15,'publica','172.16.56.164',0),
(16,'publica','172.16.56.165',0),
(17,'publica','172.16.56.166',0),
(18,'publica','172.16.56.167',0),
(19,'publica','172.16.56.168',0),
(20,'publica','172.16.56.169',0),
(21,'publica','172.16.56.170',0),
(22,'publica','172.16.56.171',0),
(23,'publica','172.16.56.172',0),
(24,'publica','172.16.56.173',0),
(25,'publica','172.16.56.174',0),
(26,'publica','172.16.56.175',0),
(27,'publica','172.16.56.176',0),
(28,'publica','172.16.56.177',0),
(29,'publica','172.16.56.178',0),
(30,'publica','172.16.56.179',0),
(31,'publica','172.16.56.180',0),
(32,'publica','172.16.56.181',0),
(33,'publica','172.16.56.182',0),
(34,'publica','172.16.56.183',0),
(35,'publica','172.16.56.184',0),
(36,'publica','172.16.56.185',0),
(37,'publica','172.16.56.186',0),
(38,'publica','172.16.56.187',0),
(39,'publica','172.16.56.188',0),
(40,'publica','172.16.56.189',0),
(41,'publica','172.16.56.190',0),
(42,'publica','172.16.56.191',0),
(43,'publica','172.16.56.192',0),
(44,'publica','172.16.56.193',0),
(45,'publica','172.16.56.194',0),
(46,'publica','172.16.56.195',0),
(47,'publica','172.16.56.196',0),
(48,'publica','172.16.56.197',0),
(49,'publica','172.16.56.198',0),
(50,'publica','172.16.56.199',0),
(51,'privada','10.10.0.20',1),
(52,'privada','10.10.0.21',1),
(53,'privada','10.10.0.22',1),
(54,'privada','10.10.0.23',1),
(55,'privada','10.10.0.24',0),
(56,'privada','10.10.0.25',0),
(57,'privada','10.10.0.26',0),
(58,'privada','10.10.0.27',0),
(59,'privada','10.10.0.28',0),
(60,'privada','10.10.0.29',0),
(61,'privada','10.10.0.30',0),
(62,'privada','10.10.0.31',0),
(63,'privada','10.10.0.32',0),
(64,'privada','10.10.0.33',0),
(65,'privada','10.10.0.34',0),
(66,'privada','10.10.0.35',0),
(67,'privada','10.10.0.36',0),
(68,'privada','10.10.0.37',0),
(69,'privada','10.10.0.38',0),
(70,'privada','10.10.0.39',0),
(71,'privada','10.10.0.40',0),
(72,'privada','10.10.0.41',0),
(73,'privada','10.10.0.42',0),
(74,'privada','10.10.0.43',0),
(75,'privada','10.10.0.44',0),
(76,'privada','10.10.0.45',0),
(77,'privada','10.10.0.46',0),
(78,'privada','10.10.0.47',0),
(79,'privada','10.10.0.48',0),
(80,'privada','10.10.0.49',0),
(81,'privada','10.10.0.50',0),
(82,'privada','10.10.0.51',0),
(83,'privada','10.10.0.52',0),
(84,'privada','10.10.0.53',0),
(85,'privada','10.10.0.54',0),
(86,'privada','10.10.0.55',0),
(87,'privada','10.10.0.56',0),
(88,'privada','10.10.0.57',0),
(89,'privada','10.10.0.58',0),
(90,'privada','10.10.0.59',0),
(91,'privada','10.10.0.60',0),
(92,'privada','10.10.0.61',0),
(93,'privada','10.10.0.62',0),
(94,'privada','10.10.0.63',0),
(95,'privada','10.10.0.64',0),
(96,'privada','10.10.0.65',0),
(97,'privada','10.10.0.66',0),
(98,'privada','10.10.0.67',0),
(99,'privada','10.10.0.68',0),
(100,'privada','10.10.0.69',0);
/*!40000 ALTER TABLE `redes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes_wordpress`
--

DROP TABLE IF EXISTS `solicitudes_wordpress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitudes_wordpress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(100) NOT NULL,
  `estado` enum('pendiente','instalado','error') DEFAULT 'pendiente',
  `db_name` varchar(100) NOT NULL,
  `db_user` varchar(255) DEFAULT NULL,
  `db_pass` varchar(255) DEFAULT NULL,
  `db_prefix` varchar(20) DEFAULT 'wp_',
  `site_url` varchar(255) NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `admin_user` varchar(100) NOT NULL,
  `admin_pass` varchar(100) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `language` varchar(10) DEFAULT 'es_ES',
  `timezone` varchar(50) DEFAULT 'Europe/Madrid',
  `fecha_solicitud` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudes_wordpress`
--

LOCK TABLES `solicitudes_wordpress` WRITE;
/*!40000 ALTER TABLE `solicitudes_wordpress` DISABLE KEYS */;
INSERT INTO `solicitudes_wordpress` VALUES
(3,'ch-01','instalado','polla','ch-01db','ch-01123','wp_','http://172.16.56.150','prueba2','base','proyecto1','base@proyecto.com','es_ES','Europe/Madrid','2025-04-10 16:44:53'),
(5,'ch-02','instalado','testwp','ch-02db','ch-02123','wp_','http://172.16.56.151','Test Cat','test','proyecto1','admin@admin.com','ca','Europe/Madrid','2025-04-17 11:58:53'),
(6,'ch-01','instalado','wptestca','ch-01db','ch-01123','wp_','http://172.16.56.150','Test reinstall','base','proyecto','core@host.com','ca','Europe/Madrid','2025-04-20 17:33:50'),
(7,'ch-01','instalado','wpteeeeest','ch-01db','ch-01123','wp_','http://172.16.56.150','Test reinstall-2','base','proyecto','core@host.com','ca','Europe/Madrid','2025-04-20 17:52:24'),
(8,'ch-01','instalado','wpteeeeesttt','ch-01db','ch-01123','wp_','http://172.16.56.150','Test reinstall-3','base','proyecto','core@host.com','ca','Europe/Madrid','2025-04-20 18:05:12'),
(13,'ch-04','instalado','wptestca','ch-04db','ch-04123','wp_','http://172.16.56.153','testwp','base','proyecto','core@host.com','ca','Europe/Madrid','2025-04-30 16:10:35');
/*!40000 ALTER TABLE `solicitudes_wordpress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tramos_disco`
--

DROP TABLE IF EXISTS `tramos_disco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tramos_disco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad_gb` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tramos_disco`
--

LOCK TABLES `tramos_disco` WRITE;
/*!40000 ALTER TABLE `tramos_disco` DISABLE KEYS */;
INSERT INTO `tramos_disco` VALUES
(1,50,5.00,1),
(2,100,10.00,1),
(3,150,15.00,1),
(4,200,20.00,1);
/*!40000 ALTER TABLE `tramos_disco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vms`
--

DROP TABLE IF EXISTS `vms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `vms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `vmid` int(11) DEFAULT NULL,
  `hostname` varchar(50) DEFAULT NULL,
  `ip_publica` varchar(15) DEFAULT NULL,
  `ip_privada` varchar(15) DEFAULT NULL,
  `estado` enum('pendiente','clonando','configurando','configurar_usuarios','iniciando','instalar_usuarios','completado','esperando_modificacion','ampliando_recursos','reduciendo_recursos','cambio_php','error','eliminada') NOT NULL,
  `cores` int(11) NOT NULL,
  `memory` int(11) NOT NULL,
  `php` float DEFAULT NULL,
  `disco_secundario` int(11) DEFAULT NULL,
  `plantilla_base` varchar(50) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `disco_secundario_id` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `vmid` (`vmid`),
  UNIQUE KEY `hostname` (`hostname`),
  KEY `cliente_id` (`cliente_id`),
  KEY `plan_id` (`plan_id`),
  KEY `disco_secundario_id` (`disco_secundario_id`),
  CONSTRAINT `vms_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `vms_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `planes_recursos` (`id`),
  CONSTRAINT `vms_ibfk_3` FOREIGN KEY (`disco_secundario_id`) REFERENCES `tramos_disco` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vms`
--

LOCK TABLES `vms` WRITE;
/*!40000 ALTER TABLE `vms` DISABLE KEYS */;
INSERT INTO `vms` VALUES
(1,1,500,'ch-01','172.16.56.150','10.10.0.20','completado',4,6144,8.1,100,'Ubuntu',2,2,'2025-04-04 19:05:12','2025-04-08 16:57:51'),
(21,10,501,'ch-02','172.16.56.151','10.10.0.21','completado',6,8192,8.1,100,'Ubuntu',3,2,'2025-04-17 11:38:51','2025-04-17 11:50:10'),
(22,2,502,'ch-03','172.16.56.152','10.10.0.22','completado',2,4096,8.1,50,'Ubuntu',1,1,'2025-04-18 14:28:32','2025-04-18 14:38:26'),
(31,2,503,'ch-04','172.16.56.153','10.10.0.23','completado',2,4096,8.1,50,'Ubuntu',1,1,'2025-04-30 15:52:01','2025-04-30 16:09:12');
/*!40000 ALTER TABLE `vms` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-01 17:03:48
