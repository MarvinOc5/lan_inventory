<?php
Class DATEPICKER extends CI_Controller 
{
	
	public function clientpicker(){
		$this->base = $this->config->item('base_url');
		$data['base'] = $this->base;
		$data['rigthcontent']= 'pdfreports/rigthcontent_pickerclient';
		$data['title']= 'Client Picker';
		$this->load->view('template',$data);
	}
	
	public function supplierpicker(){
		$this->base = $this->config->item('base_url');
		$data['base'] = $this->base;
		$data['rigthcontent']= 'pdfreports/rigthcontent_pickersupplier';
		$data['title']= 'Supplier Picker';
		$this->load->view('template',$data);
	}
	
	public function inventorypicker(){
		$this->base = $this->config->item('base_url');
		$data['base'] = $this->base;
		$data['rigthcontent']= 'pdfreports/rigthcontent_pickerinventory';
		$data['title']= 'Inventory Picker';
		$this->load->view('template',$data);
	}
	
	public function offersheetpicker(){
		$this->base = $this->config->item('base_url');
		$data['base'] = $this->base;
		$data['rigthcontent']= 'pdfreports/rigthcontent_pickeroffersheet';
		$data['title']= 'Offersheet Picker';
		$this->load->view('template',$data);
	}
	
	public function purchaseorderpicker(){
		$this->base = $this->config->item('base_url');
		$data['base'] = $this->base;
		$data['rigthcontent']= 'pdfreports/rigthcontent_pickerpurchaseorder';
		$data['title']= 'Purchaseorder Picker';
		$this->load->view('template',$data);
	}
	
	public function invoicepicker(){
		$this->base = $this->config->item('base_url');
		$data['base'] = $this->base;
		$data['rigthcontent']= 'pdfreports/rigthcontent_pickerinvoice';
		$data['title']= 'Inventory Picker';
		$this->load->view('template',$data);
	}
	
	public function purchaseordersupplier(){
		$this->base = $this->config->item('base_url');
		$data['base'] = $this->base;
		$data['rigthcontent']= 'pdfreports/rigthcontent_pickerposupplier';
		$data['title']= 'Purchase Order Supplier Picker';
		$this->load->view('template',$data);
	}
}

?>