<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/tablesorter/css/demo_table.css" />
<script type="text/javascript" src="<?php echo $base ?>/media/tablesorter/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#tablesorter').dataTable( {
        "sPaginationType": "full_numbers"
    } );
} );
</script>
 <div class="right_content">
        
    <h2>View <?php echo $Name ?>(s)</h2> 
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
            <th rowspan="2" style="cursor: pointer">Client Name</th>
            <th rowspan="2" style="cursor: pointer">Client Contact</th>
            <th rowspan="2" style="cursor: pointer">Client Phone</th>
            <th rowspan="2" style="cursor: pointer">Client Fax</th>
            <th rowspan="2" style="cursor: pointer">Client Address</th>
            <th rowspan="2" style="cursor: pointer">Client Email</th>
			<th colspan="2" align="center">Action</th>
        </tr>
        <tr>
        	
        	<th>Delete</th>
        	<th>Edit</th>
        </tr>
    </thead>
    <tbody>
    	   
			<?php foreach ($clientstable as $client):?>
			<tr>
			    <td style="cursor: pointer"><?php echo $client->clientname; ?></td>
				<td style="cursor: pointer"><?php echo $client->clientcontact; ?></td>
				<td style="cursor: pointer"><?php echo $client->clientphone; ?></td>
				<td style="cursor: pointer"><?php echo $client->clientfax; ?></td>
				<td style="cursor: pointer"><?php echo $client->clientaddress; ?></td>
	            <td style="cursor: pointer"><?php echo $client->clientemail; ?></td>
				<td><a href="<?php echo $base.$deletelink.$client->clientid;?>" class="ico del"><img src="<?php echo $base ?>/media/css/images/trash.png" alt="" title="" border="0" /></a></td>
				<td><a href="<?php echo $base.$updatelink.$client->clientid;?>" class="ico edit"><img src="<?php echo $base ?>/media/css/images/user_edit.png" alt="" title="" border="0" /></a></td> 
			</tr>
				<?php endforeach;?>
				
    </tbody>
</table>
<div class="extra">
	 <a href="<?php echo $base.$addlink; ?>" class="bt_green"><span class="bt_green_lft"></span><strong>Add new <?php echo $Name?></strong><span class="bt_green_r"></span></a>
  <a href="#" class="bt_red"><span class="bt_red_lft"></span><strong>Delete <?php echo $Name ?></strong><span class="bt_red_r"></span></a> 
     
     
        <div class="pagination">

      		 </div>
        </div> 

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  
