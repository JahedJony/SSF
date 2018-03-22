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
		//var_dump($_REQUEST); die;
		if(isset($master_id) && $master_id == ""){
			$columns_value = array(
				'payment_to_type'=>$payment_type,
				'payment_date'=>date('Y-m-d'),
				'payment_to'=>$payment_select,
				'paid_by'=>$loggedUser,
				'amount'=>$total_payment_amount
			);
			$return = $dbClass->insert("payment", $columns_value);				
			if($return)    echo "1";
			else 	       echo "0";
		}
		else if(isset($master_id) && $master_id>0){
			$columns_value = array(
				'payment_to_type'=>$payment_type,
				'payment_date'=>date('Y-m-d'),
				'payment_to'=>$payment_select,
				'paid_by'=>$loggedUser,
				'amount'=>$total_payment_amount
			);
			$condition_array = array(
				'id'=>$master_id
			);
			$return = $dbClass->update("payment", $columns_value, $condition_array);				
			if($return)    echo "2";
			else 	       echo "0";
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
			$condition .=" payment_date between '$start_date' and '$end_date' ";		
			// for status condition 			
			if($ad_type == 2 && $selected_doc_diag_value != 0){
				$condition .= " and payment_to_type = $ad_type and payemt_to_id = $selected_doc_diag_value "; 
			}
			else if($ad_type == 3 && $selected_doc_diag_value != 0){
				$condition .= " and payment_to_type = $ad_type and payemt_too_id = $selected_doc_diag_value "; 
			}
			else if($ad_type == 2 && $selected_doc_diag_value == 0){
				$condition .= " and payment_to_type = $ad_type "; 
			}
			else if($ad_type == 3 && $selected_doc_diag_value == 0){
				$condition .= " and payment_to_type = $ad_type "; 
			}
			else{}	
		}
		// textfield search for grid
		else{
			$condition .=	" CONCAT(payment_date, payment_to_end, paid_by, amount)	LIKE '%$search_txt%' ";			
		}
		
		//user type wise condition
		if($user_type == 1){ 
			$update_delete_condition = " case   when status=1 then 1 else 0 end   update_status,	case   when status=1 then 1 else 0 end  delete_status ";
		}
		else if($user_type == 2 || $user_type == 3){ 
			$update_delete_condition = "  0 update_status, 0 delete_status ";
			if($user_type == 2) $condition .= " and payemt_to_id=$loggedUser and payment_to_type=2 ";
			else if($user_type == 3) $condition .= " and payemt_too_id=$loggedUser and payment_to_type=3 ";
		}
		
		
		$countsql = "SELECT count(id)
					FROM 
					(
						select id, payment_date, paid_by, amount, status,payemt_to_id, payemt_too_id,payment_to_type,					
						case when payemt_to is not null then payemt_to  when payemt_too is not null then payemt_too end payment_to_end
						from(
							select p.id, p.payment_date , d.name payemt_to,d.id as payemt_to_id,   u.full_name paid_by, p.amount , dg.name payemt_too, dg.id as payemt_too_id, p.status, payment_to_type
							from payment p
							left join user_infos u on u.emp_id=p.paid_by 
							left join doctor d on d.id=p.payment_to and p.payment_to_type=2 
							left join diagnostic dg on dg.id=p.payment_to and p.payment_to_type=3
						)A
					)B  where $condition
					ORDER BY id ASC limit $start, $end";
		
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);

		$sql = "SELECT id, payment_date, paid_by, amount, status,payment_to_type,payemt_to_id,payemt_too_id, payment_to_end, $update_delete_condition,
				case when status =1 then 'Paid' when status=2 then 'Received' end  payment_status  
				FROM 
				(
					select id, payment_date, paid_by, amount, status,payemt_to_id,payemt_too_id,payment_to_type,					
					case when payemt_to is not null then payemt_to when payemt_too is not null then payemt_too end payment_to_end
					from(
						select p.id, p.payment_date , d.name payemt_to,d.id as payemt_to_id,   u.full_name paid_by, p.amount , dg.name payemt_too, dg.id as payemt_too_id, p.status, payment_to_type
						from payment p
						left join user_infos u on u.emp_id=p.paid_by 
						left join doctor d on d.id=p.payment_to and p.payment_to_type=2 
						left join diagnostic dg on dg.id=p.payment_to and p.payment_to_type=3
					)A
				)B  where $condition
				ORDER BY id ASC limit $start, $end";
					
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);		 
	break;
	
	case "load_single_payment":
			$data = array ();			
			$sql = "SELECT id, payment_date, payment_to_end ,  case when status =1 then 'Paid' when status=2 then 'Received' end as payment_status,amount 
					FROM (
							select id, payment_date,status,amount,					
							case when payemt_to is not null then payemt_to  when payemt_too is not null then payemt_too end payment_to_end
								from(
									select p.id, p.payment_date , d.name payemt_to,d.id as payemt_to_id,   u.full_name paid_by, p.amount , dg.name payemt_too, dg.id as payemt_too_id, p.status, payment_to_type
									from payment p
									left join user_infos u on u.emp_id=p.paid_by 
									left join doctor d on d.id=p.payment_to and p.payment_to_type=2 
									left join diagnostic dg on dg.id=p.payment_to and p.payment_to_type=3
								)A
						)B
						where id=$payment_id";
			//	echo $sql;die;			
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
			foreach ($result as $row) {
				$data['payment_master'] = $row;
			}
			$bill_details = $dbClass->getResultList("SELECT b.id, b.bill_date, b.student_id, b.billed_by, b.billed_by_type,
													b.total_amount, b.discount_amount,b.`status`,b.bill_image,b.payment_id,
													s.name, s.id student_id, s.identy_no, s.discount_card_no, s.age, s.class, s.mobile_no, s.image student_image
													from bill_info b
													join student s on s.id = b.student_id
													where b.payment_id = '$payment_id'");
			foreach ($bill_details as $row){
				$data['records_array'][] = $row;
			}			
			echo json_encode($data);	
	
	break;
	
	case "view_diagnostic":
		$data = array();
		$details = $dbClass->getResultList("select id, name from diagnostic");
		foreach ($details as $row){
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "view_doctor":
		$data = array();
		$details = $dbClass->getResultList("select * from doctor");
		foreach ($details as $row){
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;	
	
	case "view_doctor_details":
		$data = array();
		$details = $dbClass->getResultList("select * from doctor where id = $id");
		foreach ($details as $row){
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "view_diagnostic_details":
		$data = array();
		$details = $dbClass->getResultList("select * from diagnostic where id = $id");
		foreach ($details as $row){
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "get_payment_details":
		//var_dump($_REQUEST); die;
		$data = array();
		$sql = "select id, payment_date, payment_to, payment_to_type, paid_by, `status`, remarks, attachment, amount from payment where id = $payment_id";
		//echo $sql; die;
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);		
	break;
	
	case "bill_payment_report":
		//var_dump($_REQUEST); die;
		$data = array();		
		/* if($selected_doc_diag_value != 0){
			$con1 = " and payment_to = $selected_doc_diag_value "; 
			$con2 = " and billed_by = $selected_doc_diag_value "; 
		}
		else{
			$con1 = " ";
			$con2 = " ";
		}
		$sql = "select * from 
				(
					select id bill_id, bill_date, total_amount, discount_amount from bill_info 
					where bill_date between '$start_date' and '$end_date'
					and billed_by_type = $ad_type $con2
				)   as bill_infos
				inner join
				(
					select id payment_id, payment_date, p.amount from payment p 
					where payment_date between '$start_date' and '$end_date'
					and payment_to_type = $ad_type $con1 
				)	as payment_infos
			order by bill_date"; */
		//$sql = "select id, payment_date, payment_to, payment_to_type, paid_by, `status`, remarks, attachment, amount from payment where payment_date between $start_date and $end_date";
		//echo $sql; die;
		
		if($ad_type == 2 && $selected_doc_diag_value != 0){
			$con = " and payment_to_type = $ad_type and payemt_to_id = $selected_doc_diag_value ";
			$con2 = " and billed_by_type = $ad_type and doc_id = $selected_doc_diag_value "; 			
		}
		else if($ad_type == 3 && $selected_doc_diag_value != 0){
			$con = " and payment_to_type = $ad_type and payemt_too_id = $selected_doc_diag_value ";
			$con2 = " and billed_by_type = $ad_type and diag_id = $selected_doc_diag_value ";			
		}
		else{
			$con = " and payment_to_type = $ad_type ";
			$con2 = " and billed_by_type = $ad_type ";
		}
		$payment_sql = "SELECT id, payment_date, paid_by, amount, STATUS,payment_to_type,payemt_to_id,payemt_too_id, payment_to_end, 
				CASE WHEN STATUS =1 THEN 'Paid' WHEN STATUS=2 THEN 'Received' END payment_status
				FROM 
				(
					SELECT id, payment_date, paid_by, amount, STATUS,payemt_to_id,payemt_too_id,payment_to_type, 
					CASE WHEN STATUS=1 THEN 1 ELSE 0 END update_status, CASE WHEN STATUS=1 THEN 1 ELSE 0 END delete_status, CASE WHEN payemt_to IS NOT NULL THEN payemt_to WHEN payemt_too IS NOT NULL THEN payemt_too END payment_to_end
					FROM
						(
							SELECT p.id, p.payment_date, d.name payemt_to,d.id AS payemt_to_id, u.full_name paid_by, p.amount, dg.name payemt_too, dg.id AS payemt_too_id, p.status, payment_to_type
							FROM payment p
							LEFT JOIN user_infos u ON u.emp_id=p.paid_by
							LEFT JOIN doctor d ON d.id=p.payment_to AND p.payment_to_type=2
							LEFT JOIN diagnostic dg ON dg.id=p.payment_to AND p.payment_to_type=3
						)A
				)B
				WHERE payment_date between '$start_date' and '$end_date' $con 
				ORDER BY id ASC";
				
		$bill_sql = "SELECT id, bill_date, billed_by, total_amount, discount_amount, billed_by_type, 
				doc_id, diag_id, doc_name, diag_name, bill_image, name
				FROM (
						SELECT id, bill_date, billed_by, total_amount, discount_amount, doc_id, diag_id, billed_by_type, 
						doc_name, diag_name, bill_image, name, 
						CASE WHEN doc_id IS NOT NULL THEN doc_id WHEN diag_id IS NOT NULL THEN diag_id END payment_to_end
						FROM
						(
							SELECT b.id, b.bill_date, b.student_id, b.billed_by, b.billed_by_type,
							b.total_amount, b.discount_amount, b.bill_image,
							s.name, d.id doc_id, d.name doc_name, dg.id diag_id, dg.name diag_name
							FROM bill_info b
							LEFT JOIN student s ON s.id=b.student_id
							LEFT JOIN doctor d ON d.id=b.billed_by AND b.billed_by_type=2
							LEFT JOIN diagnostic dg ON dg.id=b.billed_by AND b.billed_by_type=3
						)A
					)B
				WHERE bill_date between '$start_date' and '$end_date' $con2 
				ORDER BY id ASC";
		
		$stmt = $conn->prepare($payment_sql);
		$stmt2 = $conn->prepare($bill_sql);
		$stmt->execute();
		$stmt2->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['payment_info'][] = $row;
		}	
		foreach ($result2 as $row) {
			$data['bill_info'][] = $row;
		}			
		echo json_encode($data);		
	break;
}
?>