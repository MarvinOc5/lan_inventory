   <script  type="text/javascript" src="<?php echo $base ?>/media/autocomplete/js/jq-invoice-script.js"></script>
  <script type="text/javascript" src="<?php echo $base ?>/media/autocomplete/js/minform.js" ></script>
 <script type="text/javascript" src="<?php echo $base ?>/media/autocomplete/js/jquery.reveal.js" ></script>
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
 <div class="right_content"><?php foreach($offersheets as $offer):?>
	<?php echo form_open('cinvoice/offersheettoinvoice/'.$offer->offersheetid);?>
    <h2>Offer Sheet to Invoice Statement Form</h2>
	<table>
	<tr>
			<th align="left">Invoice Number:</th>
				<td><input required type="text" name="invoicenumber" id=""  value=""  /><?php echo form_error('invoicenumber'); ?></td>
			</tr>
			<tr>
				<?php echo form_hidden('offersheetid',$id = $offer->offersheetid);?>
				<th align="left" class="rounded-foot-left">Company Name:</th>
				<td><input type="text" name="" id="" value="<?php echo $offer->clientname; ?>" readonly="readonly" />
				<?php echo form_hidden('clientid',$offer->clientid);?></td>
				<td></td>
					<th align="left">Place of Delivery:</th>
			<td><input type="text" name="clientaddress" id="" value="<?php echo $offer->clientaddress; ?>" readonly="readonly" /></td>
			</tr>
			<tr>
				<th align="left">Address:</th>
				<td><input type="text" name="clientaddress" id=""  value="<?php echo $offer->clientaddress; ?>" readonly="readonly" /></td>
				<td></td>
				<th align="left">Terms of Payment:</th>
				<td><input type="text" name="daypayment" id="" size="1" value="<?php echo $offer->daypayment; ?>" readonly="readonly" /> Days</td>
			</tr>
			<tr>
			<th align="left">Contact Person:</th>
				<td><input type="text" name="clientcontact" id=""  value="<?php echo $offer->clientcontact; ?>" readonly="readonly" /></td>
				<td></td>
				<th align="left">Time of Shipment:</th>
				<td><input type="text" name="dayship" id="" size="1" value="<?php echo $offer->dayship; ?>" readonly="readonly" /> Days</td>
			</tr>
			<tr>
			<th align="left">Contact Number:</th>
				<td><input type="text" name="clientcontact" id="" value="<?php echo $offer->clientcontact; ?>" readonly="readonly" /></td>
				<td></td>
			</tr>
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
                                        <th>Item Code</th>
										<th>Item Description</th>
                                        <th>Item Price</th>
                                        <th>Remaining Quantity</th>
										<th>Item Quantity</th>
										<th>Tax Value</th>
										<th>Discount</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody><?php foreach($offersheetsDetail as $offerdetails):?>
                                        <tr class="item-row">
											<td><a id="deleteRow"><img src="<?php echo $base ?>/media/autocomplete/images/icon-minus.png" alt="Remove Item" title="Remove Item"></a></td>
                                            <td><input required name="itemCode[]" value="<?php echo $offerdetails->number; ?>"  id="itemCode" tabindex="1"/><input name="itemId[]" value="<?php echo $offerdetails->itemid?>" type="hidden" class="tInput" id="itemId" readonly="readonly" /> </td>
                                            <td><input name="itemDesc[]" value="<?php echo $offerdetails->description; ?>"  readonly="readonly" class="Desc" id="itemDesc"   /></td>
                                            <td><input required type="text"  name="rate[]" value="<?php echo $offerdetails->itemcost; ?>" id="itemPrice" readonly="readonly" onkeyup="getValues()" style="width:80px;" onBlur=""></td>
                                            <td><input name="itemQty[]"  style="width:50px;" id="itemQty" readonly="readonly" value="<?php echo $offerdetails->quantity; ?>" /></td>
                                            <td><input required type="text" name="qty[]" value="<?php echo $offerdetails->itemquantity; ?>"  onKeyUp="getValues()" style="width:50px;" value=""></td>
                                            <td><input type="text" name="vat[]" onKeyUp="getValues()" style="width:40px;" value="<?php echo $offerdetails->itemtax?>"></td>
											<td><input placeholder="Discount" name="dsc[]" id="dsc" onKeyUp="getValues()" style="width:40px;" value="<?php echo $offerdetails->itemdiscount; ?>"></td>
											<td><input type="text"  name="amt[]" id="Total" style="width:80px;" onKeyUp="getValues()" readonly="readonly"></td>                                         
											</tr>
											<?php endforeach;?>
                                    </tbody>
                                    <tfoot>
    								<tr>
	    								<td colspan="2"><a href="#" id="addRow" class="button-clean large"><span> <img src="<?php echo $base ?>/media/autocomplete/images/icon-plus.png" alt="Add" title="Add Row" /> Add Item</span></a><?php if(!form_error('itemId[]')&&!form_error('qty[]')&&!form_error('vat[]')){ Echo "";} else echo(" Please Complete the Following data needed"); ?></td>
        								<td colspan="2"  class="rounded-foot-left" align="right">Delivery<input required type="text" name="del" id="del" onKeyUp="getValues()" style="width:100px;" value="<?php echo $offer->deliverycharges; ?>"> </td>
        								<td colspan="3"  class="rounded-foot-left" align="right">Service Charge<input required type="text" name="ser" id="ser" onKeyUp="getValues()" style="width:100px;" value="<?php echo $offer->servicecharges; ?>"> </td>
        								<td colspan="2" class="rounded-foot-left" align="right">Total<input type="text"  id="total" name="total[]" style="width:80px;" readonly="readonly" value=""></td>	
							      </tr>
							   		 </tfoot>
                                </table>
								
									<div class="extra">	
									<input type="button" class="reload" value="Reload" onClick="location='<?php echo $base ?>/cinvoice/offersheettoinvoice/<?php echo $id ?>'"> 
									<?php $data = array("class" => "save", "id" => "button",  "value" => "Save"); echo form_submit($data);?>
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