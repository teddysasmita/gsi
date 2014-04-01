
CREATE TABLE IF NOT EXISTS `salespersons` (
  `id` varchar(21) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '0',
  `startdate` varchar(19) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Pelanggan';


CREATE TABLE IF NOT EXISTS `salespersons` (
  `idtrack` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '0',
  `startdate` varchar(19) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Pelanggan';

