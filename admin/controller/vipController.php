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
			//var_dump($_REQUEST);die;			
			if(isset($_FILES['vip_image_upload']) && $_FILES['vip_image_upload']['name']!= ""){
				$desired_dir = "../images/vip";
				chmod( "../images/vip", 0777);
				$file_name = $_FILES['vip_image_upload']['name'];
				$file_size =$_FILES['vip_image_upload']['size'];
				$file_tmp =$_FILES['vip_image_upload']['tmp_name'];
				$file_type=$_FILES['vip_image_upload']['type'];	
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
					$photo  = "images/vip/".$photo;					
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
			
			$school_id = $dbClass->get_inserted_school_id($school_id, $school_list);
			
			$columns_value = array(
				'name'=>$vip_name,
				'designation'=>$designation,
				'username'=>$user_name,
				'mobile_no'=>$mobile_no,
				'password'=>md5($password),
				'status'=>$is_active,
				'image'=>$photo,
				'school_id'=>$school_id,
				'dob'=>$dob,
				'email'=>$email,
				'nid_no'=>$nid_no,
				'address'=>$address,
				'division'=>$division,
				'upazilla'=>$upazilla,
				'district'=>$district,
				'health_card_no'=>$health_card_no				
			);	
			
			$return = $dbClass->insert("vip", $columns_value);
			
			if($return){
				if($health_card_no != ""){
					$columns_value = array(
						'is_used'=>1,
						'user_type'=>6,
						'used_by_id'=>$return
					);
					$condition_array = array(
						'card_no'=>$health_card_no
					);
					$return_details = $dbClass->update("helth_card",$columns_value, $condition_array);	
				} 
				echo "1";
			}
			else 	    echo "0";
		}
		else if(isset($master_id) && $master_id>0){
			//var_dump($_REQUEST);die;
			if(isset($_FILES['vip_image_upload']) && $_FILES['vip_image_upload']['name']!= ""){
				$desired_dir = "../images/vip";
				chmod( "../images/vip", 0777);
				$file_name = $_FILES['vip_image_upload']['name'];
				$file_size =$_FILES['vip_image_upload']['size'];
				$file_tmp =$_FILES['vip_image_upload']['tmp_name'];
				$file_type=$_FILES['vip_image_upload']['type'];	
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
					$photo  = "images/vip/".$photo;
				}
				else{
					echo $img_error_ln;die;
				}
			}else{
				$photo ="";
			}
			
			$prev_attachment = $dbClass->getSingleRow("select image from vip where id=$master_id");
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
				$return = $dbClass->update("vip",$columns_value, $condition_array);				
			}

			$is_active=0;
			if(isset($_POST['is_active'])){
				$is_active=1;
			}
			
			$school_id = $dbClass->get_updated_school_id($school_id, $school_list);
			
			if(isset($_POST['password']) && $photo == ""){
				$columns_value = array(
					'name'=>$vip_name,
					'designation'=>$designation,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'password'=>md5($password),
					'status'=>$is_active,
					'school_id'=>$school_id,
					'dob'=>$dob,
					'email'=>$email,
					'nid_no'=>$nid_no,
					'address'=>$address,
					'division'=>$division,
					'upazilla'=>$upazilla,
					'district'=>$district,
					'health_card_no'=>$health_card_no
				);
			}else{
				$columns_value = array(
					'name'=>$vip_name,
					'designation'=>$designation,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'status'=>$is_active,
					'image'=>$photo,
					'school_id'=>$school_id,
					'dob'=>$dob,
					'email'=>$email,
					'nid_no'=>$nid_no,
					'address'=>$address,
					'division'=>$division,
					'upazilla'=>$upazilla,
					'district'=>$district,
					'health_card_no'=>$health_card_no					
				);
			}
			
			//var_dump($columns_value);die;
			
			$condition_array = array(
				'id'=>$master_id
			);
			$return_details = $dbClass->update("vip",$columns_value, $condition_array); 
			if($return_details){
				if($health_card_no != ""){
					$columns_value = array(
						'is_used'=>1,
						'user_type'=>6,
						'used_by_id'=>$master_id
					);
					$condition_array = array(
						'card_no'=>$health_card_no
					);
					$return_details = $dbClass->update("helth_card",$columns_value, $condition_array);	
				} 				
				echo '2';
			}
			else         		echo '0';
		}
	break;
	
	case "grid_data":	
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		$employee_permission	    = $dbClass->getUserGroupPermission(11);
		$update_permission          = $dbClass->getUserGroupPermission(12);
		$entry_permission   	   	= $dbClass->getUserGroupPermission(10);
		$delete_permission          = $dbClass->getUserGroupPermission(13);
		$cp_permission              = $dbClass->getUserGroupPermission(14);
		$employee_grid_permission   = $dbClass->getUserGroupPermission(15);
		$permission_grid_permission = $dbClass->getUserGroupPermission(16);
		
		$condition = "";
		//# advance search for grid		
		if($search_txt == "Print" || $search_txt == "Advance_search"){
			$condition .=" 	s.name LIKE '%$school_name%' AND v.address LIKE '%$address%' 
							AND v.division LIKE '%$division%' AND v.upazilla LIKE '%$upazilla%' AND v.district LIKE '%$district%'";		
			// for status condition 			
			if($active_status != 2) $condition  .=" and v.status = $active_status ";
			
			// for helth card condition
			if($health_card_status == 2){}
			else if($health_card_status == 1){
				$condition  .=" AND ifnull(v.health_card_no,'') != '' ";	
			}
			else{
				$condition  .=" AND ifnull(v.health_card_no,'') = '' ";
			}	
		}
		// textfield search for grid
		else{
			$condition .=	" v.status=1 AND CONCAT(v.name, v.division, v.upazilla, v.address, v.district, v.username, v.nid_no) LIKE '%$search_txt%' ";			
		}
		
		$countsql = "select count(v.id) 
					FROM vip v
					LEFT JOIN school s ON s.id = v.school_id
					WHERE $condition";
		
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$data['entry_status'] = $entry_permission; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		if($employee_grid_permission==1 || $permission_grid_permission==1){
			$sql = "SELECT v.id, v.name, v.image, v.mobile_no, v.username, v.status, s.id school_id, s.name school_name, v.address, v.designation,
					v.dob, v.district, v.division, v.upazilla, IFNULL(v.health_card_no,'') health_card_no, v.nid_no, v.email,
					$employee_permission as permission_status, $update_permission as update_status,	$delete_permission as delete_status
					from vip v 
					left join school s on s.id = v.school_id 
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
	
	case "get_vip_details":
		$emp_details = $dbClass->getResultList("SELECT v.id, v.name, v.image, v.mobile_no, v.username, v.status, s.id school_id, s.name school_name, v.address,	v.dob, v.district, v.division, v.upazilla, IFNULL(v.health_card_no,'') health_card_no, v.nid_no, v.email, v.designation
						from vip v 
						left join school s on s.id = v.school_id 
						where v.id = '$vip_id'");
		foreach ($emp_details as $row){
			$data['records'][]= $row;
		}			
		echo json_encode($data);
	break;	
	
		
	case "get_vip_info":
		$emp_details = $dbClass->getResultList("SELECT v.id, v.name, v.image, v.mobile_no, v.username, v.status, s.id school_id, s.name school_name, v.address,	v.dob, v.district, v.division, v.upazilla, IFNULL(v.health_card_no,'') health_card_no, v.nid_no, v.email, v.designation
						from vip v 
						left join school s on s.id = v.school_id 
						where v.id = '$vip_id'");
		foreach ($emp_details as $row){
			$data['records']= $row;
		}			
		echo json_encode($data);
	break;
	
	
	case "delete_vip":
		$delete_permission = $dbClass->getUserGroupPermission(13);
		if($delete_permission==1){
			$condition_array = array(
				'id'=>$vip_id
			);
			$columns_value = array(
				'status'=>0
			);
			$return = $dbClass->update("vip", $columns_value, $condition_array);
		}
		if($return==1) echo "1";
		else 		   echo "0";
	break;	
	
	

	
	
}
?>