-- --------------------------------------------------------

--
-- Table structure for table `detailstockentries`
--
USE `gsi-track`;

DROP TABLE IF EXISTS `detailstockentries`;
CREATE TABLE IF NOT EXISTS `detailstockentries` (
  `idtrack` varchar(21) NOT NULL,
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `serialnum` varchar(40) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `stockentries`
--

DROP TABLE IF EXISTS `stockentries`;
CREATE TABLE IF NOT EXISTS `stockentries` (
  `idtrack` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `idpurchaseorder` varchar(21) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Pesanan Pelanggan';


USE `gsi`;


--
-- Table structure for table `detailstockentries`
--

DROP TABLE IF EXISTS `detailstockentries`;
CREATE TABLE IF NOT EXISTS `detailstockentries` (
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `serialnum` varchar(40) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`iddetail`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `stockentries`
--

DROP TABLE IF EXISTS `stockentries`;
CREATE TABLE IF NOT EXISTS `stockentries` (
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `idpurchaseorder` varchar(21) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Pesanan Pelanggan';


