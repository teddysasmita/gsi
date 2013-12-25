SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `gsi`
--
USE `gsi`;

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesmemos`
--

DROP TABLE IF EXISTS `detailpurchasesmemos`;
CREATE TABLE IF NOT EXISTS `detailpurchasesmemos` (
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `qty` double NOT NULL,
  `prevprice` double NOT NULL,
  `price` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`iddetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

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

--
-- Dumping data for table `detailstockentries`
--

-- --------------------------------------------------------

--
-- Table structure for table `itemprofits`
--

DROP TABLE IF EXISTS `itemprofits`;
CREATE TABLE IF NOT EXISTS `itemprofits` (
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchasesmemos`
--

DROP TABLE IF EXISTS `purchasesmemos`;
CREATE TABLE IF NOT EXISTS `purchasesmemos` (
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `idpurchaseorder` varchar(21) NOT NULL,
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  `idwarehouse` varchar(21) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

DROP TABLE IF EXISTS `warehouses`;
CREATE TABLE IF NOT EXISTS `warehouses` (
  `id` varchar(21) NOT NULL,
  `code` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `ipaddr` varchar(15) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `gsi-track`
--
USE `gsi-track`;

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesmemos`
--

DROP TABLE IF EXISTS `detailpurchasesmemos`;
CREATE TABLE IF NOT EXISTS `detailpurchasesmemos` (
  `idtrack` varchar(21) NOT NULL,
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `qty` double NOT NULL,
  `prevprice` double NOT NULL,
  `price` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detailstockentries`
--

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
-- Table structure for table `itemprofits`
--

DROP TABLE IF EXISTS `itemprofits`;
CREATE TABLE IF NOT EXISTS `itemprofits` (
  `idtrack` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchasesmemos`
--

DROP TABLE IF EXISTS `purchasesmemos`;
CREATE TABLE IF NOT EXISTS `purchasesmemos` (
  `idtrack` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `idpurchaseorder` varchar(21) NOT NULL,
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

DROP TABLE IF EXISTS `warehouses`;
CREATE TABLE IF NOT EXISTS `warehouses` (
  `idtrack` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `code` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `ipaddr` varchar(15) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

