    <div class="right_content">            
      
           
     <h2>Update User</h2>
     
         <div class="form">
          <?php foreach($usersdetail as $usersitem):?>
         <form action="<?php echo $base ?>/cuser/updateuser/<?php echo $usersitem->userid ?>" method="post" class="niceform">
         <?php if($this->session->flashdata('message')){ echo $this->session->flashdata('message'); } ?>
         		<?php echo form_hidden('userid',$usersitem->userid);?>
                <fieldset>
                    <dl>
                        <dt><label for="companyid">Company ID:</label></dt><?php  echo form_error('companyid'); ?>
                        <dd><?php $data = array("name"=>"companyid", "id"=>"companyid", "size"=>"54", "value"=>"$usersitem->companyid"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="username">Username:</label></dt><?php  echo form_error('username'); ?>
                        <dd><?php $data = array("name"=>"username", "id"=>"username", "size"=>"54", "value"=>"$usersitem->username"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="password">New Password:</label></dt><?php  echo form_error('password'); ?>
                        <dd><?php $data = array("name"=>"password", "id"=>"password", "size"=>"54", "value"=>""); echo form_password($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="passcnf">Confirn New Password:</label></dt><?php  echo form_error('passcnf'); ?>
                        <dd><?php $data = array("name"=>"passcnf", "id"=>"passcnf", "size"=>"54"); echo form_password($data);?></dd>
                    </dl>
                     <dl>
                        <dt><label for="firstname">Firstname:</label></dt><?php  echo form_error('firstname'); ?>
                        <dd><?php $data = array("name"=>"firstname", "id"=>"firstname", "size"=>"54", "value"=>"$usersitem->firstname"); echo form_input($data);?></dd>
                    </dl> 
                      <dl>
                        <dt><label for="lastname">Lastname:</label></dt><?php  echo form_error('lastname'); ?>
                        <dd><?php $data = array("name"=>"lastname", "id"=>"lastname", "size"=>"54", "value"=>"$usersitem->lastname"); echo form_input($data);?></dd>
                    </dl>
                 	 <dl>
                        <dt><label for="color">Gender</label></dt>
                        <dd>
                              <dd><?php  if($usersitem->gender=='Male'){ ?>
                            			<input type="radio" name="gender" id="" value="Male" checked="checked"/><label class="check_label">Male</label>
                            <?php  } 
                              else {?>
                              			<input type="radio" name="gender" id="" value="Male" /><label class="check_label">Male</label>
                   		   	<?php  } ?>
                           		<?php	if($usersitem->gender=='Female'){ ?>
                            <input type="radio" name="gender" id="" value="Female" checked="checked"/><label class="check_label">Female</label>
                       		<?php  } 
                              else {?>
                              			<input type="radio" name="gender" id="" value="Female" /><label class="check_label">Female</label>
                   		   	<?php  } ?>
                        </dd>
                        
                       </dl>
					<dl>
                        <dt><label for="email">E-mail Address:</label></dt><?php  echo form_error('email'); ?>
                        <dd><?php $data = array("name"=>"email", "id"=>"email", "size"=>"54", "value"=>"$usersitem->email"); echo form_input($data);?></dd>
                    </dl>                    
                    <dl>
                        <dt><label for="userlevel">Select Company Position:</label></dt>
                        <dd>
                            <?php $userlevel_option = array("Salesincharges"=>"Sales-In-Charge","Accountant"=>"Accountant","Stockclerk"=>"Stock Clerk", "Administrator"=>"Administrator"); ?><?php echo form_dropdown('userlevel', $userlevel_option, $usersitem->userlevel); ?>
					
                        </dd>
                    </dl>
                    <dl>
                       <dt><label for="userlevel">Select Company Position:</label></dt>
                        <dd>
                            <?php $status_option = array("Active"=>"Active","NotActive"=>"NotActive"); ?><?php echo form_dropdown('status', $status_option, $usersitem->status); ?>
					
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <dd>
                    	<input type="submit" name="submit" id="submit"
                    		value="Done" /></input>
                    </dd>
                     </dl>
                     <?php endforeach;?>
                     
                     
                    
                </fieldset>
                
         </form>
     
         </div>  
      
     
     </div><!-- end of right content-->