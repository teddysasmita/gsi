<?php

//
//require_once('tcpdf.php');

// extend TCPF with custom functions


class MYPDF extends TCPDF {

	private $data;
	private $detaildata;
	private $headernames;
	private $headerwidths;
	
	public $pageorientation;
	public $pagesize;
	
	// Load table data from file
	public function LoadData($data, array $detaildata) {
		// Read file lines
		$this->data = $data;
		$this->detaildata = $detaildata;
		$this->headernames = array('No', 'Nama Barang', 'Nomor Seri', 'Gdg', 'Keterangan');
		$this->headerwidths = array(10, 70, 40, 10, 65);
	}

	// Colored table
	public function ColoredTable() {
		// Colors, line width and bold font
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('helvetica', 'B');
		$this->SetFontSize(10);
		
		// Data
		$fill = 0;
		$counter=0;
		$iditem='';
		$this->SetXY(1, 38);
		if (count($this->detaildata) <= 8)
			$maxrows = 10;
		else
			$maxrows = count($this->detaildata);		
		for($i=0;$i<$maxrows;$i++) {
			if ($i<count($this->detaildata)) {
				$row=$this->detaildata[$i];
				$counter+=1;
				$ih = $this->getStringHeight($this->headerwidths[4],$row['remark'],
						false, true, 2);
				$oh = $this->getStringHeight($this->headerwidths[1],lookup::ItemNameFromItemID($row['iditem']),
						false, true, 2);
				if ($ih < $oh ) $ih = $oh;
				if ($ih < 6) $ih = 6;
				$this->Cell($this->headerwidths[0], $ih, $counter, 'LR', 0, 'C', $fill);
				$this->MultiCell($this->headerwidths[1], 0, lookup::ItemNameFromItemID($row['iditem']), 
					'LR', 'L', false, 0);
				//$this->Cell($this->headerwidths[1], $ih, lookup::ItemNameFromItemID($row['iditem']), 
				//		'LR', 0, 'L', $fill);
				$this->Cell($this->headerwidths[2], $ih, $row['serialnum'], 'LR', 0, 'L', $fill);
				$this->Cell($this->headerwidths[3], $ih, lookup::WarehouseNameFromWarehouseID($this->data['idwarehouse']), 
						'LR', 0, 'C', $fill);
				$this->MultiCell($this->headerwidths[4], 0, $row['remark'], 'LR', 'L',
						false, 1);
				//$this->Cell($this->headerwidths[4], 6, '', 'LR', 1, 'R', $fill);
			} else {
				$this->Cell($this->headerwidths[0], 6, ' ', 'LR', 0, 'C', $fill);
				$this->Cell($this->headerwidths[1], 6, ' ', 'LR', 0, 'L', $fill);
				$this->Cell($this->headerwidths[2], 6, ' ', 'LR', 0, 'R', $fill);
				$this->Cell($this->headerwidths[3], 6, ' ', 'LR', 0, 'R', $fill);
				$this->Cell($this->headerwidths[4], 6, ' ', 'LR', 1, 'R', $fill);
				//$this->ln();
			}
			if (($i > 0) && ($i % 9 == 0))
				//$this->checkPageBreak(6, '');
				$this->Cell(array_sum($this->headerwidths), 0, '', 'T', 1);
		}
		//$this->Cell(array_sum($this->headerwidths), 0, '', 'T');
	}
	
	public function header()
	{
		$this->master();
	}
	
	public function footer()
	{
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('helvetica');
		$this->SetFontSize(10);
		$this->setXY(1, 110);
		$this->Cell(30, 15, 'Mengetahui', 'LTRB', 0, 'C', false,'', 0, false, 'T', 'T');
		$this->Cell(30, 15, 'Dibuat Oleh', 'LTRB', 0, 'C', false,'', 0, false, 'T', 'T');
		$this->Cell(30, 15, 'Yg Menyerahkan', 'LTRB', 0, 'C', false,'', 0, false, 'T', 'T');
		$this->Cell(30, 15, 'Yg Menerima', 'LTRB', 0, 'C', false,'', 0, false, 'T', 'T');
		$this->setFontSize(8);
		$this->MultiCell(30, 15, '(Gudang) Yg Menyerahkan', 'LTRB', 'C', false, 0);
		$this->MultiCell(30, 15, '(Gudang) Yg Menerima', 'LTRB', 'C', false, 0);
		$this->Cell(15, 5, 'Halaman', 'LTR', 1, 'C', false,'', 0, false, 'T', 'T');
		$this->setX(181);
		$this->Cell(15, 5, $this->PageNo().' dari ', 'LR', 1, 'C', false,'', 0, false, 'T', 'T');
		$this->setX(181);
		$this->Cell(15, 5, 'total '.trim($this->getAliasNbPages()), 'LRB', 1, 'C', false,'', 0, false, 'T', 'T');
		$this->setX(1);
		$this->setFontSize(10);
		$this->Cell(195, 4, 'TANDA TANGAN, NAMA TERANG, TANGGAL dan JAM MOHON DITULISKAN', 'LTRB', 0, 'C');
	}
	
	public function master()
	{
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		$this->SetCellPadding(0.8);
	
		$this->setFontSize(20);
		$this->setXY(91, 10);
		$this->Cell(105, 10, 'Barang Rusak', 'LTR', 1, 'C');
		$this->SetFontSize(10);
		$this->SetFont('Courier', 'B');
		$this->setXY(91, 20);
		$this->Cell(15, 5, 'Tgl', 'LT', 0, 'C');
		$tempdate = explode('/', $this->data->idatetime);
		$this->data->idatetime = $tempdate[2].'/'.$tempdate[1].'/'.$tempdate[0];
		$this->Cell(45, 5, $this->data->idatetime, 'LTR', 0, 'C');
		$this->Cell(20, 5, 'No Urut', 'LTR', 0, 'C');
		$this->Cell(25, 5, $this->data->regnum, 'LTR', 1, 'C');
		$this->Cell(195, 5, '', 'T',0);
		//$this->setXY(100, 27);
		
		$this->ln(5);
		$this->setFontSize(12);
		$this->SetFont('helvetica', 'B');
		
		for($i = 0; $i < count($this->headernames); ++$i) {
			$this->Cell($this->headerwidths[$i], 7, $this->headernames[$i], 1, 0, 'C');
		}
		/*$this->Cell(15, 7, 'No', 'LTRB', 0, 'C');
		$this->Cell(160, 7, 'Nama Barang', 'LTRB', 0, 'C');
		$this->Cell(20, 7, 'Jumlah', 'LTRB', 0 , 'C');*/
		
		
	} 	
}

function execute($model, $detailmodel) {

	// create new PDF document
	
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(215, 140), true, 'UTF-8', false);
	$pdf->pagesize = array(215, 140);
	$pdf->pageorientation = 'L';
	$pdf->setPageOrientation($pdf->pageorientation, TRUE);	
	
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor(lookup::UserNameFromUserID(Yii::app()->user->id));
	$pdf->SetTitle('Barang Rusak');
	$pdf->SetSubject('Barang Rusak');
	$pdf->SetKeywords('Barang Rusak');
	
	//$pdf->setPrintHeader(false);
	//$pdf->setPrintFooter(false);
	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	//set margins
	$pdf->SetMargins(1, 38, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(0);
	$pdf->SetFooterMargin(0);
	
	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, 20);
	
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	//set some language-dependent strings
	//$pdf->setLanguageArray($l);
	
	// ---------------------------------------------------------
	
	// set font
	$pdf->SetFont('helvetica', '', 12);
	
	// add a page
	$pdf->LoadData($model, $detailmodel);
	
	$pdf->AddPage($pdf->pageorientation, $pdf->pagesize);
	//$pdf->AddPage();
	
	$pdf->ColoredTable();
	//$pdf->master();
	// print colored table
	
	// ---------------------------------------------------------
	
	//Close and output PDF document
	$pdf->Output('DR'.idmaker::getDateTime().'.pdf', 'D');
}
//============================================================+
// END OF FILE                                                
//============================================================+
?>

