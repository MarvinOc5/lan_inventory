<?php
class usermodel extends CI_Model
{
	
	function _construct()
	{
		parent::_contruct();
	}	
	function addUser($data)
	{
		if($this->db->insert('usersdetails',$data))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	function getallusers()
	{  
		$this->db->order_by('userid', 'asc'); 
		$UsersQuery = $this->db->get('usersdetails');
		if($UsersQuery->num_rows > 0)
		{
			return $UsersQuery;
		}	
		else
		{
			return $UsersQuery;
		}			
	}
	function getuserdetails($userid)
	{
		$this->db->where('userid',$userid);
		$UserDetailQuery = $this->db->get('usersdetails');
		if($UserDetailQuery->num_rows > 0)
		{
			return $UserDetailQuery;
		}
		else
		{
			return FALSE;	
		}					
	}
	function updateUser($userid,$data)
	{
		$this->db->where('userid',$userid);
		$this->db->update('usersdetails',$data);
	}	
	public function verifyuser($username,$password)
	{
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$this->db->where('status','Active');
		$this->db->limit(1);
		$UserQuery  = $this->db->get('usersdetails');
		
		if($UserQuery->num_rows > 0)
		{
			return $UserQuery;
		}
		else 
		{
			return FALSE;	
		}
	}
	
	function addclients($data)
	{
		if($this->db->insert('clientprofile',$data))
		{
			return TRUE;
		}
		return FALSE;
	}
	public function userbatchdelete($idlist){
	
		$where = "userid in ($idlist)";
		$this->db->where($where);
		$this->db->delete('usersdetails');
			
	}
	
	
	function getallclients()
	{
		$this->db->where('type', 'Client');
		$ClientsQuery = $this->db->get('clientprofile');
		if($ClientsQuery->num_rows > 0)
		{
			return $ClientsQuery;
		}
		else
		{
			return $ClientsQuery;
		}
	}
	
	function getallsuppliers()
	{
		$this->db->where('type', 'Supplier');
		$ClientsQuery = $this->db->get('clientprofile');
		if($ClientsQuery->num_rows > 0)
		{
			return $ClientsQuery;
		}
		else
		{
			return $ClientsQuery;
		}
	}
	function getclientdetails($clientid)
	{
		$this->db->where('clientid',$clientid);
		$ClientDetailQuery = $this->db->get('clientprofile');
		if($ClientDetailQuery->num_rows > 0)
		{
			return $ClientDetailQuery;
		}
		else
		{
			return FALSE;
		}
	}
	function updateclients($clientid,$data)
	{
		$this->db->where('clientid',$clientid);
		$this->db->update('clientprofile',$data);
	}
	function deleteclient($clientid)
	{
		$this->load->database();
		$this->db->delete('clientprofile', array('clientid' => $clientid));
	}
	function getsupplierdropdown()
	{
		$this->db->where('status', 'Active');
		$this->db->where('type', 'Supplier');
		$ClientDetailQuery = $this->db->get('clientprofile');
		if($ClientDetailQuery->num_rows > 0)
		{
			return $ClientDetailQuery;
		}
		else
		{
			return $ClientDetailQuery;
		}
	}
	function getclientdropdown()
	{
		$this->db->where('status', 'Active');
		$this->db->where('type', 'Client');
		$ClientDetailQuery = $this->db->get('clientprofile');
		if($ClientDetailQuery->num_rows > 0)
		{
			return $ClientDetailQuery;
		}
		else
		{
			return FALSE;
		}
	}	
	function check_exists_username($username)
	{
		$query_str = "SELECT username FROM usersdetails where username = ?";
		$result = $this->db->query($query_str, $username);
	
		if($result->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}