<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$productName 		= $_POST['productName'];
  // $productImage 	= $_POST['productImage'];
  $quantity 			= $_POST['quantity'];
  $rate 					= $_POST['rate'];
  $brandName 			= $_POST['brandName'];
  $categoryName 	= $_POST['categoryName'];
  $productStatus 	= $_POST['productStatus'];

	$name = $_FILES['productImage']['name'];
	$target_dir = "uploads/";
	$target_file = $target_dir.basename($_FILES['productImage']['name']);

	$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	
	$extensions_arr = array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG');

	if(in_array($image_file_type, $extensions_arr)) {
			if(move_uploaded_file($_FILES['productImage']['tmp_name'], $target_dir.$name)) {
				
				$sql = "INSERT INTO product (product_name, product_image, brand_id, categories_id, quantity, rate, active, status) 
				VALUES ('$productName', '$name', '$brandName', '$categoryName', '$quantity', '$rate', '$productStatus', 1)";

				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members";
				}

			}	else {
				return false;
			}	// /else	
	} // if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST