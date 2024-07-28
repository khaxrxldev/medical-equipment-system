-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: ppkm_db_clean
-- ------------------------------------------------------
-- Server version	8.4.1

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
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applications` (
  `applicationId` varchar(100) NOT NULL,
  `applicationQuantity` int DEFAULT NULL,
  `applicationStartDate` date DEFAULT NULL,
  `applicationEndDate` date DEFAULT NULL,
  `applicationRentPrice` decimal(8,2) DEFAULT NULL,
  `applicationMedicLetter` longblob,
  `applicationStatus` varchar(100) DEFAULT NULL,
  `clientId` varchar(100) DEFAULT NULL,
  `staffId` varchar(100) DEFAULT NULL,
  `equipmentId` varchar(100) DEFAULT NULL,
  `adminNotiStatus` tinyint(1) DEFAULT NULL,
  `clientNotiStatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`applicationId`),
  UNIQUE KEY `application_unique` (`clientId`,`staffId`,`equipmentId`),
  KEY `applications_equipment_FK` (`equipmentId`),
  CONSTRAINT `applications_clients_FK` FOREIGN KEY (`clientId`) REFERENCES `clients` (`clientId`),
  CONSTRAINT `applications_equipment_FK` FOREIGN KEY (`equipmentId`) REFERENCES `equipment` (`equipmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `clientId` varchar(100) NOT NULL,
  `clientName` varchar(100) DEFAULT NULL,
  `clientEmail` varchar(100) DEFAULT NULL,
  `clientPhoneNo` varchar(100) DEFAULT NULL,
  `clientAddress` varchar(100) DEFAULT NULL,
  `clientJob` varchar(100) DEFAULT NULL,
  `clientCancerType` varchar(100) DEFAULT NULL,
  `clientMembership` varchar(100) DEFAULT NULL,
  `clientPassword` varchar(100) DEFAULT NULL,
  `clientIcNumber` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`clientId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment` (
  `equipmentId` varchar(100) NOT NULL,
  `equipmentName` varchar(100) DEFAULT NULL,
  `equipmentBuyDate` date DEFAULT NULL,
  `equipmentBuyPrice` decimal(8,2) DEFAULT NULL,
  `equipmentRentPrice` decimal(8,2) DEFAULT NULL,
  `equipmentQuantity` int DEFAULT NULL,
  `equipmentSponsor` varchar(100) DEFAULT NULL,
  `equipmentImageName` varchar(100) DEFAULT NULL,
  `equipmentImage` longblob,
  PRIMARY KEY (`equipmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment`
--

LOCK TABLES `equipment` WRITE;
/*!40000 ALTER TABLE `equipment` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `paymentId` varchar(100) NOT NULL,
  `paymentAmount` decimal(8,2) DEFAULT NULL,
  `paymentReceipt` longblob,
  `paymentStatus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `paymentDate` date DEFAULT NULL,
  `applicationId` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`paymentId`),
  UNIQUE KEY `payment_unique` (`applicationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `return_models`
--

DROP TABLE IF EXISTS `return_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `return_models` (
  `returnId` varchar(100) NOT NULL,
  `returnDate` date DEFAULT NULL,
  `returnCondition` varchar(100) DEFAULT NULL,
  `returnEvidence` longblob,
  `applicationId` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`returnId`),
  UNIQUE KEY `return_unique` (`applicationId`),
  CONSTRAINT `return_models_applications_FK` FOREIGN KEY (`applicationId`) REFERENCES `applications` (`applicationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `return_models`
--

LOCK TABLES `return_models` WRITE;
/*!40000 ALTER TABLE `return_models` DISABLE KEYS */;
/*!40000 ALTER TABLE `return_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff` (
  `staffId` varchar(100) NOT NULL,
  `staffName` varchar(100) DEFAULT NULL,
  `staffEmail` varchar(100) DEFAULT NULL,
  `staffPhoneNo` varchar(100) DEFAULT NULL,
  `staffAddress` varchar(100) DEFAULT NULL,
  `staffRole` varchar(100) DEFAULT NULL,
  `staffPassword` varchar(100) DEFAULT NULL,
  `staffIcNumber` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`staffId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ppkm_db_clean'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-25 16:40:11
