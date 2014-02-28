<?php

require_once('config/lang/eng.php');
//require_once('tcpdf.php');

// extend TCPF with custom functions


class MYPDF extends TCPDF {

	private $data;
	private $detaildata;
	private $headernames;
	private $headerwidths;
	
	// Load table data from file
	public function LoadData($data, array $detaildata) {
		// Read file lines
		$this->data = $data;
		$this->detaildata = $detaildata;
	}

	// Colored table
	public function ColoredTable() {
		// Colors, line width and bold font
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		$this->SetFontSize(10);
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		$this->SetFontSize(10);
		
		// Data
		$fill = 0;
		$counter=0;
		$iditem='';
		$this->SetXY(10, 52);
		for($i=0;$i<10;$i++) {
			if ($i<count($this->detaildata)) {
				$row=$this->detaildata[$i];
				$counter+=1;
				$this->Cell($this->headerwidths[0], 6, $counter, 'LRB', 0, 'C', $fill);
				$this->Cell($this->headerwidths[1], 6, $row['itemname'], 'LRB', 0, 'L', $fill);
				$this->Cell($this->headerwidths[2], 6, $row['qty'], 'LRB', 1, 'R', $fill);
			} else {
				$this->Cell($this->headerwidths[0], 6, ' ', 'LRB', 0, 'C', $fill);
				$this->Cell($this->headerwidths[1], 6, ' ', 'LRB', 0, 'L', $fill);
				$this->Cell($this->headerwidths[2], 6, ' ', 'LRB', 0, 'C', $fill);
				$this->ln();
			}
		}
		$this->Cell(array_sum($this->headerwidths), 0, '', 'T');
	}
	
	public function header()
	{
		$this->master();
	}
	
	public function master()
	{
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
	
		$this->setFontSize(20);
		$this->setXY(100, 10);
		$this->Cell(105, 10, 'Surat Jalan Manual', 'LTR', 1, 'C');
		$this->SetFontSize(10);
		$this->setXY(100, 20);
		$this->Cell(22, 5, 'Tanggal SJ', 'LT');
		$this->SetFont('', '');
		$this->Cell(40, 5, $this->data->idatetime, 'LTR', 0, 'C');
		$this->SetFont('', 'B');
		//$this->setXY(100, 27);
		$this->Cell(20, 5, 'Nomor SJ', 'LTR');
		$this->SetFont('', '');
		$this->Cell(23, 5, $this->data->regnum, 'LTR', 1, 'C');
		
		$this->SetFont('', 'B');
		$this->Cell(35, 5, 'Nama Penerima', 'LTR');
		$this->SetFont('', '');
		$this->Cell(80, 5, $this->data->receivername, 'LTR');
		$this->SetFont('', 'B');
		$this->Cell(30, 5, 'Telp Penerima', 'LTR');
		$this->SetFont('', '');
		$this->Cell(50, 5, $this->data->receiverphone, 'LTR', 1);
		
		$this->SetFont('', 'B');
		$this->Cell(35, 5, 'Alamat Penerima', 'LTR');
		$this->SetFont('', '');
		$this->Cell(160, 5, $this->data->receiveraddress, 'LTR', 1);
		$this->SetFont('', 'B');
		$this->Cell(35, 5, 'Info Kendaraan', 'LTRB');
		$this->SetFont('', '');
		$this->Cell(160, 5, $this->data->vehicleinfo, 'LTRB', 1);
		
		$this->ln(5);
		$this->setFontSize(12);
		$this->SetFont('', 'B');
		$this->headernames = array('No', 'Nama Barang', 'Jumlah');
		$this->headerwidths = array(15, 160, 20);
		for($i = 0; $i < count($this->headernames); ++$i) {
			$this->Cell($this->headerwidths[$i], 7, $this->headernames[$i], 1, 0, 'C');
		}
		/*$this->Cell(15, 7, 'No', 'LTRB', 0, 'C');
		$this->Cell(160, 7, 'Nama Barang', 'LTRB', 0, 'C');
		$this->Cell(20, 7, 'Jumlah', 'LTRB', 0 , 'C');*/
		
		
	} 	
}



// create new PDF document
$pagesize = array(140, 215);
$pageorientation = 'L';
$pdf = new MYPDF($pageorientation, PDF_UNIT, $pagesize, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(lookup::UserNameFromUserID(Yii::app()->user->id));
$pdf->SetTitle('Surat Jalan Manual');
$pdf->SetSubject('SJM');
$pdf->SetKeywords('SJM');

//$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->LoadData($model, $detailmodel);


$pdf->AddPage();
$pdf->ColoredTable();

//$pdf->master();
// print colored table

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('BTBP'.idmaker::getDateTime().'.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
?>

