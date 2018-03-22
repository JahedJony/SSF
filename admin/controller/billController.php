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

switch($q){
	case "insert_or_update":
		//var_dump($_REQUEST);die;	
		if(isset($master_id) && $master_id == ""){
			//var_dump($_REQUEST);die;
			if(isset($_FILES['bill_image_upload']) && $_FILES['bill_image_upload']['name']!= ""){
				$desired_dir = "../images/bill";
				chmod( "../images/bill", 0777);
				$file_name = $_FILES['bill_image_upload']['name'];
				$file_size =$_FILES['bill_image_upload']['size'];
				$file_tmp =$_FILES['bill_image_upload']['tmp_name'];
				$file_type=$_FILES['bill_image_upload']['type'];	
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
					$photo  = "images/bill/".$photo;					
				}
				else{
					echo $img_error_ln;die;
				}			
			}
			else{
				$photo  = "";	
			}	
			$columns_value = array(
				'health_card_no'=>$bill_health_card_no,
				'billed_by'=>$loggedUser,
				'billed_by_type'=>$user_type,
				'bill_date'=>$bill_date,
				'total_amount'=>$total_amount,
				'discount_amount'=>$discount_amount,
				'bill_image'=>$photo
			);	
			$return = $dbClass->insert("bill_info", $columns_value);
			
			if($return) echo "1";
			else 	    echo "0";
		}
		else if(isset($master_id) && $master_id>0){
			//var_dump($_REQUEST);die;
			if(isset($_FILES['bill_image_upload']) && $_FILES['bill_image_upload']['name']!= ""){
				$desired_dir = "../images/bill";
				chmod( "../images/bill", 0777);
				$file_name = $_FILES['bill_image_upload']['name'];
				$file_size =$_FILES['bill_image_upload']['size'];
				$file_tmp =$_FILES['bill_image_upload']['tmp_name'];
				$file_type=$_FILES['bill_image_upload']['type'];	
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
					$photo  = "images/bill/".$photo;	
				}
				else{
					echo $img_error_ln;die;
				}
			}else{
				$photo ="";
			}
			$prev_attachment = $dbClass->getSingleRow("select bill_image from bill_info where id=$master_id");
			if($photo != ""){	
				if($prev_attachment['bill_image'] != "" ){
					unlink("../".$prev_attachment['bill_image']);
				}
				$columns_value = array(
					'bill_image' => $photo
				);	 
				$condition_array = array(
					'id'=>$master_id
				);
				$return = $dbClass->update("bill_info",$columns_value, $condition_array);				
			}
			$columns_value = array(
				//'health_card_no'=>$patient_id,
				'billed_by'=>$loggedUser,
				'billed_by_type'=>$user_type,
				'bill_date'=>$bill_date,
				'total_amount'=>$total_amount,
				'discount_amount'=>$discount_amount
			);
			$condition_array = array(
				'id'=>$master_id
			);
			$return_details = $dbClass->update("bill_info",$columns_value, $condition_array); 
			if($return_details) echo '2';
			else                echo '0';
		}
	break;
	
	case "grid_data":	
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		
		$condition = "";
		//# advance search for grid		
		if($search_txt == "Print" || $search_txt == "Advance_search"){
			$condition .=" bill_date between '$start_date' and '$end_date' ";		
			// for status condition 			
			if($ad_type == 2 && $selected_doc_diag_value != 0){
				$condition .= " and billed_by_type = $ad_type and billed_by = $selected_doc_diag_value "; 
			}
			else if($ad_type == 3 && $selected_doc_diag_value != 0){
				$condition .= " and billed_by_type = $ad_type and billed_by = $selected_doc_diag_value "; 
			}
			else if($ad_type == 2 && $selected_doc_diag_value == 0){
				$condition .= " and billed_by_type = $ad_type "; 
			}
			else if($ad_type == 3 && $selected_doc_diag_value == 0){
				$condition .= " and billed_by_type = $ad_type "; 
			}
			else{}	
		}
		// textfield search for grid
		else{
			$condition .=	" CONCAT(bill_date, health_card_no, total_amount,discount_amount,billed_by_type_name) LIKE '%$search_txt%' ";			
		}
		
		//user type wise condition
		if($user_type == 1){ 
			$update_delete_condition = "  0 update_status, 0 delete_status";
		}
		else if($user_type == 2 || $user_type == 3){ 
			$update_delete_condition = " 1  update_status,	1  delete_status";
			if($user_type == 2) $condition .= " and billed_by=$loggedUser and billed_by_type=2 ";
			else if($user_type == 3) $condition .= " and billed_by=$loggedUser and billed_by_type=3 ";
		}
		
		$countsql = "SELECT count(id)
					FROM (
						SELECT id, health_card_no, bill_date,  total_amount, discount_amount, bill_image,  billed_by_type,  
						CASE WHEN billed_by_type=2 THEN doc_name WHEN billed_by_type=3   THEN diag_name END billed_by_name,billed_by,
						CASE WHEN billed_by_type=2 THEN 'Doctor' WHEN billed_by_type=3   THEN 'Diagnostic' END billed_by_type_name,
						CASE 
							WHEN user_type=1 THEN (select full_name from user_infos where emp_id= used_by_id)  
							WHEN user_type=4 THEN (select name 		 from teacher 	  where id= used_by_id) 
							WHEN user_type=5 THEN (select name 		 from student 	  where id= used_by_id) 
							WHEN user_type=6 THEN (select name 		 from vip 	  	  where id= used_by_id) 
							WHEN user_type=7 THEN (select name 		 from female 	  where id= used_by_id) 
						END billed_for
						FROM(
							SELECT b.id, b.bill_date, b.health_card_no, b.billed_by, b.billed_by_type,
							b.total_amount, b.discount_amount, b.bill_image, hc.used_by_id,hc.user_type, 
							d.id doc_id, d.name doc_name, dg.id diag_id, dg.name diag_name
							FROM bill_info b
							LEFT JOIN doctor d ON d.id=b.billed_by AND b.billed_by_type=2
							LEFT JOIN diagnostic dg ON dg.id=b.billed_by AND b.billed_by_type=3
							left join helth_card hc on hc.card_no = b.health_card_no
						)A
					)B	WHERE $condition";
		
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
			
		$sql = "SELECT id, health_card_no, bill_date, total_amount, discount_amount, bill_image, $update_delete_condition,
				billed_by_name,	billed_by_type, billed_by, billed_by_type_name, billed_for, billed_for_type_name
					FROM (
						SELECT id, health_card_no, bill_date,  total_amount, discount_amount, bill_image,  billed_by_type,  
						CASE WHEN billed_by_type=2 THEN doc_name WHEN billed_by_type=3   THEN diag_name END billed_by_name,billed_by,
						CASE WHEN billed_by_type=2 THEN 'Doctor' WHEN billed_by_type=3   THEN 'Diagnostic' END billed_by_type_name,
						CASE WHEN user_type=1 THEN 'Employee' WHEN user_type=4   THEN 'Teacher' WHEN user_type=5 THEN 'Student' WHEN user_type=6 THEN 'VIP' WHEN user_type=7 THEN 'Female' END billed_for_type_name,
						CASE 
							WHEN user_type=1 THEN (select full_name from user_infos where emp_id= used_by_id)  
							WHEN user_type=4 THEN (select name 		 from teacher 	  where id= used_by_id) 
							WHEN user_type=5 THEN (select name 		 from student 	  where id= used_by_id) 
							WHEN user_type=6 THEN (select name 		 from vip 	  	  where id= used_by_id) 
							WHEN user_type=7 THEN (select name 		 from female 	  where id= used_by_id) 
						END billed_for
						FROM(
							SELECT b.id, b.bill_date, b.health_card_no, b.billed_by, b.billed_by_type,
							b.total_amount, b.discount_amount, b.bill_image, hc.used_by_id,hc.user_type, 
							d.id doc_id, d.name doc_name, dg.id diag_id, dg.name diag_name
							FROM bill_info b
							LEFT JOIN doctor d ON d.id=b.billed_by AND b.billed_by_type=2
							LEFT JOIN diagnostic dg ON dg.id=b.billed_by AND b.billed_by_type=3
							left join helth_card hc on hc.card_no = b.health_card_no
						)A
					)B
				WHERE $condition
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
	
	case "get_bill_details":		
		$bill_details = $dbClass->getSingleRow("select b.id,bill_date, health_card_no,total_amount,discount_amount,bill_image	from bill_info b where b.id=$bill_id");

		$data['bill_info'] = $bill_details;
		$patient_details = $dbClass->getPatientDetails($bill_details['health_card_no']);
		foreach ($patient_details as $patient_row){
			$data['patient_info'] = $patient_row;
		}
	
		echo json_encode($data);
	break;
	
	case "delete_bill":
		$bill_details = $dbClass->getSingleRow("select  bill_image from bill_info where id=$bill_id");
		if($bill_details['bill_image'] != "" ){
			unlink("../".$bill_details['bill_image']);
		}	
		$delete_permission = $dbClass->getUserGroupPermission(13);
		if($delete_permission==1){
			$condition_array = array(
				'id'=>$bill_id
			);
			$return = $dbClass->delete("bill_info", $condition_array);
			if($return==1) echo "1";
		}
		else 		 	  echo "0";
	break;	
	
	case "get_patient_details":
		$data = array();
		
		$patient_details = $dbClass->getPatientDetails($health_card_no);
	
		
		if(empty($patient_details)){
			echo '1';
		}
		else{
			foreach ($patient_details as $row){
				$data['records'][] = $row;
			}			
			echo json_encode($data);
		}
	break;
}
?>