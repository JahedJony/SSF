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
			$columns_value = array(
				'name'=>$name,
				'code'=>$code,
				'type'=>$type,
				'address'=>$address
			);
			$return = $dbClass->insert("school", $columns_value);
			if($return) echo "1";
			else        echo "0";
		}
		else if(isset($master_id) && $master_id>0){
			$columns_value = array(
				'name'=>$name,
				'code'=>$code,
				'type'=>$type,
				'address'=>$address
			);
			$condition_array = array(
				'id'=>$master_id
			);
			$return = $dbClass->update("school",$columns_value, $condition_array);
			if($return) echo "2";
			else        echo "0";			 
		}
	break;
	
	case "grid_data":
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		if($search_txt == "Print" || $search_txt == "Advance_search"){
			$countsql = "SELECT count(id) FROM school";
		}
		else{
			$countsql = "SELECT count(id)
						FROM(
							SELECT id, name, code, type, address 
							FROM school  
						)A
						WHERE CONCAT(name, code, ifnull(address,'')) LIKE '%$search_txt%'";
		}
		
		//echo $countsql;die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records;  
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		if($search_txt == "Print" || $search_txt == "Advance_search"){
			$sql = "SELECT id, name, code, type, ifnull(address,'') address
					FROM school order by id asc limit $start, $end";
				//	echo $sql; die;
		}
		else{
			$sql = 	"SELECT id, name, code, type, ifnull(address,'') address
					FROM(
						SELECT id, name, type, code, address 
						FROM school 
					)A
					WHERE CONCAT(name, code, ifnull(address,'')) LIKE '%$search_txt%'
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
	
	case "get_school_details":
		$sql = "select * from school where id=$master_id";
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