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
                <h1>Events</h1>
                <ul class="bread-crumb">
                	<li><a href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>Events</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->
    
    
    
    <!--Main Footer-->
    <section class="main-footer">
    	<div class="auto-container">
        	<!--widgets section-->
            <div class="widgets-section">
                <div class="row clearfix">                
                    <div class="content-side col-lg-9 col-md-8 col-sm-12 col-xs-12">
                        <?php
							$event_html = "";
							$condition = "";
							if(isset($_GET['events'])){
								$condition = " id = '".$_GET['events']."' DESC,";
							}
							$event_info =  $dbClass->getResultList("select n.id,n.title, n.details, n.attachment, n.post_date, date_format(n.post_date, '%b') c_month, date_format(n.post_date, '%d') c_date, 
																concat(e.full_name, ' (',e.designation_name,')') emp_name, date_format(n.post_date, '%Y') c_year
																from web_notice n
																join user_infos e on e.emp_id = n.posted_by
																where `type`= 2 order by $condition id desc limit 5");											
							foreach ($event_info as $row){
								extract($row);
								$event_html .='
								<div class="blog-single">                        
									<div class="news-block-two">
										<div class="inner-box">
											<!--Image Column-->
											<div class="image-box">
												<div class="image">
													<div class="post-date">'.$c_month.' <span>'.$c_date.'</span></div>
												</div>
											</div>
											<!--Lower Box-->
											<div class="lower-box">
												<h3>'.$title.'</h3>
												<ul class="post-meta">
													<li><span class="icon fa fa-user"></span>'.$emp_name.'</li>
													<li><span class="icon fa fa-clock-o"></span>'.$post_date.'</li>
												</ul>
												<div class="text">
													<p>'.$details.'</p>
												</div>
											</div>
										</div>
									</div>                        
								</div>'; 
							}
							echo $event_html;
						?>	
                    </div>
					
					<div class="sidebar-side col-lg-3 col-md-4 col-sm-12 col-xs-12">
						<aside class="sidebar default-sidebar">                        
							<!-- Popular Posts -->
							<div class="sidebar-widget popular-posts">
								<div class="sidebar-title"><h2>Upcoming News</h2></div>
								
								<?php
									$news_html = "";
									$news_info =  $dbClass->getResultList("select n.id, n.title, n.details, n.attachment, n.post_date, 
																		date_format(n.post_date, '%b') c_month, date_format(n.post_date, '%d') c_date,	
																		concat(e.full_name, ' (',e.designation_name,')') emp_name 
																		from web_notice n
																		join user_infos e on e.emp_id = n.posted_by
																		where `type`= 1 order by id desc limit 2");
									foreach ($news_info as $row){			
										extract($row);
										$attach_html = '';
										$attachment_array = explode(",",$attachment);
										$attach_html =
											'<img src="admin/document/notice_attachment/'.$attachment_array[0].'"';
										
										if(empty($attachment)) 
											$attach_html = 
												'<img src="images/default.jpg" alt="" />';
										$news_html .=
										'<article class="post">
											<figure class="post-thumb"><a href="news.php?news='.$row['id'].'">'.$attach_html.'</a></figure>
											<div class="text"><a href="news.php?news='.$row['id'].'">'.$title.'</a></div>
											<div class="post-info">'.$c_month.' '.$c_date.', '.$c_year.'</div>
										</article>'; 
									}
									echo $news_html;
								?>		
						
							</div>
						</aside>
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
<script src="js/script.js"></script>

<!--Google Map APi Key-->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyBKS14AnP3HCIVlUpPKtGp7CbYuMtcXE2o"></script>
<script src="js/map-script.js"></script>
<!--End Google Map APi-->


</body>

<!-- Mirrored from t.commonsupport.com/maikop/contact.php by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Nov 2017 05:55:24 GMT -->
</html>
<script>

$(document).ready(function () {
	$('.events').addClass('current');
});

</script>