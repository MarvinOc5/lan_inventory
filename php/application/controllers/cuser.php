<?php 
class cuser extends CI_Controller 
{	
	function adduser()
	{
		if($this->_submit_register()===FALSE)
		{	
			if ('Administrator'!=$this->session->userdata('userlevel'))
			{
				header('Location: '.site_url('/cindex/home'));
				$this->session->set_flashdata('error',' You dont have privilage to access that page!');
			}
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Add User';
			$data['rigthcontent']= 'rigthcontent_adduser';
			$this->load->view('template',$data);
			return;
		}			
		else
		{
			$data['companyid']=$this->input->post('companyid');
			$data['username']=$this->input->post('username');
			$data['password']=do_hash($this->input->post('password'));
			$data['firstname']=$this->input->post('firstname');
			$data['lastname']=$this->input->post('lastname');
			$data['gender']=$this->input->post('gender');
			$data['email']=$this->input->post('email');
			$data['userlevel']=$this->input->post('userlevel');
			$this->usermodel->adduser($data);
			$this->session->set_flashdata('message','Registration Successful!');
			redirect('cuser/viewuser');
		}		
	}
	public function viewuser()
	{ 
		if ('Administrator'!=$this->session->userdata('userlevel'))
		{
			header('Location: '.site_url('/cindex/home'));
			$this->session->set_flashdata('error',' You dont have privilage to access that page!');
		}
		$search = $this->input->post();
		$row = $this->usermodel->getallusers();
	   	$data['userstable'] = $row->result();
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Users Management';
		$data['rigthcontent']= 'rigthcontent_viewuser';
		$this->load->view('template',$data);
	}
	
	public function viewuserdetails($userid)
	{
		$search = $this->input->post();
		$row = $this->usermodel->getuserdetails($userid);
		$data['userstable'] = $row->result();
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Users Management';
		$data['rigthcontent']= 'rigthcontent_viewuserdetails';
		$this->load->view('template',$data);
	}
	public function viewprofiledetails($userid)
	{
		$search = $this->input->post();
		$row = $this->usermodel->getuserdetails($userid);
		$data['userstable'] = $row->result();
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Users Management';
		$data['rigthcontent']= 'rigthcontent_viewprofiledetails';
		$this->load->view('template',$data);
	}
	public function updateuser($userid)
	{
		if($this->_submit_updateuser()==FALSE)
		{
			if ('Administrator'!=$this->session->userdata('userlevel'))
			{
				header('Location: '.site_url('/cindex/home'));
				$this->session->set_flashdata('error',' You dont have privilage to access that page!');
			}
			$row = $this->usermodel->getuserdetails($userid);
			$data['usersdetail'] = $row->result();
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Update user';
			$data['rigthcontent']= 'rigthcontent_updateuser';
			$this->load->view('template',$data);
		}			
		else
		{		
			$userid = $this->input->post('userid');		
			$data['companyid']=$this->input->post('companyid');
			$data['username']=$this->input->post('username');
			$data['password']=do_hash($this->input->post('password'));
			$data['firstname']=$this->input->post('firstname');
			$data['lastname']=$this->input->post('lastname');
			$data['gender']=$this->input->post('gender');
			$data['email']=$this->input->post('email');
			$data['userlevel']=$this->input->post('userlevel');
			$data['status']=$this->input->post('status');
			
			$this->usermodel->updateuser($userid,$data);
			$this->session->set_flashdata('message','User ID: '.$userid.' has been updated');
			redirect('cuser/viewUser');	
		}
	}
	public function updateprofile($userid)
	{
		if($this->_submit_updateprofile()===FALSE)
		{
			$row = $this->usermodel->getuserdetails($userid);
			$data['usersdetail'] = $row->result();
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Update Profile';
			$data['rigthcontent']= 'rigthcontent_updateprofile';
			$this->load->view('template',$data);
		}
		else
		{
			$row = $this->usermodel->getuserdetails($userid);
			foreach ($row->result() as $user)
			if(do_hash($this->input->post('oldpassword')) == $user->password)
			{
				$userid = $this->input->post('userid');
				$data['companyid']=$this->input->post('companyid');
				$data['username']=$this->input->post('username');
				$data['password']=do_hash($this->input->post('password'));
				$data['firstname']=$this->input->post('firstname');
				$data['lastname']=$this->input->post('lastname');
				$data['gender']=$this->input->post('gender');
				$data['email']=$this->input->post('email');
				
				$this->usermodel->updateuser($userid,$data);
				$this->session->set_flashdata('message','User ID: '.$userid.' has been updated');
				redirect('cuser/viewUser');
			}
			else
			{
				$this->session->set_flashdata('message','Current password invalid');
				redirect('cuser/viewUser');
			} 
				
		}
	}
	public function deactivateuser($userid)
	{
		if ('Administrator'!=$this->session->userdata('userlevel'))
		{
			header('Location: '.site_url('/cindex/home'));
			$this->session->set_flashdata('error',' You dont have privilage to access that page!');
		}
		$data['status']='NotActive';
		$this->usermodel->updateuser($userid,$data);
		$this->session->set_flashdata('massage','User'.$userid.' Deleted');
		redirect('/cuser/viewuser','refresh');
	}
	public function deactivateprofile($userid)
	{
		$data['status']='NotActive';
		$this->usermodel->updateuser($userid,$data);
		$this->session->set_flashdata('error','Your Account have been deactivate');
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('userlevel');

		redirect('','refresh');
	}
	function addclients()
	{
		if($this->_submit_addclients()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Add Client';
			$data['addlink'] = '/cuser/addclients/';
			$data['Name'] = 'Client';
			$data['rigthcontent']= 'rigthcontent_addclient';
			$this->load->view('template',$data);
			return;
		}
		else
		{
			$data['type']='Client';
			$data['clientname']=$this->input->post('clientname');
			$data['clientcontact']=$this->input->post('clientcontact');
			$data['clientphone']=$this->input->post('clientphone');
			$data['clientfax']=$this->input->post('clientfax');
			$data['clientaddress']=$this->input->post('clientaddress');
			$data['clientemail']=$this->input->post('clientemail');
			$data['clientdecription']=$this->input->post('clientdecription');
			$this->usermodel->addclients($data);
			$this->session->set_flashdata('message','Registration Successful!');
			redirect('cuser/viewclients');
		}
	}
	function addsuppliers()
	{
		if($this->_submit_addclients()===FALSE)
		{
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'Add Supplier';
			$data['Name'] = 'Supplier';
			$data['addlink'] = '/cuser/addsuppliers';
			$data['rigthcontent']= 'rigthcontent_addclient';
			$this->load->view('template',$data);
			return;
		}
		else
		{
			$data['type']='Supplier';
			$data['clientname']=$this->input->post('clientname');
			$data['clientcontact']=$this->input->post('clientcontact');
			$data['clientphone']=$this->input->post('clientphone');
			$data['clientfax']=$this->input->post('clientfax');
			$data['clientaddress']=$this->input->post('clientaddress');
			$data['clientemail']=$this->input->post('clientemail');
			$data['clientdecription']=$this->input->post('clientdecription');
			$this->usermodel->addclients($data);
			$this->session->set_flashdata('message','Registration Successful!');
			redirect('cuser/viewsuppliers');
		}
	}
	
	
	public function viewclients()
	{
		$row = $this->usermodel->getallclients();	
		$data['clientstable'] = $row->result();
		$data['Name'] = 'Client';
		$data['updatelink'] = '/cuser/updateclients/';
		$data['deletelink'] = '/cuser/deleteclient/';
		$data['addlink'] = '/cuser/addclients/';
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Clients Management';
		$data['rigthcontent']= 'rigthcontent_viewclient';
		$this->load->view('template',$data);
	}
	
	public function viewsuppliers()
	{
		$row = $this->usermodel->getallsuppliers();	
		$data['clientstable'] = $row->result();
		$data['Name'] = 'Supplier';
		$data['updatelink'] = '/cuser/updatesuppliers/';
		$data['deletelink'] = '/cuser/deletesupplier/';
		$data['addlink'] = '/cuser/addsuppliers/';
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Supplier Management';
		$data['rigthcontent']= 'rigthcontent_viewclient';
		$this->load->view('template',$data);
	}
	
	public function deleteclient($clientid)
	{
		if((int)$clientid > 0)
		{
			$data['status']='NotActive';
			$this->usermodel->updateclients($clientid,$data);
			$this->session->set_flashdata('message', $clientid. ' has been deleted');
			redirect('/cuser/viewclients/','refresh');
		}
	}
	public function deletesupplier($clientid)
	{
		if((int)$clientid > 0)
		{
			$data['status']='NotActive';
			$this->usermodel->updateclients($clientid,$data);
			$this->session->set_flashdata('message', $clientid. ' has been deleted');
			redirect('/cuser/viewclients/','refresh');
		}
	}
	
	public function updateclients($clientid=1)
	{
		if($this->_submit_addclients()===FALSE)
		{
			$row = $this->usermodel->getclientdetails($clientid);
			$data['clientsdetail'] = $row->result();
			$data['Name'] = 'Client';
			$data['base'] = $this->config->item('base_url');
			$data['updatelink'] = '/cuser/updateclients/';
			$data['title']= 'Update Client';
			$data['rigthcontent']= 'rigthcontent_updateclient';
			$this->load->view('template',$data);
		}
		else
		{
			$clientid = $this->input->post('clientid');
			
			$data['type']='Client';
			$data['clientname']=$this->input->post('clientname');
			$data['clientcontact']=$this->input->post('clientcontact');
			$data['clientphone']=$this->input->post('clientphone');
			$data['clientfax']=$this->input->post('clientfax');
			$data['clientaddress']=$this->input->post('clientaddress');
			$data['clientemail']=$this->input->post('clientemail');
			$data['clientdecription']=$this->input->post('clientdecription');
			
			$this->usermodel->updateclients($clientid,$data);
			$this->session->set_flashdata('message','Client ID: '.$clientid.' has been updated');
			redirect('cuser/viewclients/');
		}
	}
	public function updatesuppliers($clientid=1)
	{
		if($this->_submit_addclients()===FALSE)
		{
			$row = $this->usermodel->getclientdetails($clientid);
			$data['clientsdetail'] = $row->result();
			$data['base'] = $this->config->item('base_url');
			$data['Name'] = 'Supplier';
			$data['title']= 'Update Supplier';
			$data['updatelink'] = '/cuser/updatesuppliers/';
			$data['rigthcontent']= 'rigthcontent_updateclient';
			$this->load->view('template',$data);
		}
		else
		{
			$clientid = $this->input->post('clientid');
				
			$data['type']='Supplier';
			$data['clientname']=$this->input->post('clientname');
			$data['clientcontact']=$this->input->post('clientcontact');
			$data['clientphone']=$this->input->post('clientphone');
			$data['clientfax']=$this->input->post('clientfax');
			$data['clientaddress']=$this->input->post('clientaddress');
			$data['clientemail']=$this->input->post('clientemail');
			$data['clientdecription']=$this->input->post('clientdecription');
			
			$this->usermodel->updateclients($clientid,$data);
			$this->session->set_flashdata('message','Supplier ID: '.$clientid.' has been updated');
			redirect('cuser/viewsuppliers/');
		}
	}
	 function username_check($username)
	{
		$message['username_check'] = "Your username already exists";
		$this->form_validation->set_message($message);
		if($this->usermodel->check_exists_username($username))
		{
			return false;
		}
	
		else
		{
			return true;
		}
	}
	private function _submit_addclients()
	{

		$this->form_validation->set_rules('clientname', 'Client Name','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('clientcontact', 'Client Contact','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('clientphone', 'Client Phone','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('clientfax', 'Client Fax','trim|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('clientaddress', 'Client Address','trim|required|xss_clean');
		$this->form_validation->set_rules('clientemail', 'Client Email','trim|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('clientdecription', 'Client Description','trim|min_length[1]|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	private function _submit_register()
	{
		$this->form_validation->set_rules('username', 'Username','trim|required|min_length[1]|max_length[50]|xss_clean|callback_username_check');
		$this->form_validation->set_rules('lastname', 'Last Name','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('firstname', 'First Name','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('password', 'Password','trim|required|min_length[6]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('passcnf', 'Confirmation Password','trim|required|matches[password]|min_length[6]|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	private function _submit_updateprofile()
	{
		$this->form_validation->set_rules('lastname', 'Last Name','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('firstname', 'First Name','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('username', 'Username','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('oldpassword', 'Password','trim|required|min_length[6]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('password', 'Password','trim|required|min_length[6]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('passcnf', 'Confirmation Password','trim|required|matches[password]|min_length[6]|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	private function _submit_updateuser()
	{
		$this->form_validation->set_rules('lastname', 'Last Name','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('firstname', 'First Name','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('username', 'Username','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address','trim|required|min_length[1]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('password', 'Password','trim|required|min_length[6]|max_length[1000]|xss_clean');
		$this->form_validation->set_rules('passcnf', 'Confirmation Password','trim|required|matches[password]|min_length[6]|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
}
?>