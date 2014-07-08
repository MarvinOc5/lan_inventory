<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/tablesorter/css/demo_table.css" />
<script type="text/javascript" src="<?php echo $base ?>/media/tablesorter/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#tablesorter').dataTable( {
        "sPaginationType": "full_numbers"
    } );
} );
</script>
 <div class="right_content">
        
    <h2>View Purchase Order(s) Supplier</h2> 
     <?php if($this->session->flashdata('message'))  {
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
	      	echo '</div>'; } ?>                
                
<table id="tablesorter" class="rounded-corner">
    <thead>
    	<tr>
            <th style="cursor: pointer">Purchase Order Number</th>
            <th style="cursor: pointer">To Supplier</th>
            <th style="cursor: pointer">By User</th>
			<th style="cursor: pointer">Status</th>
			<th style="cursor: pointer">Date Created</th>
        	<th style="cursor: pointer">Delete</th>
        </tr>
    </thead>
    <tbody>
    	
			<?php foreach ($purchaseorderstable as $purchaseorder):?>
			<tr>
				<td><?php echo anchor('cinventory/displaypurchaseorderdetailssupplier/'.$purchaseorder->purchaseorderid, $purchaseorder->purchaseordernumber); ?></td>
				<td><?php echo $purchaseorder->clientname; ?></td>
				<td> <?php echo $purchaseorder->firstname; ?></td>
				<td> <?php echo $purchaseorder->purchaseorderstatus; ?></td>
				<td><?php echo $purchaseorder->purchasedatecreated; ?></td>
				<td><a href="<?php echo $base;?>/cinventory/deletepurchaseorders/<?php echo $purchaseorder->purchaseorderid;?>" class="ico del"><img src="<?php echo $base ?>/media/css/images/trash.png" alt="" title="" border="0" /></a></td>
			</tr>
				<?php endforeach;?>
				<?php form_close()?>
    </tbody>
</table>
<div class="extra">
     
        <div class="pagination">
      		
      		 </div>
        </div> 

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  