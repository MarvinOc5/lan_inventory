 <div class="right_content">
	<?php echo form_open('cinventory/addoffersheet');?>
    <h2>Offer Sheet Form</h2> 
	<table>
			<tr>
			<?php foreach($offersheets as $offer);?>
				<?php echo form_hidden('offersheetid',$offer->offersheetid);?>
			<th align="left">Company Name:</th>
			<td><?php echo $offer->clientname; ?></td>
			<th align="left"></th>
			<th align="left">Offer Sheet No:</th>
			<td align="left"><?php echo $offer->offersheetid; ?></td>
			</tr>
			<tr>
			<th align="left">Address:</th>
			<td><?php echo $offer->clientaddress; ?></td>
			<td></td>
			<th align="left">Terms of Payment:</th>
			<td><?php echo $offer->daypayment; ?><?php if (0!=$offer->daypayment) {
			?> <?php } ?></td>
			</tr>
			<tr>
			<th align="left">Contact Person:</th>
			<td> <?php echo $offer->clientcontact; ?></td>
			<td></td>
			<th align="left">Time of Shipment:</th>
			<td><?php echo $offer->dayship; ?><?php if (0!=$offer->dayship) {
			?> <?php } ?></td>
			
			
			</tr>
			<tr>
			<th align="left">Contact Number:</th>
			<td><?php echo $offer->clientphone; ?></td>
			<td></td>
			<th align="left">Place of Delivery:</th>
			<td>FOB/Manila</td>
			</tr>
			
			
			  <?php	$count = 0;?>
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
                                        <th>No.</th>
                                        <th>Item Code</th>
                                        <th>Item Description</th>
                                        <th>Item Price</th>
                                        <th>Item Quantity</th>
                                        <th>Item Tax</th>
                                        <th>Item Discount</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item-row">
										<?php $total = 0;?>
                                        <?php foreach($offersheetsDetail as $offerdetails):?>
                                        	
											<?php  	 $count++ ?>
											<td><?php echo $count ?></td>
											<td hidden="hidden"><?php echo $id = $offerdetails->offersheetid; ?></td>
                                            <td><?php echo $offerdetails->number; ?> </td>
                                            <td><?php echo $offerdetails->description; ?></td>
                                            <td><?php echo number_format($offerdetails->itemcost , 2); ?></td>
                                            <td><?php echo $offerdetails->itemquantity; ?></td>
                                         	 <?php $tax= $offerdetails->itemtax/100; ?>
                                         	 <?php $dsc= $offerdetails->itemdiscount/100; ?>
                                         	 <?php  $discounts = $offerdetails->itemcost*$dsc; 
                                         			 $netdiscount = ($offerdetails->itemcost-$discounts);
                                         	 $taxes = $netdiscount*$tax; ?>
                                            <td><?php echo number_format($taxes, 2)?></td>
                                             <td><?php echo number_format($discounts, 2)?></td>
                                            		<?php  $netprice = ($offerdetails->itemcost-$discounts);
                                            				$subtotal = ($netdiscount*$tax)+$netprice?>
                                            	  <td><?php echo number_format($subtotals[] = $offerdetails->itemquantity * $subtotal,2); ?></td>                                         
											</tr>
											 <?php endforeach;?>
											<?php $total = array_sum($subtotals)?>
											 
                                    </tbody>
                                    <tfoot>	
                                    <tr>
                                    <td colspan="6" ></td>
                                    	<td colspan="3" >Service Charges: <?php echo number_format($offer->servicecharges, 2);?></td>
								      
                                    </tr>
                                    <tr>
                                    <td colspan="6" ></td>
                                    	<td colspan="3" >Delivery Charges: <?php echo number_format($offer->deliverycharges, 2);?></td>
								      
                                    </tr>
                                    <tr>	
	    								<td colspan="6" ></td>
	    								<td colspan="3" >Total Price: <?php echo number_format($offer->deliverycharges+$offer->servicecharges+$total, 2);?></td>
							        </tr>
							   		 </tfoot>
                                </table>
								
									<div class="extra">
									
									 <a href="<?php echo $base.'/coffersheet/deleteoffersheets/'.$id?>" class="bt_red" type="button" onclick="return confirm('All details of will be deleted. Do you want to continue?')"/><span class="bt_red_lft"></span><strong>Delete</strong><span class="bt_red_r"></span>
									<a href="<?php echo $base.'/pdf/offersheetpdf/'.$id?>" class="bt_green"><span class="bt_green_lft"></span><strong>Preview</strong><span class="bt_green_r"></span></a>
									 <a href="<?php echo $base ?>/coffersheet/createoffersheet" class="bt_blue"/><span class="bt_blue_lft"></span><strong>Create New Offersheet</a></strong><span class="bt_blue_r"></span>
									</div>
                       
                            

                        </div>
 
                    
                
        </div>

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  