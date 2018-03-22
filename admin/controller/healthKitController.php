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
	
	/*-------------------female service-------------------------------*/
	case "healthKitService_grid_data":	
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
		
		//echo $countsql; die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);

		$sql = "select m.id, m.service_date, m.health_card_no, m.service_center_id, s.name service_center_name,
				group_concat(l.service_name ,'```', d.result, '```',d.description,'```',d.service_id) service_details,
				CASE 
					WHEN f.name !='' THEN (f.name)  
					WHEN u.full_name !='' THEN (u.full_name)
					WHEN v.name !='' THEN (v.name)	
					WHEN t.name !='' THEN (t.name)
					WHEN st.name !='' THEN (st.name)
				END patient_name,
				CASE 
					WHEN f.mobile_no !='' THEN (f.mobile_no)  
					WHEN u.contact_no !='' THEN (u.contact_no)
					WHEN v.mobile_no !='' THEN (v.mobile_no)	
					WHEN t.mobile_no !='' THEN (t.mobile_no)
					WHEN st.mobile_no !='' THEN (st.mobile_no)  
				END mobile_no,
				CASE 
					WHEN f.address !='' THEN (f.address)
					WHEN u.address !='' THEN (u.address)
					WHEN v.address !='' THEN (v.address)	
					WHEN t.address !='' THEN (t.address)
					WHEN st.address !='' THEN (st.address)    
				END address,
				CASE 
					WHEN f.dob !='' THEN (f.dob)
					WHEN u.age !='' THEN (u.age)
					WHEN st.age !='' THEN (st.age)	
					WHEN t.dob !='' THEN (t.dob)
					WHEN v.dob !='' THEN (v.dob)    
				END dob
				$update_delete_condition
				from female_services_mst m
				left join female_services_dtls d on d.master_id = m.id
				left join female_services_list l on l.id = d.service_id
				left join school s on s.id = m.service_center_id
				left join female f on f.health_card_no = m.health_card_no
				left join user_infos u on u.health_card_no = m.health_card_no
				left join student st on st.health_card_no = m.health_card_no
				left join teacher t on t.health_card_no = m.health_card_no
				left join vip v on v.health_card_no = m.health_card_no
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
	
	case "healthKit_details_info":	
		$health_card = $dbClass->getSingleRow("select distinct(card_no) health_card_no from helth_card where is_used = '1' and card_no = '$health_card_no'");
		$data = array();
		if(empty($health_card)){
			$data['records'] = "null";
		}else{
			$details = $dbClass->getPatientDetails($health_card_no);
			$data['records'] = $details;
		}
		echo json_encode($data); 
	break;
	
	case "get_healthKitServices_details":
		$health_card_details = $dbClass->getSingleRow("select health_card_no from female_services_mst where id = $healthKitServices_id");
		$health_card_no = $health_card_details['health_card_no']; 
		
		$patient_details = $dbClass->getPatientDetails($health_card_no);
		$data['patient_info'] = $patient_details;	
		
		$healthKit_details = $dbClass->getResultList("select m.id, m.service_date, m.health_card_no, m.service_center_id, s.name service_center_name,
									group_concat(l.service_name ,'```', d.result, '```',d.description,'```',d.service_id)  service_details
									from female_services_mst m
									left join female_services_dtls d on d.master_id = m.id
									left join school s on s.id = m.service_center_id
									left join female_services_list l on l.id = d.service_id
									where m.id= '$healthKitServices_id'
									group by m.health_card_no,m.service_date ");					
		foreach ($healthKit_details as $row){
				$data['service_info'] = $row;
			}
		echo json_encode($data);
	break;
	
	case "insert_or_update_healthKit_service":	
		if(isset($master_id) && $master_id == ""){
			//var_dump($_REQUEST);die;
			$columns_value = array(
				'service_date'=>$service_date,
				'health_card_no'=>$healthKit_health_card_no,
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
				'health_card_no'=>$healthKit_health_card_no,
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
	
	/* health kit entry */
	
	case "insert_or_update_healthKit":
		if(isset($master_id) && $master_id == ""){
			$columns_value = array(
				'service_name'=>$name
			);
			$return = $dbClass->insert("female_services_list", $columns_value);
			if($return) echo "1";
			else        echo "0";
		}
		else if(isset($master_id) && $master_id>0){
			$columns_value = array(
				'service_name'=>$name
			);
			$condition_array = array(
				'id'=>$master_id
			);
			$return = $dbClass->update("female_services_list",$columns_value, $condition_array);
			if($return) echo "2";
			else        echo "0";			 
		}
	break;
	
	case "health_kit_grid_data":
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		if($search_txt == "Print" || $search_txt == "Advance_search"){
			$countsql = "SELECT count(id) FROM female_services_list";
		}
		else{
			$countsql = "SELECT count(id)
						FROM(
							SELECT id, service_name
							FROM female_services_list  
						)A
						WHERE CONCAT(service_name) LIKE '%$search_txt%'";
		}
		
		//echo $countsql;die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records;  
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		if($search_txt == "Print" || $search_txt == "Advance_search"){
			$sql = "SELECT id, service_name
					FROM female_services_list order by id asc limit $start, $end";
				//	echo $sql; die;
		}
		else{
			$sql = 	"SELECT id, service_name
					FROM(
						SELECT id, service_name
						FROM female_services_list 
					)A
					WHERE CONCAT(service_name) LIKE '%$search_txt%'
					ORDER BY id ASC LIMIT $start, $end";
				//echo $sql;
		}		
		//echo $sql; die;		
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);	
	break;
	
	case "get_health_kit_details":
		$sql = "select * from female_services_list where id=$master_id";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
}
?>