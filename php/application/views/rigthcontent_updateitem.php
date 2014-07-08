    <div class="right_content">            
      
           
     <h2>Update <?php echo $Name?>s</h2>
     
         <div class="form">
          <?php foreach($itemsdetail as $item):?>
         <form action="<?php echo $base.$updatelink.$item->itemid ?>" method="post" class="niceform">
         <?php if($this->session->flashdata('message')){ echo $this->session->flashdata('message'); } ?>
         		<?php echo form_hidden('itemid',$item->itemid);?>
                <fieldset>
                      <dl>
                        <dt><label for="number">Reference Number:</label></dt><?php  echo form_error('number'); ?>
                        <dd><?php $data = array("name"=>"number", "id"=>"number", "size"=>"54", "value"=>"$item->number"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="description">Description:</label></dt><?php  echo form_error('description'); ?>
                        <dd><?php $data = array("name"=>"description", "id"=>"description", "size"=>"54", "value"=>"$item->description"); echo form_input($data);?></dd>
                    </dl>
                    <?php if($Name=="Part")
          				{ 
          					foreach ($modelstable as $model)
							{
								$model_options[$model->itemid]=$model->number;
							}
							foreach ($categorystable as $category)
							{
								$category_options[$category->partscategoryid]=$category->name;
							}
						?>
						<dl>
          				       <dt><label for="model">Model:</label></dt>
          				       <dd><?php echo form_dropdown('modelid',$model_options, $item->modelid); ?></dd>
          				</dl>
          				<dl>
          				       <dt><label for="Category">Category:</label></dt>
          				       <dd><?php echo form_dropdown('partscategoryid',$category_options, $item->partscategoryid); ?></dd>
          				</dl>
          			<?php	}	?>
                    <dl>
                        <dt><label for="cost">Cost:</label></dt><?php  echo form_error('cost'); ?>
                        <dd><?php $data = array("name"=>"cost", "id"=>"cost", "size"=>"54", "value"=>"$item->cost"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="price">Price:</label></dt><?php  echo form_error('price'); ?>
                        <dd><?php $data = array("name"=>"price", "id"=>"price", "size"=>"54", "value"=>"$item->price"); echo form_input($data);?></dd>
                    </dl>
                    <dl>
                        <dt><label for="location">Location:</label></dt><?php  echo form_error('location'); ?>
                        <dd><?php $data = array("name"=>"location", "id"=>"location", "size"=>"54", "value"=>"$item->location"); echo form_input($data);?></dd>
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