<?php
class cinvoice extends CI_Controller
{
	function offersheettoinvoice($offersheetid = 0)
	{
		if($this->_submit_form()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$row = $this->offersheetmodel->getoffersheet($offersheetid);
			$data['offersheets'] = $row->result();
			$row = $this->offersheetmodel->getoffersheetDetails($offersheetid);
			$data['offersheetsDetail'] = $row->result();
			$data['title']= 'Create Invoice Statement';
			$data['rigthcontent']= 'rigthcontent_offersheettoinvoice';
			$this->load->view('template',$data);
		}
		else
		{
			$offersheetstatus['offersheetstatus']='Transfer to Invoice';
			$this->offersheetmodel->offersheetupdate($offersheetstatus,$offersheetid);
			$datainvoice['invoicenumber']=$this->input->post('invoicenumber');
			$datainvoice['clientid']=$this->input->post('clientid');
			$datainvoice['userid']=$this->session->userdata('userid');
			$datainvoice['daypayment']=$this->input->post('daypayment');
			$datainvoice['dayship']=$this->input->post('dayship');
			$datainvoice['servicecharges'] = $this->input->post('ser');
			$datainvoice['deliverycharges'] = $this->input->post('del');
			$this->invoicemodel->addinvoice($datainvoice);
			$haha = count($this->input->post('itemId')) - 1;
			$hehe = $this->input->post('itemId');
			$huhu = $this->input->post('qty');
			$hoho = $this->input->post('vat');
			$itemdsc = $this->input->post('dsc');
			for( $i = $haha; $i>=0; $i--)
			{
				$offersheetid =$this->input->post('offersheetid');
				$offersheetstatus['offersheetstatus']='Transfer to invoice';
				$this->offersheetmodel->offersheetupdate($offersheetstatus,$offersheetid);
				$invoiceid =$this->invoicemodel->getmaxinvoice();
				$datainvoicedetails['itemid']=$hehe[$i];
				$datainvoicedetails['itemquantity'] = $huhu[$i];
				$datainvoicedetails['itemtax'] = $hoho[$i];
				$datainvoicedetails['itemdiscount'] = $itemdsc[$i];
				$datainvoicedetails['invoiceid']=$invoiceid;
				$datainventory['userid']=$this->session->userdata('userid');
				$datainventory['itemid']=$hehe[$i];
				$datainventory['inventorytype']='Invoice';
				$datainventory['transactionid']=$invoiceid;
				$datainventory['itemquantity']=$huhu[$i];
				$row = $this->inventorymodel->getolditemquatity($hehe[$i]);
				$datanewitem['quantity'] = $newquantity = $row-$huhu[$i];
				$this->inventorymodel->newitem($datanewitem, $hehe[$i]);
				$this->inventorymodel->newsupply($datainventory);
				$this->invoicemodel->addinvoicedetails($datainvoicedetails);
				$this->session->set_flashdata('valid','Invoice Statement Successful! Created');
			}
			redirect('cinvoice/viewinvoices');
		}
	}
	function purchaseordertoinvoice($purchaseorderid = 0)
	{
		if($this->_submit_form()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$row = $this->inventorymodel->getpurchaseorder($purchaseorderid);
			$data['purchaseorder'] = $row->result();
			$row = $this->inventorymodel->getpurchaseorderDetails($purchaseorderid);
			$data['purchasesheetsDetail'] = $row->result();
			$data['title']= 'Create Invoice Statement';
			$data['rigthcontent']= 'rigthcontent_purchaseordertoinvoice';
			$this->load->view('template',$data);
		}
		else
		{
			$datainvoice['invoicenumber']=$this->input->post('invoicenumber');
			$datapurchaseorder['purchaseorderstatus']='Transfer to invoice';
			$this->inventorymodel->purchaseorderupdate($datapurchaseorder,$purchaseorderid);
			$datainvoice['clientid']=$this->input->post('clientid');
			$datainvoice['userid']=$this->session->userdata('userid');
			$datainvoice['daypayment']=$this->input->post('daypayment');
			$datainvoice['dayship']=$this->input->post('dayship');
			$datainvoice['servicecharges'] = $this->input->post('ser');
			$datainvoice['deliverycharges'] = $this->input->post('del');
			$this->invoicemodel->addinvoice($datainvoice);
			$haha = count($this->input->post('itemId')) - 1;
			$hehe = $this->input->post('itemId');
			$huhu = $this->input->post('qty');
			$hoho = $this->input->post('vat');
			$itemdsc = $this->input->post('dsc');
			for( $i = $haha; $i>=0; $i--){
				$invoiceid =$this->invoicemodel->getmaxinvoice();
				$datainvoicedetails['itemid']=$hehe[$i];
				$datainvoicedetails['itemquantity'] = $huhu[$i];
				$datainvoicedetails['itemtax'] = $hoho[$i];
				$datainvoicedetails['itemdiscount'] = $itemdsc[$i];
				$datainvoicedetails['invoiceid']=$invoiceid;
				$datainventory['userid']=$this->session->userdata('userid');
				$datainventory['itemid']=$hehe[$i];
				$datainventory['inventorytype']='Invoice';
				$datainventory['transactionid']=$invoiceid;
				$datainventory['itemquantity']=$huhu[$i];
				$row = $this->inventorymodel->getolditemquatity($hehe[$i]);
				$datanewitem['quantity'] = $newquantity = $row-$huhu[$i];
				$this->inventorymodel->newitem($datanewitem, $hehe[$i]);
				$this->inventorymodel->newsupply($datainventory);
				$this->invoicemodel->addinvoicedetails($datainvoicedetails);
				$this->session->set_flashdata('valid','Invoice Statement Successful! Created');
			}
			redirect('cinvoice/viewinvoices');
		}
	}
	function createinvoice()
	{
	if($this->_submit_form()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['rigthcontent']= 'rigthcontent_offersheet';
			$row = $this->usermodel->getclientdropdown();
			$data['clientstable'] = $row->result();
			$data['title']= 'Create Invoice Statement';
			$data['rigthcontent']= 'rigthcontent_invoice';
			$this->load->view('template',$data);
		}
		else
		{
			$datainvoice['invoicenumber']=$this->input->post('invoicenumber');
			$datainvoice['clientid']=$this->input->post('clientid');
			$datainvoice['userid']=$this->session->userdata('userid');
			$datainvoice['daypayment']=$this->input->post('daypayment');
			$datainvoice['dayship']=$this->input->post('dayship');
			$datainvoice['servicecharges'] = $this->input->post('ser');
			$datainvoice['deliverycharges'] = $this->input->post('del');
			$this->invoicemodel->addinvoice($datainvoice);
			$haha = count($this->input->post('itemId')) - 1;
			$hehe = $this->input->post('itemId');
			$huhu = $this->input->post('qty');
			$hoho = $this->input->post('vat');
			$itemdsc = $this->input->post('dsc');
			for( $i = $haha; $i>=0; $i--){
				$invoiceid =$this->invoicemodel->getmaxinvoice();
				$datainvoicedetails['itemid']=$hehe[$i];
				$datainvoicedetails['itemquantity'] = $huhu[$i];
				$datainvoicedetails['itemtax'] = $hoho[$i];
				$datainvoicedetails['invoiceid']=$invoiceid;
				$datainvoicedetails['itemdiscount'] = $itemdsc[$i];
				$datainventory['userid']=$this->session->userdata('userid');
				$datainventory['itemid']=$hehe[$i];
				$datainventory['inventorytype']='Invoice';
				$datainventory['transactionid']=$invoiceid;
				$datainventory['itemquantity']=$huhu[$i];
				$row = $this->inventorymodel->getolditemquatity($hehe[$i]);
				$datanewitem['quantity'] = $newquantity = $row-$huhu[$i];
				$this->inventorymodel->newitem($datanewitem, $hehe[$i]);
				$this->inventorymodel->newsupply($datainventory);
				$this->invoicemodel->addinvoicedetails($datainvoicedetails);
				$this->session->set_flashdata('valid','Invoice Statement Successful! Created');
			}
			redirect('cinvoice/viewinvoices');
		}
	}
	public function viewinvoices()
	{
		$row = $this->invoicemodel->getinvoices();
		$data['invoicestable'] = $row->result();
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Invoice Statement Management';
		$data['rigthcontent']= 'rigthcontent_viewinvoice';
		$this->load->view('template',$data);
	}
	function displayinvoicedetails($invoiceid = 0)
	{
		$data['base'] = $this->config->item('base_url');
		$row = $this->invoicemodel->getinvoice($invoiceid);
		$data['invoices'] = $row->result();
		$row = $this->invoicemodel->getinvoiceDetails($invoiceid);
		$data['invoicesDetail'] = $row->result();
		$data['title']= 'Invoice Statement Details';
		$data['rigthcontent']= 'rigthcontent_detailsinvoice';
		$this->load->view('template',$data);
	}
	public function deleteoffersheets($offersheetid)
	{
		if((int)$offersheetid > 0)
		{
			$this->offersheetmodel->deleteoffersheets($offersheetid);
			$this->session->set_flashdata('message', $offersheetid. ' has been deleted');
			redirect('coffersheet/viewoffersheets','refresh');
		}
	}
	private function _submit_form()
	{
		$this->form_validation->set_rules('invoicenumber', 'Invoice Number','trim|min_length[1]|required|max_length[1000]|xss_clean|callback_invoice_check');
		$this->form_validation->set_rules('daypayment', 'Day Payment','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('dayship', 'Day Shippment','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('itemId[]', 'Reference Number','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('qty[]', 'Quantity','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('vat[]', 'Vat','trim|min_length[1]|required|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	function invoice_check($inveoiceorder)
	{
		$message['invoice_check'] = "Your Invoice number already exists";
		$this->form_validation->set_message($message);
		if($this->invoicemodel->check_exists_invoice($inveoiceorder))
		{
			return false;
		}
	
		else
		{
			return true;
		}
	}
}