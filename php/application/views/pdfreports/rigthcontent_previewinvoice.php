    <div class="right_content">            
      
           
     <h2>Preview Invoice</h2>
     
         <div class="form">
         <form action="" method="post" class="niceform">
         
                <fieldset>
                    <dl>
                    <dd>
                 <?php foreach ($invoice as $invo)?>
					<iframe src="http://localhost/pnl_inventory/pdfinvoice/invoicepdf/<?php echo $invo->invoiceid?>" width="800" height="900" style="border: none;"></iframe>
                    
                 
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>  
      
     
     </div><!-- end of right content-->