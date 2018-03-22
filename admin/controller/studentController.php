<?php 
session_start();
include '../includes/static_text.php';
include("../dbConnect.php");
include("../dbClass.php");

$dbClass = new dbClass;
$conn       = $dbClass->getDbConn();
$loggedUser = $dbClass->getUserId();	
$user_type = $_SESSION['user_type'];

extract($_REQUEST);

switch ($q){
	//insert or update teacher id need to update dynamically
	case "insert_or_update":	
		if(isset($master_id) && $master_id == ""){
			if($user_type != 4 &&  $user_type != 1){ echo 3; die;}
			//var_dump($_REQUEST);die;
			
			if(isset($_FILES['student_image_upload']) && $_FILES['student_image_upload']['name']!= ""){
				$desired_dir = "../images/student";
				chmod( "../images/student", 0777);
				$file_name = $_FILES['student_image_upload']['name'];
				$file_size =$_FILES['student_image_upload']['size'];
				$file_tmp =$_FILES['student_image_upload']['tmp_name'];
				$file_type=$_FILES['student_image_upload']['type'];	
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
					$photo  = "images/student/".$photo;					
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
			$teacher_id = "";
			if($user_type == 4){
				$teacher_id = $_SESSION['user_id'];
			}
			
			$school_id = $dbClass->get_inserted_school_id($school_id, $school_list);

			//echo $school_id; die;
			$columns_value = array(
				'name'=>$student_name,
				'school_id'=>$school_id,
				'teacher_id'=>$teacher_id,
				'age'=>$age,
				'class'=>$class_name,
				'address'=>$address,
				'username'=>$user_name,
				'mobile_no'=>$mobile_no,
				'password'=>md5($password),
				'status'=>$is_active,
				'image'=>$photo,
				'health_card_no'=>$health_card_no,
				'class_roll_no'=>$class_roll_no,
				'zilla'=>$zilla,
				'upazilla'=>$upazilla,
				'division'=>$division,
				'identy_no'=>$identy_no
			);
			//var_dump($columns_value);die;	
			$return = $dbClass->insert("student", $columns_value);
			
			if($return){
				if($health_card_no != ""){
					$columns_value = array(
						'is_used'=>1,
						'user_type'=>5,
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
			if(isset($_FILES['student_image_upload']) && $_FILES['student_image_upload']['name']!= ""){
				$desired_dir = "../images/student";
				chmod( "../images/student", 0777);
				$file_name = $_FILES['student_image_upload']['name'];
				$file_size =$_FILES['student_image_upload']['size'];
				$file_tmp =$_FILES['student_image_upload']['tmp_name'];
				$file_type=$_FILES['student_image_upload']['type'];	
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
					$photo  = "images/student/".$photo;	
				}
				else{
					echo $img_error_ln;die;
				}
			}else{
				$photo ="";
			}
			$prev_attachment = $dbClass->getSingleRow("select image from student where id=$master_id");
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
				$return = $dbClass->update("student",$columns_value, $condition_array);				
			}
			$is_active=0;
			if(isset($_POST['is_active'])){
				$is_active=1;
			}
			$teacher_id = "";
			if($user_type == 4){
				$teacher_id = $_SESSION['user_id'];
			}
			
			$school_id = $dbClass->get_updated_school_id($school_id, $school_list);
			
			if(isset($_POST['password']) && $photo = ""){
				$columns_value = array(
					'name'=>$student_name,
					'school_id'=>$school_id,
					'teacher_id'=>$teacher_id,
					'age'=>$age,
					'class'=>$class_name,
					'address'=>$address,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'password'=>md5($password),
					'status'=>$is_active,
					'health_card_no'=>$health_card_no,
					'class_roll_no'=>$class_roll_no,
					'zilla'=>$zilla,
					'upazilla'=>$upazilla,
					'division'=>$division,
					'identy_no'=>$identy_no
				);
			}else{
				$columns_value = array(
					'name'=>$student_name,
					'school_id'=>$school_id,
					'teacher_id'=>$teacher_id,
					'age'=>$age,
					'class'=>$class_name,
					'address'=>$address,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'status'=>$is_active,
					'health_card_no'=>$health_card_no,
					'class_roll_no'=>$class_roll_no,
					'zilla'=>$zilla,
					'upazilla'=>$upazilla,
					'division'=>$division,
					'identy_no'=>$identy_no
				);
			}
			$condition_array = array(
				'id'=>$master_id
			);
			
			//var_dump($columns_value);die;
			$return_details = $dbClass->update("student",$columns_value, $condition_array); 
			if($return_details){
				if($health_card_no != ""){
					$columns_value = array(
						'is_used'=>1,
						'user_type'=>5,
						'used_by_id'=>$master_id
					);
					$condition_array = array(
						'card_no'=>$health_card_no
					);
				//	var_dump($columns_value);
					$return_details = $dbClass->update("helth_card",$columns_value, $condition_array);	
				} 				
				echo '2';
			}
			else                echo '0';
		}
	break;
	
	case "grid_data":	
		//var_dump($_REQUEST);die;
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
	
		$condition = "";	

		//# advance search for grid		
		if($search_txt == "Print" || $search_txt == "Advance_search"){
			$condition .=	" s.name LIKE '%$std_name%' AND sch.name LIKE '%$sch_name%' AND s.class LIKE '%$std_class%'  AND s.address LIKE '%$std_address%'  AND s.upazilla LIKE '%$std_upazilla%' AND s.zilla LIKE '%$std_zilla%'  AND s.division LIKE '%$std_division%'";	
			
			// for status condition 			
			if($std_active_status != 2) $condition  .=" and s.status = $std_active_status ";
			
			// for helth card condition
			if($is_hcrd_issued == "All"){}
			else if($is_hcrd_issued == "Yes"){
				$condition  .=" AND health_card_no != '' ";	
			}
			else{
				$condition  .=" AND health_card_no = '' ";
			}
	
			if($tch_id != ""){
				$condition  .=" AND teacher_id = $tch_id ";
			}
			
		}
		// textfield search for grid
		else{
			$condition .=	"  s.status=1 AND CONCAT(s.name, s.address, s.username,s.identy_no) LIKE '%$search_txt%'";			
		}
		
		/*
		# admin 1 , teacher 4
		# admin all student
		# teacher only his enried student
		*/
		if($user_type == 4){
			 $condition .= " and teacher_id=$loggedUser";
		}

		
		$countsql = "select count(s.id)
				from student s
				left join school sch on sch.id = s.school_id 
				where $condition ";
		
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		
		
		$sql = "select s.id, s.name, s.school_id, s.age, s.class, s.address, s.mobile_no, s.image, health_card_no, identy_no, ifnull(class_roll_no,'') class_roll_no,	s.username, ifnull(s.identy_no,'') identy_no, ifnull(s.health_card_no,'') health_card_no, s.`status`, sch.name school_name, 
					case   when health_card_no is null then 1 else 0 end   update_status,
					case   when health_card_no is null then 1 else 0 end   delete_status
					from student s
					left join school sch on sch.id = s.school_id  
					where $condition";
		//echo $sql; 
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
			 
	break;
	
	case "get_student_details":
			$emp_details = $dbClass->getResultList("select s.id, s.name,  s.address, s.mobile_no, username,  image, age,sc.id as school_id, 
								  	ifnull(health_card_no,'') health_card_no,  identy_no, class_roll_no,  username, `status`,
								  	password ,	sc.name as school_name, s.class, ifnull(s.identy_no,'') identy_no , upazilla,  zilla, division 
									from student s
									left join school sc on sc.id=s.school_id
									where s.`id` = '$student_id'");
			foreach ($emp_details as $row){
				$data['records'][] = $row;
			}			
			echo json_encode($data);
	break;
	
	
	case "get_student_info":
			$emp_details = $dbClass->getResultList("select s.id, s.name,  s.address, s.mobile_no, username,  image, age,sc.id as school_id, 
								  	ifnull(health_card_no,'') health_card_no,  identy_no, class_roll_no,  username, `status`,
								  	password ,	sc.name as school_name, s.class, ifnull(s.identy_no,'') identy_no , upazilla,  zilla, division 
									from student s
									left join school sc on sc.id=s.school_id
									where s.`id` = '$student_id'");
			foreach ($emp_details as $row){
				$data['records'] = $row;
			}			
			echo json_encode($data);
	break;
	
	
	
	case "delete_student":
		$delete_permission = $dbClass->getUserGroupPermission(13);
		if($delete_permission==1){
			$condition_array = array(
				'id'=>$student_id
			);
			$columns_value = array(
				'status'=>0
			);
			$return = $dbClass->update("student", $columns_value, $condition_array);
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
		$password = $dbClass->getSingleRow("select password from student where id=$loggedUser");
		if(isset($new_password) && $new_password != ""){
			//echo $password['password'].'--'.md5($old_password);die;
			if($password['password'] == md5($old_password)){
				$columns_value = array(
					'password'=>md5($new_password)
				);
				$condition_array = array(
					'id'=>$loggedUser
				);
				$return_pass = $dbClass->update("student", $columns_value, $condition_array);
				if($return_pass==1) echo "1";
			}
			else echo "0";
		}
	break;
	
	
}
?>