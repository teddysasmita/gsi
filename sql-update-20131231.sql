USE `gsi`;

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesinvoices`
--

DROP TABLE IF EXISTS `detailpurchasesinvoices`;
CREATE TABLE IF NOT EXISTS `detailpurchasesinvoices` (
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `qty` double NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `idorder` varchar(21) NOT NULL,
  `iddetailorder` varchar(21) NOT NULL,
  PRIMARY KEY (`iddetail`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pesanan Pelanggan';

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
  `discount` double NOT NULL,
  `prevcost1` double NOT NULL DEFAULT '0',
  `cost1` double NOT NULL DEFAULT '0',
  `prevcost2` double NOT NULL DEFAULT '0',
  `cost2` double NOT NULL DEFAULT '0',
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`iddetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesorders`
--

DROP TABLE IF EXISTS `detailpurchasesorders`;
CREATE TABLE IF NOT EXISTS `detailpurchasesorders` (
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `idunit` varchar(21) DEFAULT NULL,
  `qty` double NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `cost1` double NOT NULL DEFAULT '0',
  `cost2` double NOT NULL DEFAULT '0',
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`iddetail`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesorders2`
--

DROP TABLE IF EXISTS `detailpurchasesorders2`;
CREATE TABLE IF NOT EXISTS `detailpurchasesorders2` (
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `vouchername` varchar(100) NOT NULL,
  `vouchervalue` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`iddetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Detil Biaya Pemesanan Pembelian';

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesorders3`
--

DROP TABLE IF EXISTS `detailpurchasesorders3`;
CREATE TABLE IF NOT EXISTS `detailpurchasesorders3` (
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `idexpense` varchar(21) NOT NULL,
  `qty` double NOT NULL,
  `price` double NOT NULL,
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`iddetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasespayments`
--

DROP TABLE IF EXISTS `detailpurchasespayments`;
CREATE TABLE IF NOT EXISTS `detailpurchasespayments` (
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `idpurchaseorder` varchar(21) NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `paid` double NOT NULL,
  `amount` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`iddetail`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pembayaran Pemasok';

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesreceipts`
--

DROP TABLE IF EXISTS `detailpurchasesreceipts`;
CREATE TABLE IF NOT EXISTS `detailpurchasesreceipts` (
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `idunit` varchar(21) DEFAULT NULL,
  `idwarehouse` varchar(21) NOT NULL,
  `idpurchaseorder` varchar(21) NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `leftqty` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`iddetail`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `financepayments`
--

DROP TABLE IF EXISTS `financepayments`;
CREATE TABLE IF NOT EXISTS `financepayments` (
  `id` varchar(21) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `receipient` varchar(100) NOT NULL,
  `method` char(1) NOT NULL,
  `duedate` char(19) DEFAULT NULL,
  `amount` double NOT NULL,
  `remark` text,
  `status` char(1) NOT NULL DEFAULT '0',
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Keuangan Pembayaran';

-- --------------------------------------------------------

--
-- Table structure for table `purchasesinvoices`
--

DROP TABLE IF EXISTS `purchasesinvoices`;
CREATE TABLE IF NOT EXISTS `purchasesinvoices` (
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `purchasesmemos`
--

DROP TABLE IF EXISTS `purchasesmemos`;
CREATE TABLE IF NOT EXISTS `purchasesmemos` (
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` varchar(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `idpurchaseorder` varchar(21) NOT NULL,
  `total` double NOT NULL,
  `discount` double NOT NULL,
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchasesorders`
--

DROP TABLE IF EXISTS `purchasesorders`;
CREATE TABLE IF NOT EXISTS `purchasesorders` (
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `rdatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT '0',
  `paystatus` varchar(5) NOT NULL DEFAULT '0',
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `purchasespayments`
--

DROP TABLE IF EXISTS `purchasespayments`;
CREATE TABLE IF NOT EXISTS `purchasespayments` (
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL,
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Pembayaran Pemasok';

-- --------------------------------------------------------

--
-- Table structure for table `purchasesreceipts`
--

DROP TABLE IF EXISTS `purchasesreceipts`;
CREATE TABLE IF NOT EXISTS `purchasesreceipts` (
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `vehicleinfo` varchar(50) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `donum` varchar(50) NOT NULL,
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Terima Barang dari Pemasok';


USE `gsi-track`;

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesinvoices`
--

DROP TABLE IF EXISTS `detailpurchasesinvoices`;
CREATE TABLE IF NOT EXISTS `detailpurchasesinvoices` (
  `idtrack` varchar(21) NOT NULL,
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `qty` double NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `idorder` varchar(21) NOT NULL,
  `iddetailorder` varchar(21) NOT NULL,
  PRIMARY KEY (`idtrack`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pesanan Pelanggan';

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
  `discount` double NOT NULL,
  `prevcost1` double NOT NULL,
  `cost1` double NOT NULL,
  `prevcost2` double NOT NULL,
  `cost2` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesorders`
--

DROP TABLE IF EXISTS `detailpurchasesorders`;
CREATE TABLE IF NOT EXISTS `detailpurchasesorders` (
  `idtrack` varchar(21) NOT NULL,
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `idunit` varchar(21) NOT NULL,
  `qty` double NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `cost1` double NOT NULL DEFAULT '0',
  `cost2` double NOT NULL DEFAULT '0',
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesorders2`
--

DROP TABLE IF EXISTS `detailpurchasesorders2`;
CREATE TABLE IF NOT EXISTS `detailpurchasesorders2` (
  `idtrack` varchar(21) NOT NULL,
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `vouchername` varchar(100) NOT NULL,
  `vouchervalue` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Detil Biaya Pemesanan Pembelian';

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesorders3`
--

DROP TABLE IF EXISTS `detailpurchasesorders3`;
CREATE TABLE IF NOT EXISTS `detailpurchasesorders3` (
  `idtrack` varchar(21) NOT NULL,
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `idexpense` varchar(21) NOT NULL,
  `qty` double NOT NULL,
  `price` double NOT NULL,
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
-- Table structure for table `detailpurchasespayments`
--

DROP TABLE IF EXISTS `detailpurchasespayments`;
CREATE TABLE IF NOT EXISTS `detailpurchasespayments` (
  `idtrack` varchar(21) NOT NULL,
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `idpurchaseorder` varchar(21) NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `paid` double NOT NULL,
  `amount` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pembayaran Pemasok';

-- --------------------------------------------------------

--
-- Table structure for table `detailpurchasesreceipts`
--

DROP TABLE IF EXISTS `detailpurchasesreceipts`;
CREATE TABLE IF NOT EXISTS `detailpurchasesreceipts` (
  `idtrack` varchar(21) NOT NULL,
  `idwarehouse` varchar(21) NOT NULL,
  `idpurchaseorder` varchar(21) NOT NULL,
  `iddetail` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `iditem` varchar(21) NOT NULL,
  `idunit` varchar(21) DEFAULT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `leftqty` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Detil Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `financepayments`
--

DROP TABLE IF EXISTS `financepayments`;
CREATE TABLE IF NOT EXISTS `financepayments` (
  `idtrack` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `receipient` varchar(100) NOT NULL,
  `method` char(1) NOT NULL,
  `duedate` char(19) DEFAULT NULL,
  `amount` double NOT NULL,
  `remark` text,
  `status` char(1) NOT NULL DEFAULT '0',
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Keuangan Pembayaran';

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
  `total` double NOT NULL,
  `discount` double NOT NULL,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchasesorders`
--

DROP TABLE IF EXISTS `purchasesorders`;
CREATE TABLE IF NOT EXISTS `purchasesorders` (
  `idtrack` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `rdatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL,
  `paystatus` varchar(10) NOT NULL DEFAULT '0',
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Pesanan Pelanggan';

-- --------------------------------------------------------

--
-- Table structure for table `purchasespayments`
--

DROP TABLE IF EXISTS `purchasespayments`;
CREATE TABLE IF NOT EXISTS `purchasespayments` (
  `idtrack` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL,
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Pembayaran Pemasok';

-- --------------------------------------------------------

--
-- Table structure for table `purchasesreceipts`
--

DROP TABLE IF EXISTS `purchasesreceipts`;
CREATE TABLE IF NOT EXISTS `purchasesreceipts` (
  `idtrack` varchar(21) NOT NULL,
  `id` varchar(21) NOT NULL,
  `regnum` varchar(12) NOT NULL,
  `idatetime` char(19) NOT NULL,
  `idsupplier` varchar(21) NOT NULL,
  `donum` varchar(50) NOT NULL,
  `vehicleinfo` varchar(50) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `remark` text,
  `userlog` varchar(21) NOT NULL,
  `datetimelog` char(19) NOT NULL,
  `action` char(1) NOT NULL,
  `userlogtrack` varchar(21) NOT NULL,
  `datetimelogtrack` char(19) NOT NULL,
  PRIMARY KEY (`idtrack`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabel Terima Barang dari Pemasok';

USE `gsi-auth`;

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

DROP TABLE IF EXISTS `AuthItem`;
CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('AA1', 1, 'Paramater Program', NULL, NULL),
('AA1-Append', 0, 'Paramater Program-Tambah Data', NULL, 'N;'),
('AA1-Delete', 0, 'Paramater Program-Hapus Data', NULL, 'N;'),
('AA1-List', 0, 'Paramater Program-Lihat Daftar', NULL, 'N;'),
('AA1-Update', 0, 'Paramater Program-Ubah Data', NULL, 'N;'),
('AA2', 1, 'Konfigurasi Server', NULL, NULL),
('AA2-Append', 0, 'Konfigurasi Server-Tambah Data', NULL, 'N;'),
('AA2-Delete', 0, 'Konfigurasi Server-Hapus Data', NULL, 'N;'),
('AA2-List', 0, 'Konfigurasi Server-Lihat Daftar', NULL, 'N;'),
('AA2-Update', 0, 'Konfigurasi Server-Ubah Data', NULL, 'N;'),
('AA4', 1, 'Administrasi Komputer Pengguna', NULL, NULL),
('AA4-Append', 0, 'Administrasi Komputer Pengguna-Tambah Data', NULL, 'N;'),
('AA4-Delete', 0, 'Administrasi Komputer Pengguna-Hapus Data', NULL, 'N;'),
('AA4-List', 0, 'Administrasi Komputer Pengguna-Lihat Daftar', NULL, 'N;'),
('AA4-Update', 0, 'Administrasi Komputer Pengguna-Ubah Data', NULL, 'N;'),
('AB1', 1, 'Master Data Pelanggan', NULL, NULL),
('AB1-Append', 0, 'Master Data Pelanggan-Tambah Data', NULL, 'N;'),
('AB1-Delete', 0, 'Master Data Pelanggan-Hapus Data', NULL, 'N;'),
('AB1-List', 0, 'Master Data Pelanggan-Lihat Daftar', NULL, 'N;'),
('AB1-Update', 0, 'Master Data Pelanggan-Ubah Data', NULL, 'N;'),
('AB2', 1, 'Master Data Pemasok', NULL, NULL),
('AB2-Append', 0, 'Master Data Pemasok-Tambah Data', NULL, 'N;'),
('AB2-Delete', 0, 'Master Data Pemasok-Hapus Data', NULL, 'N;'),
('AB2-List', 0, 'Master Data Pemasok-Lihat Daftar', NULL, 'N;'),
('AB2-Update', 0, 'Master Data Pemasok-Ubah Data', NULL, 'N;'),
('AB3', 1, 'Master Data Barang Dagang', NULL, NULL),
('AB3-Append', 0, 'Master Data Barang Dagang-Tambah Data', NULL, 'N;'),
('AB3-Delete', 0, 'Master Data Barang Dagang-Hapus Data', NULL, 'N;'),
('AB3-List', 0, 'Master Data Barang Dagang-Lihat Daftar', NULL, 'N;'),
('AB3-Update', 0, 'Master Data Barang Dagang-Ubah Data', NULL, 'N;'),
('AB4', 1, 'Master Data Gudang', NULL, NULL),
('AB4-Append', 0, 'Master Data Gudang-Tambah Data', NULL, 'N;'),
('AB4-Delete', 0, 'Master Data Gudang-Hapus Data', NULL, 'N;'),
('AB4-List', 0, 'Master Data Gudang-Lihat Daftar', NULL, 'N;'),
('AB4-Update', 0, 'Master Data Gudang-Ubah Data', NULL, 'N;'),
('AB5', 1, 'Master Data Tenaga Penjualan', NULL, NULL),
('AB5-Append', 0, 'Master Data Tenaga Penjualan-Tambah Data', NULL, 'N;'),
('AB5-Delete', 0, 'Master Data Tenaga Penjualan-Hapus Data', NULL, 'N;'),
('AB5-List', 0, 'Master Data Tenaga Penjualan-Lihat Daftar', NULL, 'N;'),
('AB5-Update', 0, 'Master Data Tenaga Penjualan-Ubah Data', NULL, 'N;'),
('AC1', 1, 'Proses Pemesanan Penjualan', NULL, NULL),
('AC1-Append', 0, 'Proses Pemesanan Penjualan-Tambah Data', NULL, 'N;'),
('AC1-Delete', 0, 'Proses Pemesanan Penjualan-Hapus Data', NULL, 'N;'),
('AC1-List', 0, 'Proses Pemesanan Penjualan-Lihat Daftar', NULL, 'N;'),
('AC1-Update', 0, 'Proses Pemesanan Penjualan-Ubah Data', NULL, 'N;'),
('AC1a', 1, 'Detil Proses Pemesanan Penjualan', NULL, NULL),
('AC1a-Append', 0, 'Detil Proses Pemesanan Penjualan-Tambah Data', NULL, 'N;'),
('AC1a-Delete', 0, 'Detil Proses Pemesanan Penjualan-Hapus Data', NULL, 'N;'),
('AC1a-List', 0, 'Detil Proses Pemesanan Penjualan-Lihat Daftar', NULL, 'N;'),
('AC1a-Update', 0, 'Detil Proses Pemesanan Penjualan-Ubah Data', NULL, 'N;'),
('AC2', 1, 'Proses Pemesanan Barang ke Pemasok', NULL, NULL),
('AC2-Append', 0, 'Proses Pemesanan Barang ke Pemasok-Tambah Data', NULL, 'N;'),
('AC2-Delete', 0, 'Proses Pemesanan Barang ke Pemasok-Hapus Data', NULL, 'N;'),
('AC2-List', 0, 'Proses Pemesanan Barang ke Pemasok-Lihat Daftar', NULL, 'N;'),
('AC2-Update', 0, 'Proses Pemesanan Barang ke Pemasok-Ubah Data', NULL, 'N;'),
('AC20', 1, 'Proses Penjualan Tunai', NULL, NULL),
('AC20-Append', 0, 'Proses Penjualan Tunai-Tambah Data', NULL, 'N;'),
('AC20-Delete', 0, 'Proses Penjualan Tunai-Hapus Data', NULL, 'N;'),
('AC20-List', 0, 'Proses Penjualan Tunai-Lihat Daftar', NULL, 'N;'),
('AC20-Update', 0, 'Proses Penjualan Tunai-Ubah Data', NULL, 'N;'),
('AC2a', 1, 'Detil Pemesanan Barang ke Pemasok', NULL, NULL),
('AC2a-Append', 0, 'Detil Pemesanan Barang ke Pemasok-Tambah Data', NULL, 'N;'),
('AC2a-Delete', 0, 'Detil Pemesanan Barang ke Pemasok-Hapus Data', NULL, 'N;'),
('AC2a-List', 0, 'Detil Pemesanan Barang ke Pemasok-Lihat Daftar', NULL, 'N;'),
('AC2a-Update', 0, 'Detil Pemesanan Barang ke Pemasok-Ubah Data', NULL, 'N;'),
('AC2b', 1, 'Detil Voucher Pemesanan Barang ke Pemasok', NULL, NULL),
('AC2b-Append', 0, 'Detil Voucher Pemesanan Barang ke Pemasok-Tambah Data', NULL, 'N;'),
('AC2b-Delete', 0, 'Detil Voucher Pemesanan Barang ke Pemasok-Hapus Data', NULL, 'N;'),
('AC2b-List', 0, 'Detil Voucher Pemesanan Barang ke Pemasok-Lihat Daftar', NULL, 'N;'),
('AC2b-Update', 0, 'Detil Voucher Pemesanan Barang ke Pemasok-Ubah Data', NULL, 'N;'),
('AC3', 1, 'Proses Terima Kiriman dari Pemasok', NULL, NULL),
('AC3-Append', 0, 'Proses Terima Kiriman dari Pemasok-Tambah Data', NULL, 'N;'),
('AC3-Delete', 0, 'Proses Terima Kiriman dari Pemasok-Hapus Data', NULL, 'N;'),
('AC3-List', 0, 'Proses Terima Kiriman dari Pemasok-Lihat Daftar', NULL, 'N;'),
('AC3-Update', 0, 'Proses Terima Kiriman dari Pemasok-Ubah Data', NULL, 'N;'),
('AC3a', 1, 'Proses Terima Kiriman Barang dari Pemasok', NULL, NULL),
('AC3a-Append', 0, 'Proses Terima Kiriman Barang dari Pemasok-Tambah Data', NULL, 'N;'),
('AC3a-Delete', 0, 'Proses Terima Kiriman Barang dari Pemasok-Hapus Data', NULL, 'N;'),
('AC3a-List', 0, 'Proses Terima Kiriman Barang dari Pemasok-Lihat Daftar', NULL, 'N;'),
('AC3a-Update', 0, 'Proses Terima Kiriman Barang dari Pemasok-Ubah Data', NULL, 'N;'),
('AC4', 1, 'Pembayaran Pemasok', NULL, NULL),
('AC4-Append', 0, 'Pembayaran Pemasok-Tambah Data', NULL, 'N;'),
('AC4-Delete', 0, 'Pembayaran Pemasok-Hapus Data', NULL, 'N;'),
('AC4-List', 0, 'Pembayaran Pemasok-Lihat Daftar', NULL, 'N;'),
('AC4-Update', 0, 'Pembayaran Pemasok-Ubah Data', NULL, 'N;'),
('AC5', 1, 'Penerimaan Barang dari Pemasok', NULL, NULL),
('AC5-Append', 0, 'Penerimaan Barang dari Pemasok-Tambah Data', NULL, 'N;'),
('AC5-Delete', 0, 'Penerimaan Barang dari Pemasok-Hapus Data', NULL, 'N;'),
('AC5-List', 0, 'Penerimaan Barang dari Pemasok-Lihat Daftar', NULL, 'N;'),
('AC5-Update', 0, 'Penerimaan Barang dari Pemasok-Ubah Data', NULL, 'N;'),
('AC5a', 1, 'Detil Penerimaan Barang dari Pemasok', NULL, NULL),
('AC5a-Append', 0, 'Detil Penerimaan Barang dari Pemasok-Tambah Data', NULL, 'N;'),
('AC5a-Delete', 0, 'Detil Penerimaan Barang dari Pemasok-Hapus Data', NULL, 'N;'),
('AC5a-List', 0, 'Detil Penerimaan Barang dari Pemasok-Lihat Daftar', NULL, 'N;'),
('AC5a-Update', 0, 'Detil Penerimaan Barang dari Pemasok-Ubah Data', NULL, 'N;'),
('AC6', 1, 'Memo Pembelian', NULL, NULL),
('AC6-Append', 0, 'Memo Pembelian-Tambah Data', NULL, 'N;'),
('AC6-Delete', 0, 'Memo Pembelian-Hapus Data', NULL, 'N;'),
('AC6-List', 0, 'Memo Pembelian-Lihat Daftar', NULL, 'N;'),
('AC6-Update', 0, 'Memo Pembelian-Ubah Data', NULL, 'N;'),
('AC6a', 1, 'Detil Memo Pembelian', NULL, NULL),
('AC6a-Append', 0, 'Detil Memo Pembelian-Tambah Data', NULL, 'N;'),
('AC6a-Delete', 0, 'Detil Memo Pembelian-Hapus Data', NULL, 'N;'),
('AC6a-List', 0, 'Detil Memo Pembelian-Lihat Daftar', NULL, 'N;'),
('AC6a-Update', 0, 'Detil Memo Pembelian-Ubah Data', NULL, 'N;'),
('AC7', 1, 'Proses Pembayaran ke Pemasok', NULL, NULL),
('AC7-Append', 0, 'Proses Pembayaran ke Pemasok-Tambah Data', NULL, 'N;'),
('AC7-Delete', 0, 'Proses Pembayaran ke Pemasok-Hapus Data', NULL, 'N;'),
('AC7-List', 0, 'Proses Pembayaran ke Pemasok-Lihat Daftar', NULL, 'N;'),
('AC7-Update', 0, 'Proses Pembayaran ke Pemasok-Ubah Data', NULL, 'N;'),
('AC7a', 1, 'Detil Proses Pembayaran ke Pemasok', NULL, NULL),
('AC7a-Append', 0, 'Detil Proses Pembayaran ke Pemasok-Tambah Data', NULL, 'N;'),
('AC7a-Delete', 0, 'Detil Proses Pembayaran ke Pemasok-Hapus Data', NULL, 'N;'),
('AC7a-List', 0, 'Detil Proses Pembayaran ke Pemasok-Lihat Daftar', NULL, 'N;'),
('AC7a-Update', 0, 'Detil Proses Pembayaran ke Pemasok-Ubah Data', NULL, 'N;'),
('Kasir', 2, 'Kasir', NULL, 'N;'),
('Manager', 2, 'Manajer Toko', NULL, 'N;'),
('Warehouse', 2, 'Penjaga gudang', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `AuthItemChild`
--

DROP TABLE IF EXISTS `AuthItemChild`;
CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  KEY `child` (`child`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `AuthItemChild`
--

INSERT INTO `AuthItemChild` (`id`, `parent`, `child`) VALUES
(16, 'Manager', 'Kasir'),
(22, 'AB1', 'AB1-Append'),
(23, 'AB2', 'AB2-Append'),
(24, 'AB3', 'AB3-Append'),
(25, 'AC1', 'AC1-Append'),
(27, 'AC1a', 'AC1a-Append'),
(28, 'AA4', 'AA4-Append'),
(29, 'AC2', 'AC2-Append'),
(30, 'AC2a', 'AC2a-Append'),
(31, 'AC2b', 'AC2b-Append'),
(32, 'AC5', 'AC5-Append'),
(33, 'AC5a', 'AC5a-Append'),
(34, 'AB4', 'AB4-Append'),
(35, 'AC6', 'AC6-Append'),
(36, 'AC6a', 'AC6a-Append'),
(37, 'AB5', 'AB5-Append'),
(38, 'AA1', 'AA1-Append'),
(39, 'AA2', 'AA2-Append'),
(40, 'AC20', 'AC20-Append'),
(41, 'AC7', 'AC7-Append'),
(42, 'AC7a', 'AC7a-Append'),
(43, 'AC3', 'AC3-Append'),
(44, 'AC3a', 'AC3a-Append'),
(46, 'AC4', 'AC4-Append');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;


