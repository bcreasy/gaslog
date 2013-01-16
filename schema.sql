-- MySQL dump 10.13  Distrib 5.5.29, for FreeBSD9.1 (i386)
--
-- ------------------------------------------------------
-- Server version	5.5.29

--
-- Table structure for table `gas_log`
--

CREATE TABLE `gas_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `brand` varchar(255) NOT NULL DEFAULT 'Valero',
  `octane` tinyint(3) unsigned NOT NULL DEFAULT '87',
  `pricepergallon` double DEFAULT '0',
  `volume` double DEFAULT '0',
  `totalprice` float DEFAULT NULL,
  `odometer` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
