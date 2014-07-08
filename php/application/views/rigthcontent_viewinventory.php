<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/tablesorter/css/demo_table_jui.css" />
<script type="text/javascript" src="<?php echo $base ?>/media/tablesorter/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
var asInitVals = new Array();

$(document).ready(function() {
    var oTable = $('#tablesorter').dataTable( {
        "oLanguage": {
        	"sPaginationType": "full_numbers"
        }
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
        
    <h2>View Inventory(s)</h2> 
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
            <th style="cursor: pointer">Transaction No.</th>
            <th style="cursor: pointer">Reference Number</th>
            <th style="cursor: pointer">Update by User</th>
            <th style="cursor: pointer">Item Type</th>
            <th style="cursor: pointer">Link</th>
            <th style="cursor: pointer">Type</th>
			<th style="cursor: pointer">Date Created</th>
        </tr>
    </thead>
    <tbody>
			<?php foreach ($inventorystable as $inven):?>
			<tr> 
				<td><?php echo $inven->inventorydetailsid; ?></td>
				<td><?php echo anchor('/cinventory/displaystocksdetails/'.$inven->itemid, $inven->number); ?></td>
				<td><?php echo anchor('/cuser/viewuserdetails/'.$inven->userid, $inven->username); ?></td>
				<td><?php echo $inven->itemtype; ?></td>
				<td><?php if($inven->inventorytype=='Invoice'){
						echo anchor('/cinvoice/displayinvoicedetails/'.$inven->transactionid, 'view');
						} ?>
					<?php if($inven->inventorytype=='Deduct'){
						echo anchor('/cinventory/displaydeductsdetails/'.$inven->transactionid, 'view');
						} ?>
					<?php if($inven->inventorytype=='Supply'){
						echo anchor('/cinventory/displaysupplysdetails/'.$inven->transactionid, 'view');
						} ?></td>
				<td><?php echo $inven->inventorytype; ?></td>
				<td><?php echo $inven->datecreate; ?></td>
			</tr>
				<?php endforeach;?>
 			
				<?php form_close()?>
				
    </tbody>
     <tfoot>
		<tr>
				<th><input type="text" name="search_inventorydetailsid" value="Search Inventory" class="search_init" /></th>
			<th><input type="text" name="search_itemid" value="Search Reference" class="search_init" /></th>
			<th><input type="text" name="search_username" value="Search Username" class="search_init" /></th>
			<th><input type="text" name="search_itemtype" value="Search Item Type" class="search_init" /></th>
			<th></th>
			<th hidden=hidden><input type="text" name="" value="Search Description" class="search_init" /></th>
			<th><input type="text" name="search_inventorytype" value="Search Type" class="search_init" /></th>
			<th><input type="text" name="search_datecreate" value="Search Date" class="search_init" /></th>
		</tr>
	</tfoot>
</table>
<div class="extra">

     
        <div class="pagination">
      
      		 </div>
        </div> 

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  