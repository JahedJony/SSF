<?php 
session_start();
include '../includes/static_text.php';
include("../dbConnect.php");
include("../dbClass.php");

$dbClass = new dbClass;
$conn       = $dbClass->getDbConn();
$loggedUser = $dbClass->getUserId();	

extract($_REQUEST);

switch ($q){
	
	case "insert_or_update":	
		if(isset($master_id) && $master_id == ""){
			if(isset($_FILES['diagnostic_image_upload']) && $_FILES['diagnostic_image_upload']['name']!= ""){
				$desired_dir = "../images/diagnostic";
				chmod( "../images/diagnostic", 0777);
				$file_name = $_FILES['diagnostic_image_upload']['name'];
				$file_size =$_FILES['diagnostic_image_upload']['size'];
				$file_tmp =$_FILES['diagnostic_image_upload']['tmp_name'];
				$file_type=$_FILES['diagnostic_image_upload']['type'];	
				if($file_size < $file_max_length){
					if(file_exists("$desired_dir/".$file_name)==false){
						if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
							$photo = "$file_name";
					}
					else{//rename the file if another one exist
						$new_dir="$desired_dir/".time().$file_name;
						if(rename($file_tmp,$new_dir))
							$photo =time()."$file_name";				
					}
					$photo  = "images/diagnostic/".$photo;					
				}
				else{
					echo $img_error_ln;die;
				}			
			}
			else{
				$photo = "images/no_image.png";
			}	
			$is_active=0;
			if(isset($_POST['is_active'])){
				$is_active=1;
			}
			if(empty($_POST['password'])){
				$password="123456";
			}
			$columns_value = array(
				'name'=>$diagnostic_name,
				'contact_person_name'=>$contact_person_name,
				'address'=>$address,
				'speciality'=>$speciality,
				'username'=>$user_name,
				'mobile_no'=>$mobile_no,
				'password'=>md5($password),
				'status'=>$is_active,
				'image'=>$photo,
				'remarks'=>$remarks
			);	
			$return = $dbClass->insert("diagnostic", $columns_value);
			
			if($return) echo "1";
			else 	    echo "0";
		}
		else if(isset($master_id) && $master_id>0){
			//var_dump($_REQUEST);die;
			if(isset($_FILES['diagnostic_image_upload']) && $_FILES['diagnostic_image_upload']['name']!= ""){
				$desired_dir = "../images/diagnostic";
				chmod( "../images/diagnostic", 0777);
				$file_name = $_FILES['diagnostic_image_upload']['name'];
				$file_size =$_FILES['diagnostic_image_upload']['size'];
				$file_tmp =$_FILES['diagnostic_image_upload']['tmp_name'];
				$file_type=$_FILES['diagnostic_image_upload']['type'];	
				if($file_size < $file_max_length){
					if(file_exists("$desired_dir/".$file_name)==false){
						if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
							$photo = "$file_name";
					}
					else{//rename the file if another one exist
						$new_dir="$desired_dir/".time().$file_name;
						if(rename($file_tmp,$new_dir))
							$photo =time()."$file_name";				
					}
					$photo  = "images/diagnostic/".$photo;	
				}
				else{
					echo $img_error_ln;die;
				}
			}else{
				$photo = "images/no_image.png";
			}
			$prev_attachment = $dbClass->getSingleRow("select image from diagnostic where id=$master_id");
			if($photo != ""){	
				if($prev_attachment['image'] != "" ){
					unlink("../".$prev_attachment['image']);
				}
				$columns_value = array(
					'image' => $photo
				);	 
				$condition_array = array(
					'id'=>$master_id
				);
				$return = $dbClass->update("diagnostic",$columns_value, $condition_array);				
			}
			$is_active=0;
			if(isset($_POST['is_active'])){
				$is_active=1;
			}
			if(isset($_POST['password']) && $photo = ""){
				$columns_value = array(
					'name'=>$diagnostic_name,
					'contact_person_name'=>$contact_person_name,
					'address'=>$address,
					'speciality'=>$speciality,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'password'=>md5($password),
					'status'=>$is_active,
					'remarks'=>$remarks
				);
			}else{
				$columns_value = array(
					'name'=>$diagnostic_name,
					'contact_person_name'=>$contact_person_name,
					'address'=>$address,
					'speciality'=>$speciality,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'status'=>$is_active,
					'remarks'=>$remarks
				);
			}
			$condition_array = array(
				'id'=>$master_id
			);
			$return_details = $dbClass->update("diagnostic",$columns_value, $condition_array); 
			if($return_details) echo '2';
			else                echo '0';
		}
	break;
	
	case "grid_data":	
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		$employee_permission	    = $dbClass->getUserGroupPermission(11);
		$update_permission          = $dbClass->getUserGroupPermission(12);
		$entry_permission   	    = $dbClass->getUserGroupPermission(10);
		$delete_permission          = $dbClass->getUserGroupPermission(13);
		$cp_permission              = $dbClass->getUserGroupPermission(14);
		$employee_grid_permission   = $dbClass->getUserGroupPermission(15);
		$permission_grid_permission = $dbClass->getUserGroupPermission(16);
		
		$condition = "";
		//# advance search for grid		
		if($search_txt == "Print" || $search_txt == "Advance_search"){
			$condition .=" speciality like '%$diag_speciality%' AND address LIKE '%$diag_address%'";		
			// for status condition 			
			if($active_status != 2) $condition  .=" and status = $active_status ";
		}
		// textfield search for grid
		else{
			$condition .=	" status=1 AND CONCAT(name, speciality, address,username) LIKE '%$search_txt%' ";			
		}
		$countsql = "select count(id) 
					from diagnostic 
					WHERE $condition";
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$data['entry_status'] = $entry_permission; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		if($employee_grid_permission==1 || $permission_grid_permission==1){
			$sql = "select id,name,speciality,address,mobile_no,image,remarks,username,`status`, contact_person_name, ifnull(email,'') email,
					$employee_permission as permission_status, $update_permission as update_status,	$delete_permission as delete_status
					from diagnostic 
					WHERE $condition  
					order by id asc limit $start, $end";			
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
			foreach ($result as $row) {
				$data['records'][] = $row;
			}			
			echo json_encode($data);
		}			 
	break;
	
	case "get_diagnostic_details":
		$update_permission = $dbClass->getUserGroupPermission(12);
		if($update_permission==1){
			$emp_details = $dbClass->getResultList("select id, name, speciality, contact_person_name, address, mobile_no, username,email,
												   image, remarks, username, `status` 
												   from diagnostic where id = '$dc_id'");
			foreach ($emp_details as $row){
				$data['records'][] = $row;
			}			
			echo json_encode($data);
		}
	break;
	
	case "get_diagnostic_info":		
		$emp_details = $dbClass->getResultList("select id, name, speciality, contact_person_name, address, mobile_no, username,email,
											   image, remarks, username, `status` 
											   from diagnostic where id = '$dc_id'");
		foreach ($emp_details as $row){
			$data['records']= $row;
		}			
		echo json_encode($data);

	break;
	
	
	case "delete_diagnostic":
		$delete_permission = $dbClass->getUserGroupPermission(13);
		if($delete_permission==1){
			$condition_array = array(
				'id'=>$diagnostic_id
			);
			$columns_value = array(
				'status'=>0
			);
			$return = $dbClass->update("diagnostic", $columns_value, $condition_array);
		}
		if($return==1) echo "1";
		else 		   echo "0";
	break;	

	case "update_information":
		$password = $dbClass->getSingleRow("select password from diagnostic where id=$loggedUser");
		if(isset($new_password) && $new_password != ""){
			//echo $password['password'].'--'.md5($old_password);die;
			if($password['password'] == md5($old_password)){
				$columns_value = array(
					'password'=>md5($new_password)
				);
				$condition_array = array(
					'id'=>$loggedUser
				);
				$return_pass = $dbClass->update("diagnostic", $columns_value, $condition_array);
				if($return_pass==1) echo "1";
			}
			else echo "0";
		}
	break;	


}
?>