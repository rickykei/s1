
          <TD vAlign=top bgColor=#eefafc>
            <p>              
              <? //echo"<form action='addData.php?update=".$update."&info=data' method='POST' name='form1' enctype='multipart/form-data'>"; ?>
            </p>
            <table width="677" border="0" cellspacing="0" cellpadding="0" height="24">
              <tr valign="middle">
                <td width="677" height="24"><br>                  
                  <table width="568"  border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td height="18" bgcolor="#666666"><div align="left" class="whead">&nbsp;<span class="style1">Upload your own picture</span></div></td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"> <br>
                          <table width="573" border="0" cellspacing="0" cellpadding="0">
                            <tr class="content">
                              <td width="150"><div align="center">
<?php
echo $edit_message;
echo $disply_photo;

#--------------------------------#
# HTML FORM
#--------------------------------#
?>
                              </div></td>
                              <td colspan="2">
                                <form action="<?= $_SERVER['PHP_SELF']."?page=product&subpage=edit&product_id=".$product_id; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return formCheck(this);">
                                  <div align="left">
<? 
	echo "<input type='hidden' name='ID' value='".@$ID."'>"; 
	if (isset($_GET['mod']))
		echo "<font color=red>Please, use different Product ID</font>";
	
	echo "<font color=red>$error_msg</font>";
					
	$getprod_row = getProductData($product_id);
	$product_id = $getprod_row['product_id'];
	
	$returnVal = getCustomerSellingPrices($product_id);
	$custIds = $returnVal[0];
	$custSellingPrices = $returnVal[1];
?>
                    <br>
                    <table width="450" border="0" cellpadding="0" cellspacing="0">
					<tr>
                    	<td width="120">Product ID</td>
                    	<td width="327"><? echo $product_id;?>
                    	  <input name="product_id" type="hidden" value="<?=$product_id ?>" /></td>
					</tr>
					<tr>
						<td>Product JP No (Alias)</td>
						<td><?=$getprod_row['product_jp_no']?></td>
						<input name="product_jp_no" type="hidden" value="<?=$getprod_row['product_jp_no']	 ?>" />
					</tr>
					<tr>
						<td>Product US No (Alias)</td>
						<td><?=$getprod_row['product_us_no']?></td>
						<input name="product_us_no" type="hidden" value="<?=$getprod_row['product_us_no']	 ?>" />
					</tr>
					
                      <tr>
                        <td>Make</td>
                        <td><? 
						 if (!isset($_GET['make_id']) )
						 {
						$make_id= $getprod_row['make_id'];
						getmake_selection($make_id);
						}
						else
						{
						$make_id =$_GET['make_id'] ;
						getmake_selection($make_id);
						}
						?></td>
                      </tr>
                      <tr>
                        <td>Model</td>
                        <td>
                        	<div id="model_div">
                        	<?
                        	if ($make_id == null || $make_id == '') {
                        		$make_id = 0;
                        	}
                        
                        	getmodelName_selection($make_id, $getprod_row['product_model']);
                        	
                        	if ($make_id != 0) {
	                        	$php_self=$_SERVER['PHP_SELF'];
	                        	echo "<a href=\"$php_self?page=$page&subpage=add_model&make_id=".$make_id."\" target=\"_blank\">add model</a>";
                        	}
							?>
							</div>
							</td>
                      </tr>
                      <tr>
                      	<td>Model No</td>
                      	<td>
                      		<div id="model_no_div">
                      		<? getmodelNo_selection($getprod_row['product_model'], $getprod_row['product_model_no']); ?>
							</div>
                      	</td>
                      </tr>
                      <tr>
                      	<td>Year 前期/後期</td>
                      	<td><input type=text name='product_year' value='<?=$getprod_row['product_year']?>' /></td>
                      </tr>
                      <tr>
                        <td>Item Group</td>
						<td>
							<? getprod_cat($getprod_row['cat_id']);	?>
                            <a href="product/product_add_category.php" onClick="NewWindow(this.href,'mywin','400','200','no','center');return false" onFocus="this.blur()">add item group</a>
                        </td>
                      </tr>
                      <tr>
                      	<td>Material</td>
                      	<td><input type=text name='product_material' value='<?=$getprod_row['product_material']?>' /></td>
                      </tr>
                      <tr>
                        <td>PCS</td>
                        <td><input type=text name='product_pcs' value='<?=$getprod_row['product_pcs'] ?>' /></td>
                      </tr>
                      <tr>
                        <td>PCS (JP)</td>
                        <td><input type=text name='product_stock_jp' value='<?=$getprod_row['product_stock_jp']?>' /></td>
                      </tr>
                      
                      <tr>
                        <td>Item Description</td>
                      	<td><input type=text size="45" name='product_name' value='<?=$getprod_row['product_name'] ?>' /></td>
                      </tr>
                      <tr>
                        <td>Colour</td>
                        <td><input type=text name='product_colour' value='<?=$getprod_row['product_colour'] ?>' /></td>
                      </tr>
                      <tr>
                        <td>Colour No</td>
                        <td><input type=text name='product_colour_no' value='<?=$getprod_row['product_colour_no']?>' /></td>
                      </tr>
                      <tr>
                        <td>Original Color</td>
                        <td><input type=text name='product_original_color' value='<?=$getprod_row['product_original_color']?>' /></td>
                      </tr>
                      <tr>
                        <td>Remark</td>
                        <td><input type=text name='product_remark' value='<?=$getprod_row['product_remark']?>' /></td>
                      </tr>
                      <tr>
                        <td>Custom Descrption</td>
                        <td><input type=text size="45" name='product_cus_des' value='<?=$getprod_row['product_cus_des']?>' /></td>
                      </tr>
                      <tr>
                        <td>Stock Level </td>
                        <td><input type=text name='product_stock_level' value='<?=$getprod_row['product_stock_level'] ?>' /></td>
                      </tr>
                      <tr>
                        <td>Location</td>
                        <td><input type=text name='product_location' value='<?=$getprod_row['product_location'] ?>' /></td>
                      </tr>
                      <tr>
                      	<td>Supplier</td>
                      	<td><input type=text name='product_sup' value='<?=$getprod_row['product_sup']?>' /></td>
                      </tr>
                      
					  <tr>
                      	<td>Fix Inventory Stock Bal</td>
                      	<td><input type=text name='fix_inventory_qty' value='<?=$getprod_row['fix_inventory_qty']?>' /></td>
                      </tr>
                      
					  
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      
                      <tr>
                        <td>User Price </td>
                        <td>&yen;<input type=text name='product_price_u' value='<?=$getprod_row['product_price_u']?>' /></td>
                      </tr>
                      <tr>
                        <td>Custom Price</td>
                        <td>&yen;<input type=text name='product_cus_price' value='<?=$getprod_row['product_cus_price']?>' /></td>
                      </tr>
                      <tr>
                        <td>Auction Price</td>
                        <td>&yen;<input type=text name='product_auction_p' value='<?=$getprod_row['product_auction_p']?>' /></td>
                      </tr>
                      <tr>
                        <td valign="top">Selling Price</td>
                        <td>
                        	<table id="sellingPriceTable" border="1" cellspacing="0">
                        		<tr bgcolor="#CCCCCC"><td>Customer</td><td>Price</td><td>Delete?</td></tr>
                        		<tr><td>Default</td><td>&yen;<input type=text name='product_price_s' value='<?=$getprod_row['product_price_s']?>' /></td><td>&nbsp;</td></tr>
                        		<? 
                        		if (isset($custIds)) {
                        			foreach($custIds as $key => $custId) {?>
                        				<tr><td><select name="custIds[<?=$key ?>]"><option></option><?=str_replace("<option value='".$custId."'>", "<option value='".$custId."' selected='selected'>", $customerOptions) ?></select></td><td>&yen;<input type="text" name="custSellingPrices[<?=$key ?>]" value="<?=$custSellingPrices[$key] ?>" /></td><td><a href="javascript:void(0)" onclick="deleteSellingPrice(this)">Delete</a></td></tr>
                        		<? }
                        		}
                        		 ?>
                        	</table>
                        	<br>
                        	<input type="button" value="Add" onclick="addSellingPrice()" />
                        	<div style="display:none">
                        		<select id="custList">
                        			<option></option>
                        			<?=$customerOptions ?>
                        		</select>
                        	</div>
                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Cost (RMB)</td>
                        <td>&yen;<input type=text name='product_cost_rmb' value='<?=$getprod_row['product_cost_rmb']?>' /></td>
                      </tr>

                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      
                      <tr>
                      	<td>Magazine</td>
                      	<td><input type=text name='maz' value='<?=$getprod_row['maz']?>' /></td>
                      </tr>
					  
					
					  
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Display on Web </td>
                        <td><input name="product_web" type="checkbox" id="product_web" value="1" <?if  ($getprod_row['product_web']!="") {echo "checked";} ?>></td>
                      </tr>
                       <tr>
                        <td>QC</td>
                        <td><input name="product_qc" type="checkbox" id="product_qc" value="Y" <? if ($getprod_row['product_qc'] == 'Y') {?>checked="checked"<? }?>></td>
                      </tr>
                      <tr>
                        <td>受注生産</td>
                        <td><input name="prod_on_order" type="checkbox" id="prod_on_order" value="Y" <? if ($getprod_row['prod_on_order'] == 'Y') {?>checked="checked"<? }?>></td>
                      </tr>
					  <tr>
                        <td>Special Product</td>
                        <td><select name="sagawa_label" id="sagawa_label">
                    		 <option value="" ></option>
                    		<option value="Y" <? if ($getprod_row['sagawa_label'] == 'Y'){echo "selected";}?>>Yes</option>
                    		<option value="N" <? if ($getprod_row['sagawa_label'] == 'N'){echo "selected";}?>>No</option>
                    	</select></td>
                      </tr>
					    <tr>
                        <td>Special Product 1</td>
                        <td><select name="sagawa_label1" id="sagawa_label1">
                    		 <option value="" ></option>
                    		<option value="Y" <? if ($getprod_row['sagawa_label1'] == 'Y'){echo "selected";}?>>Yes</option>
                    		<option value="N" <? if ($getprod_row['sagawa_label1'] == 'N'){echo "selected";}?>>No</option>
                    	</select></td>
                      </tr>
					    <tr>
                        <td>Special Product 3</td>
                        <td><select name="sagawa_label2" id="sagawa_label2">
                    		 <option value="" ></option>
                    		<option value="Y" <? if ($getprod_row['sagawa_label2'] == 'Y'){echo "selected";}?>>Yes</option>
                    		<option value="N" <? if ($getprod_row['sagawa_label2'] == 'N'){echo "selected";}?>>No</option>
                    	</select></td>
                      </tr>
					     <tr>
                        <td>Special Product 4</td>
                        <td><select name="sagawa_label3" id="sagawa_label3">
                    		 <option value="" ></option>
                    		<option value="Y" <? if ($getprod_row['sagawa_label3'] == 'Y'){echo "selected";}?>>Yes</option>
                    		<option value="N" <? if ($getprod_row['sagawa_label3'] == 'N'){echo "selected";}?>>No</option>
                    	</select></td>
                      </tr>
					    <tr>
                      	<td>Searchable</td>
                      <td> <select name="searchable" id="searchable">
                    		 
                    		<option value="A" <? if ($getprod_row['searchable'] == 'A'){echo "selected";}?>>Available</option>
                    		<option value="I" <? if ($getprod_row['searchable'] == 'I'){echo "selected";}?>>Invisible</option>
                    	</select></td>
                      </tr>
                    </table> 
                                    <br>
                    <input type="hidden" name="submitted" value="true">
                  Upload photo:<br>
                  <br>
                  <input name="<?= $upload_file_name; ?>" type="file" class="content">
                  <br>
                  <?
				  if  ($getprod_row['product_photo']!="") {
				  echo "Delete: <input name=\"chk_photo\" type=\"checkbox\" id=\"chk_photo\" value=\"1\" >";
				  echo "<a href='pro_image/".$getprod_row['product_photo']."' target=_blank>".$getprod_row['product_photo']."</a>";
				  } 
				  
				  ?>                  
                  <br>
                  <br>
                  Upload Dit file:<br>
                  <input name="dit_file" type="file" class="content">
                  <br>
                  <?
				  if  ($getprod_row['product_dit']!="") {
				  echo "Delete: <input name=\"chk_dit\" type=\"checkbox\" id=\"chk_dit\" value=\"1\" >";
				  echo "<a href='dit_file/".$getprod_row['product_dit']."' target=_blank>".$getprod_row['product_dit']."</a>";
				  } 
				  
				  ?>
                  <br>
                  <br>
                  <input name="submit" type="submit" class="content" value="Submit">
                                  </div>
                                </form>
                                <hr align="left">
                                <div align="left">
                                <?php
	
	
	if (isset($acceptable_file_types) && trim($acceptable_file_types)) {
		echo "The best upload image size is 1024 * 768 px.<br> Image size is limited at 1MB.<br>Image only support jpeg.<br><br> ";
	}
	
echo $upload_message;

?></div></td>
                            </tr>
                          </table>
                          <br></td>
                    </tr>
                  </table></td>
                </tr>
         
            </table>
            <p><br>
            </p></TD>

<script type="text/javascript">
	$(function() {
		$('select[name="make_id"]').change(function() {
			makeChange(this);
		});

		$('select[name="product_model"]').change(function() {
			productModelChange(this);
		});
	});
	
	function makeChange(elem) {
		// Remove model no. option
		$('#model_no_div select').html('');

		$.getJSON('product/searchModel.php', {make_id: elem.value}, function(data) {
 			var items = [];

 			items.push('<option value=""></option>');
			$.each(data, function(i, item) {
				items.push('<option value="' + item.model_name + '">' + item.model_name + '</opton>');
			});

			<? $link = $_SERVER['PHP_SELF']."?page=$page&subpage=add_model"; ?>
			$('#model_div').html('<select name="product_model"></select><a href="<?=$link?>&make_id=' + elem.value + '" target="_blank">add model</a>');

			// Bind change event
			$('select[name="product_model"]').change(function() {
				productModelChange(this);
			});

			$('select[name="product_model"]').html(items.join(''));
		});
	}

	function productModelChange(elem) {
		$.getJSON('product/searchModelNo.php', {model_name: elem.value}, function(data) {
 			var items = [];

 			items.push('<option value=""></option>');
			$.each(data, function(i, item) {
				items.push('<option value="' + item.model_no + '">' + item.model_no + '</opton>');
			});

			$('#model_no_div').html('<select name="product_model_no"></select>');
			
			$('select[name="product_model_no"]').html(items.join(''));
		});
	}

	function addSellingPrice() {
		index = $('#sellingPriceTable tr').length - 2;
		$('#sellingPriceTable tr:last').after('<tr><td><select name="custIds[' + index + ']">' + $('#custList').html() + '</select></td><td>&yen;<input type="text" name="custSellingPrices[' + index + ']" /></td><td><a href="javascript:void(0)" onclick="deleteSellingPrice(this)">Delete</a></td></tr>');
	}

	function deleteSellingPrice(elem) {
		$(elem).parent().parent().remove();
	}
</script>