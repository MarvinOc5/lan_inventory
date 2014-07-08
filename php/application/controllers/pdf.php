<?php
Class PDF extends CI_Controller 
{
	
	
	/********FILE PDF REPORT********/
	public function previewOffersheet($offersheetid){
		$row = $this->offersheetmodel->getoffersheet($offersheetid);
		$data['offersheets'] = $row->result();
		$data['rigthcontent']= 'pdfreports/rigthcontent_previewoffersheet';
		$data['title']= 'Preview Offer Sheet';
		$this->load->view('template',$data);
	}
	
	
	public function offersheetpdf($offersheetid) {
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
		$this->fpdf->SetAutoPageBreak($this->fpdf->AutoPageBreak, 10);
		$this->Header($offersheetid);
		mysql_query("SELECT @i:=0;");
		$UsersQuery = mysql_query("SELECT @i:=@i+1 as No, b.number AS Reference, SUBSTRING(b.description FROM 1 FOR 35) AS Description, a.itemquantity AS Qty, SUBSTRING(b.price FROM 1 FOR 15) AS Price, SUBSTRING((b.price*a.itemquantity) FROM 1 FOR 10)  AS Total FROM offersheetdetails a JOIN stocksitem b ON a.itemid = b.itemid WHERE offersheetid=".$offersheetid." ORDER BY offersheetid,'asc'");
		$field = mysql_num_fields($UsersQuery);
		$header = array();
		
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $UsersQuery, $i );
		}
		
		$data = $this->LoadData($offersheetid);
		$this->ColoredTable($header, $data);
		$this->Footer1();
		$this->fpdf->Output('Offersheet'.$offersheetid,'I');
	}
	public function LoadData($offersheetid){
		mysql_query("SELECT @i:=0;");
		$UsersQuery = mysql_query("SELECT @i:=@i+1 as No,SUBSTRING(b.number FROM 1 FOR 17)  AS Reference, SUBSTRING(b.description FROM 1 FOR 45) AS Description, a.itemquantity AS Quantity, SUBSTRING(a.itemcost  FROM 1 FOR 15) AS Price, SUBSTRING((a.itemcost*a.itemquantity) FROM 1 FOR 10)  AS Total, a.itemdiscount, a.itemtax, c.servicecharges, c.deliverycharges FROM offersheetdetails a JOIN stocksitem b ON a.itemid = b.itemid JOIN offersheet c ON a.offersheetid = c.offersheetid WHERE a.offersheetid=".$offersheetid);
		$data = array();
		while($rowUsers = mysql_fetch_row($UsersQuery)){
			$data[] = $rowUsers;
		}
		return $data;
	}
	public function ColoredTable($header,$data) {
		// Colors, line width and bold font
		$this->fpdf->SetFillColor(89,127,215);
		$this->fpdf->SetTextColor(255);
		$this->fpdf->SetDrawColor(2,2,2);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetFont('', 'B');
		// Header
			
		$w = array(8, 47, 93, 10 , 20, 20);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 1);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(0);
		$this->fpdf->SetFont('','',10);
		
		// Data
		$fill = 0;
		$count = 0;
		$price = 0;
		$discount = 0;
		$totalprice = 0;
		$discount_total = 0;
		$tax = 0;
		
		foreach($data as $row) {         //border LRTB
			
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'C', $fill);
			$this->fpdf->Cell($w[4], 5, number_format($row[4], 2), 'LR', 0, 'R', $fill);
			$this->fpdf->Cell($w[5], 5, number_format($row[5], 2), 'LR', 0, 'R', $fill);
			$this->fpdf->Ln();
			$price = $row [5];
			$count += $row [5];
			$servicecharges = $row[8];
			$deliverycharges = $row[9];
			
			
			$discount = $price-(($row[4] * ($row[6] / 100)) * $row[3]);
			$discount_total += ($price * ($row[6] / 100));
			$totalprice +=$price;
			$tax +=  (($row[7] / 100) *$discount);
			
			$fill=!$fill;
			
		}
//		
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(90);
		$this->fpdf->SetFont('Arial','I',10);
		$this->fpdf->Cell(10,10,'~ END ~',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(38, 0,'Amount: ', 'R', 0, 'R');
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(163);
		$this->fpdf->Cell(35, 0,'Php  '.number_format($totalprice, 2), 'R', 0, 'R');
		$this->fpdf->Ln(5);
		if (0!=$discount_total) {
			$this->fpdf->Cell(130);
			$this->fpdf->Cell(38, 0,'Less Discount:', 'R', 0, 'R');
			$this->fpdf->Ln(-0);
			$this->fpdf->Cell(163);
			$this->fpdf->Cell(35, 0,'Php  '.number_format($discount_total, 2), 'R', 0, 'R');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(130);
			$this->fpdf->Cell(38, 0,'Amount: ', 'R', 0, 'R');
			$this->fpdf->Ln(-0);
			$this->fpdf->Cell(163);
			$this->fpdf->Cell(35, 0,'Php  '.number_format($totalprice-$discount_total, 2), 'R', 0, 'R');
			$this->fpdf->Ln(5);
		}
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(38, 0,'Add 12% VAT:', 'R', 0, 'R');
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(163);
		$this->fpdf->Cell(35, 0,'Php  '.number_format($tax, 2), 'R', 0, 'R');
		$this->fpdf->Ln(5);
		
		if (0!=$servicecharges) {
			$this->fpdf->Cell(130);
			$this->fpdf->Cell(38, 0,'Amount: ', 'R', 0, 'R');
			$this->fpdf->Ln(-0);
			$this->fpdf->Cell(163);
			$this->fpdf->Cell(35, 0,'Php  '.number_format(($totalprice-$discount_total)+$tax, 2), 'R', 0, 'R');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(130);
			$this->fpdf->Cell(38, 0,'Service Charge:', 'R', 0, 'R');
			$this->fpdf->Ln(-0);
			$this->fpdf->Cell(163);
			$this->fpdf->Cell(35, 0,'Php  '.number_format($servicecharges, 2), 'R', 0, 'R');
			$this->fpdf->SetFont('Arial','B');
			$this->fpdf->Ln(5);
		}
		if (0!=$deliverycharges) {
			$this->fpdf->Cell(130);
			$this->fpdf->Cell(38, 0,'Amount: ', 'R', 0, 'R');
			$this->fpdf->Ln(-0);
			$this->fpdf->Cell(163);
			$this->fpdf->Cell(35, 0,'Php  '.number_format(($totalprice-$discount_total)+$tax+$servicecharges, 2), 'R', 0, 'R');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(130);
			$this->fpdf->Cell(38, 0,'Delivery Charge:', 'R', 0, 'R');
			$this->fpdf->Ln(-0);
			$this->fpdf->Cell(163);
			$this->fpdf->Cell(35, 0,'Php  '.number_format($deliverycharges, 2), 'R', 0, 'R');
			
			$this->fpdf->Ln(5);
		}
		$this->fpdf->Cell(130);
		$this->fpdf->SetFont('Arial','B');
		$this->fpdf->Cell(38, 0,'Net Price:', 'R', 0, 'R');
		$this->fpdf->Ln(-0);
		$this->fpdf->Cell(163);
		$this->fpdf->Cell(35, 0,'Php  '.number_format(($count-$discount_total)+$tax+$servicecharges+$deliverycharges, 2), 'R', 0, 'R');
		$this->fpdf->SetFont('Arial','');
		
	}
	public function Header($offersheetid){
		// Whatever written here will come in header of the pdf file.

		$this->fpdf->Image($this->base.'/media/images/Capture.JPG',15,3,30,20,'');
		$this->fpdf->SetFont('Arial','B',23);
		$this->fpdf->Cell(95);
		$this->fpdf->Cell(10,10,'Philippine  Newlong  Corporation',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(115);
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(93);
		$this->fpdf->Cell(10,10,'Ground Floor, Newlong Bldg., No. 3590 Davila Street, Don Chino Roces Avenue, Brgy. Sta. Cruz, Makati City 1205',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(26);
		$this->fpdf->Cell(10,10,'Sales Telefax: (02) 896-22-34',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(94);
		$this->fpdf->Cell(10,10,'Acctg Telefax: (02) 896-12-66',0,0,'C');
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(160);
		$this->fpdf->Cell(10,10,'Telefax: (02) 897-14-71',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(94);
		$this->fpdf->Cell(10,10,'www.philnewlong.com',0,0,'C');
		
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(94);
		$this->fpdf->Cell(10,10,'',0,0,'C');
		$Offerquery = mysql_query("SELECT a.offersheetid, a.dayship, a.daypayment, b.clientname, b.clientaddress, b.clientcontact, b.clientphone, b.clientemail, b.clientfax, a.offerdatecreated FROM offersheet a JOIN clientprofile b ON a.clientid = b.clientid WHERE a. offersheetid = $offersheetid");
		$OfferData = array();
		while($rowOffers = mysql_fetch_row($Offerquery)){
			$OfferData[] = $rowOffers;
		}
		foreach($OfferData as $rowTotalData)
		{
			
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(1);
			$this->fpdf->Cell(10,10,'Company Name: ',0,0,'L');
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Ln(-0);
			$this->fpdf->Cell(29);
			$this->fpdf->Cell(10,10, $rowTotalData[3] ,0,0,'L');
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(1);
			$this->fpdf->Cell(10,10,'Address: '.$rowTotalData[4].'',0,0,'L');	
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(1);
			$this->fpdf->Cell(10,10,'Contact Person: ' .$rowTotalData[5].'',0,0,'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(1);
			$this->fpdf->Cell(10,10,'Contact Number: ' .$rowTotalData[6].'',0,0,'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(1);
			$this->fpdf->Cell(10,10,'Email: '.$rowTotalData[7],0,0,'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(1);
			$this->fpdf->Cell(10,10,'Fax: '.$rowTotalData[8],0,0,'L');
			
			$this->fpdf->Ln(-25);
			$this->fpdf->Cell(137);
			$this->fpdf->Cell(10,10,'Offer Sheet No: '.$rowTotalData[0].'',0,0,'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(137);
			$this->fpdf->Cell(10,10,'Terms of Payment: '.$rowTotalData[2].'',0,0,'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(137);
			$this->fpdf->Cell(10,10,'Time of Shipment: '.$rowTotalData[1].'',0,0,'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(137);
			$this->fpdf->Cell(10,10,'Place of Delivery: FOB/Manila',0,0,'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(137);
			$this->fpdf->Cell(10,10,'Vadility: One Week',0,0,'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(137);
			$date = date_create($rowTotalData[9]);
			$this->fpdf->Cell(10,10,'Date: '.date_format($date, 'Y-m-d'),0,0,'L');

			
			
			$this->fpdf->Ln(10);
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(90);
			$this->fpdf->Cell(10,10,'',0,0,'C');
			$this->fpdf->Ln(5);
		}
		
		//$this->Cell(120); remove this if there are overlaping fields
	}
	
	
	
	public function Footer1(){
		// Whatever written here will come in footer of the pdf file.
		//Position at 1.5 cm from bottom
		
		
		$this->fpdf->SetY(145);
		
	
		$this->fpdf->Ln(90);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,0,'Thank you for giving us the opportunity to quote on your requirement.',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(0,0,'Please let us know whether this offer meets with your approval.',0,0,'C');
		$this->fpdf->SetFont('Arial','I',10);
		$this->fpdf->Cell(0,0,'',0,0,'C');
		$this->fpdf->Ln(3);
		$this->fpdf->Ln(0);
		$this->fpdf->Cell(9);
		$this->fpdf->Cell(10,10,'Kindly sign as Conforme:',0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(9);
		$this->fpdf->Cell(10,10,'Name:',0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(9);
		$this->fpdf->Cell(10,10,'Signature:',0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(9);
		$this->fpdf->Cell(10,10,'Date:',0,0,'L');
		
		$this->fpdf->Ln(-10);
		$this->fpdf->Cell(148);
		$this->fpdf->Cell(10,10,'Akiko H. Sabijon',0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(144);
		$this->fpdf->Cell(10,10,'Tel#: (02) 896-48-76',0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'Email: akikosabijon@philnewlong.com',0,0,'L');

		
		/*
		$this->fpdf->SetY(-31);
		$this->fpdf->SetFont('Arial','I',10);
		$this->fpdf->Cell(0,10,'� Philippine Newlong Corporation, 2012. All rights reserved.',0,0,'C');
		*/
		//Page number
		//$this->fpdf->Cell(0,10,'Page '.$this->fpdf->PageNo().' of {nb}',0,0,'C');
	}
}

?>