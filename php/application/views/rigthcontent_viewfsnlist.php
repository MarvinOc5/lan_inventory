<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/tablesorter/css/demo_table.css" />
<script type="text/javascript" src="<?php echo $base ?>/media/tablesorter/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
$(document).ready( function () {
	$('#tablesorter').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
			"sRowSelect": "multi",
			"aButtons": [ "select_all", "select_none" ]
		}
	} );
} );
</script>
  <div class="right_content">
        
    <h2>F-S-N Analysis</h2>
	 <div class="warning_box">
        <table>
		<tr>
		<td>F</td>
		<td>Fast-Moving</td>
		</tr>
		<tr>
		<td>S</td>
		<td>Slow-Moving</td>
		</tr>
		<tr>
		<td>N</td>
		<td>Normal-Moving</td>
		</tr>
		</table>
     </div>
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
    		
            <th style="cursor: pointer">Reference Number</th>
            <th style="cursor: pointer">Description</th>
            <th style="cursor: pointer">Deduct</th>
            <th style="cursor: pointer">Supply</th>
            <th style="cursor: pointer">Balance</th>
            <th style="cursor: pointer">Product Analysis</th>
            <th style="cursor: pointer">FSN</th>
		</tr>
    </thead>
    <tbody>
    
    		<?php	foreach ($itemstable as $item):	?>
			<tr>
			<?php  
				$plusquantity = $this->inventorymodel->gettotalquantity($item->itemid);
				$deductquantity = $this->inventorymodel->getdeductquantity($item->itemid);
				$inviocequantity = $this->inventorymodel->getinvoicequantity($item->itemid);
				foreach ($plusquantity->result() as $plus)
				foreach ($deductquantity->result() as $deduct)
				foreach ($inviocequantity->result() as $invioce)
				$a = $item->quantity; $b = $plus->itemquantity; $c= $deduct->itemquantity; ?>
				<td ><?php echo anchor('/cinventory/displaystocksdetails/'.$item->itemid, $item->number); ?></td>
				<td><?php echo substr($item->description, 0,30); ?></td>
				<td><?php echo $w = $deduct->itemquantity+$invioce->itemquantity;?></td>
				<td><?php echo $x = $plus->itemquantity;?></td>
				<td><?php echo $a ;?> pcs</td>
				<?php $fast = $x*.30; $norm = $x*.80; $slow = $x*.90;?>
				<td><?php if(($a<=$fast) && ($w!=0)) echo 'Fast-Moving';?> 
				<?php if(($a<=$norm) && ($a>$fast) && ($w!=0)) echo 'Normal-Moving';?>
				<?php if(($a>=$slow) && ($a>$norm) && ($a>$fast) && ($w!=0)) echo 'Slow-Moving';?>
				<?php if(($a<=0) && ($w<=0)) echo 'Non-Moving';?></td>
				<?php $fast = $x*.30; $norm = $x*.80; $slow = $x*.90;?>
				<td><?php if(($a<=$fast) && ($w!=0)) echo 'F';?> 
				<?php if(($a<=$norm) && ($a>$fast) && ($w!=0)) echo 'N';?>
				<?php if(($a>=$slow) && ($a>$norm) && ($a>$fast) && ($w!=0)) echo 'S';?>
				<?php if(($a<=0) && ($w<=0)) echo ' ';?></td>
				</tr>
				<?php endforeach; ?>
    </tbody>
	
</table>
<div class="extra">
	    </div> 

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  

