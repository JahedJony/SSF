<?php 
	include("includes/dbConnect.php");
	include("includes/dbClass.php");

	$dbClass = new dbClass;
	//$conn       = $dbClass->getDbConn();
	$email_info   =  $dbClass->getSingleRow("select description from web_menu where menu = 'email'");	
	$mobile_info =  $dbClass->getSingleRow("select description from web_menu where menu = 'mobile'");	
	$office_info =  $dbClass->getSingleRow("select description from web_menu where menu = 'office time'");	
?>


<!DOCTYPE html>
<html>

<!-- Mirrored from t.commonsupport.com/maikop/contact.php by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Nov 2017 05:55:24 GMT -->
<head>
<meta charset="utf-8">
<title>SSF</title>
<!-- Stylesheets -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">

<!--Color Switcher Mockup-->
<link href="css/color-switcher-design.css" rel="stylesheet">

<!--Color Themes-->
<link id="theme-color-file" href="css/color-themes/default-theme.css" rel="stylesheet">

<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
<link rel="icon" href="images/favicon.png" type="image/x-icon">
<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>

<body>

<div class="page-wrapper"> 	
    <!-- Preloader -->
    <div class="preloader"></div> 	
    <!-- Main Header-->
    <header class="main-header">    
    	<!-- Header Top -->
    	<div class="header-top">
        	<div class="auto-container">
            	<div class="clearfix">                    
                    <!--Top Left-->
                    <div class="top-left"><div class="work-hours" id="working_hour"><?php echo $office_info['description'] ?></div></div>
                    
                    <!--Top Right-->
                    <div class="top-right clearfix">
                    	<ul class="links clearfix">
                        	<li><a href="#"><span class="icon flaticon-cellphone contact_mobile_no"></span><?php echo $mobile_info['description'] ?></a></li>
                            <li><a href="#"><span class="icon flaticon-envelope contact_email_no"></span><?php echo $email_info['description'] ?></a></li>
                        </ul>
                        
                    	<!--social-icon-->
                        <div class="social-icon">
                        	<ul class="clearfix">
                            	<li><a href="#"><span class="fa fa-facebook"></span></a></li>
                                <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                                <li><a href="#"><span class="fa fa-google-plus"></span></a></li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Header Top End -->
        
        <!-- Main Box -->
    	<div class="main-box">
        	<div class="auto-container">
            	<div class="outer-container clearfix">
                
                    <!--Logo Box-->
                    <div class="logo-box">
                        <div class="logo"><a href="index-2.php"><img src="images/logo.png" alt=""></a></div>
                    </div>
