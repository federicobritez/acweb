CREATE DATABASE  IF NOT EXISTS `ecoturismo` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ecoturismo`;
-- MySQL dump 10.13  Distrib 5.5.52, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: ecoturismo
-- ------------------------------------------------------
-- Server version	5.5.52-0+deb8u1

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
-- Table structure for table `acompanante`
--

DROP TABLE IF EXISTS `acompanante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acompanante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `grupo_acompanante_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_acompanante_grupo_acompanante1_idx` (`grupo_acompanante_id`),
  CONSTRAINT `fk_acompanante_grupo_acompanante1` FOREIGN KEY (`grupo_acompanante_id`) REFERENCES `grupo_acompanante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acompanante`
--

LOCK TABLES `acompanante` WRITE;
/*!40000 ALTER TABLE `acompanante` DISABLE KEYS */;
/*!40000 ALTER TABLE `acompanante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono1` varchar(45) DEFAULT NULL,
  `telefono2` varchar(45) DEFAULT NULL,
  `ciudad` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `provincia` varchar(45) DEFAULT NULL,
  `dni` int(11) NOT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `grupo_acompanante_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_grupo_acompanante1_idx` (`grupo_acompanante_id`),
  CONSTRAINT `fk_cliente_grupo_acompanante1` FOREIGN KEY (`grupo_acompanante_id`) REFERENCES `grupo_acompanante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='Datos de cliente';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (30,'Federico','Britez','123456','6263123123','Resistencia','Argentina','Chaco',3443213,'fede1234@gmail.com',NULL),(32,'Ana','Martinez','0321231872','','Charata','Argentina','Chaco',26093213,'anamartinez@yahoo.com',NULL),(33,'Jose Luis','Ferreyra','03762 8991231','','Las Breñas','Argentina','Chaco',14098234,'jferreyra@gmail.com',NULL),(35,'David','Gonzalez Escobar','037892342567','','El Sauzalito','Argentina','Corrientes',40233122,'david.escobarg@gmail.com',NULL),(36,'Juana','Perez ','03442131231','','Puerto Tirol','Argentina','Chaco',21234421,'jgarcia@fibertel.com',NULL);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consumos_cliente`
--

DROP TABLE IF EXISTS `consumos_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consumos_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `servicio_id` int(11) NOT NULL,
  `monto_abonado` float DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `tipo_pago_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `reserva_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_consumos_serv_otros_servicio1_idx` (`servicio_id`),
  KEY `fk_consumos_serv_otros_cliente1_idx` (`cliente_id`),
  KEY `fk_consumos_serv_otros_tipo_pago1_idx` (`tipo_pago_id`),
  KEY `fk_consumos_cliente_reserva1_idx` (`reserva_id`),
  CONSTRAINT `fk_consumos_cliente_reserva1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consumos_serv_otros_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_consumos_serv_otros_servicio1` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_consumos_serv_otros_tipo_pago1` FOREIGN KEY (`tipo_pago_id`) REFERENCES `tipo_pago` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Detalle de consumos adicionales ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumos_cliente`
--

LOCK TABLES `consumos_cliente` WRITE;
/*!40000 ALTER TABLE `consumos_cliente` DISABLE KEYS */;
INSERT INTO `consumos_cliente` VALUES (4,32,8,516,0,6,'2016-10-02 15:56:50',32),(6,32,3,387,0,1,'2016-10-02 17:53:47',31),(7,36,1,3.096,0,6,'2016-10-02 19:18:13',33),(8,36,8,4.792,0,4,'2016-10-02 19:59:28',35);
/*!40000 ALTER TABLE `consumos_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_reserva`
--

DROP TABLE IF EXISTS `estado_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_reserva` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipos de estados disponibles para las reservas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_reserva`
--

LOCK TABLES `estado_reserva` WRITE;
/*!40000 ALTER TABLE `estado_reserva` DISABLE KEYS */;
INSERT INTO `estado_reserva` VALUES (1,'CONFIRMADA'),(2,'LISTA_ESPERA'),(3,'ESPERANDO_CONFIRMACION'),(4,'CANCELADA'),(5,'VENCIDA'),(6,'EFECTUADA');
/*!40000 ALTER TABLE `estado_reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_consumo`
--

DROP TABLE IF EXISTS `factura_consumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_consumo` (
  `id` int(11) NOT NULL,
  `numero_tarjeta` varchar(45) DEFAULT NULL,
  `valida_hasta` varchar(45) DEFAULT NULL,
  `nombre_apellido_tarjeta` varchar(45) DEFAULT NULL,
  `dni_titular` varchar(45) DEFAULT NULL,
  `cuil` varchar(45) DEFAULT NULL,
  `cod_seguridad` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_consumo`
--

LOCK TABLES `factura_consumo` WRITE;
/*!40000 ALTER TABLE `factura_consumo` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura_consumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formas_de_pago`
--

DROP TABLE IF EXISTS `formas_de_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formas_de_pago` (
  `servicio_id` int(11) NOT NULL,
  `tipo_pago_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`,`servicio_id`,`tipo_pago_id`),
  KEY `fk_forma_de_pago_servicio1_idx` (`servicio_id`),
  KEY `fk_formas_de_pago_tipo_pago1_idx` (`tipo_pago_id`),
  CONSTRAINT `fk_formas_de_pago_tipo_pago1` FOREIGN KEY (`tipo_pago_id`) REFERENCES `tipo_pago` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_forma_de_pago_servicio1` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='Configuración de tipos de pagos disponibles para cada servicio';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formas_de_pago`
--

LOCK TABLES `formas_de_pago` WRITE;
/*!40000 ALTER TABLE `formas_de_pago` DISABLE KEYS */;
INSERT INTO `formas_de_pago` VALUES (1,1,2),(1,2,5),(1,3,6),(1,4,7),(1,5,8),(1,6,9),(1,7,10),(2,1,11),(2,2,12),(2,3,13),(2,4,14),(2,5,15),(2,6,16),(2,7,17),(3,1,18),(3,2,19),(3,3,20),(3,4,21),(3,5,22),(3,6,23),(3,7,24),(4,1,25),(4,2,26),(4,3,27),(4,4,28),(4,5,29),(4,6,30),(4,7,31),(5,1,32),(5,2,33),(5,3,34),(5,4,35),(5,5,36),(5,6,37),(5,7,38),(6,1,39),(6,2,40),(6,3,41),(6,4,42),(6,5,43),(6,6,44),(6,7,45),(8,1,46),(8,2,47),(8,3,48),(8,4,49),(8,5,50),(8,6,51),(8,7,52);
/*!40000 ALTER TABLE `formas_de_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_acompanante`
--

DROP TABLE IF EXISTS `grupo_acompanante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_acompanante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente_responsable` int(11) NOT NULL,
  `alias` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Agrupacion de clientes para grupo familiar, comitiva o grupo en general.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_acompanante`
--

LOCK TABLES `grupo_acompanante` WRITE;
/*!40000 ALTER TABLE `grupo_acompanante` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_acompanante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `habitaciones`
--

DROP TABLE IF EXISTS `habitaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `habitaciones` (
  `id` int(11) NOT NULL,
  `cant_camas_simples` int(11) DEFAULT NULL,
  `cant_camas_doble` int(11) DEFAULT NULL,
  `valor_habitacion` int(11) DEFAULT NULL,
  `estado_habitacion` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habitaciones`
--

LOCK TABLES `habitaciones` WRITE;
/*!40000 ALTER TABLE `habitaciones` DISABLE KEYS */;
INSERT INTO `habitaciones` VALUES (1,1,1,500,0),(2,3,1,800,0),(3,2,1,600,0),(4,2,1,600,0),(5,4,2,1400,0),(6,2,2,750,1);
/*!40000 ALTER TABLE `habitaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horarios_reserva`
--

DROP TABLE IF EXISTS `horarios_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horarios_reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `horarios_servicio_id` int(11) NOT NULL,
  `reserva_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_horarios_reserva_horarios_servicio1_idx` (`horarios_servicio_id`),
  KEY `fk_horarios_reserva_reserva1_idx` (`reserva_id`),
  CONSTRAINT `fk_horarios_reserva_horarios_servicio1` FOREIGN KEY (`horarios_servicio_id`) REFERENCES `horarios_servicio` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_horarios_reserva_reserva1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='Grupo de servicios a reservar por el cliente\n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios_reserva`
--

LOCK TABLES `horarios_reserva` WRITE;
/*!40000 ALTER TABLE `horarios_reserva` DISABLE KEYS */;
INSERT INTO `horarios_reserva` VALUES (1,4,52),(2,7,54),(3,4,59),(4,7,61),(5,4,78),(6,7,80),(7,4,86),(8,7,88),(10,8,23),(11,2,25),(14,13,32),(15,4,34),(16,13,35);
/*!40000 ALTER TABLE `horarios_reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horarios_servicio`
--

DROP TABLE IF EXISTS `horarios_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horarios_servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `servicio_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_horarios_servicio_servicio1_idx` (`servicio_id`),
  CONSTRAINT `fk_horarios_servicio_servicio1` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Configuración de horarios de los servicios\n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios_servicio`
--

LOCK TABLES `horarios_servicio` WRITE;
/*!40000 ALTER TABLE `horarios_servicio` DISABLE KEYS */;
INSERT INTO `horarios_servicio` VALUES (1,'10:00:00','12:00:00',4),(2,'10:00:00','12:00:00',4),(3,'12:00:00','16:00:00',4),(4,'08:00:00','09:00:00',4),(5,'09:00:00','10:00:00',4),(6,'11:00:00','12:00:00',4),(7,'08:00:00','10:00:00',6),(8,'10:00:00','12:00:00',6),(9,'17:00:00','19:00:00',6),(13,'07:00:00','09:00:00',8),(14,'09:00:00','11:00:00',8),(15,'17:00:00','19:00:00',8),(16,'19:00:00','21:00:00',8),(17,'12:00:00','15:00:00',3),(18,'20:00:00','23:59:00',3);
/*!40000 ALTER TABLE `horarios_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mercaderia`
--

DROP TABLE IF EXISTS `mercaderia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mercaderia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `precio_unitario` float NOT NULL,
  `cant_stock` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mercaderia`
--

LOCK TABLES `mercaderia` WRITE;
/*!40000 ALTER TABLE `mercaderia` DISABLE KEYS */;
INSERT INTO `mercaderia` VALUES (1,'Azucar',15.5,8),(2,'Yerba kilo',55,10),(3,'Banana kilo',20,3),(4,'Manzana kilo',30,4),(5,'Pan kilo',24,13),(6,'Gaseosa 1/2 litro',15,55);
/*!40000 ALTER TABLE `mercaderia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `vista_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_perfil_vista1_idx` (`vista_id`),
  CONSTRAINT `fk_perfil_vista1` FOREIGN KEY (`vista_id`) REFERENCES `vista` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Tipos de Perfil configurados';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'Administrador',1),(2,'Informes',2),(3,'usuario_web',3);
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_reserva` datetime NOT NULL,
  `fecha_desde` datetime DEFAULT NULL,
  `fecha_hasta` datetime DEFAULT NULL,
  `cant_personas` int(11) NOT NULL,
  `estado_reserva_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `valor_total` float DEFAULT NULL,
  `servicio_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reserva_estado_reserva1_idx` (`estado_reserva_id`),
  KEY `fk_reserva_cliente1_idx` (`cliente_id`),
  KEY `fk_reserva_servicio1_idx` (`servicio_id`),
  CONSTRAINT `fk_reserva_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_reserva_estado_reserva1` FOREIGN KEY (`estado_reserva_id`) REFERENCES `estado_reserva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reserva_servicio1` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='Reserva de servicios \n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES (22,'2016-10-02 12:40:38','2016-09-30 00:00:00','2016-10-04 00:00:00',4,4,30,4000,1),(23,'2016-10-02 12:40:38','2016-10-02 00:00:00','2016-10-03 00:00:00',4,2,30,240,6),(24,'2016-10-02 13:50:22','2016-10-02 00:00:00','2016-10-02 00:00:00',2,1,35,160,3),(25,'2016-10-02 13:50:22','2016-10-02 00:00:00','2016-10-02 00:00:00',2,2,35,100,4),(31,'2016-10-02 15:07:10','2016-10-02 00:00:00','2016-10-02 00:00:00',4,3,32,320,3),(32,'2016-10-02 15:07:10','2016-10-02 00:00:00','2016-10-03 00:00:00',2,5,32,800,8),(33,'2016-10-02 18:53:55','2016-10-02 00:00:00','2016-10-04 00:00:00',4,3,36,2400,1),(34,'2016-10-02 18:53:55','2016-10-20 00:00:00','2016-10-25 00:00:00',3,1,36,150,4),(35,'2016-10-02 18:53:55','2016-03-18 00:00:00','2016-10-03 00:00:00',2,3,36,400,8),(36,'2016-10-14 08:49:25','2016-10-20 00:00:00','2016-10-23 00:00:00',4,3,30,9672,2),(37,'2016-10-14 11:11:18','2016-03-18 00:00:00','2016-03-23 00:00:00',4,3,30,9672,2),(38,'2016-10-23 15:03:52','2016-10-23 15:03:52','2016-10-23 15:03:52',3,3,36,150,4),(39,'2016-10-23 15:40:59','2016-10-23 15:40:59','2016-10-23 15:40:59',4,3,36,320,3),(40,'2016-10-23 15:48:00','2016-10-26 15:48:00','2016-10-26 15:48:00',3,3,36,150,5),(41,'2016-10-23 15:48:40','2016-10-24 15:48:40','2016-10-26 15:48:40',2,4,36,1200,1),(42,'2016-10-23 15:49:15','2016-10-27 15:49:15','2016-10-27 15:49:15',4,4,36,120,6),(43,'2016-10-23 15:49:41','2016-10-23 15:49:41','2016-10-23 15:49:41',3,4,36,5487.96,8),(44,'2016-10-23 15:50:04','2016-10-24 15:50:04','2016-10-26 15:50:04',5,3,36,4050,2);
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas_habitaciones`
--

DROP TABLE IF EXISTS `reservas_habitaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservas_habitaciones` (
  `reserva_id` int(11) NOT NULL,
  `habitaciones_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `fk_reservas_habitaciones_reserva1_idx` (`reserva_id`),
  KEY `fk_reservas_habitaciones_habitaciones1_idx` (`habitaciones_id`),
  CONSTRAINT `fk_reservas_habitaciones_habitaciones1` FOREIGN KEY (`habitaciones_id`) REFERENCES `habitaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservas_habitaciones_reserva1` FOREIGN KEY (`reserva_id`) REFERENCES `reserva` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservas_habitaciones`
--

LOCK TABLES `reservas_habitaciones` WRITE;
/*!40000 ALTER TABLE `reservas_habitaciones` DISABLE KEYS */;
INSERT INTO `reservas_habitaciones` VALUES (37,2,1),(37,1,2),(44,4,3),(44,6,4);
/*!40000 ALTER TABLE `reservas_habitaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(512) DEFAULT NULL,
  `valor_unitario` float NOT NULL,
  `max_plazas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Servicios disponibles';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

LOCK TABLES `servicio` WRITE;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` VALUES (1,'Camping','Alquiler de carpas. Servicios de electricidad, agua caliente, sanitarios y acceso a la pileta de natación, museo, área de juegos y cancha de futbol',200,20),(2,'Posada','Alojamiento para dos o mas personas. Servicio de limpieza, tv y aire acondicionado. ',1,21),(3,'Restaurant','Cena/Almuerzo postre incluido. Cubiertos y servicio de cantina.',80,200),(4,'Cabalgata','Recorrido de senderos. Reconocimiento de huellas. Una hora de navegación',50,5),(5,'Pesca',NULL,50,6),(6,'Paseo Nautico','Uso de embarcación. Guía de embarcación',30,8),(7,'Parrilla',NULL,10,10),(8,'Guia Pesca',NULL,1829.32,2),(9,'Largadero de Lancha',NULL,20,1),(10,'Proveduria','Consumo de mercaderia dentro del establecimiento',0,0);
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios_reservables`
--

DROP TABLE IF EXISTS `servicios_reservables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicios_reservables` (
  `servicio_id` int(11) NOT NULL,
  `tiempo_confirmacion` time DEFAULT NULL,
  `minimo_senia` float DEFAULT NULL,
  PRIMARY KEY (`servicio_id`),
  KEY `fk_servicios_reservables_servicio1_idx` (`servicio_id`),
  CONSTRAINT `fk_servicios_reservables_servicio1` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Configuracion para servicios reservables\n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios_reservables`
--

LOCK TABLES `servicios_reservables` WRITE;
/*!40000 ALTER TABLE `servicios_reservables` DISABLE KEYS */;
INSERT INTO `servicios_reservables` VALUES (1,'23:59:00',NULL),(2,'23:59:00',NULL),(3,'01:00:00',NULL),(4,'01:00:00',NULL),(5,'01:00:00',NULL),(6,'01:00:00',NULL),(8,'01:00:00',NULL);
/*!40000 ALTER TABLE `servicios_reservables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_pago`
--

DROP TABLE IF EXISTS `tipo_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `interes` varchar(45) DEFAULT NULL,
  `cant_cuotas` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Tipos de pagos disponibles\n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_pago`
--

LOCK TABLES `tipo_pago` WRITE;
/*!40000 ALTER TABLE `tipo_pago` DISABLE KEYS */;
INSERT INTO `tipo_pago` VALUES (1,'Efectivo','0',NULL),(2,'Debito Maestro','0','1'),(3,'Debito Visa','0','1'),(4,'Banco Patagonia','10','12'),(5,'Naranja','0','3'),(6,'Banco Nacion','8','6'),(7,'Nuevo Banco Chaco','5','12');
/*!40000 ALTER TABLE `tipo_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `clave` varchar(45) DEFAULT NULL,
  `perfil_id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  UNIQUE KEY `idusuario_UNIQUE` (`idusuario`),
  KEY `fk_usuario_perfil1_idx` (`perfil_id`),
  KEY `fk_usuario_cliente1_idx` (`cliente_id`),
  CONSTRAINT `fk_usuario_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `fk_usuario_perfil1` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Usuarios del sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','admin',1,NULL),(2,'usuario','usuario',2,35),(3,'usuarioweb','1234',3,30),(8,'pepe','1234',3,36);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vista`
--

DROP TABLE IF EXISTS `vista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_plantilla` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Vistas disponibles';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vista`
--

LOCK TABLES `vista` WRITE;
/*!40000 ALTER TABLE `vista` DISABLE KEYS */;
INSERT INTO `vista` VALUES (1,'base_admin.html.twig'),(2,'base_usuario.html.twig'),(3,'base_web.html.twig');
/*!40000 ALTER TABLE `vista` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-23 21:13:42
