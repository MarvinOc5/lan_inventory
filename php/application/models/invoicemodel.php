<?php
class invoicemodel extends CI_Model
{
	
	function _construct()
	{
		parent::_contruct();
	}
	function addinvoice($datas)
	{
		$this->db->insert('invoice',$datas);
	}
	function addinvoicedetails($data)
	{
		$this->db->insert('invoicedetails',$data);
	}
	function getmaxinvoice()
	{
		$query_str1 = "SELECT MAX( invoiceid ) as invoiceid FROM invoice";
		$maxorder = $this->db->query($query_str1);
			
		if ($maxorder->num_rows() == 1)
		{
				
			return $maxorder->row(0)->invoiceid;
		}
		else
		{
			return false;
		}
	}
	function getinvoices()
	{
		$this->db->join('usersdetails', 'usersdetails.userid = invoice.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = invoice.clientid', 'left');
		$ClientsQuery = $this->db->get('invoice');
		if($ClientsQuery->num_rows > 0)
		{
			return $ClientsQuery;
		}
		else
		{
			return $ClientsQuery;
			$this->session->set_flashdata('message','No invoice Found');
		}
	}
	function newinvoice()
	{
		
		$this->db->join('usersdetails', 'usersdetails.userid = invoice.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = invoice.clientid', 'left');
		$this->db->limit(5);
		$this->db->order_by("invoicedatecreated", "desc");
		$ClientsQuery = $this->db->get('invoice');
		if($ClientsQuery->num_rows > 0)
		{
			
			return $ClientsQuery;
		}
		else
		{
			return $ClientsQuery;
			$this->session->set_flashdata('message','No invoice Found');
		}
	}
	function deleteinvoices($invoiceid)
	{
		$this->load->database();
		$this->db->delete('invoice', array('invoiceid' => $invoiceid));
	}
	public function getinvoice($invoiceid)
	{
		$this->db->join('usersdetails', 'usersdetails.userid = invoice.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = invoice.clientid', 'left');
		$this->db->where('invoiceid',$invoiceid);
		$invoice = $this->db->get('invoice');
			
		if($invoice->num_rows > 0)
		{
			return $invoice;
		}
	
		else{
			return FALSE;
		}
	}
	public function getinvoiceDetails($invoiceid)
	{
		$this->db->join('stocksitem', 'stocksitem.itemid = invoicedetails.itemid', 'left');
		$this->db->where('invoiceid',$invoiceid);
		$invoicedetails = $this->db->get('invoicedetails');
		if($invoicedetails->num_rows > 0)
		{
			return $invoicedetails;
		}
	
		else{
			return FALSE;
		}
	}
	function check_exists_invoice($invoiceorder)
	{
		$query_str = "SELECT invoicenumber FROM invoice where invoicenumber = ?";
		$result = $this->db->query($query_str, $invoiceorder);
	
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
/* End of file invoicemodel.php */
/* Location: ./application/models/invoicemodel.php */