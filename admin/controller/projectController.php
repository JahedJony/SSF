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
		//var_dump($_POST);die;
		if(isset($master_id)  && $master_id == ""){
			$attachments = "";
			if(isset($_FILES['attached_file']) && $_FILES['attached_file']['name'][0] != ""){
				$desired_dir = "../document/project_attachment";
				chmod( "../document/project_attachment", 0777);
				foreach($_FILES['attached_file']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['attached_file']['name'][$key];
					$file_size =$_FILES['attached_file']['size'][$key];
					$file_tmp =$_FILES['attached_file']['tmp_name'][$key];
					$file_type=$_FILES['attached_file']['type'][$key];	
					if($file_size < $file_max_length){
						if(file_exists("$desired_dir/".$file_name)==false){
							if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
								$attachments .= "$file_name ,";
						}
						else{//rename the file if another one exist
							$new_dir="$desired_dir/".time().$file_name;
							if(rename($file_tmp,$new_dir))
								$attachments .=time()."$file_name,";				
						}	
					}
					else {
						echo $img_error_ln;die;
					}					
				}
				$attachments  = rtrim($attachments,",");
			}				
			$columns_value = array(
				'title'=>$title,
				'details'=>$details,
				'attachment'=>$attachments,
				'start_date'=>$start_date,
				'end_date'=>$end_date,
				'posted_by'=>$loggedUser,
				'project_type'=>$project_type
			);			
			$return = $dbClass->insert("project", $columns_value);
			if($return) echo "1";
			else 		echo "0";
		}
		else if(isset($master_id) && $master_id>0){
			$attachments= "";
			if(isset($_FILES['attached_file']) && $_FILES['attached_file']['name'][0] != ""){
				$attachments = "";
				$desired_dir = "../document/project_attachment";
				chmod( "../document/project_attachment", 0777);
				foreach($_FILES['attached_file']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['attached_file']['name'][$key];
					$file_size =$_FILES['attached_file']['size'][$key];
					$file_tmp =$_FILES['attached_file']['tmp_name'][$key];
					$file_type=$_FILES['attached_file']['type'][$key];	
					if($file_size < $file_max_length){
						if(file_exists("$desired_dir/".$file_name)==false){
							if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
								$attachments .= "$file_name,";
						}
						else{//rename the file if another one exist
							$new_dir="$desired_dir/".time().$file_name;
							if(rename($file_tmp,$new_dir))
								$attachments .=time()."$file_name,";				
						}	
					}
					else {
						echo "img_error";die;
					}					
				}
				$attachments  = rtrim($attachments,",");
			}
			$prev_attachment = $dbClass->getSingleRow("select attachment from project where id = $master_id");	
			if($prev_attachment['attachment'] != "")  $attachments = $attachments.",".$prev_attachment['attachment'];
			$attachments  = ltrim($attachments,",");
			$columns_value = array(
				'title'=>$title,
				'details'=>$details,
				'attachment'=>$attachments,
				'start_date'=>$start_date,
				'end_date'=>$end_date,
				'posted_by'=>$loggedUser,
				'project_type'=>$project_type
			);			
			$condition_array = array(
				'id'=>$master_id
			);
			$return = $dbClass->update("project",$columns_value, $condition_array);
			if($return) echo "2";
			else 		echo "0";		 		
		}
	break;

	case "grid_data":	
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();		

		$countsql = "select count(id) from project WHERE CONCAT(title,details) LIKE '%$search_txt%'";
		//echo $countsql;die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		$sql = "SELECT id, title, details, attachment, project_type project_type_id, start_date, end_date,
				CASE project_type WHEN 1 THEN 'On Going' WHEN 2 THEN 'Up Coming' WHEN 3 THEN 'Completed' END project_type
				FROM project
				WHERE CONCAT(title,details) LIKE '%$search_txt%%'
				ORDER BY id DESC
				LIMIT $start , $end";
		//echo $sql;die;
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);		 
	break; 
	
	case "get_project_details":
		$project_details = $dbClass->getResultList("select * from project where id=$project_id");
		foreach ($project_details as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);			
	break;

	case "delete_project_attached_file":	 
		$prev_attachment = $dbClass->getSingleRow("select attachment from project where id=$master_id");	
		$prev_attachment_array = explode(",",$prev_attachment['attachment']);
		if(($key = array_search($file_name, $prev_attachment_array)) !== false) {
			unset($prev_attachment_array[$key]);
		}
	 	$attachment = implode(",",$prev_attachment_array);
	 	$columns_value = array(
			'attachment'=>$attachment
		);	 
		$condition_array = array(
			'id'=>$master_id
		);
		if($dbClass->update("project",$columns_value, $condition_array)){
			unlink("../document/project_attachment/".$file_name);
			echo 1;
		}
		else
			echo 0;			 
	break;
	
	case "delete_project":
		$attachment = $dbClass->getSingleRow("select attachment from project where id = $project_id");	
		$attachment_array = explode(",",$attachment['attachment']);
		for($i=0;$i<count($attachment_array);$i++){
			unlink("../document/project_attachment/".$attachment_array[$i]);
		} 
		$condition_array = array(
			'id'=>$project_id
		);
		$return = $dbClass->delete("project", $condition_array);

		if($return) echo "1";
		else 		echo "0";	
	
	break;
}
?>