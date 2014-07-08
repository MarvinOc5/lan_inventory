<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>The Philippine New Long Corporation</title>
<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/css/style.css" />
<link rel="shortcut icon" type="media/image/x-icon" href="<?php echo $base; ?>/media/css/images/small_logo.png" />
<link rel="icon" type="media/image/x-icon" href="<?php echo $base; ?>/media/css/images/small_logo.png" />
<script type="text/javascript" src="<?php echo $base ?>/media/css/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/media/css/ddaccordion.js"></script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>

<script type="text/javascript" src="<?php echo $base ?>/media/css/jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>

<script language="javascript" type="text/javascript" src="<?php echo $base ?>/media/css/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $base ?>/media/css/niceforms-default.css" />
<?php  if ($this->session->userdata('userid'))
				{
					header('Location: '.site_url('/cindex/home'));
					$this->session->set_flashdata('message','You are already Login!');
				}
		if ($this->session->userdata('userlevel'))
				{
					header('Location: '.site_url('/cindex/home'));
					$this->session->set_flashdata('message','You are already Login!');
				}?> 
</head>
<body>
<div id="main_container">

	<div class="header">
    <div class="logo"><a href="#"><img src="<?php echo $base ?>/media/css/images/logo.png" alt="" title="" border="0" /></a></div>
    
    </div>

		
         <div class="login_form">

         <h3>Employee Login</h3>
	 
         <form action="" method="post" class="niceform">
		 
         	  <?php echo form_open('cindex/login'); ?>
         						
                <fieldset>
                    <dl>
                        <dt><label for="email"></label></dt>
                        <dd><font color="red"><?php if($this->session->flashdata('error')){ echo $this->session->flashdata('error'); } ?>
						<?php if($this->session->flashdata('message')){ echo $this->session->flashdata('message'); } ?></font></dd>
                    </dl>
					<dl>
                        <dt><label for="email">Username:</label></dt>
                        <dd><?php echo form_input(array("id" => "username", "name" => "username", "size" => "54"))?></dd>
                    </dl>
                    <dl>
                        <dt><label for="password">Password:</label></dt>
                        <dd><?php echo form_password(array("id" => "password", "name" => "password", "size" => "54"))?>
					</dd>
                    </dl>
        			<?php if(isset($_POST['redirect'])) : ?>
				    <input type="hidden" name="redirect" value="<?php echo $_POST['redirect']; ?>" />
				    <?php endif; ?>
                     <dl class="submit">
                     <dd>
                    <input type="submit" name="submit" id="submit" value="Enter" />
                     </dl>
                    
                </fieldset>
                
         </form>
	
         </div>  
          
	
    
   <div class="footer_login">
    
    	<div class="left_footer_login"> Official Philippine Importer of Japan's Newlong Machines <a href="<?php echo 'http://www.philnewlong.com/' ?>"> PHIL NEWLONG </a></div>
    
    </div>

</div>		
</body>
</html>