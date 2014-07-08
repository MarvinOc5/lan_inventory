   <script  type="text/javascript" src="<?php echo $base ?>/media/autocomplete/js/jq-ad-script.js"></script>
 <script type="text/javascript" src="<?php echo $base ?>/media/autocomplete/js/minform.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/autocomplete/css/styles.css" />
  <script type="text/javascript">
		$(document).ready(function() {
			$('#button').click(function(e) { // Button which will activate our modal
			   	$('#modal').reveal({ // The item which will be opened with reveal
				  	animation: 'fade',                   // fade, fadeAndPop, none
					animationspeed: 600,                       // how fast animtions are
					closeonbackgroundclick: true,              // if you click background will modal close?
					dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
				});
			return false;
			});
		});
	</script>
<div class="right_content">
	<?php echo form_open('cinventory/supplierrecieve');?>
    <h2>Receive Item from Supplier</h2> 
	<table>
			
			<tr>
			<th align="left">Supplier:<?php foreach ($supplierdropdown as $supplier){
					$supplier_options[$supplier->clientid]=$supplier->clientname;
					}
				echo form_dropdown('clientid',$supplier_options); ?></th>
			<td></td>
			</tr>
			<tr>
			<th align="left">Number: <input required autofocus type="text" name="desc" />
			<td></td>
			</tr>
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
                                        <th>Item Code</th>
                                        <th>Item Description</th>
                                        <th>Remaining Quantity</th>
                                        <th>Quantity</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item-row">
											<td></td>
                                            <td><input required placeholder="Reference Number" name="itemCode[]" value=""  id="itemCode" tabindex="1"/><input name="itemId[]" value="" type="hidden" class="tInput" id="itemId" readonly="readonly" /> </td>
                                            <td><input name="itemDesc[]" value="" readonly="readonly" class="tInput" id="itemDesc"  readonly="readonly" /></td>
                                          	<td><input name="itemQty[]"  style="width:50px;" id="itemQty" readonly="readonly"  /></td>
                                       		<td><input required placeholder="Quantity"  type="text"  name="qty[]" onBlur=""></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
    								<tr>
    								<td colspan="3"><a href="#" id="addRow" class="button-clean large"><span> <img src="<?php echo $base ?>/media/autocomplete/images/icon-plus.png" alt="Add" title="Add Row" /> Add Item</span></a></td>
        							<td class="rounded-foot-right">&nbsp;</td>
							        </tr>
							   		 </tfoot>
                                </table>
								
									<div class="extra">	
									<input type="button" class="reload" value="Reload" onClick="location='<?php echo $base ?>/cinventory/supplierrecieve'"> 
									<?php $data = array("class" => "save", "id" => "button", "value" => "Save"); echo form_submit($data);?>
									</div>
                          

                        </div>
 
                    
                
        </div>

     </div><!-- end of right content-->
 <div id="modal">
	<div id="heading">
		Are you sure you want to do that?
	</div>

	<div id="content">
		<p>Clicking save will make inserted to our system<br> Please fill out all the information needed and finalize</p>
		
		<input type="button" class="reload" value="Reload" onClick="location='<?php echo $base ?>/coffersheet/createoffersheet'"> 
		
		<?php $data = array("class" => "save", "value" => "Save"); echo form_submit($data);?>

	</div>
</div>                    
                    
 <!--end of center content -->  