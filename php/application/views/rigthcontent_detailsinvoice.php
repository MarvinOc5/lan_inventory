 <div class="right_content">
	<?php echo form_open('cinventory/addoffersheet');?>
    <h2>Invoice Statement Form</h2> 
	<table>
			<tr>
			<?php foreach($invoices as $invoice);?>
				<?php echo form_hidden('invoiceid',$invoice->invoiceid)?>
			<th align="left" class="rounded-foot-left">Company Name:</th>
			 <td><?php echo $invoice->clientname; ?></td>
			<th align="left"></th>
			<th align="left">Invoice No:</th>
			<td align="left"><?php echo $invoice->invoicenumber; ?></td>
			</tr>
			<tr>
			<th align="left">Address:</th>
			<td><?php echo $invoice->clientaddress; ?></td>
			<td></td>
			<th align="left">Terms of Payment:</th>
			<td><?php echo $invoice->daypayment; ?><?php if (0!=$invoice->daypayment) {
			?> Days <?php } ?></td>
			</tr>
			<tr>
			<th align="left">Contact Person:</th>
			<td> <?php echo $invoice->clientdecription; ?></td>
			<td></td>
			<th align="left">Time of Shipment:</th>
			<td><?php echo $invoice->dayship; ?><?php if (0!=$invoice->dayship) {
			?> Days <?php } ?></td>
			</tr>
			<tr>
			<th align="left">Contact Number:</th>
			<td><?php echo $invoice->clientcontact; ?></td>
			<td></td>
			<th align="left">Place of Delivery:</th>
			<td><?php echo $invoice->clientaddress; ?></td>
			</tr>
			
			 
	</table>
	
	<div class="panel">
            <div class="title-large">
                <div class="theme"></div>
            </div>

                <div class="content inpad">

                    <div></div>
                                <table id="itemsTable" class="general-table">
                                    <thead>
                                    <tr>
                                        <th>No</th>
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
                                        <?php foreach($invoicesDetail as $invoicedetails):?>
											<?php $count=0;
											  	 $count++ ?>
											<td><?php echo $count ?></td>
											<td hidden="hidden"><?php echo $id = $invoicedetails->offersheetid; ?></td>
                                            <td><?php echo $invoicedetails->number; ?> </td>
                                            <td><?php echo $invoicedetails->description; ?></td>
                                            <td><?php echo $invoicedetails->price; ?></td>
                                            <td><?php echo $invoicedetails->itemquantity; ?></td>
                                            	 <?php $tax= $invoicedetails->itemtax/100; ?>
                                         	 <?php $dsc= $invoicedetails->itemdiscount/100; ?>
                                         	 <?php  $discounts = $invoicedetails->price*$dsc; 
                                         			 $netdiscount = ($invoicedetails->price-$discounts);
                                         	 $taxes = $netdiscount*$tax; ?>
                                            <td><?php echo number_format($taxes, 2)?></td>
                                             <td><?php echo number_format($discounts, 2)?></td>
                                            		<?php  $netprice = ($invoicedetails->price-$discounts);
                                            				$subtotal = ($netdiscount*$tax)+$netprice?>
                                            	  <td><?php echo number_format($subtotals[] = $invoicedetails->itemquantity * $subtotal,2); ?></td>                                         
											</tr>
											 <?php endforeach;?>
											<?php $total = array_sum($subtotals)?>
											 
                                    </tbody>
                                    <tfoot>	
                                    <tr>
                                    <td colspan="6" ></td>
                                    	<td colspan="3" >Service Charges: <?php echo number_format($invoice->servicecharges, 2);?></td>
								      
                                    </tr>
                                     <tr>
                                    <td colspan="6" ></td>
                                    	<td colspan="3" >Delivery Charges: <?php echo number_format($invoice->deliverycharges, 2);?></td>
								      
                                    </tr>
                                    <tr>	
	    								<td colspan="6" ></td>
	    								<td colspan="3" >Total Price: <?php echo number_format($invoice->deliverycharges+$invoice->servicecharges+$total, 2);?></td>
							        </tr>
							   		 </tfoot>
                                </table>
								
									
                            

                        </div>
 
       
                
        </div>

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  