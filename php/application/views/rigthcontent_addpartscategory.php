    <div class="right_content">            
      
           
     <h2>Add New Parts Category </h2>
     
         <div class="form">
         <form action="<?php echo $base.'/cinventory/addpartscategory'?> " method="post" class="niceform">
         
                <fieldset>
                    <dl>
                        <dt><label for="name">Parts Category Name:</label></dt><?php  echo form_error('name'); ?>
                        <dd><?php $data = array("name"=>"name", "id"=>"name", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="description">Parts Category Description:</label></dt><?php  echo form_error('description'); ?>
                        <dd><?php $data = array("name"=>"description", "id"=>"description", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                   
                    
                     <dl class="submit">
                          <dd>
                    <input type="submit" name="submit" id="submit" value="Submit" />
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>  
      
     
     </div><!-- end of right content-->