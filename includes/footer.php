
    <!--Main Footer-->
    <section class="main-footer">
    	<div class="auto-container">
        	<!--widgets section-->
            <div class="widgets-section">
                <div class="row clearfix">                
                	<!--Big Column-->
                    <div class="big-column col-md-6 col-sm-12 col-xs-12">
                    	<div class="row clearfix">
                        	<!--Footer Column-->
                            <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="footer-widget logo-widget">
                                	<div class="footer-logo">
                                    	<a href="index-2.php"><img src="images/footer-logo.png" alt="" /></a>
                                    </div>
									<div class="widget-content">
										<div class="text">Here will some short description about the company </div>
                                        <ul class="social-icon-one">
                                            <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                                            <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                                            <li><a href="#"><span class="fa fa-google-plus"></span></a></li>                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!--Footer Column-->
                            <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                            	<!--Links Widget-->
                                <div class="footer-widget links-widget">
                                	<div class="footer-title">
                                    	<h2>Quick Links</h2>
                                    </div>
                                	<div class="widget-content">
                                    	<ul class="list">
                                            <li><a href="index.php">Home</a></li>
                                            <li><a href="about.php">About Us</a></li>
                                            <li><a href="services.php">Services</a></li>
                                        </ul>
									</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <!--Big Column-->
                    <div class="big-column col-md-6 col-sm-12 col-xs-12">
                    	<div class="row clearfix">                        	
                            <!--Footer Column-->
                        	<div class="footer-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="footer-widget posts-widget">
                                	<div class="footer-title">
                                		<h2>Latest News</h2>
                                    </div>
									<div class="widget-content">
										<div class="posts">
										<?php
											$news_html = "";
											$news_info =  $dbClass->getResultList("select n.id, n.title, n.details, n.attachment, n.post_date, date_format(n.post_date, '%Y') c_year,	
																				date_format(n.post_date, '%b') c_month, date_format(n.post_date, '%d') c_date,	
																				concat(e.full_name, ' (',e.designation_name,')') emp_name 
																				from web_notice n
																				join user_infos e on e.emp_id = n.posted_by
																				where `type`= 1 order by id desc limit 2");	
											foreach ($news_info as $row){
												extract($row);
												$attach_html = '';
												$attachment_array = explode(",",$attachment);
												$attach_html = '<img src="admin/document/notice_attachment/'.$attachment_array[0].'"';
												
												if(empty($attachment)) 	$attach_html = '<img src="images/default.jpg" alt="" />';
												$news_html .=
													'<div class="post">
														<figure class="post-thumb"><a href="news.php?news='.$row['id'].'">'.$attach_html.'</a></figure>
														<div class="desc-text"><a href="news.php?news='.$row['id'].'">'.$title.'</a></div>
														<div class="post-info">'.$c_month.' '.$c_date.', '.$c_year.'</div>
													</div>';								
											}
											echo $news_html;
										?>
										</div>
									</div>
                                </div>
                            </div>
                            <?php 
								$email_info   =  $dbClass->getSingleRow("select description from web_menu where menu = 'email'");	
								$mobile_info  =  $dbClass->getSingleRow("select description from web_menu where menu = 'mobile'");	
								$office_info  =  $dbClass->getSingleRow("select description from web_menu where menu = 'office time'");
								$address_info =  $dbClass->getSingleRow("select description from web_menu where menu = 'address'");
							?>
                            <!--Footer Column-->
                        	<div class="footer-column col-md-6 col-sm-6 col-xs-12">
                            	<div class="footer-widget contact-widget">
                                	<div class="footer-title">
                                		<h2>Contact Us</h2>
                                    </div>
                                    <div class="widget-content">
                                    	<ul class="list-style-two">
                                            <li><span class="icon flaticon-maps-and-flags"></span><span class="contact_address"><?php echo $address_info['description'] ?></span></li>
                                            <li><span class="icon flaticon-smartphone"></span><span class="contact_mobile_no"><?php echo $mobile_info['description'] ?></span></li>
                                            <li><span class="icon flaticon-note"></span><span class="contact_email_no"><?php echo $email_info['description'] ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>                    
                </div>                
            </div>
        </div>
    </section>
    <!--End Main Footer-->    
</div>
<!--End pagewrapper-->

<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-arrow-up"></span></div>


<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
<script src="js/jquery.fancybox-media.js"></script>
<script src="js/owl.js"></script>
<script src="js/wow.js"></script>
<script src="js/validate.js"></script>
<script src="js/mixitup.js"></script>
<script src="js/appear.js"></script>
<script src="js/script.js"></script>

<!--Google Map APi Key-->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyBKS14AnP3HCIVlUpPKtGp7CbYuMtcXE2o"></script>
<script src="js/map-script.js"></script>
<!--End Google Map APi-->

<!--Color Switcher-->
<script src="js/color-settings.js"></script>

</body>

<!-- Mirrored from t.commonsupport.com/maikop/contact.php by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Nov 2017 05:55:24 GMT -->
</html>