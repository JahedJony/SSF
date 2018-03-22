<!DOCTYPE html>
<?php 
	include("includes/dbConnect.php");
	include("includes/dbClass.php");

	$dbClass = new dbClass;
	
?>

<head>
	<meta charset="utf-8">
	<title>SSF</title>
	<!-- Stylesheets -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="plugins/revolution/css/settings.css" rel="stylesheet" type="text/css"><!-- REVOLUTION SETTINGS STYLES -->
	<link href="plugins/revolution/css/layers.css" rel="stylesheet" type="text/css"><!-- REVOLUTION LAYERS STYLES -->
	<link href="plugins/revolution/css/navigation.css" rel="stylesheet" type="text/css"><!-- REVOLUTION NAVIGATION STYLES -->
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
<html>

<!-- Mirrored from t.commonsupport.com/maikop/index-2.php by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Nov 2017 05:53:48 GMT -->


<body>

<div class="page-wrapper"> 	
    <!-- Preloader -->
    <div class="preloader"></div>
 	
    <!-- Main Header / Header Style Two-->
    <header class="main-header header-style-two">
    
    	<!-- Main Box -->
    	<div class="main-box">
        	<div class="auto-container">
            	<div class="outer-container clearfix">
                    <!--Logo Box-->
                    <div class="logo-box">
                        <div class="logo"><a href="index-2.php"><img src="images/logo-2.png" alt=""></a></div>
                    </div>
                    
                    <!--Btn Outer-->
<!--                    <div class="btn-outer">
                        <a href="donate.php" class="theme-btn donate-btn btn-style-one"><span class="fa fa-arrow-circle-right"></span>&ensp;donate</a>
                    </div>-->
                    
                    <!--Nav Outer-->
						<?php include('includes/top_menu.php'); ?>
                    <!--Nav Outer End-->                    
            	</div>    
            </div>
        </div>    
    </header>
    <!--End Main Header -->
    
    <!--Main Slider-->
    <section class="main-slider">    	
        <div class="rev_slider_wrapper fullwidthbanner-container"  id="rev_slider_one_wrapper" data-source="gallery">
            <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
                <ul>                	
                    <li data-description="Slide Description" data-easein="default" data-easeout="default" data-fsmasterspeed="1500" data-fsslotamount="7" data-fstransition="fade" data-hideafterloop="0" data-hideslideonmobile="off" data-index="rs-1688" data-masterspeed="default" data-param1="" data-param10="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-rotate="0" data-saveperformance="off" data-slotamount="default" data-thumb="images/main-slider/image-2.jpg" data-title="Slide Title" data-transition="parallaxvertical">
                    <img alt="" class="rev-slidebg" data-bgfit="cover" data-bgparallax="10" data-bgposition="center center" data-bgrepeat="no-repeat" data-no-retina="" src="images/main-slider/image-2.jpg"> 
                                        
                    <div class="tp-caption" 
                    data-paddingbottom="[0,0,0,0]"
                    data-paddingleft="[0,0,0,0]"
                    data-paddingright="[0,0,0,0]"
                    data-paddingtop="[0,0,0,0]"
                    data-responsive_offset="on"
                    data-type="text"
                    data-height="none"
                    data-width="['700','700','700','420']"
                    data-whitespace="normal"
                    data-hoffset="['15','15','15','15']"
                    data-voffset="['-100','-120','-120','-120']"
                    data-x="['center','center','center','center']"
                    data-y="['middle','middle','middle','middle']"
                    data-textalign="['top','top','top','top']"
                    data-frames='[{"from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'
                    style="z-index: 7; white-space: nowrap;text-transform:left;">
                    	<div class="medium-title">Shastho Shikkha Foundation</div>
                    </div>
                    
                    <div class="tp-caption" 
                    data-paddingbottom="[0,0,0,0]"
                    data-paddingleft="[0,0,0,0]"
                    data-paddingright="[0,0,0,0]"
                    data-paddingtop="[0,0,0,0]"
                    data-responsive_offset="on"
                    data-type="text"
                    data-height="none"
                    data-width="['700','700','700','420']"
                    data-whitespace="normal"
                    data-hoffset="['15','15','15','15']"
                    data-voffset="['-20','-40','-40','-55']"
                    data-x="['center','center','center','center']"
                    data-y="['middle','middle','middle','middle']"
                    data-textalign="['top','top','top','top']"
                    data-frames='[{"from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'
                    style="z-index: 7; white-space: nowrap;text-transform:left;">
                    	<div class="text-center"><h1>We provide free helth services </h1></div>
                    </div>
                    
                    <div class="tp-caption" 
                    data-paddingbottom="[0,0,0,0]"
                    data-paddingleft="[0,0,0,0]"
                    data-paddingright="[0,0,0,0]"
                    data-paddingtop="[0,0,0,0]"
                    data-responsive_offset="on"
                    data-type="text"
                    data-height="none"
                    data-width="['600','600','700','420']"
                    data-whitespace="normal"
                    data-hoffset="['15','15','15','15']"
                    data-voffset="['70','50','50','30']"
                    data-x="['center','center','center','center']"
                    data-y="['middle','middle','middle','middle']"
                    data-textalign="['top','top','top','top']"
                    data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'
                    style="z-index: 7; white-space: nowrap;text-transform:left;">
                    	<div class="text text-center">We care children, we care female </div>
                    </div>
                    
                    <div class="tp-caption tp-resizeme" 
                    data-paddingbottom="[0,0,0,0]"
                    data-paddingleft="[0,0,0,0]"
                    data-paddingright="[0,0,0,0]"
                    data-paddingtop="[0,0,0,0]"
                    data-responsive_offset="on"
                    data-type="text"
                    data-height="none"
                    data-width="['700','700','700','420']"
                    data-whitespace="normal"
                    data-hoffset="['15','15','15','15']"
                    data-voffset="['145','125','125','110']"
                    data-x="['center','center','center','center']"
                    data-y="['middle','middle','middle','middle']"
                    data-textalign="['top','top','top','top']"
                    data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'
                    style="z-index: 7; white-space: nowrap;text-transform:left;">
                    	<div class="btns-box text-center">
                    		<a href="donate.php" class="theme-btn btn-style-two"><span class="fa fa-arrow-circle-right"></span>&ensp;Explore Us</a> &ensp; <a href="donate.php" class="theme-btn btn-style-one"><span class="fa fa-arrow-circle-right"></span>&ensp;donate</a>
                        </div>
                    </div>
                    
                    </li>
                    
                    <li data-description="Slide Description" data-easein="default" data-easeout="default" data-fsmasterspeed="1500" data-fsslotamount="7" data-fstransition="fade" data-hideafterloop="0" data-hideslideonmobile="off" data-index="rs-1687" data-masterspeed="default" data-param1="" data-param10="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-rotate="0" data-saveperformance="off" data-slotamount="default" data-thumb="images/main-slider/image-1.jpg" data-title="Slide Title" data-transition="parallaxvertical">
                    <img alt="" class="rev-slidebg" data-bgfit="cover" data-bgparallax="10" data-bgposition="center center" data-bgrepeat="no-repeat" data-no-retina="" src="images/main-slider/image-1.jpg"> 
                    
                    <div class="tp-caption" 
                    data-paddingbottom="[0,0,0,0]"
                    data-paddingleft="[0,0,0,0]"
                    data-paddingright="[0,0,0,0]"
                    data-paddingtop="[0,0,0,0]"
                    data-responsive_offset="on"
                    data-type="text"
                    data-height="none"
                    data-width="['700','700','700','420']"
                    data-whitespace="normal"
                    data-hoffset="['15','15','15','15']"
                    data-voffset="['-100','-120','-120','-110']"
                    data-x="['left','left','left','left']"
                    data-y="['middle','middle','middle','middle']"
                    data-textalign="['top','top','top','top']"
                    data-frames='[{"from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'
                    style="z-index: 7; white-space: nowrap;text-transform:left;">
                    	<div class="big-title">Shastho Shikkha Foundation</div>
                    </div>
                    
                    <div class="tp-caption" 
                    data-paddingbottom="[0,0,0,0]"
                    data-paddingleft="[0,0,0,0]"
                    data-paddingright="[0,0,0,0]"
                    data-paddingtop="[0,0,0,0]"
                    data-responsive_offset="on"
                    data-type="text"
                    data-height="none"
                    data-width="['700','700','700','420']"
                    data-whitespace="normal"
                    data-hoffset="['15','15','15','15']"
                    data-voffset="['-20','-30','-40','-40']"
                    data-x="['left','left','left','left']"
                    data-y="['middle','middle','middle','middle']"
                    data-textalign="['top','top','top','top']"
                    data-frames='[{"from":"x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'
                    style="z-index: 7; white-space: nowrap;text-transform:left;">
                    	<h2>The best medical campaigner in the contry</h2>
                    </div>
                    
                    <div class="tp-caption" 
                    data-paddingbottom="[0,0,0,0]"
                    data-paddingleft="[0,0,0,0]"
                    data-paddingright="[0,0,0,0]"
                    data-paddingtop="[0,0,0,0]"
                    data-responsive_offset="on"
                    data-type="text"
                    data-height="none"
                    data-width="['650','650','700','420']"
                    data-whitespace="normal"
                    data-hoffset="['15','15','15','15']"
                    data-voffset="['60','65','40','40']"
                    data-x="['left','left','left','left']"
                    data-y="['middle','middle','middle','middle']"
                    data-textalign="['top','top','top','top']"
                    data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'
                    style="z-index: 7; white-space: nowrap;text-transform:left;">
                    	<div class="text">We frequently campaign for free to the students </div>
                    </div>
                    
                    <div class="tp-caption tp-resizeme" 
                    data-paddingbottom="[0,0,0,0]"
                    data-paddingleft="[0,0,0,0]"
                    data-paddingright="[0,0,0,0]"
                    data-paddingtop="[0,0,0,0]"
                    data-responsive_offset="on"
                    data-type="text"
                    data-height="none"
                    data-width="['700','700','700','420']"
                    data-whitespace="normal"
                    data-hoffset="['15','15','15','15']"
                    data-voffset="['140','130','120','110']"
                    data-x="['left','left','left','left']"
                    data-y="['middle','middle','middle','middle']"
                    data-textalign="['top','top','top','top']"
                    data-frames='[{"from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":1500,"to":"o:1;","delay":1000,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"auto:auto;","mask":"x:0;y:0;s:inherit;e:inherit;","ease":"Power3.easeInOut"}]'
                    style="z-index: 7; white-space: nowrap;text-transform:left;">
                    	<div class="btns-box">
                    		<a href="donate.php" class="theme-btn btn-style-two"><span class="fa fa-arrow-circle-right"></span>&ensp;Explore Us</a> &ensp; <a href="donate.php" class="theme-btn btn-style-one"><span class="fa fa-arrow-circle-right"></span>&ensp;Donate</a>
                        </div>
                    </div>
                    
                    </li>
                    
                </ul>
            </div>
        </div>
    </section>
    <!--End Main Slider-->
    
    <!--Welcome Section-->
    <section class="welcome-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Text Column-->
                <div class="text-column col-md-12 col-sm-12 col-xs-12">
                	<div class="inner">
                    	<!--Heading Title-->
                        <div class="sec-title centered"><h2><span class="theme_color">Shastho Shikkha Foundation</span></h2></div>
						
						<?php
							$about_us_info =  $dbClass->getSingleRow("select * from web_menu where id=28");
						?>					
											
                        <div class="text-content"><?php echo $about_us_info['description']; ?>  </div>

                    </div>
                </div>
                <!--Image Column
                <div class="image-column col-md-5 col-sm-12 col-xs-12">
                	<div class="inner">
                    	<div class="image-box"><figure class="image" data-wow-delay="0ms"><img src="images/resource/featured-image-1.jpg" alt=""></figure></div>
                    </div>
                </div>
				-->
            </div>
        </div>
    </section>
    
    
    
     <section class="counter-section" style="background-image:url(images/background/5.jpg);">
    	<div class="auto-container">
        	<h2><span class="theme_color">3000+</span> People Getting Services From Us</h2>       
        </div>
    </section>   
    
    <!--Services Section-->
    <section class="services-section">
    	<div class="auto-container">
        	<!--Sec Title-->
            <div class="sec-title centered">
            	<h2><span class="theme_color">What We are Doing</span></h2>   
            </div>
            <div class="row clearfix">
            	<!--Left Column-->
            	<div class="left-column pull-left col-md-4 col-sm-6 col-xs-12">
                	<div class="inner-column">
                    	<!--Services Block-->
                        <div class="services-block">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-rain"></span>
                                </div>
                                <h3><a href="services.php">Helth Awarness</a></h3>
                                <div class="text">We awar people about some dangarous disease like Cancer, Diabetic, Strock </div>
                            </div>
                        </div>
                        
                        <!--Services Block-->
                        <div class="services-block">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-eolic-energy-1"></span>
                                </div>
                                <h3><a href="services.php">Diagnosis Services</a></h3>
                                <div class="text">We provide "Diagnosis Card" thus people get discount on diagonisis in several clinic </div>
                            </div>
                        </div>
                        
                        <!--Services Block-->
                        <div class="services-block">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-animal-prints"></span>
                                </div>
                                <h3><a href="services.php">Doctors Consultancy</a></h3>
                                <div class="text">We will provide/suggest best doctor and best treatment process for a  specific disease </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!--Right Column-->
                <div class="right-column pull-right col-md-4 col-sm-6 col-xs-12">
                	<div class="inner-column">
                    	
                        <!--Services Block Two-->
                        <div class="services-block-two">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-recycling-symbol"></span>
                                </div>
                                <h3><a href="services.php">Medicin Care</a></h3>
                                <div class="text">One of the Main target is to provide people medicine for cheap rate and  free(Special cases)</div>
                            </div>
                        </div>
                        
                        <!--Services Block Two-->
                        <div class="services-block-two">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-recycle-symbol-of-three-leaves"></span>
                                </div>
                                <h3><a href="services.php">Doctors  Serial</a></h3>
                                <div class="text">We will arrange doctor's serial, because it is very difficult to manage a serial for a rural people</div>
                            </div>
                        </div>
                        
                        <!--Services Block Two-->
                        <div class="services-block-two">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-trees"></span>
                                </div>
                                <h3><a href="services.php">Law Services</a></h3>
                                <div class="text">Grow awarness & law support against tourture, childMarige,evetiging, dowry, terorisom & militancy</div>
                            </div>
                        </div>                        
                    </div>
                </div>
                <!--Image Column-->
                <div class="image-column col-md-4 col-sm-12 col-xs-12">
                	<div class="image">
                    	<img src="images/resource/bulb.jpg" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Services Section-->
    
    <!--Counter Section-->
    <section class="counter-section" style="background-image:url(images/background/5.jpg);">
    	<div class="auto-container">
        	<h2>History of <span class="theme_color">Success</span></h2>            
            <div class="fact-counter">
                <div class="auto-container">
                    <div class="row clearfix">                    
                        <!--Column-->
                        <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                            <div class="inner">
                            	<span class="icon-box"><span class="icon flaticon-rain"></span></span>
                                <h4 class="counter-title">School Counselling </h4>
                                <div class="count-outer count-box">
                                    <span class="count-text" data-speed="2000" data-stop="200">0</span><span class="plus-icon">+</span>
                                </div>
                            </div>
                        </div>
                
                        <!--Column-->
                        <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                            <div class="inner">
                            	<span class="icon-box"><span class="icon flaticon-coins-1"></span></span>
                                <h4 class="counter-title">Student Helth Card</h4>
                                <div class="count-outer count-box">
                                    <span class="plus-icon"></span><span class="count-text" data-speed="2000" data-stop="387">0</span><span class="plus-icon"></span>
                                </div>
                            </div>
                        </div>
                
                        <!--Column-->
                        <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                            <div class="inner">
                            	<span class="icon-box"><span class="icon flaticon-hand-shake-1"></span></span>
                                <h4 class="counter-title">Expert Volunteers</h4>
                                <div class="count-outer count-box">
                                    <span class="count-text" data-speed="4000" data-stop="250">0</span><span class="plus-icon">+</span>
                                </div>
                            </div>
                        </div>
                
                        <!--Column-->
                        <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                            <div class="inner">
                            	<span class="icon-box"><span class="icon flaticon-medal-2"></span></span>
                                <h4 class="counter-title">Partners </h4>
                                <div class="count-outer count-box">
                                    <span class="count-text" data-speed="2000" data-stop="42">0</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Counter Section-->
    
    <!--Project Section-->
    <section class="project-section">
    	<div class="auto-container">
			<!--Sec Title-->
            <div class="sec-title centered">
            	<h2>Our <span class="theme_color">Gallery</span></h2>
            </div>
            
            <!--Sortable Gallery-->
            <div class="mixitup-gallery">
            
                <!--Filter-->
                <div class="filters clearfix">
                    <ul class="filter-tabs filter-btns">
						<?php
							$album_info =  $dbClass->getResultList("select * from image_album ");																								
							foreach($album_info as $row){
								extract($row);
								echo '<li class="active filter" data-role="button"><a href="gallary.php?album='.$album_name.'">'.$album_name.'</a></li>';
							}
						?>	
                    </ul>
                </div>
                
                <div class="filter-list row clearfix">
					<?php
						$condition = '';
						if(isset($_GET['album']))	$condition = "where alb.album_name = '".$_GET['album']."'";	
						$attachemnt_info =  $dbClass->getResultList("select img.title, img.attachment, alb.album_name 
																	from gallary_images img
																	join image_album alb on alb.id = img.album_id 
																	$condition order by alb.id desc limit 10");																								
						foreach ($attachemnt_info as $row){
							extract($row);
					?>	
                   <!--Default Gallery Item-->
                    <div class="default-gallery-item mix all climate col-md-3 col-sm-6 col-xs-12">
                        <div class="inner-box">
                            <figure class="image-box"><img src="admin/document/gallary_attachment/<?php echo $attachment; ?>" alt=""></figure>
                            <!--Overlay Box-->
                            <div class="overlay-box">
                                <div class="overlay-inner">
                                    <div class="content">
                                        <div class="category"><?php echo $title; ?></div>
                                        <h4><a href="project-details.php"><?php echo $album_name; ?></a></h4>
                                        <a href="admin/document/gallary_attachment/<?php echo $attachment; ?>" class="option-btn lightbox-image" data-fancybox-group="gallery-two"><span class="flaticon-cross-2"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php
					}
				?>	
                </div>
                
            </div>
      	</div>
    </section>
    <!--Project Section-->
    

    <!--Clients Section-->
    <section class="clients-section" style="background-image:url(images/background/3.jpg);">
    	<div class="auto-container">
        	<!--Sponsors Carousel-->
            <ul class="sponsors-carousel owl-carousel owl-theme">
                <li class="slide-item"><figure class="image-box"><a href="#"><img src="images/clients/1.png" alt=""></a></figure></li>
                <li class="slide-item"><figure class="image-box"><a href="#"><img src="images/clients/2.png" alt=""></a></figure></li>
                <li class="slide-item"><figure class="image-box"><a href="#"><img src="images/clients/3.png" alt=""></a></figure></li>
                <li class="slide-item"><figure class="image-box"><a href="#"><img src="images/clients/4.png" alt=""></a></figure></li>
                <li class="slide-item"><figure class="image-box"><a href="#"><img src="images/clients/1.png" alt=""></a></figure></li>
                <li class="slide-item"><figure class="image-box"><a href="#"><img src="images/clients/2.png" alt=""></a></figure></li>
                <li class="slide-item"><figure class="image-box"><a href="#"><img src="images/clients/3.png" alt=""></a></figure></li>
                <li class="slide-item"><figure class="image-box"><a href="#"><img src="images/clients/4.png" alt=""></a></figure></li>
            </ul>
        </div>
    </section>
    <!--End Clients Section-->
    
    <!--News Section-->
    <section class="news-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Column-->
            	<div class="column col-md-8 col-sm-12 col-xs-12">
                	<!--Sec Title-->
                    <div class="sec-title">
                    	<h2>Latest <span class="theme_color">News</span></h2>
                    </div>
                    <div class="column-text">Donec mollis, metus a varius faibus, est magna tempor mauris, sit amet lobortis nunc sem non lectusroin vitae fugiat lorem,nec lia massa eger interdum ipsum sed placerat posuere.</div>
                    <!--News Block-->
                    <?php
							$news_html = "";
							$news_info =  $dbClass->getResultList("select n.id, n.title, n.details, n.attachment, n.post_date, left(n.details, 100) s_details,
																date_format(n.post_date, '%b') c_month, date_format(n.post_date, '%d') c_date,	
																concat(e.full_name, ' (',e.designation_name,')') emp_name 
																from web_notice n
																join user_infos e on e.emp_id = n.posted_by
																where `type`=1 order by id limit 2");	
							foreach ($news_info as $row){
								extract($row);
								$news_html .='
								
								<div class="news-block">
									<div class="inner-box">
										<div class="row clearfix">
											<!--Image Column-->
											<div class="image-column col-md-2 col-sm-2 col-xs-2">
												<div class="image">
													<div class="post-date">'.$c_month.' <span>'.$c_date.'</span></div>
												</div>
											</div>
											<!--Content Column-->
											<div class="content-column col-md-10 col-sm-10 col-xs-12">
												<div class="content-inner">
													<h3><a href="news.php?news='.$row['id'].'">'.$title.'</a></h3>
													<ul class="post-meta">
														<li><span class="icon fa fa-user"></span>'.$emp_name.'</li>
														<li><span class="icon fa fa-clock-o"></span>'.$post_date.'</li>
													</ul>
													<div class="text">'.$s_details.'</div>
													<a href="news.php?news='.$row['id'].'" class="theme-btn btn-style-one"><span class="fa fa-arrow-circle-right"></span>&ensp; Read more</a>
												</div>
											</div>
										</div>
									</div>
								</div>'; 
							}
							echo $news_html;
						?>	
                </div>
                <!--Column-->
                <div class="event-column col-md-4 col-sm-12 col-xs-12">
                	<div class="event-inner-column">
                        <!--Sec Title-->
                        <div class="sec-title">
                            <h2>Upcoming <span class="theme_color">Events</span></h2>
                        </div>
                        <div class="event-inner">
							<?php
								$event_html = "";
								$event_info =  $dbClass->getResultList("select n.id,n.title, n.details, n.attachment, n.post_date, date_format(n.post_date, '%b') c_month, date_format(n.post_date, '%d') c_date, 
																	concat(e.full_name, ' (',e.designation_name,')') emp_name, date_format(n.post_date, '%Y') c_year
																	from web_notice n
																	join user_infos e on e.emp_id = n.posted_by
																	where `type`= 2 order by id limit 2");	
								foreach ($event_info as $row){
									extract($row);
										$attach_html = '';
										$attachment_array = explode(",",$attachment);
										$attach_html =
											'<img src="admin/document/notice_attachment/'.$attachment_array[0].'"';
										
										if(empty($attachment)) 
											$attach_html = 
												'<img src="images/default.jpg"/>';
									$event_html .=
									'<div class="event-block">
										<div class="inner-box">
											<div class="image">'.$attach_html.'</div>
											<div class="content-box">
												<div class="date">'.$c_month.' '.$c_date.', '.$c_year.'</div>
												<h3><a href="events.php?events='.$row['id'].'">'.$title.'</a></h3>
											</div>
										</div>
									</div>'; 
								}
								echo $event_html;
							?>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End News Section-->
    
    <!--Footer Style Two-->
    <section class="footer-style-two">
    	<div class="outer-container clearfix">
        	<!--Left Column-->
            <div class="left-column">
                <div class="content">
                	<div class="row clearfix">
                    	<!--Footer Column-->
                        <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                        	<div class="footer-widget info-widget">
                                <div class="footer-title">
                                    <h2>Keep in Touch</h2>
                                </div>
                                <div class="widget-content">
                                	<div class="text">We highly appriciate you to visit our place and keep in our touchs</div>
                                    <?php
										$email_info   =  $dbClass->getSingleRow("select description from web_menu where menu = 'email'");	
										$mobile_info  =  $dbClass->getSingleRow("select description from web_menu where menu = 'mobile'");	
										$address_info =  $dbClass->getSingleRow("select description from web_menu where menu = 'address'");			
									?>
									<ul class="list-style-two style-two">
                                         <li><span class="icon flaticon-maps-and-flags"></span><span class="contact_address"><?php echo $address_info['description']?></span></li>
                                         <li><span class="icon flaticon-smartphone"></span><span class="contact_mobile_no"><?php echo $mobile_info['description']?></span></li>
                                         <li><span class="icon flaticon-note"></span><span class="contact_email_no"><?php echo $email_info['description']?></span></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!--Footer Column-->
                        <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                        	<div class="footer-widget links-widget">
                                <div class="footer-title">
                                    <h2>Quick Links</h2>
                                </div>
                                <div class="widget-content">
                                    <ul class="list">
                                        <li><a href="about.php">About Us</a></li>
                                        <li><a href="services.php">Our Services</a></li>
                                        <li><a href="events.php">Upcoming Events</a></li>
                                        <li><a href="news.php">Latest News</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!--Riht Column-->
            <div class="right-column">
                <!--Map Outer-->
                <div class="map-outer">
                    <!--Map Canvas-->
                    <div class="map-canvas"
                        data-zoom="10"
                        data-lat="24.879787"
                        data-lng="89.452257"
                        data-type="roadmap"
                        data-hue="#ffc400"
                        data-title="Shastho Shikkha Foundation"
                        data-icon-path="images/icons/map-marker.png"
                        data-content="<?php echo $contact_info['description']; ?><br><a href='mailto:<?php echo $email_info['description']; ?>'><?php echo $email_info['description']; ?></a>">
                    </div>
                </div>
            </div>
        </div>
        <!--Footer Bottom-->
        <div class="footer-bottom">
        	<div class="auto-container">
            	<div class="row clearfix">
                    <div class="column col-md-6 col-sm-6 col-xs-12">
                        <div class="copyright">&copy;  2017 SSF (Shastho Shikkha Foundation)</div>
                    </div>
                    <div class="column col-md-6 col-sm-6 col-xs-12">
                        <ul class="social-icon-three">
                            <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fa fa-google-plus"></span></a></li>
                            <li><a href="#"><span class="fa fa-youtube"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Footer Style Two-->
    
</div>
<!--End pagewrapper-->

<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-arrow-up"></span></div>

<!-- Color Palate / Color Switcher -->
<!--<div class="color-palate">
    <div class="color-trigger">
        <i class="fa fa-gear"></i>
    </div>
    <div class="color-palate-head">
        <h6>Choose Your Color</h6>
    </div>
    <div class="various-color clearfix">
        <div class="colors-list">
            <span class="palate default-color active" data-theme-file="css/color-themes/default-theme.css"></span>
            <span class="palate teal-color" data-theme-file="css/color-themes/teal-theme.css"></span>
            <span class="palate navy-color" data-theme-file="css/color-themes/navy-theme.css"></span>
            <span class="palate yellow-color" data-theme-file="css/color-themes/yellow-theme.css"></span>
            <span class="palate blue-color" data-theme-file="css/color-themes/blue-theme.css"></span>
            <span class="palate purple-color" data-theme-file="css/color-themes/purple-theme.css"></span>
            <span class="palate olive-color" data-theme-file="css/color-themes/olive-theme.css"></span>
            <span class="palate red-color" data-theme-file="css/color-themes/red-theme.css"></span>
        </div>
    </div>

    <div class="palate-foo">
        <span>You can easily change and switch the colors.</span>
    </div>
</div>-->
<!-- /.End Of Color Palate -->
<script src="js/jquery.js"></script> 
<!--Revolution Slider-->
<script src="plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
<script src="plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
<!--<script src="plugins/revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.navigation.min.js"></script>-->
<script src="plugins/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<!--<script src="plugins/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="plugins/revolution/js/extensions/revolution.extension.video.min.js"></script>-->
<script src="js/main-slider-script.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
<script src="js/jquery.fancybox-media.js"></script>
<script src="js/owl.js"></script>
<script src="js/wow.js"></script>
<script src="js/appear.js"></script>
<script src="js/mixitup.js"></script>
<script src="js/script.js"></script>

<!--Google Map APi Key-->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyBKS14AnP3HCIVlUpPKtGp7CbYuMtcXE2o"></script>
<script src="js/map-script.js"></script>
<!--End Google Map APi-->

<!--Color Switcher-->
<script src="js/color-settings.js"></script>
<script>

$(document).ready(function () {
	$('.index').addClass('current');
});

</script>
</body>

<!-- Mirrored from t.commonsupport.com/maikop/index-2.php by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Nov 2017 05:54:47 GMT -->
</html>