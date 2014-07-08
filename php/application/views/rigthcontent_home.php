

<div class="right_content">
<font color="red" size="3"><?php if($this->session->flashdata('message'))  {
			echo '<div class="warning_box">';
	     	echo $this->session->flashdata('message'); 
	      	echo '</div>'; }
		   if($this->session->flashdata('error'))  {
			echo '<div class="error_box">';
	     	echo $this->session->flashdata('error'); 
	      	echo '</div>'; }
		   if($this->session->flashdata('valid'))  {
			echo '<div class="valid_box">';
	     	echo $this->session->flashdata('valid'); 
	      	echo '</div>'; } ?></font>
<a class="menuitem submenuheader" href=""><h2>Low Quantity items (<?php echo count($itemstable) ?>)</h2></a>

                
    <div class="submenu">
    <table id="tablesorter" class="rounded-corner">
    <thead>
    	<tr>
    		<th rowspan="2" hidden=hidden>&nbsp;</th>
            <th rowspan="2" style="cursor: pointer">Reference Number</th>
            <th rowspan="2" style="cursor: pointer">Description</th>
            <th rowspan="2" style="cursor: pointer">Price</th>
            <th rowspan="2" style="cursor: pointer">Quantity</th>
            <th rowspan="2" style="cursor: pointer">Stocks-Level</th>
			<th rowspan="2" style="cursor: pointer">Avialability</th>
	
    </thead>
    <tbody>
    
    		<?php
    		
    		foreach ($itemstable as $item):
    		
			$plusquantity = $this->inventorymodel->gettotalquantity($item->itemid);
			$deductquantity = $this->inventorymodel->getdeductquantity($item->itemid);
			foreach ($plusquantity->result() as $plus):
			foreach ($deductquantity->result() as $deduct):
			?>
			<tr>
				
				<td hidden=hidden ><?php echo $item->name; ?></td>
				<td><?php echo anchor('/cinventory/displaystocksdetails/'.$item->itemid, $item->number); ?></td>
				<td><?php echo substr($item->description, 0,30); ?></td>
				<td> <?php echo $item->price; ?>.00</td>
				<?php $a= $item->quantity; $b = $plus->itemquantity; $c= $deduct->itemquantity; ?>
				<td><?php echo $a ?> pcs</td>
				<td width="100"><meter value="<?php echo $item->quantity; ?>" max="<?php echo $b; ?>" low=<?php echo $b*.30?>></meter> 
				<?php if($a<=$b*.30&&$a!=0){ echo '<img src="'.$base.'/media/css/images/w.png"/>';} elseif($a<=0){ echo '<img src="'.$base.'/media/css/images/user_logout.png"/>';} else{ echo '<img src="'.$base.'/media/css/images/y.png"/>';} ?></td>
				<td><?php if($a<=0)echo 'Not Available'; else echo 'Available'; ?></td>
			</tr>
				<?php   endforeach;
						endforeach;
						endforeach;
 				 ?>
    </tbody>
 
</table>
                </div>  

<a class="menuitem submenuheader" href="">
<h2>New Offersheets (<?php echo count($offerstable) ?>)</h2></a>
<div class="submenu">
<table id="tablesorter" class="rounded-corner">
    <thead>
    	<tr>
    		
            <th rowspan="2" style="cursor: pointer">Offersheet</th>
            <th rowspan="2" style="cursor: pointer">To Client</th>
            <th rowspan="2" style="cursor: pointer">By User</th>
			<th rowspan="2" style="cursor: pointer">Availability</th>
			<th rowspan="2" style="cursor: pointer">Date Created</th>
		
        </tr>
    </thead>
    <tbody>
    	
			<?php foreach ($offerstable as $offersheet):?>
			<tr>
				
				<td><?php echo anchor('coffersheet/displayoffersheetdetails/'.$offersheet->offersheetid, $offersheet->offersheetid); ?></td>
				<td><?php echo $offersheet->clientname; ?></td>
				<td> <?php echo $offersheet->firstname; ?></td>
				<td> <?php echo $offersheet->offersheetstatus; ?></td>
				<td><?php echo $offersheet->offerdatecreated; ?></td>
			<?php endforeach;?>
				<?php form_close()?>
    </tbody>
</table>
</div>
<a class="menuitem submenuheader" href=""><h2>New Purchase Oders (<?php echo count($purchasetable) ?>)</h2></a>
<div class="submenu">
<table id="tablesorter" class="rounded-corner">
    <thead>
    	<tr>
            <th rowspan="2" style="cursor: pointer">Purchase Order Number</th>
            <th rowspan="2" style="cursor: pointer">To Client</th>
            <th rowspan="2" style="cursor: pointer">By User</th>
			<th rowspan="2" style="cursor: pointer">Availability</th>
			<th rowspan="2" style="cursor: pointer">Date Created</th>
		
        </tr>
    </thead>
    <tbody>
    	
			<?php foreach ($purchasetable as $purchaseorder):?>
			<tr>
				<td><?php echo anchor('cinventory/displaypurchaseorderdetails/'.$purchaseorder->purchaseorderid, $purchaseorder->purchaseordernumber); ?></td>
				<td><?php echo $purchaseorder->clientname; ?></td>
				<td> <?php echo $purchaseorder->firstname; ?></td>
				<td> <?php echo $purchaseorder->purchaseorderstatus; ?></td>
				<td><?php echo $purchaseorder->purchasedatecreated; ?></td>
				</tr>
				<?php endforeach;?>
				<?php form_close()?>
    </tbody>
</table>
</div>
<a class="menuitem submenuheader" href=""><h2>New Invoice Statement (<?php echo count($invoicetable) ?>)</h2></a>
<div class="submenu">
<table id="tablesorter" class="rounded-corner">
    <thead>
    	<tr>
            <th  style="cursor: pointer">Invoice</th>
            <th  style="cursor: pointer">To Client</th>
            <th  style="cursor: pointer">By User</th>
			<th  style="cursor: pointer">Availability</th>
			<th  style="cursor: pointer">Date Created</th>
    </thead>
    <tbody>
    	
			<?php foreach ($invoicetable as $invoice):?>
			<tr>
				<td><?php echo anchor('cinvoice/displayinvoicedetails/'.$invoice->invoiceid, $invoice->invoiceid); ?></td>
				<td><?php echo $invoice->clientname; ?></td>
				<td> <?php echo $invoice->firstname; ?></td>
				<td> <?php echo $invoice->invoicestatus; ?></td>
				<td><?php echo $invoice->invoicedatecreated; ?></td>
			</tr>
				<?php endforeach;?>
				<?php form_close()?>
    </tbody>
</table>
</div>
</div>