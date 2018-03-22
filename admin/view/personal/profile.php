<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
?>

<script>
$(document).ready(function () {	
	var user_id 	= "<?php echo $_SESSION['user_id']; ?>";	
	var user_type  = "<?php echo $_SESSION['user_type']; ?>";	

	$('.date-picker').daterangepicker({
		singleDatePicker: true,
		calender_style: "picker_3",
		locale: {
			  format: 'YYYY-MM-DD',
			  separator: " - ",
		}
	});
});

</script>



<?php

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else{
	if($_SESSION['user_type'] == 1){
		$user_type_name = "SSF Employee";
		include("emp_profile.php");	
	}
	else if($_SESSION['user_type'] == 2){
		$user_type_name = "Doctor";
		include("doctor_profile.php");	
	}
	else if($_SESSION['user_type'] == 3){
		$user_type_name = "Diagnostic center";
		include("dc_profile.php");		
	}
	else if($_SESSION['user_type'] == 4){
		$user_type_name = "Teacher";
		include("teacher_profile.php");	
	}
	else if($_SESSION['user_type'] == 5){
		$user_type_name = "Student";
		include("student_profile.php");		
	}
	else if($_SESSION['user_type'] == 6){
		$user_type_name = "VIP";
		include("vip_profile.php");		
	}
	else if($_SESSION['user_type'] == 7){
		$user_type_name = "Female";
		include("female_profile.php");		
	}
	else{
	}
} 
?>

<style type="text/css">
	@media print {    
		.no-print, .no-print * {
			display: none !important;
		}
	}
</style>

