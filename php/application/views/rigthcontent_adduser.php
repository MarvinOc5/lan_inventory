    <div class="right_content">            
      
           
     <h2>Add User</h2>
     
         <div class="form">
         <form action="<?php echo $base ?>/cuser/adduser" method="post" class="niceform">
         
                <fieldset>
                    <dl>
                        <dt><label for="companyid">Company ID:</label></dt><?php  echo form_error('companyid'); ?>
                        <dd><?php $data = array("name"=>"companyid", "id"=>"companyid", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="username">Username:</label></dt><?php  echo form_error('username'); ?>
                        <dd><?php $data = array("name"=>"username", "id"=>"username", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="password">Password:</label></dt><?php  echo form_error('password'); ?>
                        <dd><?php $data = array("name"=>"password", "id"=>"password", "size"=>"54", ); echo form_password($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="passcnf">Confirn Password:</label></dt><?php  echo form_error('passcnf'); ?>
                        <dd><?php $data = array("name"=>"passcnf", "id"=>"passcnf", "size"=>"54", ); echo form_password($data);?></dd>
                    </dl>
                     <dl>
                        <dt><label for="firstname">Firstname:</label></dt><?php  echo form_error('firstname'); ?>
                        <dd><?php $data = array("name"=>"firstname", "id"=>"firstname", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl> 
                      <dl>
                        <dt><label for="lastname">Lastname:</label></dt><?php  echo form_error('lastname'); ?>
                        <dd><?php $data = array("name"=>"lastname", "id"=>"lastname", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>
                 	 <dl>
                        <dt><label for="color">Gender</label></dt>
                        <dd>
                            <input type="radio" name="gender" id="" value="Male" /><label class="check_label">Male</label>
                            <input type="radio" name="gender" id="" value="Female" /><label class="check_label">Female</label>
                        </dd>
                        </dl>
					<dl>
                        <dt><label for="email">E-mail Address:</label></dt><?php  echo form_error('email'); ?>
                        <dd><?php $data = array("name"=>"email", "id"=>"email", "size"=>"54", ); echo form_input($data);?></dd>
                    </dl>                    
                    <dl>
                        <dt><label for="userlevel">Select Company Position:</label></dt>
                        <dd>
                            <?php $userlevel_option = array("Salesincharges"=>"Sales-In-Charge","Accountant"=>"Accountant","Stockclerk"=>"Stock Clerk", "Administrator"=>"Administrator"); ?><?php echo form_dropdown('userlevel', $userlevel_option); ?>
					
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                          <dd>
                    <input type="submit" name="submit" id="submit" value="Submit" />
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>  
      
     
     </div><!-- end of right content-->