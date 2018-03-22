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
		if(isset($healthcard_id) && $healthcard_id == ""){
			$is_active = 0;
			if(isset($_POST['is_active'])){
				$is_active = 1;
			}
			$columns_value = array(
				'card_no'=>$healthcard_no,
				'status'=>$is_active
			);
			$return = $dbClass->insert("helth_card", $columns_value);
			if($return) echo "1";
			else        echo "0";
		}
		else if(isset($healthcard_id) && $healthcard_id>0){
			$is_active = 0;
			if(isset($_POST['is_active'])){
				$is_active = 1;
			}
			$columns_value = array(
				'card_no'=>$healthcard_no,
				'status'=>$is_active
			);
			$condition_array = array(
				'id'=>$healthcard_id
			);
			$return = $dbClass->update("helth_card",$columns_value, $condition_array);
			if($return) echo "2";
			else        echo "0";			 
		}
	break;
	
	case "grid_data":
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();		
		if($search_txt == "Print" || $search_txt == "Advance_search"){			
			$condition ="";			
			
			if($health_card_status == "All"){
				$condition  .=" is_used is not null ";
			}
			else if($health_card_status == "Available"){
				$condition  .=" is_used = 0 ";	
			}
			else{
				$condition  .=" is_used = 1 ";
			}
			
			if($active_status == "All"){
				$condition  .=" and status is not null ";
			}
			else if($active_status == "Active"){
				$condition  .=" and status = 1 ";	
			}
			else{
				$condition  .=" and status = 0 ";
			}
		}
		else{
			$condition = "CONCAT(id, card_no, availability, ifnull(assigned_to,'')) LIKE '%$search_txt%'";
		}	
					
		$countsql = "SELECT count(id)
					FROM(
						SELECT h.id, h.card_no, h.`status`, h.is_used,
						CASE h.status WHEN 1 THEN 'Active' WHEN 0 THEN 'Inactive' END active_status,
						CASE h.is_used WHEN 1 THEN 'NO' WHEN 0 THEN 'Yes' END availability,
						CASE 
							WHEN user_type=1 THEN (select full_name from user_infos where emp_id= used_by_id)  
							WHEN user_type=4 THEN (select name 		 from teacher 	  where id= used_by_id) 
							WHEN user_type=5 THEN (select name 		 from student 	  where id= used_by_id) 
							WHEN user_type=6 THEN (select name 		 from vip 	  	  where id= used_by_id) 
							WHEN user_type=7 THEN (select name 		 from female 	  where id= used_by_id)
						END assigned_to
						FROM helth_card h 
					)A
					WHERE $condition";
		//echo $countsql;die;
		
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records;  
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		
		$sql = "SELECT id, card_no, status, availability, ifnull(assigned_to,'') assigned_to, active_status
			FROM(
				SELECT h.id, h.card_no, h.`status`, h.is_used, 
				CASE h.status WHEN 1 THEN 'Active' WHEN 0 THEN 'Inactive' END active_status,
				CASE h.is_used WHEN 1 THEN 'Used' WHEN 0 THEN 'Available' END availability,
				CASE 
					WHEN user_type=1 THEN (select full_name from user_infos where emp_id= used_by_id)  
					WHEN user_type=4 THEN (select name 		 from teacher 	  where id= used_by_id) 
					WHEN user_type=5 THEN (select name 		 from student 	  where id= used_by_id) 
					WHEN user_type=6 THEN (select name 		 from vip 	  	  where id= used_by_id) 
					WHEN user_type=7 THEN (select name 		 from female 	  where id= used_by_id)
				END assigned_to
				FROM helth_card h 
			)A
			WHERE $condition
			ORDER BY id ASC LIMIT $start, $end";
					
		//echo $sql; die;		
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		
		$last_healthcard_no = $dbClass->getSingleRow("select max(card_no) card_no from helth_card");	
		if(empty($last_healthcard_no)) $last_healthcard_no['card_no'] = "0000000001"; 
		$set_healthcard_no = $last_healthcard_no['card_no'] + 1;	
		$data['set_healthcard_no'] = $set_healthcard_no;
		
		echo json_encode($data);	
	break;
	
	case "get_healthcard_details":
		$sql = "select * from helth_card where id=$healthcard_id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);	
	break;

}
?>