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
		
	case "my_service_record":	
		//var_dump($_REQUEST);die;
		$data = array();
		
		$condition = "";
	
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
	
		$condition .= " and used_by_id=$loggedUser and user_type=$user_type ";
		
			
		$sql = "SELECT id, health_card_no, bill_date, total_amount, discount_amount, bill_image,
				billed_by_name,	billed_by_type, billed_by, billed_by_type_name, billed_for, billed_for_type_name, user_type,used_by_id
					FROM (
						SELECT id, health_card_no, bill_date,  total_amount, discount_amount, bill_image,  billed_by_type,  
						CASE WHEN billed_by_type=2 THEN doc_name WHEN billed_by_type=3   THEN diag_name END billed_by_name,billed_by,
						CASE WHEN billed_by_type=2 THEN 'Doctor' WHEN billed_by_type=3   THEN 'Diagnostic' END billed_by_type_name,
						CASE WHEN user_type=1 THEN 'Employee' WHEN user_type=4   THEN 'Teacher' WHEN user_type=5 THEN 'Student' WHEN user_type=6 THEN 'VIP' WHEN user_type=7 THEN 'Female' END billed_for_type_name,
						user_type,used_by_id,
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
				ORDER BY id ASC ";
			//echo $sql; die;		
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
			foreach ($result as $row) {
				$data['records'][] = $row;
			}			
		echo json_encode($data);			 
	break;	
	
	case "bill_vs_payment_record":	
		//var_dump($_REQUEST);die;
		$data = array();
		
		$condition = "";
		
		$condition .=" bill_date between '$start_date' and '$end_date' and payment_date between '$start_date' and '$end_date' ";		
		
		// for search type condition 			
		if($ad_type == 2 && $selected_doc_diag_value != 0){
			$condition .= " and billed_by_type = $ad_type and billed_by = $selected_doc_diag_value"; 
		}
		else if($ad_type == 3 && $selected_doc_diag_value != 0){
			$condition .= " and billed_by_type = $ad_type and billed_by = $selected_doc_diag_value"; 
		}
		else if($ad_type == 2 && $selected_doc_diag_value == 0){
			$condition .= " and billed_by_type = $ad_type  "; 
		}
		else if($ad_type == 3 && $selected_doc_diag_value == 0){
			$condition .= " and billed_by_type = $ad_type "; 
		}
		else{}		
		
		$sql = "select discount_amount, billed_by, billed_by_type, payment_amount, (discount_amount-payment_amount) as balance, bill_date, payment_date,
				CASE WHEN billed_by_type=2 THEN 'Doctor' WHEN billed_by_type=3   THEN 'Diagnostic' END billed_by_type_name,
				CASE 
					WHEN billed_by_type=2 THEN (select name from doctor  		  where id= billed_by)  
					WHEN billed_by_type=3 THEN (select name from diagnostic	  where id= billed_by) 
				END billed_for
				from
				(select sum(b.discount_amount) discount_amount, b.bill_date, b.billed_by, b.billed_by_type
				from bill_info b 
				group by  billed_by,billed_by_type ) A
				left join 
				(select sum(p.amount) payment_amount, p.payment_to, p.payment_date, p.payment_to_type from payment p group by  p.payment_to, p.payment_to_type)B 
				on A.billed_by = B.payment_to and A.billed_by_type = B.payment_to_type 
				where $condition 
				ORDER BY billed_by_type ASC";
		//echo $sql; die;		
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);			 
	break;
	
	case "health_card_service_record":	
	//var_dump($_REQUEST);die;
		$data = array();		
		$condition = "";	
		$condition .=" bill_date between '$start_date' and '$end_date' and health_card_no='$health_card_no' ";		
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
			
		$sql = "SELECT id, health_card_no, bill_date, total_amount, discount_amount, bill_image,
				billed_by_name,	billed_by_type, billed_by, billed_by_type_name, billed_for, billed_for_type_name, user_type,used_by_id
					FROM (
						SELECT id, health_card_no, bill_date,  total_amount, discount_amount, bill_image,  billed_by_type,  
						CASE WHEN billed_by_type=2 THEN doc_name WHEN billed_by_type=3   THEN diag_name END billed_by_name,billed_by,
						CASE WHEN billed_by_type=2 THEN 'Doctor' WHEN billed_by_type=3   THEN 'Diagnostic' END billed_by_type_name,
						CASE WHEN user_type=1 THEN 'Employee' WHEN user_type=4   THEN 'Teacher' WHEN user_type=5 THEN 'Student' WHEN user_type=6 THEN 'VIP' WHEN user_type=7 THEN 'Female' END billed_for_type_name,
						user_type,used_by_id,
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
				ORDER BY id ASC ";
			//echo $sql; die;		
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
			foreach ($result as $row) {
				$data['records'][] = $row;
			}			
		echo json_encode($data);	
	break;
	
	case "myFemaleService":	

	break;	
	
	case "myFemaleService":	

	break;
	
}
?>