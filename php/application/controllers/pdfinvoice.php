<?php
Class PDFINVOICE extends CI_Controller 
{
	
	
	/********FILE PDF REPORT********/
	public function invoice($invoiceid) {
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
		$this->Header($invoiceid);
		mysql_query("SELECT @i:=0;");
		$UsersQuery = mysql_query("SELECT @i:=@i+1 as 'No', b.number AS Item, SUBSTRING(b.description FROM 1 FOR 35) AS Description, SUBSTRING(b.price FROM 1 FOR 15) AS Price, a.itemquantity AS Quantity, SUBSTRING((a.itemtax/100)*b.price FROM 1 FOR 10)  AS Tax,  SUBSTRING((a.itemdiscount/100)*b.price FROM 1 FOR 10)  AS Discount,  SUBSTRING(((b.price-(((a.itemdiscount/100)*b.price)+b.price))+(((a.itemtax/100)*b.price)+b.price)) FROM 1 FOR 10)  AS Total FROM purchaseorderdetails a JOIN stocksitem b ON a.itemid = b.itemid WHERE purchaseorderdetailsid=".$invoiceid);
		$field = mysql_num_fields($UsersQuery);
		$header = array();
		
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $UsersQuery, $i );
		}
		
		$data = $this->LoadData($invoiceid);
		$this->ColoredTable($header, $data);
		$this->Footer();
		$this->fpdf->Output('PurchaseOrder'.$invoiceid.'.pdf','I');
			
	}
	
	
	public function LoadData($invoiceid){
		$UsersQuery = mysql_query("SELECT @i:=@i+1 as 'No', b.number AS Item, SUBSTRING(b.description FROM 1 FOR 35) AS Description, SUBSTRING(b.price FROM 1 FOR 15) AS Price, a.itemquantity AS Quantity, SUBSTRING((a.itemtax/100)*b.price FROM 1 FOR 10)  AS Tax,  SUBSTRING((a.itemdiscount/100)*b.price FROM 1 FOR 10)  AS Discount,  SUBSTRING(((b.price-(((a.itemdiscount/100)*b.price)+b.price))+(((a.itemtax/100)*b.price)+b.price)) FROM 1 FOR 10)  AS Total FROM purchaseorderdetails a JOIN stocksitem b ON a.itemid = b.itemid WHERE purchaseorderdetailsid=".$invoiceid);
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
		$this->fpdf->SetDrawColor(2,2,2);
		$this->fpdf->Cell(-195);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetFont('', 'B');
		// Header
		$this->fpdf->Ln();
		$w = array(25, 80, 40 , 50);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 3);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(4);
		$this->fpdf->SetFont('','',11);
		
		// Data
		$fill = 0;
		foreach($data as $row) {         //border LRTB
			
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'LR', $fill);
				
				$this->fpdf->Ln();
				
			$fill=!$fill;
		}
		
		
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');

		
		
	}
	public function Header($invoiceid){
		// Whatever written here will come in header of the pdf file.
		$Offerquery = mysql_query("SELECT a.purchaseordernumber, a.dayship, a.daypayment, a.purchasedatecreated, b.clientname, b.clientaddress, b.clientcontact, b.clientphone FROM purchaseorder a JOIN clientprofile b ON a.clientid = b.clientid WHERE a.purchaseorderid = $invoiceid");
		$OfferData = array();
		while($rowOffers = mysql_fetch_row($Offerquery)){
			$OfferData[] = $rowOffers;
		}
		foreach($OfferData as $rowTotalData)
		{
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Cell(93);
		$this->fpdf->Cell(10,10,'PHILIPPINE NEWLONG CORPORATION',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(115);
		$this->fpdf->Ln(0);
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(92);
		$this->fpdf->Cell(10,10,'3590 Davila Steet, Sta. Cruz, Makati City',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(92);
		$this->fpdf->Cell(10,10,'Tels. (02)869-4876 / 1471-1471 / 896-2234',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(92);
		$this->fpdf->Cell(10,10,'VAT REG. TIN:230-390-163-000',0,0,'C');
		$this->fpdf->Ln(-13);
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Cell(170);
		$this->fpdf->Cell(10,10,'SALES INVOICE',0,0,'C');
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Cell(156);
		$this->fpdf->Cell(10,10,'No.',0,0,'C');

		$this->fpdf->Ln(12);
		$this->fpdf->SetFont('Arial','',11);
		$this->fpdf->Cell(5);		
		$this->fpdf->Cell(10,10,'SOLD TO: '.$rowTotalData[3],0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(118);
		$this->fpdf->Cell(10,10,'TIN:  230-390-163-000',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(148);
		$this->fpdf->Cell(10,10,'Date:',0,0,'C');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(6);
		$this->fpdf->Cell(10,10,'ADDRESS:',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(152);
		$this->fpdf->Cell(10,10,'P.O. NO. ',0,0,'C');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(8);
		$this->fpdf->Cell(10,10,'SHIPPED TO:',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(151.5);
		$this->fpdf->Cell(10,10,'P/R NO. ',0,0,'C');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(6);
		$this->fpdf->Cell(10,10,'ADDRESS:',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(95);
		$this->fpdf->Cell(10,10,'BUSINESS STYLE:',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(149.5);
		$this->fpdf->Cell(10,10,'Terms:',0,0,'C');
		
		$this->fpdf->Ln(10);
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.50);
		$this->fpdf->Line(205, 63, 10, 63);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(112, 41, 30, 41);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(122, 41, 155, 41);

		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(169, 41, 205, 41);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(155, 47, 32, 47);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(175, 47, 205, 47);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(155, 53, 36, 53);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(174, 53, 205, 53);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(91, 59, 31, 59);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(128, 59, 155, 59);
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.20);
		$this->fpdf->Line(171, 59, 205, 59);
		
		$this->fpdf->Ln(-1);
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(-1);
		$this->fpdf->Cell(10,10,'Our responsibility ceases upon the delivery of the goods to public carrier in good order. Interest at the rate of 12% per annum',0,0,'J');
		$this->fpdf->Ln(3.5);
		$this->fpdf->Cell(-1);
		$this->fpdf->Cell(10,10,'shall be charged on  all accounts the same to  be computed from  the date of  default until full  payment  therefore it is hereby',0,0,'J');
		$this->fpdf->Ln(3.5);
		$this->fpdf->Cell(-1);
		$this->fpdf->Cell(10,10,'understood  that  the items  stated  herein the  property  of the seller  until  fully  paid by  the  buyer and the  former may  take',0,0,'J');
		$this->fpdf->Ln(3.5);
		$this->fpdf->Cell(-1);
		$this->fpdf->Cell(10,10,'possesion of the same and dispose them accordingly  upon the letters failure to pay.  In case of suit, the courts of Makati City',0,0,'J');
		$this->fpdf->Ln(3.5);
		$this->fpdf->Cell(-1);
		$this->fpdf->Cell(10,10,'option of  the  seller  shall  have  the exclusive jurisdiction  to try the case. An addtional sum quivalent to 25% of the total due',0,0,'J');
		$this->fpdf->Ln(3.5);
		$this->fpdf->Cell(-1);
		$this->fpdf->Cell(10,10,'and payable, which in case shall be less than Php 50.00 shall be paid by the buyer as attorneys fee and liquidation damages.',0,0,'J');
		$this->fpdf->Ln(3.5);
		$this->fpdf->Cell(-1);
		$this->fpdf->Cell(10,10,'Cost of shall be for the account of the buyer. The buyer or his authorized representative hereby certifies his conformity in the ',0,0,'J');
		$this->fpdf->Ln(3.5);
		$this->fpdf->Cell(-1);
		$this->fpdf->Cell(10,10,'foregoing terms and conditions affixing his signiture below.',0,0,'J');
		
		
		$this->fpdf->Ln(7.5);
		}
	}

	public function Footer(){

	
		$this->fpdf->SetY(227);
		$this->fpdf->Ln(0);
		$this->fpdf->SetFont('Arial','',11);
		$this->fpdf->Cell(109);
		$this->fpdf->Cell(10,10,'Received the articles in good order and condition:',0,0,'L');
		$this->fpdf->Ln(15);
		$this->fpdf->Cell(102.5);
		$this->fpdf->Cell(10,10,'By: Customers printed name and authorized signiture',0,0,'L');
		
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetLineWidth(0.50);
		$this->fpdf->Line(114, 244, 205, 244);
	

	}
}

?>