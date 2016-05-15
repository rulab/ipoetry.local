-- MySQL dump 10.13  Distrib 5.7.9, for Win32 (AMD64)
--
-- Host: 10.13.5.174    Database: ipoetry
-- ------------------------------------------------------
-- Server version	5.5.45-log

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
-- Table structure for table `ipoetry_background_images`
--

DROP TABLE IF EXISTS `ipoetry_background_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_background_images` (
  `idipoetry_background_images_id` int(11) NOT NULL,
  `ipoetry_event_idipoetry_event_id` int(11) NOT NULL,
  `ipoetry_poetry_poetry_id` int(11) NOT NULL,
  `ipoetry_poetry_ipoetry_poetry_parent_id` int(11) NOT NULL,
  `ipoetry_background_image` blob,
  `ipoetry_user_group_idipoetry_user_group_id` int(11) NOT NULL,
  PRIMARY KEY (`idipoetry_background_images_id`),
  KEY `fk_ipoetry_background_images_ipoetry_event1_idx` (`ipoetry_event_idipoetry_event_id`),
  KEY `fk_ipoetry_background_images_ipoetry_poetry1_idx` (`ipoetry_poetry_poetry_id`,`ipoetry_poetry_ipoetry_poetry_parent_id`),
  KEY `fk_ipoetry_background_images_ipoetry_user_group1_idx` (`ipoetry_user_group_idipoetry_user_group_id`),
  CONSTRAINT `fk_ipoetry_background_images_ipoetry_event1` FOREIGN KEY (`ipoetry_event_idipoetry_event_id`) REFERENCES `ipoetry_event` (`idipoetry_event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_background_images_ipoetry_poetry1` FOREIGN KEY (`ipoetry_poetry_poetry_id`, `ipoetry_poetry_ipoetry_poetry_parent_id`) REFERENCES `ipoetry_poetry` (`poetry_id`, `ipoetry_poetry_parent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_background_images_ipoetry_user_group1` FOREIGN KEY (`ipoetry_user_group_idipoetry_user_group_id`) REFERENCES `ipoetry_user_group` (`idipoetry_user_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_background_images`
--

LOCK TABLES `ipoetry_background_images` WRITE;
/*!40000 ALTER TABLE `ipoetry_background_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_background_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_classic_authors`
--

DROP TABLE IF EXISTS `ipoetry_classic_authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_classic_authors` (
  `ipoetry_classic_authors_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_classic_authors_name` varchar(255) DEFAULT 'undefined',
  PRIMARY KEY (`ipoetry_classic_authors_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='Список авторов- классиков поэзии,литеруры и т.д.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_classic_authors`
--

LOCK TABLES `ipoetry_classic_authors` WRITE;
/*!40000 ALTER TABLE `ipoetry_classic_authors` DISABLE KEYS */;
INSERT INTO `ipoetry_classic_authors` VALUES (1,'С.Есенин'),(2,'А.Пушкин'),(3,'Б.Пастернак'),(4,'М.Цветаева'),(5,'З.Гипиус');
/*!40000 ALTER TABLE `ipoetry_classic_authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_classic_authors_has_ipoetry_user`
--

DROP TABLE IF EXISTS `ipoetry_classic_authors_has_ipoetry_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_classic_authors_has_ipoetry_user` (
  `ipoetry_classic_authors_has_ipoetry_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_classic_authors_ipoetry_classic_authors_id` int(11) NOT NULL,
  `ipoetry_user_user_id` int(11) NOT NULL,
  `ipoetry_user_ipoetry_user_parent_id` int(11) NOT NULL,
  PRIMARY KEY (`ipoetry_classic_authors_has_ipoetry_user_id`,`ipoetry_classic_authors_ipoetry_classic_authors_id`,`ipoetry_user_user_id`,`ipoetry_user_ipoetry_user_parent_id`),
  KEY `fk_ipoetry_classic_authors_has_ipoetry_user_ipoetry_user1_idx` (`ipoetry_user_user_id`,`ipoetry_user_ipoetry_user_parent_id`),
  KEY `fk_ipoetry_classic_authors_has_ipoetry_user_ipoetry_classic_idx` (`ipoetry_classic_authors_ipoetry_classic_authors_id`),
  CONSTRAINT `fk_ipoetry_classic_authors_has_ipoetry_user_ipoetry_classic_a1` FOREIGN KEY (`ipoetry_classic_authors_ipoetry_classic_authors_id`) REFERENCES `ipoetry_classic_authors` (`ipoetry_classic_authors_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_classic_authors_has_ipoetry_user_ipoetry_user1` FOREIGN KEY (`ipoetry_user_user_id`, `ipoetry_user_ipoetry_user_parent_id`) REFERENCES `ipoetry_user` (`user_id`, `ipoetry_user_parent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_classic_authors_has_ipoetry_user`
--

LOCK TABLES `ipoetry_classic_authors_has_ipoetry_user` WRITE;
/*!40000 ALTER TABLE `ipoetry_classic_authors_has_ipoetry_user` DISABLE KEYS */;
INSERT INTO `ipoetry_classic_authors_has_ipoetry_user` VALUES (1,1,0,0),(2,2,0,0);
/*!40000 ALTER TABLE `ipoetry_classic_authors_has_ipoetry_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_event`
--

DROP TABLE IF EXISTS `ipoetry_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_event` (
  `idipoetry_event_id` int(11) NOT NULL,
  `ipoetry_event_date` datetime DEFAULT NULL,
  `ipoetry_event_place` varchar(1024) DEFAULT 'undefined',
  `ipoetry_event_background_image_id` int(11) DEFAULT '0' COMMENT 'фоновая картинка события',
  `ipoetry_event_user_group_welcome` tinyint(1) DEFAULT '0' COMMENT 'пригласить подписчиков группы на мероприятие',
  `ipoetry_event_description` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`idipoetry_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_event`
--

LOCK TABLES `ipoetry_event` WRITE;
/*!40000 ALTER TABLE `ipoetry_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_poetry`
--

DROP TABLE IF EXISTS `ipoetry_poetry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_poetry` (
  `poetry_id` int(11) NOT NULL,
  `poetry_body` tinytext,
  `poetry_tag_id` int(11) NOT NULL,
  `poetry_rating_id` int(11) NOT NULL,
  `poetry_discuss_id` int(11) NOT NULL,
  `ipoetry_poetry_parent_id` int(11) NOT NULL COMMENT 'если стих передавался несколькими людьми друг другу то это поле для истории стиха',
  `ipoetry_poetry_video_id` int(11) DEFAULT NULL COMMENT 'вложение видео',
  `ipoetry_poetry_photo_id` int(11) DEFAULT '0' COMMENT 'вложение фото',
  `ipoetry_poetry_audio_id` int(11) DEFAULT '0' COMMENT 'вложение аудио',
  `ipoetry_poetry_theme_id` int(11) DEFAULT '0' COMMENT 'Тема стихотворения',
  `ipoetry_background_image_id` int(11) DEFAULT '0' COMMENT 'фоновая картинка',
  `ipoetry_poetry_is_gift` tinyint(1) DEFAULT '0',
  `ipoetry_poetry_description` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`poetry_id`,`ipoetry_poetry_parent_id`),
  KEY `fk_ipoetry_poetry_ipoetry_poetry1_idx` (`ipoetry_poetry_parent_id`),
  CONSTRAINT `fk_ipoetry_poetry_ipoetry_poetry1` FOREIGN KEY (`ipoetry_poetry_parent_id`) REFERENCES `ipoetry_poetry` (`poetry_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_poetry`
--

LOCK TABLES `ipoetry_poetry` WRITE;
/*!40000 ALTER TABLE `ipoetry_poetry` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_poetry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_poetry_tags_relation`
--

DROP TABLE IF EXISTS `ipoetry_poetry_tags_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_poetry_tags_relation` (
  `idipoetry_poetry_tags_relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_tags_idipoetry_tags_id` int(11) NOT NULL,
  `ipoetry_poetry_poetry_id` int(11) NOT NULL,
  `ipoetry_poetry_ipoetry_poetry_parent_id` int(11) NOT NULL,
  PRIMARY KEY (`idipoetry_poetry_tags_relation_id`),
  KEY `fk_ipoetry_poetry_tags_relation_ipoetry_tags1_idx` (`ipoetry_tags_idipoetry_tags_id`),
  KEY `fk_ipoetry_poetry_tags_relation_ipoetry_poetry1_idx` (`ipoetry_poetry_poetry_id`,`ipoetry_poetry_ipoetry_poetry_parent_id`),
  CONSTRAINT `fk_ipoetry_poetry_tags_relation_ipoetry_poetry1` FOREIGN KEY (`ipoetry_poetry_poetry_id`, `ipoetry_poetry_ipoetry_poetry_parent_id`) REFERENCES `ipoetry_poetry` (`poetry_id`, `ipoetry_poetry_parent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_poetry_tags_relation_ipoetry_tags1` FOREIGN KEY (`ipoetry_tags_idipoetry_tags_id`) REFERENCES `ipoetry_tags` (`ipoetry_tags_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_poetry_tags_relation`
--

LOCK TABLES `ipoetry_poetry_tags_relation` WRITE;
/*!40000 ALTER TABLE `ipoetry_poetry_tags_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_poetry_tags_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_tags`
--

DROP TABLE IF EXISTS `ipoetry_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_tags` (
  `ipoetry_tags_id` int(11) NOT NULL,
  `ipoetry_tags_text` varchar(255) DEFAULT 'undefined',
  PRIMARY KEY (`ipoetry_tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_tags`
--

LOCK TABLES `ipoetry_tags` WRITE;
/*!40000 ALTER TABLE `ipoetry_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user`
--

DROP TABLE IF EXISTS `ipoetry_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL DEFAULT 'undefined' COMMENT 'Имя пользователя',
  `user_password` varchar(20) NOT NULL DEFAULT 'undefined' COMMENT 'Пароль',
  `user_lastname` varchar(50) DEFAULT 'undefined',
  `user_email` varchar(255) NOT NULL DEFAULT 'undefined',
  `user_phone_id` int(11) NOT NULL DEFAULT '0',
  `user_photo_id` int(11) NOT NULL DEFAULT '0' COMMENT 'ссылка на фото,аватарку пользователя',
  `user_city_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Город участника',
  `user_age_id` int(11) NOT NULL DEFAULT '0',
  `user_status_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Статус пользователя: просто пользователь,модератор/владелец группы/события,администратор сайта',
  `user_rating_id` int(11) NOT NULL DEFAULT '0' COMMENT 'рейтинг пользователя в системе',
  `user_post_message_id` int(11) NOT NULL DEFAULT '0' COMMENT 'номер комментария в "стене" пользователя',
  `user_poetry_id` int(11) NOT NULL DEFAULT '0' COMMENT 'стихи пользователя',
  `user_event_id` int(11) NOT NULL DEFAULT '0',
  `user_group_id` int(11) NOT NULL DEFAULT '0' COMMENT 'к каким группам принадлежит пользователь',
  `ipoetry_user_parent_id` int(11) NOT NULL DEFAULT '0',
  `ipoetry_user_website_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`ipoetry_user_parent_id`),
  KEY `user_name_index` (`user_name`) USING BTREE,
  KEY `user_password_index` (`user_password`) USING BTREE,
  KEY `user_password` (`user_name`,`user_password`),
  KEY `user_name_lastname_email` (`user_name`,`user_lastname`,`user_email`(191)),
  KEY `fk_ipoetry_user_ipoetry_user1_idx` (`ipoetry_user_parent_id`),
  KEY `fk_ipoetry_user_ipoetry_user_photo1_idx` (`user_photo_id`),
  KEY `fk_ipoetry_user_ipoetry_user_city1_idx` (`user_city_id`),
  KEY `fk_ipoetry_user_ipoetry_user_age1_idx` (`user_age_id`),
  KEY `fk_ipoetry_user_ipoetry_user_website1_idx` (`ipoetry_user_website_id`),
  KEY `fk_ipoetry_user_ipoetry_user_phone_idx` (`user_phone_id`),
  KEY `fk_ipoetry_user_ipoetry_user_status1_idx` (`user_status_id`),
  CONSTRAINT `fk_ipoetry_user_ipoetry_user` FOREIGN KEY (`ipoetry_user_parent_id`) REFERENCES `ipoetry_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_ipoetry_user_age` FOREIGN KEY (`user_age_id`) REFERENCES `ipoetry_user_age` (`ipoetry_user_age_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_ipoetry_user_city` FOREIGN KEY (`user_city_id`) REFERENCES `ipoetry_user_city` (`ipoetry_city_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_ipoetry_user_phone` FOREIGN KEY (`user_phone_id`) REFERENCES `ipoetry_user_phone` (`ipoetry_user_phone_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_ipoetry_user_photo` FOREIGN KEY (`user_photo_id`) REFERENCES `ipoetry_user_photo` (`ipoetry_user_photo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_ipoetry_user_status` FOREIGN KEY (`user_status_id`) REFERENCES `ipoetry_user_status` (`ipoetry_user_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_ipoetry_user_website` FOREIGN KEY (`ipoetry_user_website_id`) REFERENCES `ipoetry_user_website` (`ipoetry_user_website_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 PACK_KEYS=1 COMMENT='Сущность пользователь, отражает зарегистрированного пользователя.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user`
--

LOCK TABLES `ipoetry_user` WRITE;
/*!40000 ALTER TABLE `ipoetry_user` DISABLE KEYS */;
INSERT INTO `ipoetry_user` VALUES (0,'test_user','test_password','undefined','test@mail.ru',0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `ipoetry_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_age`
--

DROP TABLE IF EXISTS `ipoetry_user_age`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_age` (
  `ipoetry_user_age_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_user_age` int(3) DEFAULT NULL,
  PRIMARY KEY (`ipoetry_user_age_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_age`
--

LOCK TABLES `ipoetry_user_age` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_age` DISABLE KEYS */;
INSERT INTO `ipoetry_user_age` VALUES (0,0);
/*!40000 ALTER TABLE `ipoetry_user_age` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_blog_post`
--

DROP TABLE IF EXISTS `ipoetry_user_blog_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_blog_post` (
  `ipoetry_user_blog_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_user_blog_post_text` tinytext,
  `ipoetry_user_blog_post_theme` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ipoetry_user_blog_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_blog_post`
--

LOCK TABLES `ipoetry_user_blog_post` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_blog_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_user_blog_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_city`
--

DROP TABLE IF EXISTS `ipoetry_user_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_city` (
  `ipoetry_city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) NOT NULL DEFAULT 'undefined' COMMENT 'Название города',
  PRIMARY KEY (`ipoetry_city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_city`
--

LOCK TABLES `ipoetry_user_city` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_city` DISABLE KEYS */;
INSERT INTO `ipoetry_user_city` VALUES (0,'undefined');
/*!40000 ALTER TABLE `ipoetry_user_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_event_relation`
--

DROP TABLE IF EXISTS `ipoetry_user_event_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_event_relation` (
  `idipoetry_user_event_relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_event_idipoetry_event_id` int(11) NOT NULL,
  `ipoetry_user_user_id` int(11) NOT NULL,
  PRIMARY KEY (`idipoetry_user_event_relation_id`),
  KEY `fk_ipoetry_user_event_relation_ipoetry_event1_idx` (`ipoetry_event_idipoetry_event_id`),
  KEY `fk_ipoetry_user_event_relation_ipoetry_user1_idx` (`ipoetry_user_user_id`),
  CONSTRAINT `fk_ipoetry_user_event_relation_ipoetry_event1` FOREIGN KEY (`ipoetry_event_idipoetry_event_id`) REFERENCES `ipoetry_event` (`idipoetry_event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_event_relation_ipoetry_user1` FOREIGN KEY (`ipoetry_user_user_id`) REFERENCES `ipoetry_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_event_relation`
--

LOCK TABLES `ipoetry_user_event_relation` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_event_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_user_event_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_group`
--

DROP TABLE IF EXISTS `ipoetry_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_group` (
  `idipoetry_user_group_id` int(11) NOT NULL,
  `ipoetry_user_group_name` varchar(255) DEFAULT 'undefined',
  `ipoetry_user_group_background_image_id` int(11) DEFAULT '0',
  `ipoetry_user_group_description` varchar(1024) DEFAULT NULL,
  `ipoetry_user_group_city_id` int(11) DEFAULT NULL,
  `ipoetry_user_city_ipoetry_city_id` int(11) NOT NULL,
  PRIMARY KEY (`idipoetry_user_group_id`),
  KEY `fk_ipoetry_user_group_ipoetry_user_city1_idx` (`ipoetry_user_city_ipoetry_city_id`),
  CONSTRAINT `fk_ipoetry_user_group_ipoetry_user_city1` FOREIGN KEY (`ipoetry_user_city_ipoetry_city_id`) REFERENCES `ipoetry_user_city` (`ipoetry_city_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_group`
--

LOCK TABLES `ipoetry_user_group` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_has_ipoetry_user_blog_post`
--

DROP TABLE IF EXISTS `ipoetry_user_has_ipoetry_user_blog_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_has_ipoetry_user_blog_post` (
  `ipoetry_user_has_ipoetry_user_blog_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_user_user_id` int(11) NOT NULL,
  `ipoetry_user_ipoetry_user_parent_id` int(11) NOT NULL,
  `ipoetry_user_blog_post_ipoetry_user_blog_post_id` int(11) NOT NULL,
  PRIMARY KEY (`ipoetry_user_has_ipoetry_user_blog_post_id`),
  KEY `fk_ipoetry_user_has_ipoetry_user_blog_post_ipoetry_user_blo_idx` (`ipoetry_user_blog_post_ipoetry_user_blog_post_id`),
  KEY `fk_ipoetry_user_has_ipoetry_user_blog_post_ipoetry_user1_idx` (`ipoetry_user_user_id`,`ipoetry_user_ipoetry_user_parent_id`),
  CONSTRAINT `fk_ipoetry_user_has_ipoetry_user_blog_post_ipoetry_user1` FOREIGN KEY (`ipoetry_user_user_id`, `ipoetry_user_ipoetry_user_parent_id`) REFERENCES `ipoetry_user` (`user_id`, `ipoetry_user_parent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_has_ipoetry_user_blog_post_ipoetry_user_blog_1` FOREIGN KEY (`ipoetry_user_blog_post_ipoetry_user_blog_post_id`) REFERENCES `ipoetry_user_blog_post` (`ipoetry_user_blog_post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_has_ipoetry_user_blog_post`
--

LOCK TABLES `ipoetry_user_has_ipoetry_user_blog_post` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_has_ipoetry_user_blog_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_user_has_ipoetry_user_blog_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_phone`
--

DROP TABLE IF EXISTS `ipoetry_user_phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_phone` (
  `ipoetry_user_phone_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_user_phone` char(11) NOT NULL DEFAULT 'undefined',
  PRIMARY KEY (`ipoetry_user_phone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_phone`
--

LOCK TABLES `ipoetry_user_phone` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_phone` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_user_phone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_photo`
--

DROP TABLE IF EXISTS `ipoetry_user_photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_photo` (
  `ipoetry_user_photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_photo` blob,
  `user_photo_url` varchar(2083) NOT NULL DEFAULT 'undefined',
  PRIMARY KEY (`ipoetry_user_photo_id`),
  KEY `photo_url` (`user_photo_url`(191)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='фотография,аватарка пользователя';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_photo`
--

LOCK TABLES `ipoetry_user_photo` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_photo` DISABLE KEYS */;
INSERT INTO `ipoetry_user_photo` VALUES (0,NULL,'undefined');
/*!40000 ALTER TABLE `ipoetry_user_photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_poetry_relation`
--

DROP TABLE IF EXISTS `ipoetry_user_poetry_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_poetry_relation` (
  `ipoetry_user_poetry_relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_poetry_poetry_id` int(11) NOT NULL,
  `ipoetry_poetry_ipoetry_poetry_parent_id` int(11) NOT NULL,
  `ipoetry_user_user_id` int(11) NOT NULL,
  PRIMARY KEY (`ipoetry_user_poetry_relation_id`),
  KEY `fk_ipoetry_user_poetry_relation_ipoetry_poetry1_idx` (`ipoetry_poetry_poetry_id`,`ipoetry_poetry_ipoetry_poetry_parent_id`),
  KEY `fk_ipoetry_user_poetry_relation_ipoetry_user1_idx` (`ipoetry_user_user_id`),
  CONSTRAINT `fk_ipoetry_user_poetry_relation_ipoetry_poetry1` FOREIGN KEY (`ipoetry_poetry_poetry_id`, `ipoetry_poetry_ipoetry_poetry_parent_id`) REFERENCES `ipoetry_poetry` (`poetry_id`, `ipoetry_poetry_parent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_poetry_relation_ipoetry_user1` FOREIGN KEY (`ipoetry_user_user_id`) REFERENCES `ipoetry_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_poetry_relation`
--

LOCK TABLES `ipoetry_user_poetry_relation` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_poetry_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_user_poetry_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_status`
--

DROP TABLE IF EXISTS `ipoetry_user_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_status` (
  `ipoetry_user_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_user_status` varchar(45) DEFAULT 'undefined',
  PRIMARY KEY (`ipoetry_user_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_status`
--

LOCK TABLES `ipoetry_user_status` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_status` DISABLE KEYS */;
INSERT INTO `ipoetry_user_status` VALUES (0,'initial'),(1,'registered');
/*!40000 ALTER TABLE `ipoetry_user_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `ipoetry_user_uroom`
--

DROP TABLE IF EXISTS `ipoetry_user_uroom`;
/*!50001 DROP VIEW IF EXISTS `ipoetry_user_uroom`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `ipoetry_user_uroom` AS SELECT 
 1 AS `user_name`,
 1 AS `user_lastname`,
 1 AS `user_city`,
 1 AS `user_age`,
 1 AS `user_website`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ipoetry_user_usergroup_relation`
--

DROP TABLE IF EXISTS `ipoetry_user_usergroup_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_usergroup_relation` (
  `ipoetry_user_usergroup_relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_user_group_idipoetry_user_group_id` int(11) NOT NULL,
  `ipoetry_user_user_id` int(11) NOT NULL,
  PRIMARY KEY (`ipoetry_user_usergroup_relation_id`),
  KEY `fk_ipoetry_user_usergroup_relation_ipoetry_user_group1_idx` (`ipoetry_user_group_idipoetry_user_group_id`),
  KEY `fk_ipoetry_user_usergroup_relation_ipoetry_user1_idx` (`ipoetry_user_user_id`),
  CONSTRAINT `fk_ipoetry_user_usergroup_relation_ipoetry_user1` FOREIGN KEY (`ipoetry_user_user_id`) REFERENCES `ipoetry_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipoetry_user_usergroup_relation_ipoetry_user_group1` FOREIGN KEY (`ipoetry_user_group_idipoetry_user_group_id`) REFERENCES `ipoetry_user_group` (`idipoetry_user_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_usergroup_relation`
--

LOCK TABLES `ipoetry_user_usergroup_relation` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_usergroup_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipoetry_user_usergroup_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipoetry_user_website`
--

DROP TABLE IF EXISTS `ipoetry_user_website`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipoetry_user_website` (
  `ipoetry_user_website_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipoetry_user_website` varchar(2083) DEFAULT 'undefined',
  PRIMARY KEY (`ipoetry_user_website_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipoetry_user_website`
--

LOCK TABLES `ipoetry_user_website` WRITE;
/*!40000 ALTER TABLE `ipoetry_user_website` DISABLE KEYS */;
INSERT INTO `ipoetry_user_website` VALUES (0,'undefined');
/*!40000 ALTER TABLE `ipoetry_user_website` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'ipoetry'
--

--
-- Dumping routines for database 'ipoetry'
--
/*!50003 DROP PROCEDURE IF EXISTS `get_ipoetry_user_authors_list` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `get_ipoetry_user_authors_list`(IN ipoetry_user_id INT(11),OUT authors_list VARCHAR(255))
    READS SQL DATA
    DETERMINISTIC
BEGIN
SELECT ipoetry_classic_authors_name authors_list from ipoetry_classic_authors ica right join ipoetry_classic_authors_has_ipoetry_user ica_hiu on ica.ipoetry_classic_authors_id=ica_hiu.ipoetry_classic_authors_ipoetry_classic_authors_id where ica_hiu.ipoetry_user_user_id=ipoetry_user_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `ipoetry_user_uroom`
--

/*!50001 DROP VIEW IF EXISTS `ipoetry_user_uroom`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `ipoetry_user_uroom` AS select `iusr`.`user_name` AS `user_name`,`iusr`.`user_lastname` AS `user_lastname`,`iusr_city`.`city_name` AS `user_city`,`iusr_age`.`ipoetry_user_age` AS `user_age`,`iusr_website`.`ipoetry_user_website` AS `user_website` from ((((`ipoetry_user` `iusr` join `ipoetry_user_photo` `iusr_photo` on((`iusr`.`user_photo_id` = `iusr_photo`.`ipoetry_user_photo_id`))) join `ipoetry_user_city` `iusr_city` on((`iusr`.`user_city_id` = `iusr_city`.`ipoetry_city_id`))) join `ipoetry_user_age` `iusr_age` on((`iusr`.`user_age_id` = `iusr_age`.`ipoetry_user_age_id`))) join `ipoetry_user_website` `iusr_website` on((`iusr`.`user_age_id` = `iusr_website`.`ipoetry_user_website`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-05 11:40:28
