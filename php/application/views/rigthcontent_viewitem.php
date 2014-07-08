<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/tablesorter/css/demo_table.css" />
<script type="text/javascript" src="<?php echo $base ?>/media/tablesorter/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
var asInitVals = new Array();

$(document).ready(function() {
    var oTable = $('#tablesorter').dataTable( {
    	 "sPaginationType": "full_numbers"
      } );
     
    $("tfoot input").keyup( function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );
     
     
     
    /*
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
     * the footer
     */
    $("tfoot input").each( function (i) {
        asInitVals[i] = this.value;
    } );
     
    $("tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
     
    $("tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    } );
} );
</script>
  <div class="right_content">
        
    <h2>View <?php echo $Name?>(s)</h2> 
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
    		<th rowspan="2" style="cursor: pointer">Part No.</th>
            <th rowspan="2" style="cursor: pointer">Description</th>
            <th rowspan="2" style="cursor: pointer">Price</th>
            <?php if($Name=="Part"){ ?>
            <th rowspan="2" style="cursor: pointer">Category</th>
            <?php  } ?>
            <th rowspan="2" style="cursor: pointer">Quantity</th>
            <th rowspan="2" style="cursor: pointer">Stocks-Level</th>
			<th rowspan="2" style="cursor: pointer">Availability</th>
			<th colspan=2 align="Center">Action</th>
        </tr>
        <tr>
        	<th>Delete</th>
        	<th>Edit</th>
        </tr>
    </thead>
    <tbody>
    
    		<?php
    		foreach ($itemstable as $item):
			$plusquantity = $this->inventorymodel->gettotalquantity($item->itemid);
			$deductquantity = $this->inventorymodel->getdeductquantity($item->itemid);
			$inviocequantity = $this->inventorymodel->getinvoicequantity($item->itemid);
			foreach ($plusquantity->result() as $plus):
			foreach ($deductquantity->result() as $deduct):
			foreach ($inviocequantity->result() as $invioce):
			?>
			<tr>
				
				
				<td><?php echo anchor('/cinventory/displaystocksdetails/'.$item->itemid, $item->number); ?></td>
				<td><?php echo substr($item->description, 0,30); ?></td>
				<td> <?php echo number_format($item->price, 2);  ?></td>
				<?php if($Name=="Part"){ ?>
				<td><?php echo $item->name; ?></td>
				<?php  } ?>
				<?php  $a= $item->quantity; $b = $plus->itemquantity; $c= $deduct->itemquantity; $d = $invioce->itemquantity ?>
				<td><?php echo $a ?> pcs</td>
				<td width="100"><meter value="<?php echo $item->quantity; ?>" max="<?php echo $b; ?>" low=<?php echo $d*.30||$b*.30?>></meter> 
				<?php if($a<=$b*.30&&$a!=0){ echo '<img src="'.$base.'/media/css/images/w.png"/>';} elseif($a<=0){ echo '<img src="'.$base.'/media/css/images/user_logout.png"/>';} else{ echo '<img src="'.$base.'/media/css/images/y.png"/>';} ?></td>
				<td><?php if($a<=0)echo 'Not Available'; else echo 'Available'; ?></td>
				<td><a href="<?php echo $base.$deletelink.$item->itemid;?>" class="ico del" onclick = "return confirm('All details of <?php echo $item->number?> will be deleted. Only use this for incorrect adding of item. Do you want to continue?')"><img src="<?php echo $base ?>/media/css/images/trash.png" alt="" title="" border="0" /></a></td>
				
				<td><a href="<?php echo $base.$upadatelink.$item->itemid;?>" class="ico edit"><img src="<?php echo $base ?>/media/css/images/user_edit.png" alt="" title="" border="0" /></a></td> 
			</tr>
				<?php   endforeach;
						endforeach;
						endforeach;
						endforeach;
 				 ?>
 				 
    </tbody>
    
    <tfoot>
		<tr>
			
        	<th><input type="text" name="search_engine" value="Search Reference Number" class="search_init" /></th>
			<th><input type="text" name="search_browser" value="Search Description" class="search_init" /></th>
			<th><input type="text" name="search_platform" value="Search Price" class="search_init" /></th>
			 <?php if($Name=="Part"){ ?>
			<th><input type="text" name="search_version" value="Search Category" class="search_init" /></th>
			<?php  } ?>
			<th><input type="text" name="search_version" value="Search Quantity" class="search_init" /></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			

		</tr>
	</tfoot>
	
</table>
<div class="extra">
	 <a href="<?php echo $base.$addlink; ?>" class="bt_green"><span class="bt_green_lft"></span><strong>Add new <?php echo $Name?></strong><span class="bt_green_r"></span></a>
        </div> 

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  

