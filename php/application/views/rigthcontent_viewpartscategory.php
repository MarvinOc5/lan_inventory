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
        
    <h2>View Category(s)</h2> 
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
        	<th scope="col" class="rounded">Category Name</th>
            <th scope="col" class="rounded">Category Description</th> 
			<th scope="col" class="rounded" colspan=2>Action</th>

        </tr>
    </thead>
    <tbody>
			<?php foreach ($userstable as $user):?>

			<tr>
			 	<td><?php echo $user->name; ?></td>
				<td><?php echo $user->categorydescription; ?></td>
	
				<td><a href="<?php echo $base;?>/cinventory/deletepartscategory/<?php echo $user->partscategoryid;?>" class="ico del"><img src="<?php echo $base ?>/media/css/images/trash.png" alt="" title="" border="0" onclick = "return confirm('All details will be deleted, Do you want to continue?')" /></a></td>
				
			</tr>
				<?php endforeach;?>
 					
				
    </tbody>
</table>
<div class="extra">

        <div class="pagination">
      		 
      		 </div>
        </div> 

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  