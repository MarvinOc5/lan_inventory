 <link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/tablesorter/css/demo_table.css" />
<script type="text/javascript" src="<?php echo $base ?>/media/tablesorter/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
(function($) {
	/*
	 * Function: fnGetColumnData
	 * Purpose:  Return an array of table values from a particular column.
	 * Returns:  array string: 1d data array 
	 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
	 *           int:iColumn - the id of the column to extract the data from
	 *           bool:bUnique - optional - if set to false duplicated values are not filtered out
	 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
	 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
	 * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
	 */
	$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
	    // check that we have a column id
	    if ( typeof iColumn == "undefined" ) return new Array();
	     
	    // by default we only wany unique data
	    if ( typeof bUnique == "undefined" ) bUnique = true;
	     
	    // by default we do want to only look at filtered data
	    if ( typeof bFiltered == "undefined" ) bFiltered = true;
	     
	    // by default we do not wany to include empty values
	    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
	     
	    // list of rows which we're going to loop through
	    var aiRows;
	     
	    // use only filtered rows
	    if (bFiltered == true) aiRows = oSettings.aiDisplay; 
	    // use all rows
	    else aiRows = oSettings.aiDisplayMaster; // all row numbers
	 
	    // set up data array    
	    var asResultData = new Array();
	     
	    for (var i=0,c=aiRows.length; i<c; i++) {
	        iRow = aiRows[i];
	        var aData = this.fnGetData(iRow);
	        var sValue = aData[iColumn];
	         
	        // ignore empty values?
	        if (bIgnoreEmpty == true && sValue.length == 0) continue;
	 
	        // ignore unique values?
	        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
	         
	        // else push the value onto the result data array
	        else asResultData.push(sValue);
	    }
	     
	    return asResultData;
	}}(jQuery));
	 
	 
	function fnCreateSelect( aData )
	{
	    var r='<select><option value=""></option>', i, iLen=aData.length;
	    for ( i=0 ; i<iLen ; i++ )
	    {
	        r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
	    }
	    return r+'</select>';
	}
	 
	 
	$(document).ready(function() {
	    /* Initialise the DataTable */
	    var oTable = $('#tablesorter').dataTable( {
	        "oLanguage": {
	            "sPaginationType": "full_numbers"
	        }
	    } );
	    /* Add a select menu for each TH element in the table footer */
	    $("tfoot th").each( function ( i ) {
	        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
	        $('select', this).change( function () {
	            oTable.fnFilter( $(this).val(), i );
	        } );
	    } );
	} );
</script>
 <div class="right_content">
	<?php echo form_open('cinventory/addoffersheet');?>
    <h2>Items Details</h2> 
	<table>
			<tr>
			<?php foreach($itemsdetails as $items):?>
				<?php foreach($totalsupply as $supply):?>
					<?php foreach($totaldeduction as $deduction):?>
					<?php foreach($totalinvoice as $invoice):?>
				<?php echo form_hidden('itemid',$items->itemid);?>
				<?php $id = $items->itemid;?>
			<th align="left" class="rounded-foot-left">Reference Number: <?php echo $items->number; ?></th>
			<th align="left"></th>
			</tr>
			<tr>
			<th align="left">Item Type: <?php $id = $items->itemid; echo $name=$items->itemtype; ?></th>
			<td></td>
			</tr>
			<tr>
			<th align="left">Description: <?php echo $items->description; ?></th>
			<td></td>
			</tr>
			<tr>
			<th align="left">Price: <?php echo $items->price; ?></th>
			<td></td>
			</tr>
			<tr>
			<th align="left">Quantity Remaining: <?php echo $items->quantity; ?></th>
			<td><th align="left">Total Item Supply: <?php echo $supply->itemquantity; ?></th>
			</tr>
			<tr>
			<th align="left">Location: <?php echo $items->location; ?></th>
			<td><th align="left">Total Item Deduct: <?php echo $a= $deduction->itemquantity+$invoice->itemquantity; ?>
			</tr>
			 <?php endforeach;?>
			  <?php endforeach;?>
			   <?php endforeach;?>
			   <?php endforeach;?>
	</table>
	
	<div class="panel">
            <div class="title-large">
                <div class="theme"></div>
            </div>

                <div class="content inpad">

                    <div id="messageBox" style="margin-left:15px; padding-left:20px; padding-bottom:5px; border:1px #ccc solid; display:none;"></div>
						 
                                <table id="itemsTable" class="general-table">
                                
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Inventory</th>
                                        <th>Quantity Changes</th>
                                        <th>Inventory Type</th>
                                        <th>View</th>
                                        <th>Operation Date</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item-row">
                                        <?php foreach($inventoryitemsdetails as $inventoryitems):?>
											<td></td>
                                            <td><?php echo $inventoryitems->inventorydetailsid; ?> </td>
                                            <td><?php echo $inventoryitems->itemquantity; ?></td> 
                                            <td><?php echo $inventoryitems->inventorytype; ?></td>
                                          	<td><?php if($inventoryitems->inventorytype=='Invoice'){
												echo anchor('/cinvoice/displayinvoicedetails/'.$inventoryitems->inventorydetailsid, 'view');
												} ?>
											<?php if($inventoryitems->inventorytype=='Deduct'){
												echo anchor('/cinventory/displaydeductsdetails/'.$inventoryitems->inventorydetailsid, 'view');
												} ?>
											<?php if($inventoryitems->inventorytype=='Supply'){
												echo anchor('/cinventory/displaysupplysdetails/'.$inventoryitems->inventorydetailsid, 'view');
												} ?></td>
                                            <td><?php echo $inventoryitems->datecreate; ?></td>                                      
											</tr>
											  <?php endforeach;?>
                                    </tbody>
                                    <tfoot>
    								
							   		 </tfoot>
							   		
                                </table>
                                 <?php if($name=="Model"){ 
							   		 $row = $this->inventorymodel->getallpartsbymodel($id);
										$partsbymodel = $row->result();
									?>	
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
					        </tr>
					    </thead>
					    <tbody>
					    
					    		<?php
					    		foreach ($partsbymodel as $item):
								$plusquantity = $this->inventorymodel->gettotalquantity($item->itemid);
								$deductquantity = $this->inventorymodel->getdeductquantity($item->itemid);
								foreach ($plusquantity->result() as $plus):
								foreach ($deductquantity->result() as $deduct):
								?>
								<tr>
									<td hidden=hidden ><?php echo $item->name; ?></td>
									<td><?php echo anchor('/cinventory/displaystocksdetails/'.$item->itemid, $item->number); ?></td>
									<td><?php echo substr($item->description, 0,30); ?></td>
									<td> <?php echo number_format($item->price, 2);  ?></td>
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
					   
						<?php  } ?>
					</table>
					<div class="extra">
								   <?php if($name=="Model"){ ?>
									<a href="<?php echo $base.'/report/itemsReport/'.$id?>" class="bt_green"><span class="bt_green_lft"></span><strong>Generate</strong><span class="bt_green_r"></span></a>
									<?php  } ?>
									 <a href="<?php echo $base.'/cinventory/updateparts/'.$id?>" class="bt_green"><span class="bt_green_lft"></span><strong>Edit</strong><span class="bt_green_r"></span></a>
    
									</div>
					
                            

                        </div>
 
                   
                
        </div>

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  