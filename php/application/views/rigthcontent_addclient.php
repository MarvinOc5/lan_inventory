    <div class="right_content">            
      
           
     <h2>Add New <?php echo $Name?>s</h2>
     
         <div class="form">
         <form action="<?php echo $base.$addlink?> " method="post" class="niceform">
         
                <fieldset>
                    <dl>
                        <dt><label for="clientname"><?php echo $Name?> Name:</label></dt><?php  echo form_error('clientname'); ?>
                        <dd><?php $data = array("name"=>"clientname", "id"=>"clientname", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientcontact"><?php echo $Name?> Contact:</label></dt><?php  echo form_error('clientcontact'); ?>
                        <dd><?php $data = array("name"=>"clientcontact", "id"=>"clientcontact", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientphone"><?php echo $Name?> Phone:</label></dt><?php  echo form_error('clientphone'); ?>
                        <dd><?php $data = array("name"=>"clientphone", "id"=>"clientphone", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientfax"><?php echo $Name?> Fax:</label></dt><?php  echo form_error('clientfax'); ?>
                        <dd><?php $data = array("name"=>"clientfax", "id"=>"clientfax", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientaddress"><?php echo $Name?> Address:</label></dt><?php  echo form_error('clientaddress'); ?>
                        <dd><?php $data = array("name"=>"clientaddress", "id"=>"clientaddress", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientemail"><?php echo $Name?> Email:</label></dt><?php  echo form_error('clientemail'); ?>
                        <dd><?php $data = array("name"=>"clientemail", "id"=>"clientemail", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientdecription"><?php echo $Name?> Decription:</label></dt><?php  echo form_error('clientdecription'); ?>
                        <dd><?php $data = array("name"=>"clientdecription", "id"=>"clientdecription", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    
                     <dl class="submit">
                     <dd>
                    <input type="submit" name="submit" id="submit" value="Submit" />
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>  
      
     
     </div><!-- end of right content-->