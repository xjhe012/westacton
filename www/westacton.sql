/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 5.6.25-log : Database - westacton!
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`westacton!` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `westacton!`;

/*Table structure for table `gamesession` */

DROP TABLE IF EXISTS `gamesession`;

CREATE TABLE `gamesession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `player_id` int(11) NOT NULL,
  `active` int(11) DEFAULT '0',
  `gamestart_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `gamesession` */

insert  into `gamesession`(`id`,`session_name`,`status`,`player_id`,`active`,`gamestart_time`) values 
(14,'673aab57f9aaa33645dd15b7da08b1f4',1,20,0,'2021-09-27 13:22:43'),
(16,'673aab57f9aaa33645dd15b7da08b1f4',1,23,0,'2021-09-27 13:22:43'),
(21,'673aab57f9aaa33645dd15b7da08b1f4',1,28,0,'2021-09-27 13:22:43');

/*Table structure for table `players` */

DROP TABLE IF EXISTS `players`;

CREATE TABLE `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `energy` int(11) DEFAULT '100',
  `points` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

/*Data for the table `players` */

insert  into `players`(`id`,`name`,`energy`,`points`) values 
(20,'fatz',42,100),
(23,'ferdz',80,0),
(28,'marcus',80,0);

/*Table structure for table `transaction` */

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `transaction` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
