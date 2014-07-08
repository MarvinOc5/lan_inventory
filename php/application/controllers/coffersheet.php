<?php
class coffersheet extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ('Administrator'!=$this->session->userdata('userlevel')
				&&'Salesincharges'!=$this->session->userdata('userlevel')
				&&'Accountant'!=$this->session->userdata('userlevel'))
		{
			$this->session->unset_userdata('userid');
			$this->session->unset_userdata('userlevel');
			header('Location: '.site_url(''));
			$this->session->set_flashdata('error',' You dont have privilage to access that page(You are not ADMIN)!');
		}
	}
	function createoffersheet()
	{
		if($this->_submit_form()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Create Offersheet';
			$data['rigthcontent']= 'rigthcontent_offersheet';
			$row = $this->usermodel->getclientdropdown();
			$data['clientstable'] = $row->result();
			$this->load->view('template',$data);
		}
		else
		{
			$datas['clientid']=$this->input->post('clientid');
			$datas['userid']=$this->session->userdata('userid');
			$datas['daypayment']=$this->input->post('daypayment');
			$datas['dayship']=$this->input->post('dayship');
			$datas['servicecharges'] = $this->input->post('ser');
			$datas['deliverycharges'] = $this->input->post('del');
			$this->offersheetmodel->addoffersheet($datas);
			$countitemId = count($this->input->post('itemId')) - 1;
			$itemId = $this->input->post('itemId');
			$itemquantity = $this->input->post('qty');
			$itemtax = $this->input->post('vat');
			$itemdsc = $this->input->post('dsc');
			$cost = $this->input->post('rate');
			for( $i = $countitemId; $i>=0; $i--){
				$offersheetid =$this->offersheetmodel->getmaxoffersheet();
				$data['itemid']= $itemId[$i];
				$data['itemquantity'] = $itemquantity[$i];
				$data['itemtax'] = $itemtax[$i];
				$data['itemdiscount'] = $itemdsc[$i];
				$data['itemdiscount'] = $itemdsc[$i];
				$data['offersheetid']=$offersheetid;
				$data['itemcost']= $cost[$i] ;
				$this->offersheetmodel->addoffersheetdetails($data);
				$this->session->set_flashdata('message','Offersheet Successful! Created');
			}
			redirect('coffersheet/viewoffersheets');
		}
	}
	public function viewoffersheets()
	{
		$row = $this->offersheetmodel->getoffersheets();
		$data['offersheetstable'] = $row->result();
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Offersheet Management';
		$data['rigthcontent']= 'rigthcontent_viewoffersheet';
		$this->load->view('template',$data);
	}
	function displayoffersheetdetails($offersheetid = 0)
	{
		$data['base'] = $this->config->item('base_url');
		$row = $this->offersheetmodel->getoffersheet($offersheetid);
		$data['offersheets'] = $row->result();
		$row = $this->offersheetmodel->getoffersheetDetails($offersheetid);
		$data['offersheetsDetail'] = $row->result();
		$data['title']= 'Offersheet Details';
		$data['rigthcontent']= 'rigthcontent_detailsoffersheet';
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
		$this->form_validation->set_rules('daypayment', 'Day Payment','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('dayship', 'Day Shippment','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('ser', 'Service Charges','trim|min_length[1]|numeric|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('itemId[]', 'Reference Number','trim|numeric|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('qty[]', 'Quantity','trim|min_length[1]|required|numeric|max_length[1000]|xss_clean');
		
		return $this->form_validation->run();
	}
}