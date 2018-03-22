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
			if(isset($_FILES['teacher_image_upload']) && $_FILES['teacher_image_upload']['name']!= ""){
				$desired_dir = "../images/teacher";
				chmod( "../images/teacher", 0777);
				$file_name = $_FILES['teacher_image_upload']['name'];
				$file_size =$_FILES['teacher_image_upload']['size'];
				$file_tmp =$_FILES['teacher_image_upload']['tmp_name'];
				$file_type=$_FILES['teacher_image_upload']['type'];	
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
					$photo  = "images/teacher/".$photo;					
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
				'name'=>$teacher_name,
				'address'=>$address,
				'subject'=>$subject,
				'username'=>$user_name,
				'mobile_no'=>$mobile_no,
				'password'=>md5($password),
				'status'=>$is_active,
				'image'=>$photo,
				'school_id'=>$school_id,
				'dob'=>$dob,
				'designation'=>$designation,
				'email'=>$email,
				'nid_no'=>$nid_no,
				'zilla'=>$zilla,
				'upazilla'=>$upazilla,
				'division'=>$division,
				'health_card_no'=>$health_card_no				
			);	
			$return = $dbClass->insert("teacher", $columns_value);
			
			if($return){
				if($health_card_no != ""){
					$columns_value = array(
						'is_used'=>1,
						'user_type'=>4,
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
			if(isset($_FILES['teacher_image_upload']) && $_FILES['teacher_image_upload']['name']!= ""){
				$desired_dir = "../images/teacher";
				chmod( "../images/teacher", 0777);
				$file_name = $_FILES['teacher_image_upload']['name'];
				$file_size =$_FILES['teacher_image_upload']['size'];
				$file_tmp =$_FILES['teacher_image_upload']['tmp_name'];
				$file_type=$_FILES['teacher_image_upload']['type'];	
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
					$photo  = "images/teacher/".$photo;	
				}
				else{
					echo $img_error_ln;die;
				}
			}else{
				$photo ="";
			}
			$prev_attachment = $dbClass->getSingleRow("select image from teacher where id=$master_id");
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
				$return = $dbClass->update("teacher",$columns_value, $condition_array);				
			}
			$is_active=0;
			if(isset($_POST['is_active'])){
				$is_active=1;
			}
			
			$school_id = $dbClass->get_updated_school_id($school_id, $school_list);
			
			if(isset($_POST['password']) && $photo = ""){
				$columns_value = array(
					'name'=>$teacher_name,
					'address'=>$address,
					'subject'=>$subject,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'password'=>md5($password),
					'status'=>$is_active,
					'school_id'=>$school_id,
					'dob'=>$dob,
					'designation'=>$designation,
					'email'=>$email,
					'nid_no'=>$nid_no,
					'zilla'=>$zilla,
					'upazilla'=>$upazilla,
					'division'=>$division,
					'health_card_no'=>$health_card_no	
				);
			}else{
				$columns_value = array(
					'name'=>$teacher_name,
					'address'=>$address,
					'subject'=>$subject,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'status'=>$is_active,
					'school_id'=>$school_id,
					'dob'=>$dob,
					'designation'=>$designation,
					'email'=>$email,
					'nid_no'=>$nid_no,
					'zilla'=>$zilla,
					'upazilla'=>$upazilla,
					'division'=>$division,
					'health_card_no'=>$health_card_no	
				);
			}
			//var_dump($columns_value);die;
			$condition_array = array(
				'id'=>$master_id
			);
			$return_details = $dbClass->update("teacher",$columns_value, $condition_array); 
			if($return_details){
				if($health_card_no != ""){
					$columns_value = array(
						'is_used'=>1,
						'user_type'=>4,
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
			$condition .=	"  t.designation LIKE '%$tec_designation%' AND t.address LIKE '%$tec_address%' AND t.upazilla LIKE '%$tec_upazilla%' AND t.zilla LIKE '%$tec_zilla%' AND t.division LIKE '%$tec_division%'";		
			// for status condition 			
			if($active_status != 2) $condition  .=" and t.status = $active_status ";
			
			// for helth card condition
			if($is_hcrd_issued == 2){}
			else if($is_hcrd_issued == 1){
				$condition  .=" AND ifnull(t.health_card_no,'') != '' ";	
			}
			else{
				$condition  .=" AND ifnull(t.health_card_no,'') = '' ";
			}	
		}
		// textfield search for grid
		else{
			$condition .=	"  t.status=1 AND CONCAT(t.name, t.subject, t.address, t.username) LIKE '%$search_txt%' ";			
		}
		
		$countsql = "select count(t.id) 
					from teacher  t 
					left join school s on s.id = t.school_id 					
					WHERE $condition ";
		
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$data['entry_status'] = $entry_permission; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		if($employee_grid_permission==1 || $permission_grid_permission==1){
		$sql = "select t.id,t.name, t.subject, t.address, t.mobile_no,t.image,t.username,t.status, s.name school_name,ifnull(t.health_card_no,'') health_card_no, ifnull(t.designation,'') designation,
				$employee_permission as permission_status, $update_permission as update_status,	$delete_permission as delete_status
				from teacher  t 
				left join school s on s.id = t.school_id 					
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
	
	case "get_teacher_details":
		$emp_details = $dbClass->getResultList("select t.id, t.name,  t.address, t.mobile_no, username,   image,  username, `status`, dob, designation,  email, nid_no , upazilla,  zilla, division, ifnull(health_card_no,'') health_card_no,  s.name as school_name, subject , s.id as school_id 
			from teacher t
			left join school s on s.id=t.school_id
			where t.id = '$teacher_id'");
		foreach ($emp_details as $row){
			$data['records'][]= $row;
		}			
		echo json_encode($data);
	break;	
	
	
	case "get_teacher_info":
		$emp_details = $dbClass->getResultList("select t.id, t.name,  t.address, t.mobile_no, username,   image,  username, `status`, dob, designation,  email, nid_no , upazilla,  zilla, division, ifnull(health_card_no,'') health_card_no,  s.name as school_name, subject , s.id as school_id 
			from teacher t
			left join school s on s.id=t.school_id
			where t.id = '$teacher_id'");
		foreach ($emp_details as $row){
			$data['records'] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "delete_teacher":
		$delete_permission = $dbClass->getUserGroupPermission(13);
		if($delete_permission==1){
			$condition_array = array(
				'id'=>$teacher_id
			);
			$columns_value = array(
				'status'=>0
			);
			$return = $dbClass->update("teacher", $columns_value, $condition_array);
		}
		if($return==1) echo "1";
		else 		   echo "0";
	break;	
	
	case "view_school":
		$details = $dbClass->getResultList("select id, name from school");
		foreach ($details as $row) {
			$data['records'][] = $row;
		}			 
		echo json_encode($data);
	break;
	
	case "update_information":
		$password = $dbClass->getSingleRow("select password from teacher where id=$loggedUser");
		if(isset($new_password) && $new_password != ""){
			//echo $password['password'].'--'.md5($old_password);die;
			if($password['password'] == md5($old_password)){
				$columns_value = array(
					'password'=>md5($new_password)
				);
				$condition_array = array(
					'id'=>$loggedUser
				);
				$return_pass = $dbClass->update("teacher", $columns_value, $condition_array);
				if($return_pass==1) echo "1";
			}
			else echo "0";
		}
	break;
	
	case "getSchools":
		$sql_query = "SELECT id,code, name FROM school WHERE concat(code,name) LIKE '%" . $term . "%' ORDER BY name";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["name"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Title Found');
		}			
		echo json_encode($json);			
	break;
	
	
	
}
?>