<?php 
session_start();
include '../includes/static_text.php';
include("../dbConnect.php");	

$user_name	= htmlspecialchars($_POST['user_name'],ENT_QUOTES);
$pass	  	 = $_POST['password'];
$user_type	= $_POST['user_type'];

// ssf employee
if($user_type == 1){	
	$query="select user_id, user_password, user_name, full_name, designation_name, photo from appuser a left join user_infos e on e.emp_id=a.user_id WHERE a.user_name='".$user_name."' and a.is_active=1";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$data = array();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
	foreach ($result as $row) {
		$data['records'][] = $row;
	}	
	//if username exists
	if($stmt -> rowCount()>0){
		//compare the password
		if($row['user_password'] == md5($pass)){
			$update_activity_login_sql = "UPDATE web_login set is_login=:is_login where emp_id=:user_id";
			$stmt = $conn->prepare($update_activity_login_sql);
			$stmt->bindParam(':is_login', $is_login);
			$stmt->bindParam(':user_id', $row['user_id']);		
			$is_login = 1;
			$stmt->execute();		
			$_SESSION['user_id']=$row['user_id']; 
			$_SESSION['user_type']=1; 
			// need to get these info dynamicly later
			$_SESSION['user_pic']	= $row['photo'];
			$_SESSION['user_name']	= $row['full_name'];
			$_SESSION['user_desg']	= $row['designation_name'];
		
																									
			$sql = "select group_concat(group_id) my_groups from user_group_member where emp_id = '".$row['user_id']."' and status = 1";		
			$stmt_group = $conn->prepare($sql);
			$stmt_group->execute();
			$result_group = $stmt_group->fetch(PDO::FETCH_ASSOC);
			$_SESSION['user_groups'] = $result_group['my_groups']; 
	
			echo 1;
		}
		else
			echo 2; 
	}
	else
		echo 3; //Invalid Login
}
//Doctor
else if($user_type == 2){
	$query="select id, name, speciality, address, mobile_no, username, email,  image, remarks, username, `status`, password    from doctor where username='$user_name' and status=1";
	//echo $query; die;
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$data = array();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
	foreach ($result as $row) {
		$data['records'][] = $row;
	}	
	//if username exists
	if($stmt -> rowCount()>0){
		//compare the password
		//echo  $row['password']."---".md5($pass);die;
		if($row['password'] == md5($pass)){	
			$_SESSION['user_id']=$row['id']; 
			$_SESSION['user_type']=2; 
			// need to get these info dynamicly later
			$_SESSION['user_pic']	= $row['image'];
			$_SESSION['user_name']	= $row['name'];
			$_SESSION['user_desg']	= $row['speciality'];
		
			$_SESSION['user_groups'] = '22'; 
	
			echo 1;
		}
		else
			echo 2; 
	}
	else
		echo 3; //Invalid Login
	
}
//diagnostic center
else if($user_type == 3){
	$query="select id, name, speciality, address, mobile_no, username, email,  image, remarks, username, `status`, password    from diagnostic where username='$user_name' and status=1";

	$stmt = $conn->prepare($query);
	$stmt->execute();
	$data = array();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
	foreach ($result as $row) {
		$data['records'][] = $row;
	}	
	//if username exists
	if($stmt -> rowCount()>0){
		//compare the password
		//echo  $row['password']."---".md5($pass);die;
		if($row['password'] == md5($pass)){	
			$_SESSION['user_id']=$row['id']; 
			$_SESSION['user_type']=3; 
			// need to get these info dynamicly later
			$_SESSION['user_pic']	= $row['image'];
			$_SESSION['user_name']	= $row['name'];
			$_SESSION['user_desg']	= $row['speciality'];
		
			$_SESSION['user_groups'] = '23'; 
	
			echo 1;
		}
		else
			echo 2; 
	}
	else
		echo 3; //Invalid Login
}
//Teacher
else if($user_type == 4){
	$query="select t.id, t.name,  t.address, t.mobile_no, username,   image,  username, `status`, password , s.name as school_name, subject  
			from teacher t
			left join school s on s.id=t.school_id
			where username='$user_name' and status=1";

	$stmt = $conn->prepare($query);
	$stmt->execute();
	$data = array();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
	foreach ($result as $row) {
		$data['records'][] = $row;
	}	
	//if username exists
	if($stmt -> rowCount()>0){
		//compare the password
		//echo  $row['password']."---".md5($pass);die;
		if($row['password'] == md5($pass)){	
			$_SESSION['user_id']=$row['id']; 
			$_SESSION['user_type']=4; 
			// need to get these info dynamicly later
			$_SESSION['user_pic']	= $row['image'];
			$_SESSION['user_name']	= $row['name'];
			$_SESSION['user_desg']	= 'Teacher';		
			$_SESSION['user_groups'] = '24'; 	
			echo 1;
		}
		else
			echo 2; 
	}
	else
		echo 3; //Invalid Login
}
//Student
else if($user_type == 5){
	$query="select s.id, s.name,  s.address, s.mobile_no, username,   image,  username, `status`, password , 
sc.name as school_name, s.class, s.identy_no, s.health_card_no  
			from student s
			left join school sc on sc.id=s.school_id
			where username ='$user_name' and status=1";

	$stmt = $conn->prepare($query);
	$stmt->execute();
	$data = array();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
	foreach ($result as $row) {
		$data['records'][] = $row;
	}	
	//if username exists
	if($stmt -> rowCount()>0){
		//compare the password
		//echo  $row['password']."---".md5($pass);die;
		if($row['password'] == md5($pass)){	
			$_SESSION['user_id']=$row['id']; 
			$_SESSION['user_type']=5; 
			// need to get these info dynamicly later
			$_SESSION['user_pic']	= $row['image'];
			$_SESSION['user_name']	= $row['name'];
			$_SESSION['user_desg']	= 'Student';		
			$_SESSION['user_groups'] = '24'; 	
			echo 1;
		}
		else
			echo 2; 
	}
	else
		echo 3; //Invalid Login
}
//VIP
else if($user_type == 6){
	$query="select v.id, v.name,  v.address, v.mobile_no,   image,  username, `status`, password , 
			sc.name as school_name, health_card_no  
			from vip v
			left join school sc on sc.id=v.school_id
			where username ='$user_name' and status=1";

	$stmt = $conn->prepare($query);
	$stmt->execute();
	$data = array();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
	foreach ($result as $row) {
		$data['records'][] = $row;
	}	
	//if username exists
	if($stmt -> rowCount()>0){
		//compare the password
		//echo  $row['password']."---".md5($pass);die;
		if($row['password'] == md5($pass)){	
			$_SESSION['user_id']=$row['id']; 
			$_SESSION['user_type']=6; 
			// need to get these info dynamicly later
			$_SESSION['user_pic']	= $row['image'];
			$_SESSION['user_name']	= $row['name'];
			$_SESSION['user_desg']	= 'VIP';		
			$_SESSION['user_groups'] = '26'; 	
			echo 1;
		}
		else
			echo 2; 
	}
	else
		echo 3; //Invalid Login
}
//Female
else if($user_type == 7){
	$query="select f.id, f.name, f.mobile_no, username,   image,  username, `status`, password , 
			sc.name as school_name,  f.health_card_no  
			from female f
			left join school sc on sc.id=f.school_id
			where username ='$user_name' and status=1";

	$stmt = $conn->prepare($query);
	$stmt->execute();
	$data = array();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
	foreach ($result as $row) {
		$data['records'][] = $row;
	}	
	//if username exists
	if($stmt -> rowCount()>0){
		//compare the password
		//echo  $row['password']."---".md5($pass);die;
		if($row['password'] == md5($pass)){	
			$_SESSION['user_id']=$row['id']; 
			$_SESSION['user_type']=7; 
			// need to get these info dynamicly later
			$_SESSION['user_pic']	= $row['image'];
			$_SESSION['user_name']	= $row['name'];
			$_SESSION['user_desg']	= 'Female';		
			$_SESSION['user_groups'] = '27'; 	
			echo 1;
		}
		else
			echo 2; 
	}
	else
		echo 3; //Invalid Login
}
else{
	echo 3; 
}





?>