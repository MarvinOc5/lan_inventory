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
        
    <h2>View Invoice Statement(s)</h2> 
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
            <th  style="cursor: pointer">Invoice Number</th>
            <th  style="cursor: pointer">To Client</th>
            <th  style="cursor: pointer">By User</th>
			<th  style="cursor: pointer">Availability</th>
			<th  style="cursor: pointer">Date Created</th>
    </thead>
    <tbody>
    	
			<?php foreach ($invoicestable as $invoice):?>
			<tr>
				<td><?php echo anchor('cinvoice/displayinvoicedetails/'.$invoice->invoiceid, $invoice->invoicenumber); ?></td>
				<td><?php echo $invoice->clientname; ?></td>
				<td> <?php echo $invoice->firstname; ?></td>
				<td> <?php echo $invoice->invoicestatus; ?></td>
				<td><?php echo $invoice->invoicedatecreated; ?></td>
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