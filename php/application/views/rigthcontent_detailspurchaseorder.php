 <div class="right_content">
	<?php echo form_open('cinventory/addoffersheet');?>
    <h2>Purchase Order Form</h2> 
	<table>
			<tr>
			<?php foreach($purchaseorder as $purchase);?>
				<?php echo form_hidden('purchaseorderid',$purchase->purchaseorderid);?>
			<th align="left" class="rounded-foot-left">Company Name:</th>
			 <td><?php echo $purchase->clientname; ?></td>
			<th align="left"></th>
			<th align="left">Purchase Order No:</th>
			<td align="left"><?php echo $purchase->purchaseordernumber; ?></td>
			</tr>
			<tr>
			<th align="left">Address:</th>
			<td><?php echo $purchase->clientaddress; ?></td>
			<td></td>
			<th align="left">Terms of Payment:</th>
			<td><?php echo $purchase->daypayment; ?><?php if (0!=$purchase->daypayment) {
			?>  <?php } ?></td>
			</tr>
			<tr>
			<th align="left">Contact Person:</th>
			<td> <?php echo $purchase->clientdecription; ?></td>
			<td></td>
			<th align="left">Time of Shipment:</th>
			<td><?php echo $purchase->dayship; ?><?php if (0!=$purchase->dayship) {
			?>  <?php } ?></td>
			</tr>
			<tr>
			<th align="left">Contact Number:</th>
			<td><?php echo $purchase->clientcontact; ?></td>
			<td></td>
			<th align="left">Place of Delivery:</th>
			<td><?php echo $purchase->clientaddress; ?></td>
			</tr>
			
			  <?php $count=0?>
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
                                        <th>Refernce Number</th>
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
                                        <?php foreach($purchasesheetsDetail as $purchasedetails):?>
											<?php  	 $count++ ?>
											<td><?php echo $count ?></td>
											<td hidden="hidden"><?php echo $id = $purchasedetails->purchaseorderid; ?></td>
                                            <td><?php echo $purchasedetails->number; ?> </td>
                                            <td><?php echo $purchasedetails->description; ?></td>
                                            <td><?php echo $purchasedetails->poitemcost; ?></td>
                                            <td><?php echo $purchasedetails->itemquantity; ?></td>
                                           <?php $tax= $purchasedetails->itemtax/100; ?>
                                         	 <?php $dsc= $purchasedetails->itemdiscount/100; ?>
                                         	 <?php  $discounts = $purchasedetails->poitemcost*$dsc; 
                                         			 $netdiscount = ($purchasedetails->poitemcost-$discounts);
                                         	 		$taxes = $netdiscount*$tax; ?>
                                            <td><?php echo number_format($taxes, 2)?></td>
                                             <td><?php echo number_format($discounts, 2)?></td>
                                            		<?php  $netprice = ($purchasedetails->poitemcost-$discounts);
                                            				$subtotal = ($netdiscount*$tax)+$netprice?>
                                            	  <td><?php echo number_format($subtotals[] = $purchasedetails->itemquantity * $subtotal,2); ?></td>                                         
											</tr>
											 <?php endforeach;?>
											<?php $total = array_sum($subtotals)?>
											 
                                    </tbody>
							   		 <tfoot>
							   		 <tr>
							   		 
							   		 <td colspan="6" ></td>		
    									<td colspan="3" >Service Charges: <?php echo number_format($purchase->servicecharges, 2);?></td>
								     </tr>
								     <tr>
                                    <td colspan="6" ></td>
                                    	<td colspan="3" >Delivery Charges: <?php echo number_format($purchase->deliverycharges, 2);?></td>
								      
                                    </tr>
                                    <tr>	
	    								<td colspan="6" ></td>
	    								<td colspan="3" >Total Price: <?php echo number_format($purchase->deliverycharges+$purchase->servicecharges+$total, 2);?></td>
							        </tr>
							   		 </tfoot> 
                                </table>
								
									<div class="extra">
									
									</div>
                      

                        </div>
 
                   
                
        </div>

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  