<?php
class offersheetmodel extends CI_Model
{
	
	function _construct()
	{
		parent::_contruct();
	}
	function addoffersheet($datas)
	{
		$this->db->insert('offersheet',$datas);
	}
	function addoffersheetdetails($data)
	{
		$this->db->insert('offersheetdetails',$data);
	}
	function getmaxoffersheet()
	{
		$query_str1 = "SELECT MAX( offersheetid ) as offersheetid FROM offersheet";
		$maxorder = $this->db->query($query_str1);
			
		if ($maxorder->num_rows() == 1)
		{
				
			return $maxorder->row(0)->offersheetid;
		}
		else
		{
			return false;
		}
	}
	function getoffersheets()
	{
		$this->db->join('usersdetails', 'usersdetails.userid = offersheet.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = offersheet.clientid', 'left');
		$ClientsQuery = $this->db->get('offersheet');
		if($ClientsQuery->num_rows > 0)
		{
			return $ClientsQuery;
		}
		else
		{
			return $ClientsQuery;
			redirect('/coffersheet/viewoffersheets','refresh');
		}
	}
	function newoffer()
	{
		$this->db->join('usersdetails', 'usersdetails.userid = offersheet.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = offersheet.clientid', 'left');
		$this->db->limit(5);
		$this->db->order_by("offerdatecreated", "desc");
		$ClientsQuery = $this->db->get('offersheet');
		if($ClientsQuery->num_rows > 0)
		{
			return $ClientsQuery;
		}
		else
		{
			return $ClientsQuery;
			$this->session->set_flashdata('message','No Offersheet Found');
		}
	}
	function deleteoffersheets($offersheetid)
	{
		$this->load->database();
		$this->db->delete('offersheet', array('offersheetid' => $offersheetid));
	}
	public function getoffersheet($offersheetid)
	{
		$this->db->join('usersdetails', 'usersdetails.userid = offersheet.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = offersheet.clientid', 'left');
		$this->db->where('offersheetid',$offersheetid);
		$offersheet = $this->db->get('offersheet');	
		if($offersheet->num_rows > 0)
		{
			return $offersheet;
		}
	
		else{
			return FALSE;
		}
	}
	public function getoffersheetDetails($offersheetid)
	{
		$this->db->join('stocksitem', 'stocksitem.itemid = offersheetdetails.itemid', 'left');
		$this->db->where('offersheetid',$offersheetid);
		$offersheetdetails = $this->db->get('offersheetdetails');
		if($offersheetdetails->num_rows > 0)
		{
			return $offersheetdetails;
		}
	
		else{
			return FALSE;
		}
	}
	function offersheetupdate($offersheetstatus,$offersheetid)
	{
		$this->db->where('offersheetid',$offersheetid);
		$this->db->update('offersheet',$offersheetstatus);
	}
}
/* End of file offersheetmodel.php */
/* Location: ./application/models/offersheetmodel.php */