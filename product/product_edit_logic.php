<? 
if ($subpage="edit"){
	include_once("product_edit_js.php");
}

require("fileupload-class.php");

$upload_message = "<font color='red'>Please upload your picture</font>";
$edit_message = '';
$error_msg = '';

#--------------------------------#
# Variables
#--------------------------------#

// The path to the directory where you want the 
// uploaded files to be saved. This MUST end with a 
// trailing slash unless you use $path = ""; to 
// upload to the current directory. Whatever directory
// you choose, please chmod 777 that directory.

	$path = "pro_image/";

// The name of the file field in your form.

	$upload_file_name = "userfile";

// ACCEPT mode - if you only want to accept
// a certain type of file.
// possible file types that PHP recognizes includes:
//
// OPTIONS INCLUDE:
//  text/plain
//  image/gif
//  image/jpeg
//  image/png
	
	// Accept ONLY gifs's
	#$acceptable_file_types = "image/gifs";
	
	// Accept GIF and JPEG files
	$acceptable_file_types = "../image/jpeg|image/pjpeg";
	
	// Accept ALL files
	#$acceptable_file_types = "";

// If no extension is supplied, and the browser or PHP
// can not figure out what type of file it is, you can
// add a default extension - like ".jpg" or ".txt"

	$default_extension = "";

// MODE: if your are attempting to upload
// a file with the same name as another file in the
// $path directory
//
// OPTIONS:
//   1 = overwrite mode
//   2 = create new with incremental extention
//   3 = do nothing if exists, highest protection

	$mode = 1;
	
	
#--------------------------------#
# PHP
#--------------------------------#
	if (isset($_REQUEST['submitted'])) {
		$fix_inventory_qty=$_POST['fix_inventory_qty'];
		$product_name=$_POST['product_name'];
		$product_id=$_POST['product_id'];
		$product_pcs=$_POST['product_pcs'];
		$make_id=$_POST['make_id'];
		$product_model=$_POST['product_model'];
	
		$product_stock_level=$_POST['product_stock_level'];
		$product_stock_jp=$_POST['product_stock_jp'];
		
		$product_location=$_POST['product_location'];
		
		$product_colour=$_POST['product_colour'];
		$product_remark=$_POST['product_remark'];
	
		$product_made=$_POST['product_made'];
		
		if (isset($custIds)) {
			// Check duplidate customer seeling price
			$custCount = array_count_values($custIds);
			foreach ($custCount as $count) {
				if ($count > 1) {
					$error_msg='Duplicate customer is found when setting selling price';
				}
			}
		}
	
	if ($error_msg == '') {

		$product_photo=$product_id;
		if (getprod_data($product_id)!='' and $product_id!=$_GET['product_id']) {
			$php_self = $_SERVER['PHP_SELF'];
			echo "<html><meta http-equiv='refresh' content='0; URL=$php_self?page=$page&subpage=$subpage&mod=same_id&product_id=".$_GET['product_id'].'></html>';
			exit;
		}
		//remove dit and photo
		 
		$o_getprod_row = getprod_data($product_id);
		$o_product_photo=$o_getprod_row["product_photo"];
		$o_product_dit=$o_getprod_row["product_dit"];

		$o_pro_image = "pro_image/".$o_product_photo;
		$o_pro_dit = "dit_file/".$o_product_dit;
	
		if ($_POST['chk_photo']==1) {
			unlink($o_pro_image);
			$product_photo='';
		}
		else {
			$product_photo=$o_product_photo;
		}
		
		if ($_POST['chk_dit']==1){
			unlink($o_pro_dit);
			$dit_name='';
		}
		else {
			$dit_name=$o_product_dit;
		}

	//----------------------Sumit Dit File
	
	if ($_FILES["dit_file"]['name']!=""){
			
		if ($o_product_dit!='' and $_POST['chk_dit']!=1) {
			unlink($o_pro_dit);}
		
			$uploaddir = 'dit_file/'; 
			$uploaddit = $uploaddir . $_FILES['dit_file']['name']; 
			$fileOK=true;
			//echo $uploadfile."<br>";
			//echo $_FILES['dit_file']['tmp_name'];
			$getExt = substr ($_FILES['dit_file']['name'],strrpos($_FILES['dit_file']['name'],'.'),strlen ($_FILES['dit_file']['name']));
			$uploaddit = $uploaddir . $product_id . $getExt; 
			$dit_name = $product_id . $getExt;	
			if (move_uploaded_file($_FILES['dit_file']['tmp_name'], $uploaddit)) { 
				//echo "File is valid, and was successfully uploaded. "; 
				//echo "Here's some more debugging info:\n"; 
			//print_r($_FILES);
			}
			else {
				$fileOK=false;
				print "Possible file upload attack!  Here's some debugging info:\n";
			}
		}
   		//--------------------------------------end file submit
   
	
		/* 
			A simpler way of handling the submitted upload form
			might look like this:
			
			$my_uploader = new uploader('en'); // errors in English
	
			$my_uploader->max_filesize(30000);
			$my_uploader->max_image_size(800, 800);
			$my_uploader->upload('userfile', 'image/gif', '.gif');
			$my_uploader->save_file('uploads/', 2);
			
			if ($my_uploader->error) {
				print($my_uploader->error . "<br><br>\n");
			} else {
				print("Thanks for uploading " . $my_uploader->file['name'] . "<br><br>\n");
			}
		*/
			
		// Create a new instance of the class
		$my_uploader = new uploader('en'); // for error messages in french, try: uploader('fr');
		
		// OPTIONAL: set the max filesize of uploadable files in bytes
		$my_uploader->max_filesize(1024000);
		
		// OPTIONAL: if you're uploading images, you can set the max pixel dimensions 
		$my_uploader->max_image_size(1500, 1500); // max_image_size($width, $height)
		
				
		// UPLOAD the file
		//Remove file
		if ($_FILES["userfile"]['name']!="") {
			if ($o_product_photo!='' and $_POST['chk_photo']!=1) {
				unlink($o_pro_image);}
			}
			//add
			if ($my_uploader->upload($upload_file_name, $acceptable_file_types, $default_extension)) {
				$my_uploader->save_file($path, $mode, $product_id);
			}
		
			if ($my_uploader->error) {
				$edit_message = $my_uploader->error . "<br><br>\n";
			}
			else {
				$product_photo=$product_id.$my_uploader->file['extention'];
				
				// Successful upload!
				
				//print($my_uploader->file['name'] . " was successfully uploaded!");
				$upload_message = "Your picture was successfully uploaded!";
				
				// Print all the array details...
				//print_r($my_uploader->file);
				
				// ...or print the file
				if(stristr($my_uploader->file['type'], "image")) {
					$disply_photo = "<img src=\"image.php?w=120&h=120&name=" . $product_id.$my_uploader->file['extention'] . "\" border=\"0\" alt=\"\">";
				} else {
					$fp = fopen($path . $my_uploader->file['name'], "r");
					while(!feof($fp)) {
						$line = fgets($fp, 255);
						echo $line;
					}
					if ($fp) { fclose($fp); }
				}
 			}
			
			$upd_sql = "UPDATE product SET
					product_name = '$product_name',
					product_photo = '$product_photo',
					product_dit = '$dit_name',
					cat_id = '$cat_id',
					product_group = ifnull((select cat_name from ben_cat where cat_id = '$cat_id'), ''),
					product_price_u = '$product_price_u',
					product_price_s = '$product_price_s', 
					make_id = '$make_id',
					product_made = ifnull((select make_name from ben_make where make_id = '$make_id'), ''),
					product_model = '$product_model',
					product_pcs = '$product_pcs',
					product_stock_level = '$product_stock_level',
					product_stock_jp = '$product_stock_jp',
					product_location = '$product_location',
					product_colour = '$product_colour',
					product_remark = '$product_remark',
					product_web = '$product_web',
					product_cus_des = '$product_cus_des',
					product_model_no = '$product_model_no',
					product_year = '$product_year',
					product_material = '$product_material',
					product_sup = '$product_sup',
					maz= '$maz',
					product_colour_no = '$product_colour_no',
					product_original_color = '$product_original_color',
					product_cus_price = '$product_cus_price',
					product_auction_p = '$product_auction_p',
					product_cost_rmb = '$product_cost_rmb',
					product_qc = '$product_qc',
					prod_on_order= '$prod_on_order',
					sagawa_label= '$sagawa_label',
					sagawa_label1= '$sagawa_label1',
					sagawa_label2= '$sagawa_label2',
					sagawa_label3= '$sagawa_label3',
					fix_inventory_qty='$fix_inventory_qty',
					searchable='$searchable'
					";
				
				$sql = $upd_sql."where product_id = '$product_id'";
				sqlinsert($sql);
				
				// Update alias
				if ($product_us_no != '') {
					$sql = $upd_sql."where product_id = '$product_us_no'";
					sqlinsert($sql);
				}
				
				if ($product_jp_no != '') {
					$sql = $upd_sql."where product_id = '$product_jp_no'";
					sqlinsert($sql);
				}
				
				// Delete customer market price
				$sql = "DELETE FROM cust_prod_price WHERE product_id = '$product_id' ";
				sqlinsert($sql);
				if (isset($custIds)) {
					foreach($custIds as $key => $custId) {
						if (!empty($custId)) {
							$customerSellingPrice = $custSellingPrices[$key];
							if ($customerSellingPrice == null) {
								$customerSellingPrice = 0;
								$custSellingPrices[$key] = 0;
							}
				
							$sql = "INSERT INTO cust_prod_price SET
									cust_id = '$custId',
									product_id = '$product_id',
									market_price = '$customerSellingPrice'";
							sqlinsert($sql);
						}
						else {
							// Remove row from array
							unset($custIds[$key]);
						}
					}
				}
	} // End of if ($error_msg == '')
 		}
	else {
		if (@$product_photo =='') {
			$disply_photo = "images/002.gif";
		}
		else {
			$disply_photo = "image.php?w=120&h=120&name=".@$product_photo;
		}
		$disply_photo = "<img src=\"".$disply_photo."\" >";
	}
	
	$customerOptions = genCustomerCodeOptions();

/*********************
* Function
**********************/

function getProductData($product_id) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM product where product_id = '".$product_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	$row=mysql_fetch_array($result);
	
	if ($row['alias'] == 'Y') {
		// Search by product_us_no
		$result = mysql_query("SELECT * FROM product where alias = '' and product_us_no = '".$product_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
		$num_results=mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		
		if ($num_results == 0) {
			// Search by product_jp_no
			$result = mysql_query("SELECT * FROM product where alias = '' and product_jp_no = '".$product_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
			$num_results=mysql_num_rows($result);
			$row=mysql_fetch_array($result);
		}
	}
	
	mysql_free_result($result);
	mysql_close($db);
	
	return $row;
}

function getCustomerSellingPrices($product_id) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$custIds = array();
	$custSellingPrices = array();
	
	$username = $_SESSION[user_name];
	$result = mysql_query("SELECT cust_id, market_price FROM cust_prod_price t1 join customer t2 on t1.cust_id = t2.id where product_id = '$product_id' ORDER BY cust_cd ", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$custIds[$i] = $row['cust_id'];
		$custSellingPrices[$i] = $row['market_price'];
	}
	
	mysql_free_result($result);
	mysql_close($db);
	
	return array($custIds, $custSellingPrices);
}

?>