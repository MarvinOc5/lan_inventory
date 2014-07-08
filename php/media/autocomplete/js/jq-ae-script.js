	var total = 0;
	function getValues() {
	var qty = 0;
	var rate = 0;
	var vat	 = 0;
	var dsc	 = 0;
	var ser  = 0;
	var obj = document.getElementsByTagName("input");
	      for(var i=0; i<obj.length; i++){
	         if(obj[i].name == "qty[]"){var qty = obj[i].value;}
	         if(obj[i].name == "rate[]"){var rate = obj[i].value;}
			 if(obj[i].name == "vat[]"){var vat = obj[i].value;}
			 if(obj[i].name == "dsc[]"){var dsc = obj[i].value;}
			 if(obj[i].name == "ser[]"){var ser = obj[i].value;}
	         if(obj[i].name == "amt[]"){
	          		if(qty > 0 && rate > 0){obj[i].value = parseFloat((rate*1 +(rate*vat/100)) - ((rate*1 + rate*vat/100)*(dsc/100)) * qty).toFixed(2);total+=(obj[i].value*1);}
	          				else{obj[i].value = 0;total+=(obj[i].value*1);}
	          		}
	         	 }
	        document.getElementById("total").value = parseFloat(total*1).toFixed(2);
	        total=0;
	}
	var base_url = '<?php echo base_url(); ?>';	
$(document).ready(function(){

    // Use the .autocomplete() method to compile the list based on input from user
    $('#itemCode').autocomplete({
        source: '/lan_inventory/media/autocomplete/data/item-data.php',
        minLength: 1,
        select: function(event, ui) {
            var $itemrow = $(this).closest('tr');
                    // Populate the input fields from the returned values
                    $itemrow.find('#itemCode').val(ui.item.itemCode);
                    $itemrow.find('#itemDesc').val(ui.item.itemDesc);
                    $itemrow.find('#itemPrice').val(ui.item.itemPrice);
                    $itemrow.find('#itemId').val(ui.item.itemId);

                    // Give focus to the next input field to recieve input from user
                    $('#itemQty').focus();

            return false;
	    }
    // Format the list menu output of the autocomplete
    }).data( "autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>" + item.itemCode + " - " + item.itemDesc + "</a>" )
            .appendTo( ul );
    };

    // Get the table object to use for adding a row at the end of the table
    var $itemsTable = $('#itemsTable');

    // Create an Array to for the table row. ** Just to make things a bit easier to read.
    var rowTemp = [
                   '<tr class="item-row">',
                   '<td><a id="deleteRow"><img src="/lan_inventory/media/autocomplete/images/icon-minus.png" alt="Remove Item" title="Remove Item"></a></td>', 
                    '<td><input required autofocus placeholder="Reference Number"  name="itemCode[]" value=""  id="itemCode" tabindex="1"/><input name="itemId[]" value="" type="hidden" class="tInput" id="itemId" readonly="readonly" /> </td>',
                    '<td><input name="itemDesc[]" value="" class="Desc" id="itemDesc"   /></td>',
                    '<td><input type="text"  name="rate[]"  id="itemPrice" onkeyup="getValues()" style="width:80px;" onBlur=""></td>',
                    '<td><input required placeholder="Quantity"  type="text" name="qty[]" onKeyUp="getValues()" style="width:80px;" value="1"></td>',
                    '<td><input type="text" name="vat[]" onKeyUp="getValues()" style="width:80px;" value="12"></td>',
                    '	<td><input placeholder="Discount" name="dsc[]" id="dsc" onKeyUp="getValues()" style="width:50px;" value=""></td>',
					'<td><input type="text"  name="amt[]" id="Total" style="width:80px;" onKeyUp="getValues()"></td>',                                         
					'</tr>'
               ].join('');

    // Add row to list and allow user to use autocomplete to find items.
    $("#addRow").bind('click',function(){

        var $row = $(rowTemp);

        // save reference to inputs within row
        var $itemCode 	        = $row.find('#itemCode');
        var $itemDesc 	        = $row.find('#itemDesc');
        var $itemPrice	        = $row.find('#itemPrice');
        var $itemQty	        = $row.find('#itemQty');
        var $itemId			    = $row.find('#itemId');

        if ( $('#itemCode:last').val() !== '' ) {

            // apply autocomplete widget to newly created row
            $row.find('#itemCode').autocomplete({
                source: '/lan_inventory/media/autocomplete/data/item-data.php',
                minLength: 1,
                select: function(event, ui) {
                    $itemCode.val(ui.item.itemCode);
                    $itemDesc.val(ui.item.itemDesc);
                    $itemPrice.val(ui.item.itemPrice);
                    $itemQty.val(ui.item.itemQty);
					$itemId.val(ui.item.itemId);

                    // Give focus to the next input field to recieve input from user
                    $itemQty.focus();

                    return false;
                }
            }).data( "autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + item.itemCode + " - " + item.itemDesc + "</a>" )
                    .appendTo( ul );
            };
            // Add row after the first row in table
            $('.item-row:last', $itemsTable).after($row);
            $($itemCode).focus();

        } // End if last itemCode input is empty
        return false;
    });

    $('#save').focus(function(){
        window.onbeforeunload = function(){ return "You haven't saved your data.  Are you sure you want to leave this page without saving first?"; };
    });

}); // End DOM

	// Remove row when clicked
	$("#deleteRow").live('click',function(){
		$(this).parents('.item-row').remove();
        // Hide delete Icon if we only have one row in the list.
        if ($(".item-row").length < 2) $("#deleteRow").hide();
	});
