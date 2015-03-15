SET FOREIGN_KEY_CHECKS=0;

--
-- Table structure for table `fxs_slider`
--

DROP TABLE IF EXISTS `fxs_slider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fxs_slider` (
  `slider_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `slider_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slider_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slider_width` smallint(6) DEFAULT NULL,
  `slider_height` smallint(6) DEFAULT NULL,
  `slider_slide_width` smallint(6) DEFAULT NULL,
  `slider_slide_height` smallint(6) DEFAULT NULL,
  `slider_full_page` tinyint(1) NOT NULL DEFAULT 0,
  `slider_scroll_auto` tinyint(1) NOT NULL DEFAULT 0,
  `slider_scroll_manual` tinyint(1) NOT NULL DEFAULT 0,
  `slider_circular` tinyint(1) NOT NULL DEFAULT 0,  
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fxs_slide`
--

DROP TABLE IF EXISTS `fxs_slide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fxs_slide` (
  `slide_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `slide_slider` bigint(20) NOT NULL,  
  `slide_image` bigint(20) DEFAULT NULL,
  `slide_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slide_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slide_content` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `slide_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slide_order` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`slide_id`),
  KEY `fk_slide_1` (`slide_slider`),
  KEY `fk_slide_2` (`slide_image`),
  CONSTRAINT `fk_slide_1` FOREIGN KEY (`slide_slider`) REFERENCES `fxs_slider` (`slider_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_slide_2` FOREIGN KEY (`slide_image`) REFERENCES `cmg_file` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=1;