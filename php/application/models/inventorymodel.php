<?php
class inventorymodel extends CI_Model
{
	
	function _construct()
	{
		parent::_contruct();
	}
	
	
	function additems($data)
	{
		if($this->db->insert('stocksitem',$data))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	

	function getallpartsbymodel($modelid)
	{
		$this->db->cache_on();
		$this->db->join('partscategory', 'partscategory.partscategoryid = stocksitem.partscategoryid', 'left');
		$this->db->where('itemtype', 'Part');
		$this->db->where('modelid', $modelid);
		$ItemsQuery = $this->db->get('stocksitem');
		if($ItemsQuery->num_rows > 0)
		{
			return $ItemsQuery;
		}
		else 
		{
			return $ItemsQuery;
		}
	}
	function getallparts()
	{
		$this->db->cache_on();
		$this->db->join('partscategory', 'partscategory.partscategoryid = stocksitem.partscategoryid', 'left');
		$this->db->where('itemtype', 'Part');
		$ItemsQuery = $this->db->get('stocksitem');
		if($ItemsQuery->num_rows > 0)
		{
			return $ItemsQuery;
		}
		else
		{
			return $ItemsQuery;
			
		}
	}
	function getallowitems()
	{
		$this->db->cache_on();
		$this->db->join('partscategory', 'partscategory.partscategoryid = stocksitem.partscategoryid', 'left');
		$this->db->where('stocksitem.quantity  <', '10');
		$this->db->order_by('stocksitem.quantity', 'dsc');
		$this->db->limit(10);
		$ItemsQuery = $this->db->get('stocksitem');
		if($ItemsQuery->num_rows > 0)
		{
			return $ItemsQuery;
		}
		else
		{
			return $ItemsQuery;
			
		}
	}
	public function getinventoryitemsDetails($itemid)
	{
		$this->db->cache_on();
		$this->db->join('inventorydetails', 'inventorydetails.itemid = stocksitem.itemid', 'left');
		$this->db->where('stocksitem.itemid',$itemid);
		$inventoryitemdetails = $this->db->get('stocksitem');
		if($inventoryitemdetails->num_rows > 0)
		{
			return $inventoryitemdetails;
		}
	
		else
		{
			return FALSE;
		}
	}
	function getallmodels()
	{
		$this->db->cache_on();
		$this->db->where('itemtype', 'Model');
		$ItemsQuery = $this->db->get('stocksitem');
		if($ItemsQuery->num_rows > 0)
		{
			return $ItemsQuery;
		}
		else
		{
			return $ItemsQuery;
		}
	}
	function deleteitems($itemid)
	{
		$this->load->database();
		$this->db->delete('stocksitem', array('itemid' => $itemid));
	}
	
	function getitemdetails($itemid)
	{
		$this->db->cache_on();
		$this->db->where('itemid',$itemid);
		$ItemDetailQuery = $this->db->get('stocksitem');
		if($ItemDetailQuery->num_rows > 0)
		{
			return $ItemDetailQuery;
		}
		else
		{
			return FALSE;
		}
	}
	function updateitem($itemid,$data)
	{
		$this->db->where('itemid',$itemid);
		$this->db->update('stocksitem',$data);
	}
	function purchaseorderupdate($datapurchaseorder,$purchaseorderid)
	{
		$this->db->where('purchaseorderid',$purchaseorderid);
		$this->db->update('purchaseorder',$datapurchaseorder);
	}
	public function itembatchDelete($idlist){
	
		$where = "itemid in ($idlist)";
		$this->db->where($where);
		$this->db->delete('stocksitem');
			
	}

	
	function getolditemquatity($itemid)
	{
		$this->db->where('itemid', $itemid);
		$query = $this->db->get('stocksitem');
		foreach ($query->result() as $row)
		{
			return $row->quantity;
		}
	}
	function newitem($datas, $itemid)
	{
		$this->db->where('itemid',$itemid);
		$this->db->update('stocksitem',$datas);
	}
	function supplydetails($data)
	{
		$this->db->insert('supplysdetails',$data);
	}
	function deductdetails($data)
	{
		$this->db->insert('deductsdetails',$data);
	}
	function getmaxsupply()
	{
		$this->db->select_max('supplyid');
		$maxsupply = $this->db->get('supplysdetails');
	
		if ($maxsupply->num_rows() == 1)
		{	
			return $maxsupply->row(0)->supplyid;
		}
		else
		{
			return false;
		}
	}
	function getmaxdeduct()
	{
		$this->db->select_max('deductid');
		$maxsupply = $this->db->get('deductsdetails');
	
		if ($maxsupply->num_rows() == 1)
		{
			return $maxsupply->row(0)->deductid;
		}
		else
		{
			return false;
		}
	}
	function newsupply($data)
	{
		$this->db->insert('inventorydetails',$data);
	}
	function getallinventorys()
	{
		$this->db->join('usersdetails', 'usersdetails.userid = inventorydetails.userid');
		$this->db->join('stocksitem', 'stocksitem.itemid = inventorydetails.itemid', 'left');
		$ItemsQuery = $this->db->get('inventorydetails');
		if($ItemsQuery->num_rows > 0)
		{
			return $ItemsQuery;
		}
		else
		{
			return $ItemsQuery;
			
		}
	}
	public function getitemsDetails($itemid)
	{
		$this->db->cache_on();
		$this->db->where('itemid',$itemid);
		$itemdetails = $this->db->get('stocksitem');
		if($itemdetails->num_rows > 0)
		{
			return $itemdetails;
		}
	
		else
		{
			return FALSE;
		}
	}
	public function gettotalquantity($partid)
	{
		$this->db->cache_on();
		$where = "itemid in ($partid)";
		$this->db->where($where);
		$this->db->where_in('inventorytype','Supply');
		$this->db->select_sum('itemquantity');
		$supplyitem = $this->db->get('inventorydetails');
		if($supplyitem->num_rows > 0)
		{
			return $supplyitem;
		}
	
		else
		{
			return FALSE;
		}
	}
	public function getdeductquantity($partid)
	{
		$this->db->cache_on();
		$this->db->where("itemid in ($partid)");
		$this->db->where('inventorytype', 'Deduct');
		$this->db->select_sum('itemquantity');
		$supplyitem = $this->db->get('inventorydetails');
		
		if($supplyitem->num_rows > 0)
		{
			return $supplyitem;
		}
	
		else
		{
			return FALSE;
		}
	}
	public function getinvoicequantity($partid)
	{
		$this->db->where("itemid in ($partid)");
		$this->db->where('inventorytype', 'Invoice');
		$this->db->select_sum('itemquantity');
		$supplyitem = $this->db->get('inventorydetails');
	
		if($supplyitem->num_rows > 0)
		{
			return $supplyitem;
		}
	
		else
		{
			return FALSE;
		}
	}
	function addpurchaseorder($datas)
	{
		$this->db->insert('purchaseorder',$datas);
	}
	function addpurchaseorderdetails($data)
	{
		$this->db->insert('purchaseorderdetails',$data);
	}
	function getmaxpurchaseorder()
	{
		$query_str1 = "SELECT MAX( purchaseorderid ) as purchaseorderid FROM purchaseorder";
		$maxorder = $this->db->query($query_str1);
			
		if ($maxorder->num_rows() == 1)
		{
				
			return $maxorder->row(0)->purchaseorderid;
		}
		else
		{
			return false;
		}
	}
	function getpurchaseorders()
	{
		$this->db->join('usersdetails', 'usersdetails.userid = purchaseorder.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = purchaseorder.clientid', 'left');
		$this->db->where('purchasetype', 'Client');
		$Query = $this->db->get('purchaseorder');
		if($Query->num_rows > 0)
		{
			return $Query;
		}
		else
		{
			return $Query;
		}
	}
	function getpurchaseorderssupplier()
	{
		$this->db->join('usersdetails', 'usersdetails.userid = purchaseorder.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = purchaseorder.clientid', 'left');
		$this->db->where('purchasetype', 'Supplier');
		$Query = $this->db->get('purchaseorder');
		if($Query->num_rows > 0)
		{
			return $Query;
		}
		else
		{
			return $Query;
		}
	}
	function newpurchase()
	{
		$this->db->join('usersdetails', 'usersdetails.userid = purchaseorder.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = purchaseorder.clientid', 'left');
		$this->db->limit(5);
		$this->db->order_by("purchasedatecreated", "desc");
		$Query = $this->db->get('purchaseorder');
		if($Query->num_rows > 0)
		{
			return $Query;
		}
		else
		{
			return $Query;
			$this->session->set_flashdata('message','No Purchase Order Found');
		}
	}
	function deletepurchaseorders($purchaseorderid)
	{
		$this->db->delete('purchaseorder', array('purchaseorderid' => $purchaseorderid));
	}
	public function getpurchaseorder($purchaseorderid)
	{
		$this->db->join('usersdetails', 'usersdetails.userid = purchaseorder.userid');
		$this->db->join('clientprofile', 'clientprofile.clientid = purchaseorder.clientid', 'left');
		$this->db->where('purchaseorderid',$purchaseorderid);
		$purchaseorder = $this->db->get('purchaseorder');
			
		if($purchaseorder->num_rows > 0)
		{
			return $purchaseorder;
		}
	
		else{
			return FALSE;
		}
	}
	public function getpurchaseorderDetails($purchaseorderid)
	{
		$this->db->join('stocksitem', 'stocksitem.itemid = purchaseorderdetails.itemid', 'left');
		$this->db->where('purchaseorderid',$purchaseorderid);
		$purchaseorderdetails = $this->db->get('purchaseorderdetails');
		if($purchaseorderdetails->num_rows > 0)
		{
			return $purchaseorderdetails;
		}
	
		else
		{
			return FALSE;
		}
	}
	function addpartscategory($data)
	{
		$this->db->insert('partscategory',$data);
	}
	function deletepartscategory($partscategoryid)
	{
		$this->load->database();
		$this->db->delete('partscategory', array('partscategoryid' => $partscategoryid));
	}
	function updatepartscategory($partscategoryid,$data)
	{
		$this->db->where('partscategoryid',$partscategoryid);
		$this->db->update('partscategory',$data);
	}
	function getallpartscategory()
	{   
		$this->db->order_by('partscategoryid', 'asc'); 
		$PartscategoryQuery = $this->db->get('partscategory');
		if($PartscategoryQuery->num_rows > 0)
		{
			return $PartscategoryQuery;
		}	
		else
		{
			return $PartscategoryQuery;
		}			
	}
	function getpartscategorydetails($partscategoryid)
	{
		$this->db->where('partscategoryid',$partscategoryid);
		$UserDetailQuery = $this->db->get('partscategory');
		if($PartscategoryDetailQuery->num_rows > 0)
		{
			return $PartscategoryDetailQuery;
		}
		else
		{
			return FALSE;
		}
	}
	function getmodeldropdown()
	{
		$this->db->where('itemtype', 'Model');
		$ClientDetailQuery = $this->db->get('stocksitem');
		if($ClientDetailQuery->num_rows > 0)
		{
			return $ClientDetailQuery;
		}
		else
		{
			return FALSE;
		}
	}
	function getcategorydropdown()
	{
		$ClientDetailQuery = $this->db->get('partscategory');
		if($ClientDetailQuery->num_rows > 0)
		{
			return $ClientDetailQuery;
		}
		else
		{
			return FALSE;
		}
	}
	public function getdeduct($deductid)
	{
		$this->db->join('usersdetails', 'usersdetails.userid = deductsdetails.userid', 'left');
		
		$this->db->where('deductid',$deductid);
		$offersheet = $this->db->get('deductsdetails');
		if($offersheet->num_rows > 0)
		{
			return $offersheet;
		}
	
		else{
			return FALSE;
		}
	}
	public function getdeductDetails($deductid)
	{
		$this->db->join('stocksitem', 'stocksitem.itemid = inventorydetails.itemid', 'left');
		$this->db->where('transactionid',$deductid);
		$this->db->where('inventorytype','Deduct');
		$offersheetdetails = $this->db->get('inventorydetails');
		if($offersheetdetails->num_rows > 0)
		{
			return $offersheetdetails;
		}
	
		else{
			return FALSE;
		}
	}
	public function getsupply($supplyid)
	{
		$this->db->join('clientprofile', 'clientprofile.clientid = supplysdetails.clientid');
		$this->db->join('usersdetails', 'usersdetails.userid = supplysdetails.userid', 'left');
		$this->db->where('supplyid',$supplyid);
		$supply = $this->db->get('supplysdetails');
		if($supply->num_rows > 0)
		{
			return $supply;
		}
	
		else{
			return FALSE;
		}
	}
	public function getsupplyDetails($supplyid)
	{
		$this->db->join('stocksitem', 'stocksitem.itemid = inventorydetails.itemid', 'left');
		$this->db->where('transactionid',$supplyid);
		$this->db->where('inventorytype','Supply');
		$supplydetails = $this->db->get('inventorydetails');
		if($supplydetails->num_rows > 0)
		{
			return $supplydetails;
		}
	
		else{
			return FALSE;
		}
	}
	function check_exists_puchase($purchaseorder)
	{
		$query_str = "SELECT purchaseordernumber FROM purchaseorder where purchaseordernumber = ?";
		$result = $this->db->query($query_str, $purchaseorder);
	
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
/* End of file inventorymodel.php */
/* Location: ./application/models/inventorymodel.php */