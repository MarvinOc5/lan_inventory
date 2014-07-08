    <div class="right_content">            
      
           
     <h2>Preview Offer Sheet</h2>
     
         <div class="form">
         <form action="" method="post" class="niceform">
         
                <fieldset>
                    <dl>
                    <dd>
                     <?php foreach ($offersheets as $offer)?>
					<iframe src="http://localhost/pnl_inventory/pdf/offersheetpdf/<?php echo $offer->offersheetid?>" width="800" height="900" style="border: none;"></iframe>
                    
                 
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>  
      
     
     </div><!-- end of right content-->