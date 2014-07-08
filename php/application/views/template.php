<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo $title;?></title>
<?php  $base=$this->config->item('base_url'); ?>
<link rel="shortcut icon" href="<?php echo $base ?>/media/css/images/small_logo.png">
<link rel="stylesheet" type="text/css" href="<?php echo $base ?>/media/css/style.css" />

   <style type="text/css" title="currentStyle">
                @import "<?php echo $base ?>/media/autocomplete/css/layout-styles.css";
                @import "<?php echo $base ?>/media/autocomplete/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
    </style>

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
 <!-- jQuery libs -->
    <script type="text/javascript" src="<?php echo $base ?>/media/css/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $base ?>/media/css/ddaccordion.js"></script>
    <script  type="text/javascript" src="<?php echo $base ?>/media/autocomplete/js/jquery-1.6.1.min.js"></script>
    <script  type="text/javascript" src="<?php echo $base ?>/media/autocomplete/js/jquery-ui-1.8.14.custom.min.js"></script>

    <!-- Our jQuery Script to make everything work -->
  
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
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})


 
</script>
<script src="<?php echo $base ?>/media/css/jquery.jclock-1.2.0.js.txt" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $base ?>/media/css/jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>
<script type="text/javascript">
$(function($) {
    $('.jclock').jclock();
});
</script>

<script language="javascript" type="text/javascript" src="<?php echo $base ?>/media/css/niceforms.js"></script>
    
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo $base ?>/media/css/niceforms-default.css" />

</head>

<?php  if (!$this->session->userdata('userid'))
				{
					$this->session->unset_userdata('userid');
					$this->session->unset_userdata('userlevel');
					header('Location: '.site_url(''));
					$this->session->set_flashdata('error',' You dont have privilage to access that page (You are not Login)!');
				}
?> 
<body>
<div id="main_container">

	<div class="header">
    <div class="logo"><a href="#"><img src="<?php echo $base ?>/media/css/images/logo.png" alt="" title="" border="0" /></a></div>
    
    <div class="right_header"></div>
    <div class="jclock"></div>
    </div>
    
    <div class="main_content">
    			<?php echo form_open();?>
                    <div class="menu">
                    <ul>
                    <li><a href="<?php echo $base ?>/cindex/home">Home</a></li>
                     <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                     		'Stockclerk'==$this->session->userdata('userlevel')||
                     		'Salesincharges'==$this->session->userdata('userlevel'))	{?>
                    <li><a href="<?php echo $base ?>/cinventory/viewmodels">Model</a>
                        <ul>
                        <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                        		'Stockclerk'==$this->session->userdata('userlevel')	||
                        		'Salesincharges'==$this->session->userdata('userlevel'))	{?>
                        <li><a href="<?php echo $base ?>/cinventory/addmodels" title="">Add New Item Model</a></li>
                        <?php } ?>
                        <li><a href="<?php echo $base ?>/cinventory/viewmodels" title="">View All Item Model</a></li>
                        </ul>
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
                    <li><a href="<?php echo $base ?>/cinventory/viewparts">Parts</a>
                        <ul>
                        <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                        		'Stockclerk'==$this->session->userdata('userlevel')||
                        		'Salesincharges'==$this->session->userdata('userlevel'))	{?>
                        <li><a href="<?php echo $base ?>/cinventory/addparts" title="">Add New Item Part</a></li>
                        <?php } ?>
                        <li><a href="<?php echo $base ?>/cinventory/viewparts" title="">View All Item Part</a></li>
                        <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                        		'Stockclerk'==$this->session->userdata('userlevel'))	{?>
                          <li><a href="<?php echo $base ?>/cinventory/addpartscategory" title="">Add New Parts Category</a></li>
                          <li><a href="<?php echo $base ?>/cinventory/viewpartscategory" title="">View Parts Category</a></li>
                          <?php } ?>
                      </ul>
                    </li>
                    <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                        		'Salesincharges'==$this->session->userdata('userlevel'))	{?>
                    <li><a href="<?php echo $base ?>/cuser/viewclients">Client/Supplier</a>
                        <ul>
                        <li><a href="<?php echo $base ?>/cuser/addclients" title="">Add New Client</a></li>
						<li><a href="<?php echo $base ?>/cuser/addsuppliers" title="">Add New Supplier</a></li>
                        <li><a href="<?php echo $base ?>/cuser/viewclients" title="">View All Client</a></li>
						<li><a href="<?php echo $base ?>/cuser/viewsuppliers" title="">View All Supplier</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php } ?>
                    <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                    		'Stockclerk'==$this->session->userdata('userlevel')||
                    		'Accountant'==$this->session->userdata('userlevel'))	{?>
					<li><a href="<?php echo $base ?>/cinventory/viewinventory">Inventory</a>
						<ul>
						<?php  if ('Salesincharges'!=$this->session->userdata('userlevel')&&
                    		'Accountant'!=$this->session->userdata('userlevel'))	{?>
						<li><a href="<?php echo $base ?>/cinventory/supplierrecieve">New Supply</a></li>
						<li><a href="<?php echo $base ?>/cinventory/deductitem">Deduct Stock</a></li>
						 <?php } ?> 
						<li><a href="<?php echo $base ?>/cinventory/viewinventory">View Inventory</a></li>
	                    </ul>
	                </li>
	                <?php } ?> 
	                <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                    		'Accountant'==$this->session->userdata('userlevel'))	{?>
                    <li><a href="<?php echo $base ?>/cinvoice/viewinvoices">Invoice</a>
        				<ul>
          	     	     <li><a href="<?php echo $base ?>/cinvoice/createinvoice">Create Invoice Statement</a></li>
						<li><a href="<?php echo $base ?>/cinvoice/viewinvoices">View All Invoice Statements</a></li>
	                    </ul>
	                  <?php } ?> 
	                   <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                    		'Accountant'==$this->session->userdata('userlevel')||
	                   		'Salesincharges'==$this->session->userdata('userlevel'))	{?>
                    <li><a href="#">Purchase Order</a>
                    	<ul>
                       	<li><a href="<?php echo $base ?>/cinventory/createpurchaseorder">Create Purchase Order</a></li>
                 	   <li><a href="<?php echo $base ?>/cinventory/viewpurchaseorders">View Purchase Order</a></li>
                    	</ul>
                    	<?php } ?> 
                    <li><a class="#" href="">Reports<!--[if IE 7]><!--></a><!--<![endif]-->
                    <!--[if lte IE 6]><table><tr><td><![endif]-->
                        <ul>
                        <li><a href="<?php echo $base ?>/datepicker/clientpicker">Client List Reports</a></li>
                        <li><a href="<?php echo $base ?>/datepicker/supplierpicker">Supplier List Reports</a></li>
                        <li><a href="<?php echo $base ?>/datepicker/inventorypicker">Inventory List Reports</a></li>
                        <li><a href="<?php echo $base ?>/datepicker/offersheetpicker">Offer Sheet List Reports</a></li>
                        <li><a href="<?php echo $base ?>/datepicker/purchaseorderpicker">Purchase Oder Client List Reports</a></li>
                         <li><a href="<?php echo $base ?>/datepicker/supplierpicker">Purchase Oder Supplier List Reports</a></li>
                        <li><a href="<?php echo $base ?>/datepicker/invoicepicker">Invoice List Reports</a></li>
                        <li><a class="sub1" href="<?php echo $base ?>" title="">Product Analysis Reports<!--[if IE 7]><!--></a><!--<![endif]-->
                            <ul>
                                <li><a href="<?php echo $base ?>/cinventory/viewfsnlist" title="">FSN Analysis</a></li>
                            </ul>
                        </li>
                        </ul>
                        
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
                    <li><a href="list.html">Account Settings<!--[if IE 7]><!--></a><!--<![endif]-->
                    <!--[if lte IE 6]><table><tr><td><![endif]-->
                        <ul>
                        <li><a href="<?php echo $base.'/cuser/viewprofiledetails/'.$this->session->userdata('userid')?>" title="">View Account</a></li>
                        <li><a href="<?php echo $base.'/cuser/updateprofile/'.$this->session->userdata('userid')?>" title="">Update Account</a></li>
                        <li><a href="<?php echo $base.'/cuser/deactivateprofile/'.$this->session->userdata('userid')?>" title="">Deactivate Account</a></li>
                        </ul>
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
                    <li><a href="<?php echo $base ?>/cindex/logout">Logout</a></li>
                    </ul>
                    </div> 
                    
                    
                    
                    
    <div class="center_content">  
    
    
    
    <div class="left_content">
   
    		    
            <div class="sidebarmenu">
            <?php echo form_open();?>
            <?php echo form_close(); ?>
            <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                    		'Accountant'==$this->session->userdata('userlevel')||
            		'Salesincharges'==$this->session->userdata('userlevel'))	{?>
				<a class="menuitem_green" href="">User : <?php echo $this->session->userdata('user_name');?></a>
				
                <a class="menuitem submenuheader" href="">Offer Sheet</a>
                <div class="submenu">
                    <ul>
                    <?php  if ('Accountant'!=$this->session->userdata('userlevel')){?>
                    <li><a href="<?php echo $base ?>/coffersheet/createoffersheet">Create Offer Sheet</a></li>
                  	 <?php } ?>
                    <li><a href="<?php echo $base ?>/coffersheet/viewoffersheets">View Offer Sheet</a></li>
                    
                    </ul>
                </div>
                 <?php } ?>
                 <?php  if ('Administrator'==$this->session->userdata('userlevel')||
                    		'Accountant'==$this->session->userdata('userlevel')||
                 			'Salesincharges'==$this->session->userdata('userlevel'))	{?>
                <a class="menuitem submenuheader" href="" >Purchase Order</a>
                <div class="submenu">
                    <ul>
                    <?php  if ('Stockclerk'!=$this->session->userdata('userlevel')){?>
                   	<li><a href="<?php echo $base ?>/cinventory/createpurchaseorder">Create Purchase Order</a></li>
                     <?php } ?>
                     <?php  if ('Stockclerk'!=$this->session->userdata('userlevel')){?>
                   	<li><a href="<?php echo $base ?>/cinventory/createpurchaseordersupplier">Create Purchase Order Supplier</a></li>
                    <?php } ?>
                    <li><a href="<?php echo $base ?>/cinventory/viewpurchaseorders">View Purchase Order</a></li>
                    </ul>
                     <ul>
                    <li><a href="<?php echo $base ?>/cinventory/viewpurchaseordersupplier">View Purchase Order Supplier</a></li>
                   
                    </ul>
                </div>
                <?php } ?>
                <a class="menuitem submenuheader" href="">Inventory Management</a>
                <div class="submenu">
                    <ul>
                    <?php  if ('Salesincharges'!=$this->session->userdata('userlevel')&&
                    		'Accountant'!=$this->session->userdata('userlevel'))	{?>
					<li><a href="<?php echo $base ?>/cinventory/supplierrecieve">New Supply</a></li>
					<li><a href="<?php echo $base ?>/cinventory/deductitem">Deduct Stock</a></li>
					 <?php } ?>
					<li><a href="<?php echo $base ?>/cinventory/viewinventory">View Inventory</a></li>
                    </ul>
                </div>
                 <?php  if ('Administrator'==$this->session->userdata('userlevel')
            		||'Accountant'==$this->session->userdata('userlevel'))	{?>
                <a class="menuitem submenuheader" href="">Invoice Management</a>
                <div class="submenu">
                    <ul>
                    <li><a href="<?php echo $base ?>/cinvoice/createinvoice">Create Invoice Statement</a></li>
					<li><a href="<?php echo $base ?>/cinvoice/viewinvoices">View All Invoice Statements</a></li>
                    </ul>
                </div>
                <?php } ?>
           	  <?php  if ('Administrator'==$this->session->userdata('userlevel'))	{?>
                <a class="menuitem submenuheader" href="">Users Management</a>
                <div class="submenu">
                    <ul>
                    <li><a href="<?php echo $base ?>/cuser/adduser">Create New User</a></li>
                    <li><a href="<?php echo $base ?>/cuser/viewuser">View All Users</a></li>
                    </ul>
                </div>
				<a class="menuitem_red" href="<?php echo $base ?>/cinventory/viewfsnlist">FSN Analysis</a>
               <?php } ?>
            </div>
            
              
    
    </div>  
    
	<?php $this->load->view($rigthcontent);?> 
            
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    <div class="left_footer_login"> Official Philippine Importer of Japan's Newlong Machines <a href="<?php echo 'http://www.philnewlong.com/' ?>"> PHIL NEWLONG, Copyright <?php echo date("Y"); ?> </a></div>
    <div class="footer">
    
    </div>

</div>		
</body>
 
</html>