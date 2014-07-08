<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/tablesorter/css/demo_table.css" />
<script type="text/javascript" src="<?php echo $base ?>/media/tablesorter/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
$(document).ready( function () {
	$('#tablesorter').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
			"sRowSelect": "multi",
			"aButtons": [ "select_all", "select_none" ]
		}
	} );
} );
</script>
 <div class="right_content">
        
    <h2>View User(s)</h2> 
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
        	<th rowspan="2" style="cursor: pointer">Company ID</th>
            <th rowspan="2" style="cursor: pointer">Position</th>
            <th rowspan="2" style="cursor: pointer">Firstname</th>
            <th rowspan="2" style="cursor: pointer">Lastname</th>
            <th rowspan="2" style="cursor: pointer">Username</th>
			<th rowspan="2" style="cursor: pointer">E-mail</th>
			<th rowspan="2" style="cursor: pointer">Status</th>
			<th colspan="2" align="center">Action</th>
        </tr>
        <tr>
        	<th>Deactivate</th>
        	<th>Edit</th>
        </tr>
    </thead>
    <tbody>
			<?php foreach ($userstable as $user):?>
			<tr>
			    <td><?php echo substr($user->companyid, 0,10); ?></td>
				<td><?php echo substr($user->userlevel, 0,5); ?></td>
				<td><?php echo substr($user->firstname, 0,15); ?></td>
				<td><?php echo substr($user->lastname, 0,20); ?></td>
				<td><?php echo anchor('cuser/viewuserdetails/'.$user->userid, $user->username); ?></td>
	            <td><?php echo substr($user->email, 0,20); ?></td>
	            <td><?php echo $user->status; ?></td>
				<td><a href="<?php echo $base;?>/cuser/deactivateuser/<?php echo $user->userid;?>" class="ico del" onclick = "return confirm('All details of <?php echo $user->userid;?>, <?php echo $user->username;?> will be deactive. Do you want to continue?')"><img src="<?php echo $base ?>/media/css/images/trash.png" alt="" title="" border="0" /></a></td>
				<td><a href="<?php echo $base;?>/cuser/updateuser/<?php echo $user->userid;?>" class="ico edit"><img src="<?php echo $base ?>/media/css/images/user_edit.png" alt="" title="" border="0" /></a></td> 
			</tr>
				<?php endforeach;?>
 					
				
    </tbody>
</table>

<div class="extra">
	  <a href="<?php echo $base; ?>/cuser/adduser" class="bt_green"><span class="bt_green_lft"></span><strong>Add new User</strong><span class="bt_green_r"></span></a>
     <div class="pagination">
      		 
      		 </div>
        </div> 

     </div><!-- end of right content-->
            
                    
 <!--end of center content -->  