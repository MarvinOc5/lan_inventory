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
        
    <h2>View Account(s)</h2> 
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
                

    	   
			<?php foreach ($userstable as $user):?>
			<table>
				<tr>
					<th>Position:</th>
					<td><?php echo $user->userlevel; ?></td>
				</tr>
				<tr>
					<th>Username:</th>
					<td><?php echo $user->username; ?></td>
				</tr>
				<tr>
					<th>Company ID:</th>
					<td><?php echo $user->companyid; ?></td>
				</tr>
				<tr>
					<th>Firstname:</th>
					<td><?php echo $user->firstname; ?></td>
				</tr>
				<tr>
					<th>Lastname:</th>
					<td><?php echo $user->lastname; ?></td>
				</tr>
				<tr>
					<th>Gender:</th>	
					<td><?php echo $user->gender; ?></td>
				</tr>
				<tr>
					<th>Email Address:</th>
					<td><?php echo $user->email; ?></td>
				</tr>
				<tr>
					<th>Status:</th>
				<td><p><?php echo $user->status; ?></p></td>
				</tr>
				
			</table>
				
				<?php endforeach;?>
				
   
<div class="extra">
	 <a href="<?php echo $base ?>/cuser/updateuser/<?php echo $user->userid;?>" class="bt_green"><span class="bt_green_lft"></span><strong>Edit</strong><span class="bt_green_r"></span></a>
     <a href="<?php echo $base;?>/cuser/deactivateuser/<?php echo $user->userid;?>" class="bt_red" onclick = "return confirm('User  <?php echo $user->username;?> will be deactive and they cant login to the system, You cant Activate the user again in the user update. Do you want to continue?')"><span class="bt_red_lft"></span><strong>Deactivate </strong><span class="bt_red_r"></span></a> 
     </div>
     
        <div class="pagination">

      		 
        </div> 

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  
    