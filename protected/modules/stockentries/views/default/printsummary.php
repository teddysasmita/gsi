<?php
//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2010-08-08
//
// Description : Example 011 for TCPDF class
//               Colored Table
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */

require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

	private $headerData;
	private $detailData;
	
	// Load table data from file
	public function LoadData($id) {
		// Read file lines
		$sqlheader="select * from stockentries where id='$id'";
		$sqldetail="select * from detailstockentries where id='$id'";
		$this->headerData=Yii::app()->db->createCommand($sqlheader)->queryAll();
		$this->detailData=Yii::app()->db->createCommand($sqldetail)->queryAll();
	}

	// Colored table
	public function ColoredTable() {
		// Colors, line width and bold font
		$this->SetFillColor(255, 0, 0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		$w = array(120, 60);
		
		$this->headerData=array('Nama Barang', 'Nomor Serial');
		$num_headers = count($this->headerData);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $this->headerData[$i], 1, 0, 'C', 1);
		}
		
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		foreach($this->detailData as $row) {
			$this->Cell($w[0], 6, lookup::ItemNameFromItemID($row['iditem']), 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 6, $row['serialnum'], 'LR', 0, 'L', $fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(lookup::UserNameFromUserID(Yii::app()->user->id));
$pdf->SetTitle('Laporan Penerimaan Barang');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->setHeaderData(false, 0, 'Gunung Sari Intan', 
	'Laporan Penerimaan Barang', 'Testing');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
$pdf->AddPage();

$pdf->LoadData($model->id);

// print colored table
$pdf->ColoredTable();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_011.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
?>

