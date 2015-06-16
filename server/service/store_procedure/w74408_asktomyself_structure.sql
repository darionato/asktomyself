-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.83-0ubuntu3


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema w74408_asktomyself
--

CREATE DATABASE IF NOT EXISTS w74408_asktomyself;
USE w74408_asktomyself;

DROP TABLE IF EXISTS `w74408_asktomyself`.`askme_categories`;
CREATE TABLE  `w74408_asktomyself`.`askme_categories` (
  `id_category` int(10) unsigned NOT NULL auto_increment,
  `desc` varchar(30) NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_category`),
  KEY `users` USING BTREE (`id_user`),
  CONSTRAINT `fk_categories_to_users` FOREIGN KEY (`id_user`) REFERENCES `askme_users` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `w74408_asktomyself`.`askme_key_settings`;
CREATE TABLE  `w74408_asktomyself`.`askme_key_settings` (
  `id_setting` int(4) NOT NULL auto_increment,
  `desc` varchar(20) NOT NULL,
  `type_value` int(1) NOT NULL COMMENT '1 = numeric 2 = text',
  PRIMARY KEY  (`id_setting`),
  UNIQUE KEY `desc` (`desc`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
INSERT INTO `w74408_asktomyself`.`askme_key_settings` VALUES  (1,'time_out_ask',1),
 (2,'last_category',1),
 (3,'invert',1),
 (4,'dowload_image',1);

DROP TABLE IF EXISTS `w74408_asktomyself`.`askme_log`;
CREATE TABLE  `w74408_asktomyself`.`askme_log` (
  `id_user` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `id_log` int(4) NOT NULL,
  PRIMARY KEY  (`id_user`,`id_log`,`date`),
  CONSTRAINT `fk_log_to_users` FOREIGN KEY (`id_user`) REFERENCES `askme_users` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `w74408_asktomyself`.`askme_questions`;
CREATE TABLE  `w74408_asktomyself`.`askme_questions` (
  `date` datetime NOT NULL,
  `id_word` int(10) unsigned NOT NULL,
  `result` tinyint(1) NOT NULL,
  KEY `order_by_date` (`date`),
  KEY `words` (`id_word`),
  CONSTRAINT `fk_questions_to_words` FOREIGN KEY (`id_word`) REFERENCES `askme_words` (`id_word`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `w74408_asktomyself`.`askme_settings`;
CREATE TABLE  `w74408_asktomyself`.`askme_settings` (
  `id_user` int(10) unsigned NOT NULL,
  `id_setting` int(4) NOT NULL,
  `numeric_value` int(11) default NULL,
  `text_value` varchar(20) default NULL,
  PRIMARY KEY  (`id_user`,`id_setting`),
  CONSTRAINT `fk_settings_to_users` FOREIGN KEY (`id_user`) REFERENCES `askme_users` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `w74408_asktomyself`.`askme_type_log`;
CREATE TABLE  `w74408_asktomyself`.`askme_type_log` (
  `id_log` int(4) unsigned NOT NULL auto_increment,
  `desc` varchar(20) NOT NULL,
  PRIMARY KEY  (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
INSERT INTO `w74408_asktomyself`.`askme_type_log` VALUES  (1,'Login'),
 (2,'Word asked'),
 (3,'Got answer'),
 (4,'Add word'),
 (5,'Word asked'),
 (6,'Add word failed');

DROP TABLE IF EXISTS `w74408_asktomyself`.`askme_users`;
CREATE TABLE  `w74408_asktomyself`.`askme_users` (
  `name` varchar(30) collate utf8_bin NOT NULL,
  `pass` varchar(30) collate utf8_bin NOT NULL,
  `id_user` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id_user`),
  UNIQUE KEY `Index_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `w74408_asktomyself`.`askme_words`;
CREATE TABLE  `w74408_asktomyself`.`askme_words` (
  `from` varchar(60) NOT NULL,
  `to` varchar(60) NOT NULL,
  `id_category` int(10) unsigned NOT NULL,
  `id_word` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id_word`),
  KEY `id_category` (`id_category`),
  CONSTRAINT `fk_words_to_categories` FOREIGN KEY (`id_category`) REFERENCES `askme_categories` (`id_category`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
