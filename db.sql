/*
SQLyog Professional v12.5.1 (32 bit)
MySQL - 10.4.27-MariaDB : Database - webservis
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`webservis` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `webservis`;

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `tahun` year(4) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_beli` float NOT NULL,
  `harga_jual` float NOT NULL,
  `kategori` int(3) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `buku` */

insert  into `buku`(`id`,`judul`,`penulis`,`tahun`,`penerbit`,`cover`,`stok`,`harga_beli`,`harga_jual`,`kategori`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Mencari Cahaya','Ki Anom',2014,'BitRead','',100,20000,30000,1,'2022-07-06 22:48:29','2022-07-06 22:48:29',NULL),
(2,'Laskar Pelangi','Andrea Hirata',2010,'Bentang','',1000,35000,40000,1,'2022-07-06 22:49:04','2022-07-06 22:49:04',NULL),
(3,'Naruto','Kisimoto',2008,'Jepang','',100,55000,60000,3,'2022-07-25 22:17:19','2022-07-25 22:17:19',NULL),
(5,'Matematika Diskret','Anom',2022,'Gramedia','',1000,100000,120000,2,'2022-07-26 22:51:05','2022-07-26 22:51:05',NULL),
(6,'Mahabharata','Nyoman S. Pandit',2018,'Gramedia','',100,95000,100000,1,'2022-09-04 22:21:00','2022-09-04 22:21:00',NULL),
(7,'Mahabharata','Nyoman S. Pandit',2018,'Gramedia','',100,95000,100000,1,'2022-09-04 22:42:33','2022-09-04 22:42:33',NULL),
(11,'Ayah','Andrea Hirata',2014,'Bentang','',50,65000,70000,1,'2022-09-23 21:48:38','2022-09-23 21:48:38',NULL),
(12,'Boruto','Masasi Kisimoto',2017,'Granedia','',100,50000,60000,3,'2022-09-23 21:48:38','2022-09-23 21:48:38',NULL),
(13,'Cepat Pinter Berhitung Matematika','Dharma',2020,'Andi','',100,20000,25000,2,'2022-09-23 21:48:38','2022-09-23 21:48:38',NULL),
(14,'Kungfu Boy','Nyoamn S. Pandit',2018,'Gramedia','',100,95000,100000,1,'2022-09-23 21:55:43','2022-09-23 21:55:43',NULL),
(15,'Kungfu Boy','Nyoamn S. Pandit',2018,'Gramedia','./uploads/buku/1663944962.jpeg',100,95000,100000,1,'2022-09-23 21:56:02','2022-09-23 21:56:02',NULL),
(16,'Ayah','Andrea Hirata',2014,'Bentang','',50,65000,70000,1,'2022-09-23 21:56:36','2022-09-23 21:56:36',NULL),
(19,'SIWEB','Anom',2022,'Andi','./uploads/buku/1669910859.jpg',100,85000,100000,2,'2022-12-01 23:07:39','2022-12-01 23:07:39',NULL);

/*Table structure for table `galeri` */

DROP TABLE IF EXISTS `galeri`;

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `path` varchar(150) NOT NULL,
  `size` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `galeri` */

insert  into `galeri`(`id`,`filename`,`type`,`path`,`size`) values 
(1,'1664985983.png','image/png','./uploads/galeri/1664985983.png',516.03),
(2,'1664985984.jpeg','image/jpeg','./uploads/galeri/1664985984.jpeg',159.77);

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kategori` */

insert  into `kategori`(`id`,`nama_kategori`) values 
(1,'Novel'),
(2,'Buku Pelajaran'),
(3,'Komik');

/*Table structure for table `keys` */

DROP TABLE IF EXISTS `keys`;

CREATE TABLE `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `keys` */

insert  into `keys`(`id`,`user_id`,`key`,`level`,`ignore_limits`,`is_private_key`,`ip_addresses`,`date_created`) values 
(1,1,'ncp123',1,0,0,NULL,1);

/*Table structure for table `limits` */

DROP TABLE IF EXISTS `limits`;

CREATE TABLE `limits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `limits` */

insert  into `limits`(`id`,`uri`,`count`,`hour_started`,`api_key`) values 
(1,'uri:buku/index:get',7,1667315623,'ncp123');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`username`,`password`) values 
(1,'Administrator','admin','f5d054006e805e467697b3ca8651429006c8f1cad95413d2eb89469fa520d3cb0fa875b898fcd8b2b8278f662d29884822391ac176f6462ae2825871fbd4128d');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
