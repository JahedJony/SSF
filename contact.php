<?php include('includes/header.php'); ?>
                    <!--Btn Outer-->
<!--                <div class="btn-outer">
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
    <!--Page Title-->
    <section class="page-title" style="background-image:url(images/background/6.jpg);">
    	<div class="auto-container">
        	<div class="inner-box">
                <h1>Contact us</h1>
                <ul class="bread-crumb">
                	<li><a href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>Contact</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->
    
    <!--Contact Section-->
    <section class="contact-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Form Column-->
            	<div class="form-column col-md-7 col-sm-12 col-xs-12">
                	<h2>SEND US MESSAGE</h2>
                    <div class="text">We would be delighted to hear from you. Please send us a message and we will get back to you as soon as possible.</div>
                    
                    <!-- Contact Form -->
                    <div class="contact-form">
                            
                        <!--Contact Form-->
                        <form method="post" action="send_mail.php" id="contact-form">
                            <div class="row clearfix">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <input type="text" name="username" placeholder="Name" required>
                                </div>
                                
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <input type="email" name="email" placeholder="Email" required>
                                </div>
                                
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <input type="text" name="phone" placeholder="Phone">
                                </div>
                                
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <input type="text" name="subject" placeholder="Subject">
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <textarea name="message" placeholder="Message"></textarea>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <button class="theme-btn btn-style-one" type="submit" name="submit-form"><span class="fa fa-arrow-circle-right"></span>&ensp; Submit</button>
                                </div>                                
                            </div>
                        </form>                            
                    </div>
                    <!--End Contact Form --> 
                    
                </div>
                <!--Map Column-->
                <div class="map-column col-md-5 col-sm-12 col-xs-12">
				<?php
					$contact_info =  $dbClass->getSingleRow("select description from web_menu where menu = 'address'");	
					$email_info   =  $dbClass->getSingleRow("select description from web_menu where menu = 'email'");	
					$mobile_info =  $dbClass->getSingleRow("select description from web_menu where menu = 'mobile'");	
					$office_info =  $dbClass->getSingleRow("select description from web_menu where menu = 'office time'");	
				?>	
                	<h2>LOCATION</h2>
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
                    <ul class="list-style-three">
                        <li><span class="icon flaticon-maps-and-flags"></span><span class="contact_address"><?php echo $contact_info['description']; ?></span></li>
                        <li><span class="icon flaticon-smartphone"></span><span class="contact_mobile_no"><?php echo $email_info['description']; ?></span></li>
                        <li><span class="icon flaticon-note"></span><span class="contact_email_no"><?php echo $mobile_info['description']; ?></span></li>
                        <li><span class="icon flaticon-clock-1"></span><span class="contact_hour"><?php echo $office_info['description']; ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--End Contact Section-->
    
        
<?php include('includes/footer.php'); ?>  
    
<script>

$(document).ready(function () {
	$('.contact').addClass('current');
});

</script>