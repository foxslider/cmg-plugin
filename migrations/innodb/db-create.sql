/* ============================= FoxSlider ================================================== */

--
-- Table structure for table `fxs_slider`
--

DROP TABLE IF EXISTS `fxs_slider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fxs_slider` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullPage` tinyint(1) NOT NULL DEFAULT 0,
  `width` smallint(6) DEFAULT NULL,
  `height` smallint(6) DEFAULT NULL,
  `slideWidth` smallint(6) DEFAULT NULL,
  `slideHeight` smallint(6) DEFAULT NULL,
  `scrollAuto` tinyint(1) NOT NULL DEFAULT 0,
  `scrollType` smallint(6) NOT NULL DEFAULT 0,
  `circular` tinyint(1) NOT NULL DEFAULT 0,  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fxs_slide`
--

DROP TABLE IF EXISTS `fxs_slide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fxs_slide` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sliderId` bigint(20) NOT NULL,  
  `imageId` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` smallint(6) NOT NULL DEFAULT '0',
  `content` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fxs_slide_1` (`sliderId`),
  KEY `fk_fxs_slide_2` (`imageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=0;

--
-- Constraints for table `fxs_slide`
--
ALTER TABLE `fxs_slide`
	ADD CONSTRAINT `fk_fxs_slide_1` FOREIGN KEY (`sliderId`) REFERENCES `fxs_slider` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `fk_fxs_slide_2` FOREIGN KEY (`imageId`) REFERENCES `cmg_core_file` (`id`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS=1;