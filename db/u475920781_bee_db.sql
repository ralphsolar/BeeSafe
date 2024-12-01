/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.11.9-MariaDB : Database - u475920781_bee_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u475920781_bee_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `u475920781_bee_db`;

/*Table structure for table `fan_status` */

DROP TABLE IF EXISTS `fan_status`;

CREATE TABLE `fan_status` (
  `hive_id` int(11) NOT NULL,
  `ontemp` float DEFAULT NULL,
  `timestamp_on` datetime DEFAULT NULL,
  `offtemp` float DEFAULT NULL,
  `timestamp_off` datetime DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`hive_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `fan_status` */

insert  into `fan_status`(`hive_id`,`ontemp`,`timestamp_on`,`offtemp`,`timestamp_off`,`date`) values 
(25,30,'2024-11-10 03:29:16',0,'2024-11-10 11:03:00','2024-11-10');

/*Table structure for table `hive` */

DROP TABLE IF EXISTS `hive`;

CREATE TABLE `hive` (
  `hive_id` int(9) NOT NULL AUTO_INCREMENT,
  `hive_name` char(255) NOT NULL,
  `location` char(255) NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  PRIMARY KEY (`hive_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `hive` */

insert  into `hive`(`hive_id`,`hive_name`,`location`,`lat`,`lng`) values 
(21,'NARTDI NLUC','Bacnotan',9.82772,8);

/*Table structure for table `sensors` */

DROP TABLE IF EXISTS `sensors`;

CREATE TABLE `sensors` (
  `sensor_id` int(90) NOT NULL AUTO_INCREMENT,
  `hive_id` int(90) DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `windspeed` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`sensor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sensors` */

/*Table structure for table `user_hives` */

DROP TABLE IF EXISTS `user_hives`;

CREATE TABLE `user_hives` (
  `user_hive_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `hive_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_hive_id`),
  KEY `user_hives_ibfk_1` (`user_id`),
  KEY `user_hives_ibfk_2` (`hive_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_hives` */

insert  into `user_hives`(`user_hive_id`,`user_id`,`hive_id`) values 
(10,20,21),
(11,20,21);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(9) NOT NULL AUTO_INCREMENT,
  `username` char(255) NOT NULL,
  `email` char(255) NOT NULL,
  `password` char(255) NOT NULL,
  `fname` char(255) NOT NULL,
  `lname` char(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`email`,`password`,`fname`,`lname`) values 
(34,'samplehehe','ralphjacobsolar4@gmail.com','$2y$10$gztvy3KkJCxRus8QJGqbLu0gcCqUftjqAJU7Aynx5w/4ADFOLrbFG','Ralph','Solar'),
(35,'Ganda','kisstherrose@gmail.com','$2y$10$PcE15uM29RQypqBVGA1NU.pVRxz4LszRhN9Vu2nE8HtUoWRvpVPE2','Kissther','Rose'),
(36,'Yehsjwiwj','hjsjs@bsjs.com','$2y$10$jcxqEG1KPI931XsSKsII9ucVp3LDb8OW7sbn3SMk/fVz1SuoO3lfm','Hsussj','Hshshs'),
(37,'manny_pogi','mhortizuela@dmmmsu.edu.ph','$2y$10$9Z6207J5Qvc3G99ntcbgqOxzYJxbyJHe6v1ym60i.CDQUjdICCHIO','Manny','Hortizuela'),
(38,'shesh','ralphjacobsolar4@gmail.com','$2y$10$eY5h7P3m9RsDcCmp4ztD5u/Et2KdzDR99tl9uau4fMKayYF6HbO66','ralph','solar'),
(39,'apateu','ralphjacobsolar4@gmail.com','$2y$10$1g739toLjjmU9AVArk0zO.YjLPUFtbDI2j2gdL1FbZa1V/gkaMKUu','Apateu','Imnida'),
(40,'lalpuu','ralphjacobsolar4@gmail.com','$2y$10$Ua7QyLKSbGrcySBn7E73eu86rVXmhGdbUJaErrJYKEJSi7fvAL1Y.','Ralph Jacob','Solar'),
(41,'pogi','rsolar16672@student.dmmmsu.edu.ph','$2y$10$7t0u1SroEZMTl6CwGljo2e49Wpz8zFvSvkUPyWOKnL7RxNXETVbeC','Pogi','Pogi'),
(42,'lalpuu','aaaqqa@d.b','$2y$10$BS7nJSR/Jc.aL2V4pL.wieG5rGQ//khyPF7DwjmoAQ/2EWY/TqJkS','aa','aa'),
(43,'hash','rsolar16672@student.dmmmsu.edu.ph','$2y$10$azSKC7SILvYzZOllsizk3OvTqZCyBmS9nPl0YL7c20giMT7U1HyFe','Ralph Jacob','Solar'),
(44,'hash','rsolar16672@student.dmmmsu.edu.ph','$2y$10$HL09UFfrPU1XfPb6TYCwieio.OAT5ICp1kkVjJuVKlASZKa8odgva','Ralph Jacob','Solar'),
(45,'hash','rsolar16672@student.dmmmsu.edu.ph','$2y$10$QpwiMWolvEUUAh8VjdkqAulYoAqW1cNkTYiRd4icazz1IHJzYWPBa','Ralph Jacob','Solar'),
(46,'ralphjacobsolar4@gmail.com','rsolar16672@student.dmmmsu.edu.ph','$2y$10$8WxKqlksOi0P6AgXVsr0leVYAAJ2ZuBNnJobwK0VVo3gEqc1L7XUa','Ralph Jacob','Solar'),
(47,'test','rsolar16672@student.dmmmsu.edu.ph','$2y$10$mKIdHTRNmd8PfnKcqhtf2Os1vFJB3gyRqTgBX.7B5ZBPrAQl/9jJC','Ralph Jacob','Solar'),
(48,'lalpuut','ralphjacobsolar4@gmail.com','$2y$10$Fs6HxynZEnADJ.2KUYosEucD2Ukm0HafJT5JR/pjRtbdczbZouHyu','Ralph Jacob','Solar'),
(49,'Ralph','rsolar16672@student.dmmmsu.edu.ph','$2y$10$kSquyjaibiyC/REMruBXO.tENuzjbn7QAXGEJBmDv56xbcqxNMXQm','Ralph Jacob','Solar'),
(50,'pepito','pepitomanaloto@gmail.com','$2y$10$sxEZ.6sNZlvqMYvcrEy4XOkqSucOPEVsP/MzeUTmnXHAPQ5gC3WZe','Pepito','Manaloto'),
(51,'rar','rar@gmail.com','$2y$10$N58XhxTqoeEvJCohThGZLuLJkoEoI9R76EUTG04nrReEmZtvV5sXq','rar','rar'),
(52,'testh','rsolar16672@student.dmmmsu.edu.ph','$2y$10$hzay6YHhl30sVzYYB3sFNe4/pt5GmHfygAbDhEyULcm3IpxvfZsRu','Ralph Jacob','Solar'),
(53,'warinramos','warinramos@gmail.com','$2y$10$8cxWYmhR/3NovezBJ/SfaOPdB0VZ.nIGvDoGxg5fz0eTDU00.6Dii','warin','ramos'),
(54,'kisstherrose','rose@gmail.com','$2y$10$3ncVemsERqChLad9Kkjvg.yQrKv9oLANmearCcaVql7y8jVm99DZC','kissther','rose'),
(55,'p','rsolar16672@student.dmmmsu.edu.ph','$2y$10$.77kzMz29QQUV7zx/UoBQOTXBqmGIyR1cmZdXQ9lcVrNOaTKzWMyW','p','p'),
(56,'sampleqq','sam@gmail.com','$2y$10$tn2.f4oH12S16tEQKWvZUusqdqvOKQF.eW.lgp.pPppYt7wYJdukm','Sample','QQ');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
