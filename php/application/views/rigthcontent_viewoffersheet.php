<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/tablesorter/css/demo_table.css" />
<script type="text/javascript" src="<?php echo $base ?>/media/tablesorter/js/jquery.dataTables.min.js" ></script>
<style type="text/css">
.message{
    border:1px solid #CCCCCC;
    width:300px;
    border:1px solid #c93;
    background:#ffc;
    padding:5px;
    color: #333333;
    margin-bottom:10px;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $('#tablesorter').dataTable( {
        "sPaginationType": "full_numbers"
    } );
} );
</script>
<script>
$("#flashmessage").animate({top: "0px"}, 1000 ).show('fast').fadeIn(200).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
</script>
<div class="right_content">
        
    <h2>View Offersheet(s)</h2> 
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
	      	echo '</div>'; }?>              
    
<table id="tablesorter" class="rounded-corner">
    <thead>
    	<tr>
    		
            <th rowspan="2" style="cursor: pointer">Offersheet</th>
            <th rowspan="2" style="cursor: pointer">To Client</th>
            <th rowspan="2" style="cursor: pointer">By User</th>
			<th rowspan="2" style="cursor: pointer">Availability</th>
			<th rowspan="2" style="cursor: pointer">Date Created</th>
			<th colspan="3" align="center">Action</th>
        </tr>
        <tr>
        	<th>PO</th>
        	<th>Invoice</th>
        	<th>Delete</th>
        </tr>
    </thead>
    <tbody>
    	
			<?php foreach ($offersheetstable as $offersheet):?>
			<tr>
				
				<td><?php echo anchor('coffersheet/displayoffersheetdetails/'.$offersheet->offersheetid, $offersheet->offersheetid); ?></td>
				<td><?php echo $offersheet->clientname; ?></td>
				<td> <?php echo $offersheet->firstname; ?></td>
				<td> <?php echo $offersheet->offersheetstatus; ?></td>
				<td><?php echo $offersheet->offerdatecreated; ?></td>
				<?php if($offersheet->offersheetstatus=='pending'){ ?>
				<td><a href="<?php echo $base;?>/cinventory/offersheettopo/<?php echo $offersheet->offersheetid;?>" class="ico edit"><img src="<?php echo $base ?>/media/css/images/to.png" alt="" title="" border="0" /></a></td> 
				<td><a href="<?php echo $base;?>/cinvoice/offersheettoinvoice/<?php echo $offersheet->offersheetid;?>" class="ico edit"><img src="<?php echo $base ?>/media/css/images/to.png" alt="" title="" border="0" /></a></td> 
				 <?php }  
				 else { ?>
				<td>Already</td> 
				<td>Transfered</td><?php } ?>
				<td><a href="<?php echo $base;?>/coffersheet/deleteoffersheets/<?php echo $offersheet->offersheetid;?>" class="ico del" onclick="return confirm('All details of will be deleted. Do you want to continue?')"><img src="<?php echo $base ?>/media/css/images/trash.png" alt="" title="" border="0" /></a></td>
			</tr>
				<?php endforeach;?>
				<?php form_close()?>
    </tbody>
</table>
<div class="extra">
     
        <div class="pagination">
      		
      		 </div>
        </div> 

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  