<?php
Class REPORT extends CI_Controller 
{
	
	
	/********FILE PDF REPORT********/
	
	
	public function clientReport() {
		$this->load->helper('path');
		$this->base = $this->config->item('base_url');
		$font_directory = './fpdf_fonts/';
		set_realpath($font_directory);		
		$this->load->library('fpdf/fpdf');
		define('FPDF_FONTPATH',$font_directory);
		$this->fpdf = new FPDF('L', 'mm', 'Letter', true, 'UTF-8', false);
		$this->fpdf->Open();
		$this->fpdf->AliasNbPages();
		$this->fpdf->AddPage();
		//$this->fpdf->SetAutoPageBreak($this->fpdf->AutoPageBreak, 45);
		$this->Header();
		
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		
		$UsersQuery = mysql_query("SELECT clientname AS 'Client Name', clientaddress AS 'Address', clientemail AS 'Email', clientcontact AS 'Contact', clientphone AS 'Phone', clientfax AS 'Fax'
									FROM clientprofile 	WHERE `type`='Client' AND clientdatecreated BETWEEN  $fromDate AND  $toDate");
		$field = mysql_num_fields($UsersQuery);
		$header = array();
		
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $UsersQuery, $i );			
		}	
			
		$data = $this->LoadData();
		$this->ColoredTable($header, $data);
		$this->Footer();
		$this->fpdf->Output('Client_Report_'.$fromDate.'/'.$toDate.'.pdf','I');
	}
	
	
	public function LoadData(){
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		
		$UsersQuery = mysql_query("SELECT clientname AS 'Client Name', clientaddress AS 'Address', clientemail AS 'Email', clientcontact AS 'Contact', clientphone AS 'Phone', clientfax AS 'Fax' FROM clientprofile WHERE `type`='Client' AND `clientdatecreated` between  '$fromDate' and '$toDate' ORDER BY clientid,'asc'");
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
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'Client List Reports',0,0,'C');
		$this->fpdf->SetFont('Arial','B',11);
		// Header
		$this->fpdf->Ln();
		$w = array(65, 65, 50, 27, 27, 27);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 3);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(4);
		$this->fpdf->SetFont('','',9.5);
		
		// Data
		$fill = 0;
		foreach($data as $row) {         //border LRTB
			
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[4], 5, $row[4], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[5], 5, $row[5], 'LR', 0, 'LR', $fill);
	
				
				$this->fpdf->Ln();
				
			$fill=!$fill;
		}
		
		
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
		
		
	}
	
	public function supplierReport() {
		$this->load->helper('path');
		$this->base = $this->config->item('base_url');
		$font_directory = './fpdf_fonts/';
		set_realpath($font_directory);
		$this->load->library('fpdf/fpdf');
		define('FPDF_FONTPATH',$font_directory);
		$this->fpdf = new FPDF('L', 'mm', 'Letter', true, 'UTF-8', false);
	
		$this->fpdf->Open();
		$this->fpdf->AliasNbPages();
		$this->fpdf->AddPage();
		//$this->fpdf->SetAutoPageBreak($this->fpdf->AutoPageBreak, 45);
		$this->Header();
		
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		
		$SupplierQuery = mysql_query("SELECT clientname AS 'Supplier Name', clientaddress AS 'Address', clientemail AS 'Email', clientcontact AS 'Contact', clientphone AS 'Phone', clientfax AS 'Fax'
									FROM clientprofile WHERE `type`='Supplier' AND clientdatecreated BETWEEN  $fromDate AND  $toDate");
		$field = mysql_num_fields($SupplierQuery);
		$header = array();
	
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $SupplierQuery, $i );
		}
			
		$data = $this->LoadSupplier();
		$this->ColoredSupplier($header, $data);
		$this->Footer();
		$this->fpdf->Output('Supplier_Report'.$fromDate.'/'.$toDate.'.pdf','I');
	}
	
	
	public function LoadSupplier(){
		
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		
		$SupplierQuery = mysql_query("SELECT clientname AS 'Supplier Name', clientaddress AS 'Address', clientemail AS 'Email', clientcontact AS 'Contact', clientphone AS 'Phone', clientfax AS 'Fax' FROM clientprofile WHERE `type`='Supplier' AND `clientdatecreated` between  '$fromDate' and '$toDate' ORDER BY clientid,'asc'");
		$data = array();
		while($rowUsers = mysql_fetch_row($SupplierQuery)){
			$data[] = $rowUsers;
		}
		return $data;
	}
	public function ColoredSupplier($header,$data) {
		// Colors, line width and bold font
	
		$this->fpdf->SetFillColor(89,127,215);
		$this->fpdf->SetTextColor(33);
		$this->fpdf->SetDrawColor(2,2,2);
		$this->fpdf->Cell(-195);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetFont('', 'B');
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'Supplier List Reports',0,0,'C');
		$this->fpdf->SetFont('Arial','B',11);
		// Header
		$this->fpdf->Ln();
		$w = array(65, 65, 50, 27, 27, 27);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 3);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(4);
		$this->fpdf->SetFont('','',9.5);
	
		// Data
		$fill = 0;
		foreach($data as $row) {         //border LRTB
				
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[4], 5, $row[4], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[5], 5, $row[5], 'LR', 0, 'LR', $fill);
	
	
			$this->fpdf->Ln();
	
			$fill=!$fill;
		}
	
	
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
	
	
	}
	
	
	public function offersheetReport() {
		$this->load->helper('path');
		$this->base = $this->config->item('base_url');
		$font_directory = './fpdf_fonts/';
		set_realpath($font_directory);
		$this->load->library('fpdf/fpdf');
		define('FPDF_FONTPATH',$font_directory);
		$this->fpdf = new FPDF('L', 'mm', 'Letter', true, 'UTF-8', false);	
		$this->fpdf->Open();
		$this->fpdf->AliasNbPages();
		$this->fpdf->AddPage();
		//$this->fpdf->SetAutoPageBreak($this->fpdf->AutoPageBreak, 45);
		$this->Header();
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		$OffersheetQuery = mysql_query("SELECT invoiceid AS 'Invoice No.', clientprofile.clientname AS 'Client', username AS 'By User', invoicestatus AS 'Status',  dayship AS 'DayShip', daypayment AS 'Day payment', invoicedatecreated AS 'Date'  FROM (`invoice`) LEFT JOIN `usersdetails` ON `usersdetails`.`userid` = `invoice`.`userid` LEFT JOIN `clientprofile` ON `clientprofile`.`clientid` = `invoice`.`clientid` where invoicedatecreated BETWEEN  '$fromDate' AND  '$toDate'");
		$field = mysql_num_fields($OffersheetQuery);
		$header = array();
	
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $OffersheetQuery, $i );
		}
			
		$data = $this->LoadOffersheet();
		$this->ColoredOffersheet($header, $data);
		$this->Footer();
		$this->fpdf->Output('Offersheet_Report'.$fromDate.'/'.$toDate.'.pdf','I');
	}
	
	
	public function LoadOffersheet(){
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		$OffersheetQuery = mysql_query("SELECT invoiceid AS 'Invoice No.', clientprofile.clientname AS 'Client', username AS 'By User', invoicestatus AS 'Status',  dayship AS 'DayShip', daypayment AS 'Day payment', invoicedatecreated AS 'Date'  FROM (`invoice`) LEFT JOIN `usersdetails` ON `usersdetails`.`userid` = `invoice`.`userid` LEFT JOIN `clientprofile` ON `clientprofile`.`clientid` = `invoice`.`clientid` where invoicedatecreated BETWEEN  '$fromDate' AND  '$toDate'");
		$data = array();
		while($rowUsers = mysql_fetch_row($OffersheetQuery)){
			$data[] = $rowUsers;
		}
		return $data;
	}
	public function Coloredoffersheet($header,$data) {
		// Colors, line width and bold font
	
		$this->fpdf->SetFillColor(89,127,215);
		$this->fpdf->SetTextColor(33);
		$this->fpdf->SetDrawColor(2,2,2);
		$this->fpdf->Cell(-195);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetFont('', 'B');
		// Header
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'Offer Sheet List Reports',0,0,'C');
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Ln();
		$w = array(30, 70, 40, 30, 25, 25, 40);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 3);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(4);
		$this->fpdf->SetFont('','',9.5);
	
		// Data
		$fill = 0;
		foreach($data as $row) {         //border LRTB
	
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[4], 5, $row[4], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[5], 5, $row[5], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[6], 5, $row[6], 'LR', 0, 'LR', $fill);
	
	
			$this->fpdf->Ln();
	
			$fill=!$fill;
		}
	
	
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
	
	
	}
	
	public function inventoryReport() {
		$this->load->helper('path');
		$this->base = $this->config->item('base_url');
		$font_directory = './fpdf_fonts/';
		set_realpath($font_directory);
		$this->load->library('fpdf/fpdf');
		define('FPDF_FONTPATH',$font_directory);
		$this->fpdf = new FPDF('L', 'mm', 'Letter', true, 'UTF-8', false);
		$this->fpdf->Open();
		$this->fpdf->AliasNbPages();
		$this->fpdf->AddPage();
		//$this->fpdf->SetAutoPageBreak($this->fpdf->AutoPageBreak, 45);
		$this->Header();
	
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
	
		$UsersQuery = mysql_query("SELECT number AS 'Part No.',description AS 'Description',itemtype AS 'Type',username AS 'By User', itemquantity AS 'Quantity', inventorytype AS 'Entry' FROM inventorydetails JOIN usersdetails ON inventorydetails.userid=usersdetails.userid JOIN stocksitem ON stocksitem.itemid=inventorydetails.itemid WHERE inventorydetails.datecreate BETWEEN  '$fromDate%' AND  '$toDate%'");
		$field = mysql_num_fields($UsersQuery);
		$header = array();
	
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $UsersQuery, $i );
		}
			
		$data = $this->Loadinventory();
		$this->inventoryTable($header, $data);
		$this->Footer();
		$this->fpdf->Output('Inventory_Report'.$fromDate.'/'.$toDate.'.pdf','I');
	}
	
	
	public function Loadinventory(){
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
	
		$UsersQuery = mysql_query("SELECT number AS 'Part No.',description AS 'Description',itemtype AS 'Type',username AS 'By User', itemquantity AS 'Quantity', inventorytype AS 'Entry' FROM inventorydetails JOIN usersdetails ON inventorydetails.userid=usersdetails.userid JOIN stocksitem ON stocksitem.itemid=inventorydetails.itemid WHERE inventorydetails.datecreate BETWEEN  '$fromDate%' AND  '$toDate%'");
		$data = array();
		while($rowUsers = mysql_fetch_row($UsersQuery)){
			$data[] = $rowUsers;
		}
		return $data;
	}
	public function inventoryTable($header,$data) {
		// Colors, line width and bold font
	
		$this->fpdf->SetFillColor(89,127,215);
		$this->fpdf->SetTextColor(33);
		$this->fpdf->SetDrawColor(2,2,2);
		$this->fpdf->Cell(-195);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetFont('', 'B');
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'Inventory List Reports',0,0,'C');
		$this->fpdf->SetFont('Arial','B',11);
		// Header
		$this->fpdf->Ln();
		$w = array(40, 65, 50, 27, 27, 27);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 3);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(4);
		$this->fpdf->SetFont('','',9.5);
	
		// Data
		$fill = 0;
		foreach($data as $row) {         //border LRTB
				
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[4], 5, $row[4], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[5], 5, $row[5], 'LR', 0, 'LR', $fill);
	
	
			$this->fpdf->Ln();
	
			$fill=!$fill;
		}
	
	
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
	
	
	}
	
	public function purchaseorderReport() {
		$this->load->helper('path');
		$this->base = $this->config->item('base_url');
		$font_directory = './fpdf_fonts/';
		set_realpath($font_directory);
		$this->load->library('fpdf/fpdf');
		define('FPDF_FONTPATH',$font_directory);
		$this->fpdf = new FPDF('L', 'mm', 'Letter', true, 'UTF-8', false);
		$this->fpdf->Open();
		$this->fpdf->AliasNbPages();
		$this->fpdf->AddPage();
		//$this->fpdf->SetAutoPageBreak($this->fpdf->AutoPageBreak, 45);
		$this->Header();
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		$PurchaseorderQuery = mysql_query("SELECT purchaseordernumber AS 'Purchase Order No.', clientname AS 'Client', username AS 'User', purchaseorderstatus AS 'Status', dayship AS 'DayShip', daypayment AS 'Day payment', purchasedatecreated AS 'Date'  FROM (`purchaseorder`) JOIN `usersdetails` ON `usersdetails`.`userid` = `purchaseorder`.`userid` LEFT JOIN `clientprofile` ON `clientprofile`.`clientid` = `purchaseorder`.`clientid` WHERE `type`='client' and purchasedatecreated BETWEEN  '$fromDate%' AND  '$toDate%'");
		$field = mysql_num_fields($PurchaseorderQuery);
		$header = array();
	
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $PurchaseorderQuery, $i );
		}
			
		$data = $this->LoadPurchaseorder();
		$this->ColoredPurchaseorder($header, $data);
		$this->Footer();
		$this->fpdf->Output('Purchaseorder_Report'.$fromDate.'/'.$toDate.'.pdf','I');
	}
	
	
	public function LoadPurchaseorder(){
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		$PurchaseorderQuery = mysql_query("SELECT purchaseordernumber AS 'Purchase Order No.', clientname AS 'Client', username AS 'User', purchaseorderstatus AS 'Status', dayship AS 'DayShip', daypayment AS 'Day payment', purchasedatecreated AS 'Date'  FROM (`purchaseorder`) JOIN `usersdetails` ON `usersdetails`.`userid` = `purchaseorder`.`userid` LEFT JOIN `clientprofile` ON `clientprofile`.`clientid` = `purchaseorder`.`clientid` WHERE `type`='client' and purchasedatecreated BETWEEN  '$fromDate%' AND  '$toDate%'");
		$data = array();
		while($rowUsers = mysql_fetch_row($PurchaseorderQuery)){
			$data[] = $rowUsers;
		}
		return $data;
	}
	public function ColoredPurchaseorder($header,$data) {
		// Colors, line width and bold font
	
		$this->fpdf->SetFillColor(89,127,215);
		$this->fpdf->SetTextColor(33);
		$this->fpdf->SetDrawColor(2,2,2);
		$this->fpdf->Cell(-195);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetFont('', 'B');
		// Header
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'Purchase Order Client List Reports',0,0,'C');
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Ln();
		$w = array(40, 70, 30, 30, 25, 25, 40);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 3);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(4);
		$this->fpdf->SetFont('','',9.5);
	
		// Data
		$fill = 0;
		foreach($data as $row) {         //border LRTB
	
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[4], 5, $row[4], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[5], 5, $row[5], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[6], 5, $row[6], 'LR', 0, 'LR', $fill);
	
	
			$this->fpdf->Ln();
	
			$fill=!$fill;
		}
	
	
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
	
	
	}
	
	public function invoiceReport() {
		$this->load->helper('path');
		$this->base = $this->config->item('base_url');
		$font_directory = './fpdf_fonts/';
		set_realpath($font_directory);
		$this->load->library('fpdf/fpdf');
		define('FPDF_FONTPATH',$font_directory);
		$this->fpdf = new FPDF('L', 'mm', 'Letter', true, 'UTF-8', false);
		$this->fpdf->Open();
		$this->fpdf->AliasNbPages();
		$this->fpdf->AddPage();
		//$this->fpdf->SetAutoPageBreak($this->fpdf->AutoPageBreak, 45);
		$this->Header();
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		$InvoiceQuery = mysql_query("SELECT invoiceid AS 'Invoice No.', clientname AS 'Client', username AS 'By User', invoicestatus AS 'Status',  dayship AS 'DayShip', daypayment AS 'Day payment', invoicedatecreated AS 'Date'  FROM (`invoice`) JOIN `usersdetails` ON `usersdetails`.`userid` = `invoice`.`userid` LEFT JOIN `clientprofile` ON `clientprofile`.`clientid` = `invoice`.`clientid` where invoicedatecreated BETWEEN  '$fromDate%' AND  '$toDate%'");
		$field = mysql_num_fields($InvoiceQuery);
		$header = array();
	
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $InvoiceQuery, $i );
		}
			
		$data = $this->LoadInvoice();
		$this->ColoredInvoice($header, $data);
		$this->Footer();
		$this->fpdf->Output('Invoice_Report'.$fromDate.'/'.$toDate.'.pdf','I');
	}
	
	
	public function LoadInvoice(){
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		$InvoiceQuery = mysql_query("SELECT invoiceid AS 'Invoice No.', clientname AS 'Client', username AS 'By User', invoicestatus AS 'Status',  dayship AS 'DayShip', daypayment AS 'Day payment', invoicedatecreated AS 'Date'  FROM (`invoice`) JOIN `usersdetails` ON `usersdetails`.`userid` = `invoice`.`userid` LEFT JOIN `clientprofile` ON `clientprofile`.`clientid` = `invoice`.`clientid` where invoicedatecreated BETWEEN  '$fromDate%' AND  '$toDate%'");
		$data = array();
		while($rowUsers = mysql_fetch_row($InvoiceQuery)){
			$data[] = $rowUsers;
		}
		return $data;
	}
	public function ColoredInvoice($header,$data) {
		// Colors, line width and bold font
	
		$this->fpdf->SetFillColor(89,127,215);
		$this->fpdf->SetTextColor(33);
		$this->fpdf->SetDrawColor(2,2,2);
		$this->fpdf->Cell(-195);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetFont('', 'B');
		// Header
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'Invoice List Reports',0,0,'C');
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Ln();
		$w = array(40, 70, 30, 30, 25, 25, 40);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 3);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(4);
		$this->fpdf->SetFont('','',9.5);
	
		// Data
		$fill = 0;
		foreach($data as $row) {         //border LRTB
	
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[4], 5, $row[4], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[5], 5, $row[5], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[6], 5, $row[6], 'LR', 0, 'LR', $fill);
	
	
			$this->fpdf->Ln();
	
			$fill=!$fill;
		}
	
	
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
	
	
	}
	
	
	public function itemsReport($modelid) {
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
		//$this->fpdf->SetAutoPageBreak($this->fpdf->AutoPageBreak, 45);
		$this->Header($modelid);
		$ItemsQuery = mysql_query("SELECT number AS 'Reference No.', description AS 'Description', price AS 'Price', quantity AS 'Quantity', location AS 'Location' FROM (`stocksitem`) LEFT JOIN `partscategory` ON `partscategory`.`partscategoryid` = `stocksitem`.`partscategoryid` WHERE `itemtype` = 'Part' AND `modelid` = '$modelid'");
		$field = mysql_num_fields($ItemsQuery);
		$header = array();
	
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $ItemsQuery, $i );
		}
			
		$data = $this->LoadItems($modelid);
		$this->ColoredItems($header, $data);
		$this->Footer();
		$this->fpdf->Output('Items.pdf','I');
	}
	
	
	public function LoadItems($modelid){
		$ItemsQuery = mysql_query("SELECT number AS 'Reference No.', description AS 'Description', price AS 'Price', quantity AS 'Quantity', location AS 'Location' FROM (`stocksitem`) LEFT JOIN `partscategory` ON `partscategory`.`partscategoryid` = `stocksitem`.`partscategoryid` WHERE `itemtype` = 'Part' AND `modelid` = '$modelid'");
		$data = array();
		while($rowUsers = mysql_fetch_row($ItemsQuery)){
			$data[] = $rowUsers;
		}
		return $data;
	}
	public function ColoredItems($header,$data) {
		// Colors, line width and bold font
	
		$this->fpdf->SetFillColor(89,127,215);
		$this->fpdf->SetTextColor(33);
		$this->fpdf->SetDrawColor(2,2,2);
		$this->fpdf->Cell(-195);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetFont('', 'B');
		// Header
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(80);
		$this->fpdf->Cell(10,10,'Model: ',0,0,'C');
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Ln();
		$w = array(40, 70, 30, 30, 25);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 4, $header[$i], 1, 0, 'C', 3);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(4);
		$this->fpdf->SetFont('','',9.5);
	
		// Data
		$fill = 0;
		foreach($data as $row) {         //border LRTB
	
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[4], 5, $row[4], 'LR', 0, 'LR', $fill);

			
	
	
			$this->fpdf->Ln();
	
			$fill=!$fill;
		}
	
	
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
	
	
		
	}
	
	public function purchaseordersupplierReport() {
		$this->load->helper('path');
		$this->base = $this->config->item('base_url');
		$font_directory = './fpdf_fonts/';
		set_realpath($font_directory);
		$this->load->library('fpdf/fpdf');
		define('FPDF_FONTPATH',$font_directory);
		$this->fpdf = new FPDF('L', 'mm', 'Letter', true, 'UTF-8', false);
		$this->fpdf->Open();
		$this->fpdf->AliasNbPages();
		$this->fpdf->AddPage();
		//$this->fpdf->SetAutoPageBreak($this->fpdf->AutoPageBreak, 45);
		$this->Header();
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		$PurchaseordersupplierQuery = mysql_query("SELECT purchaseordernumber AS 'Purchase Order No.', clientname AS 'Client', username AS 'User', purchaseorderstatus AS 'Status', dayship AS 'DayShip', daypayment AS 'Day payment', purchasedatecreated AS 'Date'  FROM (`purchaseorder`) JOIN `usersdetails` ON `usersdetails`.`userid` = `purchaseorder`.`userid` LEFT JOIN `clientprofile` ON `clientprofile`.`clientid` = `purchaseorder`.`clientid` WHERE `type`='supplier' and purchasedatecreated BETWEEN  '$fromDate%' AND  '$toDate%'");
		$field = mysql_num_fields($PurchaseordersupplierQuery);
		$header = array();
	
		for ( $i = 0; $i < $field; $i++ ) {
			$header[] = mysql_field_name( $PurchaseordersupplierQuery, $i );
		}
			
		$data = $this->LoadPurchaseordersupplier();
		$this->ColoredPurchaseordersupplier($header, $data);
		$this->Footer();
		$this->fpdf->Output('Purchaseordersupplier_Report'.$fromDate.'/'.$toDate.'.pdf','I');
	}
	
	
	public function LoadPurchaseordersupplier(){
		$fromDate = $this->input->post('from');
		$toDate = $this->input->post('to');
		$PurchaseordersupplierQuery = mysql_query("SELECT purchaseordernumber AS 'Purchase Order No.', clientname AS 'Client', username AS 'User', purchaseorderstatus AS 'Status', dayship AS 'DayShip', daypayment AS 'Day payment', purchasedatecreated AS 'Date'  FROM (`purchaseorder`) JOIN `usersdetails` ON `usersdetails`.`userid` = `purchaseorder`.`userid` LEFT JOIN `clientprofile` ON `clientprofile`.`clientid` = `purchaseorder`.`clientid` WHERE `type`='supplier' and purchasedatecreated  '$fromDate%' AND  '$toDate%'");
		$data = array();
		while($rowUsers = mysql_fetch_row($PurchaseordersupplierQuery)){
			$data[] = $rowUsers;
		}
		return $data;
	}
	public function ColoredPurchaseordersupplier($header,$data) {
		// Colors, line width and bold font
	
		$this->fpdf->SetFillColor(89,127,215);
		$this->fpdf->SetTextColor(33);
		$this->fpdf->SetDrawColor(2,2,2);
		$this->fpdf->Cell(-195);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetFont('', 'B');
		// Header
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'Purchase Order Supplier List Reports',0,0,'C');
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Ln();
		$w = array(40, 70, 30, 30, 25, 25, 40);
		$num_headers = count($header);
			
		for($i = 0; $i < $num_headers; ++$i) {
			$this->fpdf->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 3);
		}
			
		$this->fpdf->Ln();
			
		// Color and font restoration
		$this->fpdf->SetFillColor(213, 234, 197);
		$this->fpdf->SetTextColor(4);
		$this->fpdf->SetFont('','',9.5);
	
		// Data
		$fill = 0;
		foreach($data as $row) {         //border LRTB
	
			$this->fpdf->Cell($w[0], 5, $row[0], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[1], 5, $row[1], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[2], 5, $row[2], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[3], 5, $row[3], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[4], 5, $row[4], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[5], 5, $row[5], 'LR', 0, 'LR', $fill);
			$this->fpdf->Cell($w[6], 5, $row[6], 'LR', 0, 'LR', $fill);
	
	
			$this->fpdf->Ln();
	
			$fill=!$fill;
		}
	
	
		$this->fpdf->Cell(array_sum($w), 0, '', 'T');
	
	
	}
	
	
	
	

	
	public function Header(){
		// Whatever written here will come in header of the pdf file.
		
		$this->fpdf->Image($this->base.'/media/images/Capture.JPG', 30, 10, 50, 20,'');
		$this->fpdf->SetFont('Arial','B',13);
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(10,10,'PHILIPPINE NEWLONG CORPORATION',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Ln(0);
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(129);
		$this->fpdf->Cell(10,10,'3590 Davila Steet, Sta. Cruz, Makati City',0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(129);
		$this->fpdf->Cell(10,10,'Tels. (02)869-4876 / 1471-1471 / 896-2234',0,0,'C');
		$this->fpdf->Ln(10);
		
		
		
		//$this->Cell(120); remove this if there are overlaping fields
	}
	
	

	
	
	
	
	
	public function Footer(){
		// Whatever written here will come in footer of the pdf file.
		//Position at 1.5 cm from bottom
	
		$this->fpdf->SetY(-35);
		$this->fpdf->SetFont('Arial','I',10);
		$this->fpdf->Cell(0,10,'© Philippine Newlong Corporation, 2012. All rights reserved.',0,0,'C');
	
		//Page number
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(125);
		$this->fpdf->Cell(10,10,'Page '.$this->fpdf->PageNo().' of {nb}',0,0,'C');
		
		
	}
}

?>