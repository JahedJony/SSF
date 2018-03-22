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
	
	case "insert_or_update":	
		if(isset($master_id) && $master_id == ""){
			//var_dump($_REQUEST);die;			
			if(isset($_FILES['female_image_upload']) && $_FILES['female_image_upload']['name']!= ""){
				$desired_dir = "../images/female";
				chmod( "../images/female", 0777);
				$file_name = $_FILES['female_image_upload']['name'];
				$file_size =$_FILES['female_image_upload']['size'];
				$file_tmp =$_FILES['female_image_upload']['tmp_name'];
				$file_type=$_FILES['female_image_upload']['type'];	
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
					$photo  = "images/female/".$photo;					
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
				'name'=>$female_name,
				'father_or_husband_name'=>$father_or_husband_name,
				'mother_name'=>$mother_name,
				'username'=>$user_name,
				'mobile_no'=>$mobile_no,
				'password'=>md5($password),
				'status'=>$is_active,
				'address'=>$address,
				'image'=>$photo,
				'school_id'=>$school_id,
				'dob'=>$dob,
				'email'=>$email,
				'nid_no'=>$nid_no,
				'village'=>$village,
				'post'=>$post,
				'upazilla'=>$upazilla,
				'district'=>$district,
				'health_card_no'=>$health_card_no				
			);	
			$return = $dbClass->insert("female", $columns_value);
			
			if($return){
				if($health_card_no != ""){
					$columns_value = array(
						'is_used'=>1,
						'user_type'=>7,
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
			if(isset($_FILES['female_image_upload']) && $_FILES['female_image_upload']['name']!= ""){
				$desired_dir = "../images/female";
				chmod( "../images/female", 0777);
				$file_name = $_FILES['female_image_upload']['name'];
				$file_size =$_FILES['female_image_upload']['size'];
				$file_tmp =$_FILES['female_image_upload']['tmp_name'];
				$file_type=$_FILES['female_image_upload']['type'];	
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
					$photo  = "images/female/".$photo;	
				}
				else{
					echo $img_error_ln;die;
				}
			}else{
				$photo ="";
			}
			$prev_attachment = $dbClass->getSingleRow("select image from female where id=$master_id");
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
				$return = $dbClass->update("female",$columns_value, $condition_array);				
			}
			$is_active=0;
			if(isset($_POST['is_active'])){
				$is_active=1;
			}
			
			$school_id = $dbClass->get_updated_school_id($school_id, $school_list);
			
			if(isset($_POST['password']) && $photo == ""){
				$columns_value = array(
					'name'=>$female_name,
					'father_or_husband_name'=>$father_or_husband_name,
					'mother_name'=>$mother_name,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'password'=>md5($password),
					'status'=>$is_active,
					'school_id'=>$school_id,
					'address'=>$address,
					'dob'=>$dob,
					'email'=>$email,
					'nid_no'=>$nid_no,
					'village'=>$village,
					'post'=>$post,
					'upazilla'=>$upazilla,
					'district'=>$district,
					'health_card_no'=>$health_card_no
				);
			}else{
				$columns_value = array(
					'name'=>$female_name,
					'father_or_husband_name'=>$father_or_husband_name,
					'mother_name'=>$mother_name,
					'username'=>$user_name,
					'mobile_no'=>$mobile_no,
					'status'=>$is_active,
					'school_id'=>$school_id,
					'address'=>$address,
					'image'=>$photo,
					'dob'=>$dob,
					'email'=>$email,
					'nid_no'=>$nid_no,
					'village'=>$village,
					'post'=>$post,
					'upazilla'=>$upazilla,
					'district'=>$district,
					'health_card_no'=>$health_card_no					
				);
			}
			$condition_array = array(
				'id'=>$master_id
			);
			$return_details = $dbClass->update("female",$columns_value, $condition_array); 
			if($return_details){
				if($health_card_no != ""){
					$columns_value = array(
						'is_used'=>1,
						'user_type'=>7,
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
			$condition .=" 	s.name LIKE '%$school_name%' AND f.post LIKE '%$post%' AND f.upazilla LIKE '%$upazilla%' 
							AND f.district LIKE '%$district%' AND f.village LIKE '%$village%' AND f.address LIKE '%$address%' ";		
			// for status condition 			
			if($active_status != 2) $condition  .=" and f.status = $active_status ";
			
			// for helth card condition
			if($health_card_status == 2){}
			else if($health_card_status == 1){
				$condition  .=" AND ifnull(f.health_card_no,'') != '' ";	
			}
			else{
				$condition  .=" AND ifnull(f.health_card_no,'') = '' ";
			}	
		}
		// textfield search for grid
		else{
			$condition .=	" f.status=1 AND CONCAT(f.name, f.village, f.address, f.post, f.district, f.upazilla, s.name, f.health_card_no) LIKE '%$search_txt%' ";			
		}
		
		$countsql = "select count(f.id) 
					FROM female f 
					left join school s on s.id = f.school_id 
					WHERE $condition";
		
		
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$data['entry_status'] = $entry_permission; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		if($employee_grid_permission==1 || $permission_grid_permission==1){
			$sql = "SELECT f.id, f.name, f.father_or_husband_name, f.mother_name, f.image, f.mobile_no, f.username, 
					f.status, s.name school_name, f.dob, f.district, f.upazilla, f.village, f.post, f.address,
					IFNULL(f.health_card_no,'') health_card_no, f.nid_no, f.email,
					$employee_permission as permission_status, $update_permission as update_status,	$delete_permission as delete_status
					from female f 
					left join school s on s.id = f.school_id 
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
	
	case "get_female_details":
		$emp_details = $dbClass->getResultList("SELECT f.id, f.name, f.father_or_husband_name, f.mother_name, f.image, f.mobile_no, f.username, 
					f.status,s.id school_id, s.name school_name, f.dob, f.district, f.upazilla, f.village, f.post, f.address,
					IFNULL(f.health_card_no,'') health_card_no, f.nid_no, f.email
					from female f 
					left join school s on s.id = f.school_id 
					where f.id = '$female_id'");
		foreach ($emp_details as $row){
			$data['records'][]= $row;
		}			
		echo json_encode($data);
	break;	
	
	case "get_female_info":
		$emp_details = $dbClass->getResultList("SELECT f.id, f.name, f.father_or_husband_name, f.mother_name, f.image, f.mobile_no, f.username, 
					f.status,s.id school_id, s.name school_name, f.dob, f.district, f.upazilla, f.village, f.post, f.address,
					IFNULL(f.health_card_no,'') health_card_no, f.nid_no, f.email
					from female f 
					left join school s on s.id = f.school_id 
					where f.id = '$female_id'");
		foreach ($emp_details as $row){
			$data['records']= $row;
		}			
		echo json_encode($data);
	break;	
	
	case "delete_female":
		$delete_permission = $dbClass->getUserGroupPermission(13);
		if($delete_permission==1){
			$condition_array = array(
				'id'=>$female_id
			);
			$columns_value = array(
				'status'=>0
			);
			$return = $dbClass->update("female", $columns_value, $condition_array);
		}
		if($return==1) echo "1";
		else 		   echo "0";
	break;	
	
	
	/*-------------------female service-------------------------------*/
	case "femaleService_grid_data":	
		//var_dump($_REQUEST);die;
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		
		$condition = "";
		$update_delete_condition = "";
		//# advance search for grid		
		if($search_txt == "Print" || $search_txt == "Advance_search"){
			if($ad_service_center_id != 0)	$condition .=" m.service_center_id = '$ad_service_center_id' and ";
			if($ad_health_card == ''){
				$condition .=" m.service_date between '$start_date' and '$end_date' ";
			}else{
				$condition .=" m.health_card_no = '$ad_health_card' and m.service_date between '$start_date' and '$end_date' ";			
			}	
		}
		// textfield search for grid
		else{
			$condition .=	" CONCAT(m.service_date, m.health_card_no) LIKE '%$search_txt%' ";			
		}
		//echo $condition; die;
		//user type wise condition
		if($user_type == 1){ 
			$update_delete_condition = " , 1 update_status, 1 delete_status";
		}
		
		$countsql = "SELECT count(m.id)
					from female_services_mst m
					left join school s on s.id = m.service_center_id WHERE $condition";
		
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
			
		$sql = "select m.id, m.service_date, m.health_card_no, m.service_center_id, f.name female_name, f.mobile_no, f.address, f.dob, s.name service_center_name  , 1 update_status, 1 delete_status 
				,group_concat(l.service_name ,'```', d.result, '```',d.description,'```',d.service_id) service_details
				from female_services_mst m
				left join female_services_dtls d on d.master_id = m.id
				left join female_services_list l on l.id = d.service_id
				left join school s on s.id = m.service_center_id
				left join female f on f.health_card_no = m.health_card_no
				WHERE $condition
				group by m.health_card_no,m.service_date
				ORDER BY id ASC limit $start, $end";
		//echo $sql; die;		
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data); 
	break;	
	
	case "female_details_info":	
		$health_card_details = $dbClass->getSingleRow("select distinct(health_card_no) health_card_no from female where health_card_no = $health_card_no");
		if($health_card_details['health_card_no'] != "" ){
			$female_details = $dbClass->getResultList("select f.id, f.name, f.dob as age, f.address, f.mobile_no,f.image, 
											f.username, f.nid_no as identy_no, f.health_card_no,f.`status`	from female f
											where health_card_no = '$health_card_no' and status=1");
			foreach ($female_details as $row){
				$data['records'][] = $row;
			}
		}
		else{
			$data['records'] = "null";	
		}	
		echo json_encode($data);
	break;
	
	case "get_femaleServices_details":
		$health_card_details = $dbClass->getSingleRow("select health_card_no from female_services_mst where id = $femaleServices_id");
		
		$health_card_no = $health_card_details['health_card_no']; 
		$female_details = $dbClass->getSingleRow("select f.id, f.name, f.dob as age, f.address, f.mobile_no,f.image, 
											f.username, f.nid_no as identy_no, f.health_card_no,f.`status`	from female f
											where health_card_no = '$health_card_no' and status=1");
		
		$data['female_info'] = $female_details;		
		$femaleServices_details = $dbClass->getResultList("select m.id, m.service_date, m.health_card_no, m.service_center_id, s.name service_center_name,
									group_concat(l.service_name ,'```', d.result, '```',d.description,'```',d.service_id)  service_details
									from female_services_mst m
									left join female_services_dtls d on d.master_id = m.id
									left join school s on s.id = m.service_center_id
									left join female_services_list l on l.id = d.service_id
									where m.id= '$femaleServices_id'
									group by m.health_card_no,m.service_date ");
									
		foreach ($femaleServices_details as $row){
				$data['service_info'] = $row;
			}
		echo json_encode($data);
	break;
	
	case "insert_or_update_female_service":	
		if(isset($master_id) && $master_id == ""){
			//var_dump($_REQUEST);die;
			$columns_value = array(
				'service_date'=>$service_date,
				'health_card_no'=>$female_health_card_no,
				'service_center_id'=>$service_center_id				
			);	
			$return_mst = $dbClass->insert("female_services_mst", $columns_value);			
			if($return_mst){
				foreach($service_id as $key => $value){
					$columns_value = array(
						'master_id'=>$return_mst,
						'service_id'=>$service_id[$key],
						'result'=>$service_results[$key],
						'description'=>$service_details[$key]
					);
					$return_details = $dbClass->insert("female_services_dtls", $columns_value);
				}	
				if($return_details) echo "1";
				else 				echo '0';
			} 
			else echo "0"; 
		}
		else if(isset($master_id) && $master_id>0){
			//var_dump($_REQUEST);die;
			$columns_value = array(
				'service_date'=>$service_date,
				'health_card_no'=>$female_health_card_no,
				'service_center_id'=>$service_center_id				
			);	
			$condition_array = array(
				'id'=>$master_id
			);
			$return_update_mst = $dbClass->update("female_services_mst", $columns_value, $condition_array); 		
			if($return_update_mst){
				foreach($service_id as $key => $value){
					$columns_value = array(
						'result'=>$service_results[$key],
						'description'=>$service_details[$key]
					);
					$condition_array = array(
						'master_id'=>$master_id,
						'service_id'=>$service_id[$key]
					);
					$return_update_details = $dbClass->update("female_services_dtls", $columns_value, $condition_array);
				}
				if($return_update_details)	echo '2';
			}
			else                            echo '3';
		}
	break;
}
?>