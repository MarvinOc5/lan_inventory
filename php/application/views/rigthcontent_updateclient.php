    <div class="right_content">            
      
           
     <h2>Update <?php echo $Name?> Form</h2>
     
         <div class="form">
          <?php foreach($clientsdetail as $clientsitem):?>
         <form action="<?php echo $base.$updatelink.$clientsitem->clientid ?>" method="post" class="niceform">
         <?php if($this->session->flashdata('message')){ echo $this->session->flashdata('message'); } ?>
         		<?php echo form_hidden('clientid',$clientsitem->clientid);?>
                <fieldset>
                    <dl>
                        <dt><label for="clientname">Client Name:</label></dt><?php  echo form_error('clientname'); ?>
                        <dd><?php $data = array("name"=>"clientname", "id"=>"clientname", "size"=>"54", "value"=>"$clientsitem->clientname"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientcontact">Client Contact:</label></dt><?php  echo form_error('clientcontact'); ?>
                        <dd><?php $data = array("name"=>"clientcontact", "id"=>"clientcontact", "size"=>"54", "value"=>"$clientsitem->clientcontact"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for=clientphone>Client Phone:</label></dt><?php  echo form_error('clientphone'); ?>
                        <dd><?php $data = array("name"=>"clientphone", "id"=>"clientphone", "size"=>"54", "value"=>"$clientsitem->clientphone"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for=clientfax>Client Fax:</label></dt><?php  echo form_error('clientfax'); ?>
                        <dd><?php $data = array("name"=>"clientfax", "id"=>"clientfax", "size"=>"54", "value"=>"$clientsitem->clientfax"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientaddress">Client Address:</label></dt><?php  echo form_error('clientaddress'); ?>
                        <dd><?php $data = array("name"=>"clientaddress", "id"=>"clientaddress", "size"=>"54", "value"=>"$clientsitem->clientaddress"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientemail">Client Email:</label></dt><?php  echo form_error('clientemail'); ?>
                        <dd><?php $data = array("name"=>"clientemail", "id"=>"clientemail", "size"=>"54", "value"=>"$clientsitem->clientemail"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="clientdecription">Client Decription:</label></dt><?php  echo form_error('clientdecription'); ?>
                        <dd><?php $data = array("name"=>"clientdecription", "id"=>"clientdecription", "size"=>"54", "value"=>"$clientsitem->clientdecription"); echo form_input($data);?></dd>
                    </dl>
                   
                    
                     <dl class="submit">
                     <dd>
                    <input type="submit" name="submit" id="submit" value="Submit" />
                     </dl>
                     <?php endforeach;?>
                     
                     
                    
                </fieldset>
                
         </form>
     
         </div>  
      
     
     </div><!-- end of right content-->