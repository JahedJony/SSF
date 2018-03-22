<?php 
session_start();
include '../includes/static_text.php';
include("../dbConnect.php");
include("../dbClass.php");

$dbClass = new dbClass;
$conn       = $dbClass->getDbConn();
$loggedUser = $dbClass->getUserId();	
$user_type = $_SESSION['user_type'];
$user_id	 = $_SESSION['user_id'];

extract($_REQUEST);
switch ($q){
	case "getSchools":
		$condition = "";
		if($user_type == 4){
			 $teachers_school_id =  $dbClass->getSingleRow(" select school_id from teacher where  id=$user_id");
			 $condition = " AND id=".$teachers_school_id['school_id'];
		}		
		$sql_query = "SELECT id,code, name FROM school WHERE concat(code,name) LIKE '%" . $term . "%' $condition  ORDER BY name";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["code"]." >> ".$row["name"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No School Found');
		}			
		echo json_encode($json);			
	break;

	case "getTeachers":
		$condition = "";
		if($user_type == 4){
			 $condition = " AND t.id=".$user_id;
		}		
		$sql_query = "SELECT t.id, t.name t_name, s.name s_name FROM teacher t left join school s on s.id=t.school_id where concat(t.name)  LIKE '%" . $term . "%' $condition  ORDER BY t.name";
		//echo $sql_query;die;
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				/* $json[] = array('id' => $row["id"],'label' => $row["t_name"]."  (".$row["s_name"].")"); */
				$json[] = array('id' => $row["id"],'label' => $row["t_name"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Teacher Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getTeacherDesignation":	
		if($user_type == 4){
			$sql_query = "SELECT distinct designation FROM teacher WHERE designation LIKE '%" . $term . "%' and id=$user_id ORDER BY designation";
		}else{
			$sql_query = "SELECT distinct designation FROM teacher WHERE designation LIKE '%" . $term . "%' ORDER BY designation";
		}	
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["designation"],'label' => $row["designation"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Designation Found');
		}			
		echo json_encode($json);			
	break;
	
	

	case "getSchoolNames":	
		if($user_type == 4){
			 $teachers_school_id =  $dbClass->getSingleRow(" select school_id from teacher where  id=$user_id");
			 $condition = " AND id=".$teachers_school_id['school_id'];
		}else{
			$condition = '';
		}	
		$sql_query = "SELECT id,code, name FROM school WHERE concat(code,name) LIKE '%" . $term . "%' $condition ORDER BY name";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["name"],'label' => $row["name"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No School Found');
		}			
		echo json_encode($json);			
	break;
	
	
	
	case "getUnusedCards":
		$sql_query = "SELECT id,card_no FROM helth_card  WHERE card_no LIKE '%" . $term . "%' and is_used=0 ORDER BY id";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["card_no"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Cards Found, create card');
		}			
		echo json_encode($json);			
	break;
	
	
	case "getTeacherUpazillas":
		$sql_query = "SELECT distinct upazilla FROM teacher WHERE upazilla LIKE '%" . $term . "%' ORDER BY upazilla";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["upazilla"],'label' => $row["upazilla"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Upazilla Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getTeacherZillas":
		$sql_query = "SELECT distinct zilla FROM teacher WHERE zilla LIKE '%" . $term . "%' ORDER BY zilla";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["zilla"],'label' => $row["zilla"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Zilla Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getTeacherDivisions":
		$sql_query = "SELECT distinct division FROM teacher WHERE division LIKE '%" . $term . "%' ORDER BY division";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["division"],'label' => $row["division"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Division Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getStudentUpazillas":
		$sql_query = "SELECT distinct upazilla FROM student WHERE upazilla LIKE '%" . $term . "%' ORDER BY upazilla";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["upazilla"],'label' => $row["upazilla"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Upazilla Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getStudentZillas":
		$sql_query = "SELECT distinct zilla FROM student WHERE zilla LIKE '%" . $term . "%' ORDER BY zilla";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["zilla"],'label' => $row["zilla"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Zilla Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getStudentDivisions":
		$sql_query = "SELECT distinct division FROM student WHERE division LIKE '%" . $term . "%' ORDER BY division";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["division"],'label' => $row["division"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Division Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getFemaleUpazillas":
		$sql_query = "SELECT distinct upazilla FROM female WHERE upazilla LIKE '%" . $term . "%' ORDER BY upazilla";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["upazilla"],'label' => $row["upazilla"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Upazilla Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getFemaleDistricts":
		$sql_query = "SELECT distinct district FROM female WHERE district LIKE '%" . $term . "%' ORDER BY district";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["district"],'label' => $row["district"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No District Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getFemalePosts":
		$sql_query = "SELECT distinct post FROM female WHERE post LIKE '%" . $term . "%' ORDER BY post";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["post"],'label' => $row["post"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Post Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getFemaleVillages":
		$sql_query = "SELECT distinct village FROM female WHERE village LIKE '%" . $term . "%' ORDER BY village";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["village"],'label' => $row["village"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Village Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getVipDivisions":
		$sql_query = "SELECT distinct division FROM vip WHERE division LIKE '%" . $term . "%' ORDER BY division";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["division"],'label' => $row["division"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Division Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getVipUpazillas":
		$sql_query = "SELECT distinct upazilla FROM vip WHERE upazilla LIKE '%" . $term . "%' ORDER BY upazilla";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["upazilla"],'label' => $row["upazilla"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Upazilla Found');
		}			
		echo json_encode($json);			
	break;
	
	case "getVipDistricts":
		$sql_query = "SELECT distinct district FROM vip WHERE district LIKE '%" . $term . "%' ORDER BY district";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["district"],'label' => $row["district"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No District Found');
		}			
		echo json_encode($json);			
	break;
	
	case "allServiceCenter":	
		$sql_query = "SELECT id, name FROM school WHERE type = '3' and name LIKE '%" . $term . "%' ORDER BY name";
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
			$json[] = array('id' => '0','label' => 'No Service Center Found');
		}			
		echo json_encode($json);			
	break;
	
}
?>