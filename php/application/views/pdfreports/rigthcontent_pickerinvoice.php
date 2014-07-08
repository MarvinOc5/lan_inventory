  <script>
	$(function() {
		$( "#from" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			numberOfMonths: 2,
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			numberOfMonths: 2,
			onSelect: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
	</script>
    <div class="right_content">            
      
           
     <h2>Invoice Picker</h2>
     
         <div class="form">
                     
                   
	

<?php echo form_open('report/invoiceReport');?>

<div>
<table>
<tr>
<td><label for="from">From</label>
<input type="text" id="from" name="from"/></td>
<td><label for="to">to</label>
<input type="text" id="to" name="to"/></td>
</tr>
</table>
</div><!-- End demo -->



<div class="demo-description">

</div><!-- End demo-description -->
                    
                     
                     <?php $data = array("class" => "save", "value" => "Generate Report"); echo form_submit($data);?>
                    
         
                
       
         </div>  
      
     
     </div><!-- end of right content-->