<?php 
class cinventory extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		if ('Administrator'!=$this->session->userdata('userlevel')
				&&'Salesincharges'!=$this->session->userdata('userlevel')
				&&'Accountant'!=$this->session->userdata('userlevel')
				&&'Stockclerk'!=$this->session->userdata('userlevel'))
		{
			$this->session->unset_userdata('userid');
			$this->session->unset_userdata('userlevel');
			header('Location: '.site_url(''));
		 	$this->session->set_flashdata('error',' You dont have privilage to access that page(You are not ADMIN)!');
		}
	}
	function addparts()
	{
		if($this->_submit_additems()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Add Part';
			$data['addlink'] = '/cinventory/addparts/';
			$data['Name'] = 'Part';
			$row = $this->inventorymodel->getmodeldropdown();
			$data['modelstable'] = $row->result();
			$row = $this->inventorymodel->getcategorydropdown();
			$data['categorystable'] = $row->result();
			$data['rigthcontent']= 'rigthcontent_additems';
			$this->load->view('template',$data);
			return;
		}
		else
		{
			$data['itemtype']='Part';
			$data['modelid']=$this->input->post('modelid');
			$data['partscategoryid']=$this->input->post('partscategoryid');
			$data['number']=$this->input->post('number');
			$data['description']=$this->input->post('description');
			$data['cost']=$this->input->post('cost');
			$data['price']=$this->input->post('price');
			$data['location']=$this->input->post('location');
			$this->inventorymodel->additems($data);
			$this->session->set_flashdata('valid','Item Added Successful!');
			redirect('cinventory/viewparts');
		}
	}
	function addmodels()
	{
		if($this->_submit_additems()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Add Model';
			$data['Name'] = 'Model';
			$data['addlink'] = '/cinventory/addmodels';
			$data['rigthcontent']= 'rigthcontent_additems';
			$this->load->view('template',$data);
			return;
		}
		else
		{
			$data['itemtype']='Model';
			$data['number']=$this->input->post('number');
			$data['description']=$this->input->post('description');
			$data['cost']=$this->input->post('cost');
			$data['price']=$this->input->post('price');
			$data['location']=$this->input->post('location');
			$this->inventorymodel->additems($data);
			$this->session->set_flashdata('valid','Item Added Successful!');
			redirect('cinventory/viewmodels');
		}
	}
	public function deleteparts($itemid)
	{
		if((int)$itemid > 0)
		{
			$this->inventorymodel->deleteitems($itemid);
			$this->session->set_flashdata('message', $itemid. ' has been deleted');
			redirect('/cinventory/viewparts','refresh');
		}
	}
	public function deletemodels($itemid)
	{
		if((int)$itemid > 0)
		{
			$this->inventorymodel->deleteitems($itemid);
			$this->session->set_flashdata('message', $itemid. ' has been deleted');
			redirect('cinventory/viewmodels','refresh');
		}
	}
	
	public function viewparts()
	{
		$row = $this->inventorymodel->getallparts();	
		$data['itemstable'] = $row->result();
		$data['Name'] = 'Part';
		$data['upadatelink'] = '/cinventory/updateparts/';
		$data['deletelink'] = '/cinventory/deleteparts/';
		$data['addlink'] = '/cinventory/addparts/';
		$data['batchdeletelink'] = '/cinventory/deletepartcheck/';
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Parts Management';
		$data['rigthcontent']= 'rigthcontent_viewitem';
		$this->load->view('template',$data);
	}
	public function viewmodels()
	{
		$row = $this->inventorymodel->getallmodels();
		$data['itemstable'] = $row->result();
		$data['Name'] = 'Model';
		$data['upadatelink'] = '/cinventory/updatemodels/';
		$data['deletelink'] = '/cinventory/deletemodels/';
		$data['addlink'] = '/cinventory/addmodels/';
		$data['batchdeletelink'] = '/cinventory/deletemodelcheck/';
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Models Management';
		$data['rigthcontent']= 'rigthcontent_viewitem';
		$this->load->view('template',$data);
	}
	public function updateparts($itemid=1)
	{
		if($this->_submit_additems()===FALSE)
		{
			$row = $this->inventorymodel->getitemdetails($itemid);
			$data['itemsdetail'] = $row->result();
			$data['Name'] = 'Part';
			$data['base'] = $this->config->item('base_url');
			$row = $this->inventorymodel->getmodeldropdown();
			$data['modelstable'] = $row->result();
			$row = $this->inventorymodel->getcategorydropdown();
			$data['categorystable'] = $row->result();
			$data['updatelink'] = '/cinventory/updateparts/';
			$data['title']= 'Update Items';
			$data['rigthcontent']= 'rigthcontent_updateitem';
			$this->load->view('template',$data);
		}
		else
		{
			$itemid = $this->input->post('itemid');
			
			$data['itemtype']='Part';
			$data['modelid']=$this->input->post('modelid');
			$data['partscategoryid']=$this->input->post('partscategoryid');
			$data['number']=$this->input->post('number');
			$data['description']=$this->input->post('description');
			$data['cost']=$this->input->post('cost');
			$data['price']=$this->input->post('price');
			$data['location']=$this->input->post('location');
			$this->inventorymodel->updateitem($itemid,$data);
			$this->session->set_flashdata('valid','Parts ID: '.$itemid.' has been updated');
			redirect('cinventory/viewparts/');
		}
	}
	public function updatemodels($itemid=1)
	{
		if($this->_submit_additems()===FALSE)
		{
			$row = $this->inventorymodel->getitemdetails($itemid);
			$data['itemsdetail'] = $row->result();
			$data['base'] = $this->config->item('base_url');
			$data['Name'] = 'Model';
			$data['title']= 'Update Items';
			$data['updatelink'] = '/cinventory/updatemodels/';
			$data['rigthcontent']= 'rigthcontent_updateitem';
			$this->load->view('template',$data);
		}
		else
		{
			$itemid = $this->input->post('itemid');
				
			$data['itemtype']='Model';
			$data['number']=$this->input->post('number');
			$data['description']=$this->input->post('description');
			$data['cost']=$this->input->post('cost');
			$data['price']=$this->input->post('price');
			$data['location']=$this->input->post('location');
			$this->inventorymodel->updateitem($itemid,$data);
			$this->session->set_flashdata('message','Parts ID: '.$itemid.' has been updated');
			redirect('cinventory/viewmodels/');
		}
	}
	public function deletemodelcheck()
	{
		if($this->input->post('Delete'))
		{
			if(count($this->input->post('itemid')))
			{
				$idlist = implode(',',array_values($this->input->post('itemid')));
				$this->inventorymodel->itembatchDelete($idlist);
				$this->session->set_flashdata('message','Model(s)'.$idlist.' Deleted');
				redirect('/cinventory/viewmodels','refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('message','No Model were deleted');
			redirect('cinventory/viewmodels','refresh');
		}
	}
	public function deletepartcheck()
	{
		if($this->input->post('Delete'))
		{
			if(count($this->input->post('itemid')))
			{
				$idlist = implode(',',array_values($this->input->post('itemid')));
				$this->inventorymodel->itembatchdelete($idlist);
				$this->session->set_flashdata('message','Part(s)'.$idlist.' Deleted');
				redirect('cinventory/viewparts','refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('message','No Parts were deleted');
			redirect('cinventory/viewparts','refresh');
		}
	}
	
	function supplierrecieve()
	{
		if ($this->_submit_supply()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Recieve Products';
			$data['rigthcontent']= 'rigthcontent_supplierrecieve';
			$row = $this->usermodel->getsupplierdropdown();
			$data['supplierdropdown'] = $row->result();
			$this->load->view('template',$data);	
		}
		else 
		{
			$supplydetails['clientid']=$this->input->post('clientid');
			$supplydetails['userid']=$this->session->userdata('userid');
			$supplydetails['supplydesc']=$this->input->post('desc');
			$this->inventorymodel->supplydetails($supplydetails);
			$haha = count($this->input->post('itemId')) - 1;
			$hehe = $this->input->post('itemId');
			$huhu = $this->input->post('qty');
		
			$data['userid']=$this->session->userdata('userid');
			for( $i = $haha; $i>=0; $i--)
			{
				$supplyid = $this->inventorymodel->getmaxsupply();
				$data['itemid']=$hehe[$i];
				$data['inventorytype']='Supply';
				$data['itemquantity']=$huhu[$i];
				$data['transactionid']=$supplyid;
				$row = $this->inventorymodel->getolditemquatity($hehe[$i]);
				$datas['quantity'] = $newquantity = $huhu[$i]+$row;
				$this->inventorymodel->newitem($datas, $hehe[$i]);
				$this->inventorymodel->newsupply($data);
				$this->session->set_flashdata('valid','New Supply Updated');
			}
			redirect('cinventory/viewinventory');
		}
	}
	function deductitem()
	{
		if($this->_submit_deduction()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Deduct Item';
			$data['rigthcontent']= 'rigthcontent_releaseitem';
			$this->load->view('template',$data);
		}
		else
		{
			$deductdetails['userid']=$this->session->userdata('userid');
			$deductdetails['deductdesc']=$this->input->post('desc');
			$deductdetails['cname']=$this->input->post('cname');
			$this->inventorymodel->deductdetails($deductdetails);
			$haha = count($this->input->post('itemId')) - 1;
			$hehe = $this->input->post('itemId');
			$huhu = $this->input->post('qty');
			$data['inventorydesc']=$this->input->post('desc');
			$data['userid']=$this->session->userdata('userid');
			for( $i = $haha; $i>=0; $i--)
			{
				$deductid = $this->inventorymodel->getmaxdeduct();
				$data['itemid']=$hehe[$i];
				$data['inventorytype']='Deduct';
				$data['itemquantity']=$huhu[$i];
				$data['transactionid']=$deductid;
				$row = $this->inventorymodel->getolditemquatity($hehe[$i]);
				$datas['quantity'] = $newquantity = $row-$huhu[$i];
				$this->inventorymodel->newitem($datas, $hehe[$i]);
				$this->inventorymodel->newsupply($data);
				$this->session->set_flashdata('valid','Items Deducted');
			}
			redirect('cinventory/viewinventory');
		}
	}
	public function viewinventory()
	{
		$row = $this->inventorymodel->getallinventorys();
		$data['inventorystable'] = $row->result();
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Inventory Management';
		$data['rigthcontent']= 'rigthcontent_viewinventory';
		$this->load->view('template',$data);
	}
	function displaystocksdetails($itemid)
	{
		$data['base'] = $this->config->item('base_url');
		$row = $this->inventorymodel->getitemsDetails($itemid);
		$types = $data['itemsdetails'] = $row->result();
		$row = $this->inventorymodel->getinventoryitemsDetails($itemid);
		$data['inventoryitemsdetails'] = $row->result();
		$row = $this->inventorymodel->gettotalquantity($itemid);
		$data['totalsupply'] = $row->result();
		$row = $this->inventorymodel->getdeductquantity($itemid);
		$data['totaldeduction'] = $row->result();
		$row = $this->inventorymodel->getinvoicequantity($itemid);
		$data['totalinvoice'] = $row->result();
		$data['title']= 'Items Details Management';
		$data['rigthcontent']= 'rigthcontent_detailsitems';
		$this->load->view('template',$data);
	}
	function offersheettopo($offersheetid = 0)
	{
		if($this->_submit_purchaseorder()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$row = $this->offersheetmodel->getoffersheet($offersheetid);
			$data['offersheets'] = $row->result();
			$row = $this->offersheetmodel->getoffersheetDetails($offersheetid);
			$data['offersheetsDetail'] = $row->result();
			$data['title']= 'Create Purchase Order';
			$data['rigthcontent']= 'rigthcontent_offersheettopo';
			$this->load->view('template',$data);
		}
		else
		{
			$offersheetid =$this->input->post('offersheetid');
			$offersheetstatus['offersheetstatus']='Transfer to po';
			$this->offersheetmodel->offersheetupdate($offersheetstatus,$offersheetid);
			$datas['clientid']=$this->input->post('clientid');
			$datas['userid']=$this->session->userdata('userid');
			$datas['purchasetype']='Client';
			$datas['daypayment']=$this->input->post('daypayment');
			$datas['purchaseordernumber']=$this->input->post('purchaseordernumber');
			$datas['servicecharges'] = $this->input->post('ser');
			$datas['deliverycharges'] = $this->input->post('del');
			$datas['dayship']=$this->input->post('dayship');
			$this->inventorymodel->addpurchaseorder($datas);
			$haha = count($this->input->post('itemId')) - 1;
			$hehe = $this->input->post('itemId');
			$huhu = $this->input->post('qty');
			$hoho = $this->input->post('vat');
			$cost = $this->input->post('rate');
			$itemdsc = $this->input->post('dsc');
			for( $i = $haha; $i>=0; $i--){
				$purchaseorderid =$this->inventorymodel->getmaxpurchaseorder();
				$data['itemid']=$hehe[$i];
				$data['poitemcost']= $cost[$i] ;
				$data['itemquantity'] = $huhu[$i];
				$data['itemtax'] = 0;
				$data['itemdiscount'] = 0;
				$data['purchaseorderid']=$purchaseorderid;
				$this->inventorymodel->addpurchaseorderdetails($data);
				$this->session->set_flashdata('valid','Purchase Order Successful! Created');
			}
			redirect('cinventory/viewpurchaseorders');
		}
	}
	function createpurchaseorder()
	{
		if($this->_submit_purchaseorder()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Create Purchase Order';
			$row = $this->usermodel->getclientdropdown();
			$data['clientstable'] = $row->result();
			$data['rigthcontent']= 'rigthcontent_purchaseorder';
			$this->load->view('template',$data);
		}
		else
		{
			$datas['clientid']=$this->input->post('clientid');
			$datas['userid']=$this->session->userdata('userid');
			$datas['daypayment']=$this->input->post('daypayment');
			$datas['purchaseordernumber']=$this->input->post('purchaseordernumber');
			$datas['dayship']=$this->input->post('dayship');
			$datas['purchasetype']='Client';
			$datas['servicecharges'] = $this->input->post('ser');
			$datas['deliverycharges'] = $this->input->post('del');
			$this->inventorymodel->addpurchaseorder($datas);
			$haha = count($this->input->post('itemId')) - 1;
			$hehe = $this->input->post('itemId');
			$huhu = $this->input->post('qty');
			$hoho = $this->input->post('vat');
			$cost = $this->input->post('rate');
			$itemdsc = $this->input->post('dsc');
			for( $i = $haha; $i>=0; $i--){
				$purchaseorderid =$this->inventorymodel->getmaxpurchaseorder();
				$data['itemid']=$hehe[$i];
				$data['poitemcost']= $cost[$i] ;
				$data['itemquantity'] = $huhu[$i];
				$data['itemtax'] = 0;
				$data['itemdiscount'] = 0;
				$data['purchaseorderid']=$purchaseorderid;
				$this->inventorymodel->addpurchaseorderdetails($data);
				$this->session->set_flashdata('valid','Purchase Order Successful! Created');
			}
			redirect('cinventory/viewpurchaseorders');
		}
	}
	public function viewpurchaseorders()
	{
		$row = $this->inventorymodel->getpurchaseorders();
		$data['purchaseorderstable'] = $row->result();
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Purchase Order Management';
		$data['rigthcontent']= 'rigthcontent_viewpurchaseorder';
		$this->load->view('template',$data);
	}
	public function viewpurchaseordersupplier()
	{
		$row = $this->inventorymodel->getpurchaseorderssupplier();
		$data['purchaseorderstable'] = $row->result();
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Purchase Order Supplier Management';
		$data['rigthcontent']= 'rigthcontent_viewpurchaseordersupplier';
		$this->load->view('template',$data);
	}
	public function deletepurchaseorders($purchaseorderid)
	{
		if((int)$purchaseorderid > 0)
		{
			$this->inventorymodel->deletepurchaseorders($purchaseorderid);
			$this->session->set_flashdata('message', $purchaseorderid. ' has been deleted');
			redirect('cinventory/viewpurchaseorders','refresh');
		}
	}
	function displaypurchaseorderdetails($purchaseorderid = 0)
	{
		$data['base'] = $this->config->item('base_url');
		$row = $this->inventorymodel->getpurchaseorder($purchaseorderid);
		$data['purchaseorder'] = $row->result();
		$row = $this->inventorymodel->getpurchaseorderDetails($purchaseorderid);
		$data['purchasesheetsDetail'] = $row->result();
		$data['title']= 'Purchase Order Details Management';
		$data['rigthcontent']= 'rigthcontent_detailspurchaseorder';
		$this->load->view('template',$data);
	}
	function displaypurchaseorderdetailssupplier($purchaseorderid = 0)
	{
		$data['base'] = $this->config->item('base_url');
		$row = $this->inventorymodel->getpurchaseorder($purchaseorderid);
		$data['purchaseorder'] = $row->result();
		$row = $this->inventorymodel->getpurchaseorderDetails($purchaseorderid);
		$data['purchasesheetsDetail'] = $row->result();
		$data['title']= 'Purchase Order Details Management';
		$data['rigthcontent']= 'rigthcontent_detailspurchaseordersupplier';
		$this->load->view('template',$data);
	}
	function addpartscategory()
	{
		if($this->_submit_addpartscategory()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Add Parts Category';
			$data['rigthcontent']= 'rigthcontent_addpartscategory';
			$this->load->view('template',$data);
			return;
		}
		else
		{
			$data['partscategoryid']=$this->input->post('partscategoryid');
			$data['name']=$this->input->post('name');
			$data['categorydescription']=$this->input->post('description');
			$this->inventorymodel->addpartscategory($data);
			$this->session->set_flashdata('message','Save new category!');
			redirect('cinventory/viewpartscategory');
		}
	}
	public function viewpartscategory()
	{
		$search = $this->input->post();
		$row = $this->inventorymodel->getallpartscategory();
		$data['userstable'] = $row->result();
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Category Management';
		$data['rigthcontent']= 'rigthcontent_viewpartscategory';
		$this->load->view('template',$data);
	}
	public function deletepartscategory($partscategoryid)
	{
		if((int)$partscategoryid > 0)
		{
			$this->inventorymodel->deletepartscategory($partscategoryid);
			$this->session->set_flashdata('message', $partscategoryid. ' has been deleted');
			redirect('/cinventory/viewpartscategory/','refresh');
		}
	}
	function displaydeductsdetails($deductid)
	{
		$data['base'] = $this->config->item('base_url');
		$row = $this->inventorymodel->getdeduct($deductid);
		$data['deducts'] = $row->result();
		$row = $this->inventorymodel->getdeductDetails($deductid);
		$data['dedutsDetail'] = $row->result();
		$data['title']= 'Deduct Details';
		$data['rigthcontent']= 'rigthcontent_detailsdeduct';
		$this->load->view('template',$data);
	}
	function displaysupplysdetails($supplyid)
	{
		$data['base'] = $this->config->item('base_url');
		$row = $this->inventorymodel->getsupply($supplyid);
		$data['supplys'] = $row->result();
		$row = $this->inventorymodel->getsupplyDetails($supplyid);
		$data['supplysDetail'] = $row->result();
		$data['title']= 'Supply Details';
		$data['rigthcontent']= 'rigthcontent_detailssupply';
		$this->load->view('template',$data);
	}
	public function viewfsnlist()
	{
		$row = $this->inventorymodel->getallparts();
		$data['itemstable'] = $row->result();
		$data['Name'] = 'Part';
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Parts Management';
		$data['rigthcontent']= 'rigthcontent_viewfsnlist';
		$this->load->view('template',$data);
	}
	function createpurchaseordersupplier()
	{
		if($this->_submit_purchaseorderssupplier()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Create Purchase Order Supplier';
			$row = $this->usermodel->getsupplierdropdown();
			$data['clientstable'] = $row->result();
			$data['rigthcontent']= 'rigthcontent_purchaseordersupplier';
			$this->load->view('template',$data);
		}
		else
		{
			$datas['clientid']=$this->input->post('clientid');
			$datas['userid']=$this->session->userdata('userid');
			$datas['daypayment']=$this->input->post('daypayment');
			$datas['purchaseordernumber']=$this->input->post('purchaseordernumber');
			$datas['purchasetype']='Supplier';
			$datas['dayship']=$this->input->post('dayship');
			$datas['servicecharges'] = $this->input->post('ser');
			$this->inventorymodel->addpurchaseorder($datas);
			$haha = count($this->input->post('itemId')) - 1;
			$hehe = $this->input->post('itemId');
			$huhu = $this->input->post('qty');
			$hoho = $this->input->post('vat');
			$cost = $this->input->post('rate');
			$itemdsc = $this->input->post('dsc');
			for( $i = $haha; $i>=0; $i--){
				$purchaseorderid =$this->inventorymodel->getmaxpurchaseorder();
				$data['itemid']=$hehe[$i];
				$data['poitemcost']= $cost[$i] ;
				$data['itemquantity'] = $huhu[$i];
				$data['itemtax'] = 0;
				$data['itemdiscount'] = 0;
				$data['purchaseorderid']=$purchaseorderid;
				$this->inventorymodel->addpurchaseorderdetails($data);
				$this->session->set_flashdata('valid','Purchase Order Successful! Created');
			}
			redirect('cinventory/viewpurchaseordersupplier');
		}
	}
	function purchase_check($purchaseorder)
	{
		$message['purchase_check'] = "Your Purchase number already exists";
		$this->form_validation->set_message($message);
		if($this->inventorymodel->check_exists_puchase($purchaseorder))
		{
			return false;
		}
	
		else
		{
			return true;
		}
	}
	
	private function _submit_addpartscategory()
	{
		$this->form_validation->set_rules('name', 'Category Name','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('description', 'Category Description','trim|min_length[1]|required|max_length[1000]|xss_clean');
		
		return $this->form_validation->run();
	}
	private function _submit_additems()
	{
		$this->form_validation->set_rules('number', 'Reference Number','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('description', 'Description','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('cost', 'Cost','trim|min_length[1]|numeric|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('price', 'Price','trim|min_length[1]|numeric|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('location', 'Location','trim|min_length[1]|required|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	private function _submit_form()
	{
		$this->form_validation->set_rules('daypayment', 'Day Payment','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('dayship', 'Day Shippment','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('itemId[]', 'Reference Number','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('qty[]', 'Quantity','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('vat[]', 'Vat','trim|min_length[1]|required|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	
	private function _submit_purchaseorder()
	{
		$this->form_validation->set_rules('purchaseordernumber', 'Purchase Order Number','trim|required|min_length[1]|max_length[50]|xss_clean|callback_purchase_check');
		$this->form_validation->set_rules('daypayment', 'Day Payment','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('dayship', 'Day Shippment','trim|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('itemId[]', 'Reference Number','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('qty[]', 'Quantity','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('vat[]', 'Vat','trim|min_length[1]|required|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	private function _submit_purchaseorderssupplier()
	{
		$this->form_validation->set_rules('purchaseordernumber', 'Purchase Order Number','trim|required|min_length[1]|max_length[50]|xss_clean|callback_purchase_check');
		$this->form_validation->set_rules('itemId[]', 'Reference Number','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('qty[]', 'Quantity','trim|min_length[1]|required|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	private function _submit_supply()
	{
		$this->form_validation->set_rules('itemId[]', 'Reference Number','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('qty[]', 'Quantity','trim|min_length[1]|required|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	private function _submit_deduction()
	{
		$this->form_validation->set_rules('itemId[]', 'Reference Number','trim|min_length[1]|required|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('qty[]', 'Quantity','trim|min_length[1]|required|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}

	
}
/* End of file cinventory.php */
/* Location: ./application/controllers/cinventory.php */