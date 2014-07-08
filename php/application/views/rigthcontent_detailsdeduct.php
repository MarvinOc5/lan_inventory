 <div class="right_content">
	<?php echo form_open('cinventory/addoffersheet');?>
    <h2>Deduction Details</h2> 
	<table>
			<tr>
			<?php foreach($deducts as $offer):?>
				<?php echo form_hidden('deductid',$offer->deductid);?>
			<th align="left">No:</th>
			<td align="left"><?php echo $offer->deductid; ?></td>

			</tr>
			<tr>
		
			<th align="left">Company:</th>
			<td align="left"><?php echo $offer->cname; ?></td>
			</tr>
			<tr>
		
			<th align="left">Description:</th>
			<td align="left"><?php echo $offer->deductdesc; ?></td>
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
                                        <?php foreach($dedutsDetail as $offerdetails):?>
                                        	
											
										
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