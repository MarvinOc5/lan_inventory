<?php
Class PDFPO extends CI_Controller 
{
	
	
	/********FILE PDF REPORT********/
	public function purchaseorder($purchaseorderid) {
		$this->load->helper('path');
		$this->base = $this->config->item('base_url');
		$font_directory = './fpdf_fonts/';
		set_realpath($font_directory);		
		$this->load->library('fpdf/fpdf');
		define('FPDF_FONTPATH',$font_directory);
		$this->fpdf = new FPDF('P', 'mm', 'Letter', true, 'UTF-8', false);
		
		$this->fpdf->Open();
		$this->fpdf->AliasNbPages();
		$this->fpdf->AddPage();
		$this->Header($purchaseorderid);
		mysql_query("SELECT @i:=0;");
		$UsersQuery = mysql_query("SELECT @i:=@i+1 as 'No', b.number AS Item, SUBSTRING(b.description FROM 1 FOR 35) AS Description, a.itemquantity AS Quantity, SUBSTRING(b.cost FROM 1 FOR 15) AS Price, SUBSTRING((((b.cost-(((a.itemdiscount/100)*b.cost)+b.cost)) +(((a.itemtax/100)*b.cost)+b.cost))*a.itemquantity) FROM 1 FOR 10)  AS Total FROM purchaseorderdetails a JOIN stocksitem b ON a.itemid = b.itemid WHERE a.purchaseorderid=".$purchaseorderid);
		$field = mysql_num_fields($UsersQuery);
		$header = array();
		
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $UsersQuery, $i );
		}
		
		$data = $this->LoadData($purchaseorderid);
		$this->ColoredTable($header, $data);
		$this->Footer();
		$this->fpdf->Output('PurchaseOrder'.$purchaseorderid.'.pdf','I');
	}
	public function LoadData($purchaseorderid){
		mysql_query("SELECT @i:=0;");
		$UsersQuery = mysql_query("SELECT @i:=@i+1 as 'No', b.number AS Item, SUBSTRING(b.description FROM 1 FOR 35) AS Description, a.itemquantity AS Quantity, SUBSTRING(a.poitemcost FROM 1 FOR 15) AS Price, SUBSTRING((((a.poitemcost-(((a.itemdiscount/100)*a.poitemcost)+a.poitemcost)) +(((a.itemtax/100)*a.poitemcost)+a.poitemcost))*a.itemquantity) FROM 1 FOR 10)  AS Total FROM purchaseorderdetails a JOIN stocksitem b ON a.itemid = b.itemid WHERE a.purchaseorderid=".$purchaseorderid);
		$data = array();
		while($rowUsers = mysql_fetch_row($UsersQuery)){
			$data[] = $rowUsers;
		}
		return $data;
	}
	public function ColoredTable($header,$data) {
		// Colors, line width and bold font
		$this->fpdf->SetFillColor(89,127,215);
		$this->fpdf->SetTextColor(33);
		$this->fpdf->SetDrawColor(255);
		$this->fpdf->SetFont('', 'B');
		// Header
			
		$w = array(8, 25, 90, 20, 23, 30  );
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 1);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(0);
		$this->fpdf->SetFont('','',11);
		
		// Data
		$fill = 0;
		$count = 0;	
		foreach($data as $row) {         //border LRTB
			$this->fpdf->Cell($w[0], 10, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 10, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 10, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 10, $row[3], 'C', 0, 'C', $fill);
			$this->fpdf->Cell($w[4], 10, number_format($row[4], 2), 'R', 0, 'R', $fill);
			$this->fpdf->Cell($w[5], 10, number_format($row[5], 2), 'R', 0, 'R', $fill);
			
			$this->fpdf->Ln();
			$fill=!$fill;
			$count += $row[5];
		}
		
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
		$this->fpdf->SetFont('', 'B');
		$this->fpdf->Ln(3);
		$this->fpdf->Cell(153);
		$this->fpdf->Cell(0,0,'Total Price: ',0,0,'L');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(173);
		$this->fpdf->Cell(0, 0,number_format($count, 2), 'R', 0, 'R');
		
	}
	public function Header($purchaseorderid){
		// Whatever written here will come in header of the pdf file.


		$this->fpdf->SetFont('Arial','',20);
		$this->fpdf->Cell(93);
		$this->fpdf->Cell(10,10,'PHILIPPINE NEWLONG CORPORATION',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(115);
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','',11);
		$this->fpdf->Cell(92);
		$this->fpdf->Cell(10,10,'G/F, Newlong Bldg., No. 3590 Davila St., Brgy. Sta. Cruz, Makati City 1205',0,0,'C');
		
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(32);
		$this->fpdf->Cell(10,10,'Telephone Numbers:',0,0,'L');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(100);
		$this->fpdf->Cell(10,10,'Fax:',0,0,'L');
		
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(115);
		$this->fpdf->Cell(10,10,'(+632) 896-4876',0,0,'L');
		
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(69);
		$this->fpdf->Cell(10,10,'(+632) 896-2234',0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(69);
		$this->fpdf->Cell(10,10,'(+632) 896-1266',0,0,'L');
		
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(100);
		$this->fpdf->Cell(10,10,'Email:',0,0,'L');
		
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(115);
		$this->fpdf->Cell(10,10,'shtano@smartbro.net',0,0,'L');
		
		$this->fpdf->Ln(12);
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.40);
		$this->fpdf->Line(205, 52, 10, 52);
		$this->fpdf->SetLineWidth(0.90);
		$this->fpdf->Line(205, 53, 10, 53);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.10);
		$this->fpdf->Rect(10.02, 65, 120, 20);
		$this->fpdf->Rect(130, 65, 75, 20);
		$this->fpdf->Rect(10.02, 85, 194.96, 13);
		
		$this->fpdf->SetFont('Arial','',11);
		$this->fpdf->Ln(-2);
		$this->fpdf->Cell(37);
		$this->fpdf->Cell(10,10,'Branches:',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(67);
		$this->fpdf->Cell(10,10,'Bulacan',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(97);
		$this->fpdf->Cell(10,10,'Bacolod',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(127);
		$this->fpdf->Cell(10,10,'Cebu',0,0,'C');
		
		$this->fpdf->Ln(15);
		$this->fpdf->SetFont('Arial','B',17);
		$this->fpdf->Cell(88);
		$this->fpdf->Cell(10,10,'PURCHASE ORDER',0,0,'C');
		$Offerquery = mysql_query("SELECT a.purchaseordernumber, a.dayship, a.daypayment,SUBSTRING(a.purchasedatecreated  FROM 1 FOR 11), b.clientname, b.clientaddress, b.clientcontact, b.clientphone FROM purchaseorder a JOIN clientprofile b ON a.clientid = b.clientid WHERE a.purchaseorderid = $purchaseorderid");
		$OfferData = array();
		while($rowOffers = mysql_fetch_row($Offerquery)){
			$OfferData[] = $rowOffers;
		}
		foreach($OfferData as $rowTotalData)
		{
		$this->fpdf->Ln(-1);
		$this->fpdf->SetFont('Arial','b',12);
		$this->fpdf->Cell(140);
		$this->fpdf->Cell(10,10,'P.O. NO.',0,0,'C');
		$this->fpdf->Ln(-0);
		$this->fpdf->SetFont('Arial','b',17);
		$this->fpdf->Cell(170);
		$this->fpdf->Cell(10,10,$rowTotalData[0],0,0,'C');
		
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(94);
		$this->fpdf->Cell(10,10,'',0,0,'C');
		$this->fpdf->SetFont('Arial','',11);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(3);
		$this->fpdf->Cell(10,10,'TO:  '.$rowTotalData[4],0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(3);
		$this->fpdf->Cell(10,10,''.$rowTotalData[5],0,0,'L');
		
		

		
		$this->fpdf->Ln(-5);
		$this->fpdf->Cell(120);
		$this->fpdf->Cell(10,10,'Date:',0,0,'L');
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'                '.$rowTotalData[3],0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(120);
		$this->fpdf->Cell(10,10,'Terms:  ',0,0,'L');
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'                '.$rowTotalData[2],0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(120);
		$this->fpdf->Cell(10,10,'Ref. P.R.NO.',0,0,'L');
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(131);
		$this->fpdf->Cell(10,10,'                ',0,0,'L');
		}	
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(10);
		$this->fpdf->Cell(10,10,'Please deliver the following merchandise and/or perform the  following services and indicate',0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(10);
		$this->fpdf->Cell(10,10,'our Purchase Order No. all invoices and other shipping documents.',0,0,'L');
		
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(0);
		$this->fpdf->Cell(10,10,'',0,0,'');
		$this->fpdf->Ln(0);
		
		//$this->Cell(120); remove this if there are overlaping fields
	}
	public function Footer(){
		// Whatever written here will come in footer of the pdf file.
		//Position at 1.5 cm from bottom
		
		$this->fpdf->SetY(227);
		$this->fpdf->Cell(9);
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(10,10,'',0,0,'L');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(1);
		$this->fpdf->Cell(10,10,'Conforme:',0,0,'L');		
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(72);
		$this->fpdf->Cell(10,10,'Prepared by:',0,0,'L');		
		$this->fpdf->Ln(14);
		$this->fpdf->Cell(12);
		$this->fpdf->Cell(10,10,'Suppliers Signiture',0,0,'L');	
		$this->fpdf->Ln(3);
		$this->fpdf->Cell(72);
		$this->fpdf->Cell(10,10,'Noted by:',0,0,'L');	
		$this->fpdf->Ln(-10);
		$this->fpdf->Cell(140);
		$this->fpdf->Cell(10,10,'Approve by:',0,0,'L');	
		$this->fpdf->Ln(15);
		$this->fpdf->Cell(145);
		$this->fpdf->Cell(10,10,'Authorized Signatory',0,0,'L');

		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.50);
		$this->fpdf->Line(70, 243, 13, 243);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.50);
		$this->fpdf->Line(83, 243, 135, 243);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.50);
		$this->fpdf->Line(83, 259, 135, 259);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.50);
		$this->fpdf->Line(151, 251, 205, 251);
		/*
		$this->fpdf->SetY(-31);
		$this->fpdf->SetFont('Arial','I',10);
		$this->fpdf->Cell(0,10,'© Philippine Newlong Corporation, 2012. All rights reserved.',0,0,'C');
		*/
		//Page number
		//$this->fpdf->Cell(0,10,'Page '.$this->fpdf->PageNo().' of {nb}',0,0,'C');
	}
}

?>