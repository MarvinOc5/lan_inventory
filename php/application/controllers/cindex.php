<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CIndex extends CI_Controller
{
	public function index() 
	{	
		if($this->_submit_login()===FALSE) 
		{	
			$data['base'] = $this->config->item('base_url');
			$data['title']= 'The Philippine New Long Corporation';
			$this->load->view('index',$data);
			return;
			return $this->index();
		}
		else 
		{
			if($this->input->post('username')) 
			{
				$username = $this->input->post('username');
				$password = do_hash($this->input->post('password'));
					if ($row = $this->usermodel->verifyuser($username,$password)) 
					{
						$data['userdetail'] = $row->result();
						foreach($data['userdetail'] as $UserItem) 
						{
							$_SESSION['userid'] = $UserItem->userid;
							$_SESSION['userlevel'] = $UserItem->userlevel;
							$_SESSION['username'] = $UserItem->username;
						}
							if ($_SESSION['userid'] > 0) 
							{
								$this->session->set_userdata('userid', $UserItem->userid);
								$this->session->set_userdata('userlevel', $UserItem->userlevel);
								$this->session->set_userdata('user_name', $UserItem->firstname.' '.$UserItem->lastname);
								$this->_redirect();
							}
					}
					else 
					{
						$this->session->set_flashdata('error','Account unknown, consult the Administrator!');	
						redirect('cindex/index','refresh');
					}
			}
		}
	}
	function _redirect()
	{
		// Is there a redirect to handle?
		if( ! isset($_POST['redirect']))
		{
			redirect("/cindex/home", "location");
			return;
		}
	
		// Basic check to make sure we aren't redirecting to the login page
		// current_url would be your login controller
		if($_POST['redirect'] === current_url())
		{
			redirect("/cindex/home", "location");
			return;
		}
	
		redirect($_POST['redirect'], "location");
	}
	public function logout() {
		$this->session->set_flashdata('error','You have been logged out!');
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('userlevel');
		redirect('','refresh');
	}
	private function _submit_login() { 
		$this->form_validation->set_rules('username', 'Username','trim|required|min_length[1]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('password', 'Password','trim|required|min_length[1]|max_length[1000]|xss_clean');
		return $this->form_validation->run();
	}
	public function home()
	{
		$data['base'] = $this->config->item('base_url');
		$data['title']= 'Home';
		$data['rigthcontent']= 'rigthcontent_home';
		$row = $this->inventorymodel->getallowitems();
		$data['itemstable'] = $row->result();
		$row = $this->offersheetmodel->newoffer();
		$data['offerstable'] = $row->result();
		$row = $this->inventorymodel->newpurchase();
		$data['purchasetable'] = $row->result();
		$row = $this->invoicemodel->newinvoice();
		$data['invoicetable'] = $row->result();
		$this->load->view('template',$data);
	}
}

/* End of file cindex.php */
/* Location: ./application/controllers/cindex.php */