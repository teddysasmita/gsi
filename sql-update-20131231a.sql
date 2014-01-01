USE `gsi`;

-- --------------------------------------------------------

--
-- Table structure for table `detailinputinventorytakings`
--

DROP TABLE IF EXISTS `detailinputinventorytakings`;
CREATE TABLE IF NOT EXISTS `detailinputinventorytakings` (
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `idwarehouse` varchar(21) NOT NULL,
  `qty` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`iddetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Input Stok Opname';

-- --------------------------------------------------------

--
-- Table structure for table `inputinventorytakings`
--

DROP TABLE IF EXISTS `inputinventorytakings`;
CREATE TABLE IF NOT EXISTS `inputinventorytakings` (
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idinventorytaking` varchar(21) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Input Stok Opname';

-- --------------------------------------------------------

--
-- Table structure for table `inventorytakings`
--

DROP TABLE IF EXISTS `inventorytakings`;
CREATE TABLE IF NOT EXISTS `inventorytakings` (
  `id` varchar(21) NOT NULL,
  `operationlabel` varchar(10) NOT NULL,
  `idatetime` varchar(21) NOT NULL,
  `status` char(1) NOT NULL,
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Stok Opname';

