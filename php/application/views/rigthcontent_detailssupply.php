 <div class="right_content">
	<?php echo form_open('cinventory/addoffersheet');?>
    <h2>Supplys Details</h2> 
	<table>
			<tr>
			<?php foreach($supplys as $offer):?>
				<?php echo form_hidden('supplyid',$offer->supplyid);?>
				<th align="left" class="rounded-foot-left">Company Name:</th>
				<td><?php echo $offer->clientname; ?></td>
			</tr>
			<tr>
				
				<th align="left">No:</th>
				<td align="left"><?php echo $offer->supplyid; ?></td>
			</tr>
			<tr>
				
				<th align="left">Description:</th>
				<td align="left"><?php echo $offer->supplydesc; ?></td>
			</tr>

			
			 <?php endforeach;?>
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
                                        
                                        <th>Reference Number</th>
                                        <th>Item Description</th>
                                     
                                        <th>Item Quantity</th>
    
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item-row">
                                       		<?php foreach($supplysDetail as $offerdetails):?>
                                        	
											<td><?php echo $offerdetails->number; ?> </td>
                                            <td><?php echo $offerdetails->description; ?></td>
                                            <td><?php echo $offerdetails->itemquantity; ?></td>
                                        	</tr>
											  <?php endforeach;?>
                                    </tbody>
                                    <tfoot>
    								<tr>
    									
    								
        							 </tr>
							   		 </tfoot>
                                </table>
								
									<div class="extra">
									</div>
                           
                            

                        </div>
 
        
                
        </div>

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  