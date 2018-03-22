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
                <h1>About us</h1>
                <ul class="bread-crumb">
                	<li><a href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>About us</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->
    
    
   
    <!--Tab Section-->
    <!--Tab Section-->
    <section class="tab-section">
    	<div class="auto-container">        
            <!--Product Tabs-->
            <div class="prod-tabs tabs-box">
                <div class="row clearfix">
                	<!--Column-->
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <!--Tab Btns-->
<!--Tab Btns-->
						<?php
							$li_html = "";
							$content_html = "";
							$about_us_info =  $dbClass->getResultList("select id, menu, title, description from web_menu where parent_menu_id=28");	
							$count = 0;
							foreach ($about_us_info as $row){
								extract($row);
								if($count == 0){		$class = "active-btn";  $content_class = "active-tab"; }
								else 			{		$class = "";			$content_class = "";			}

								$li_html .= ' <li data-tab="#about_'.$id.'" class="tab-btn '.$class.'"><span class="icon flaticon-recycling-water"></span>'.$title.'</li>';		
								$title_arr = explode(' ',trim($title), 2);
								$content_html .= '								
									<div class="tab  '.$content_class.'" id="about_'.$id.'">
										<div class="content">
											<div class="row clearfix">
												<!--Text Column-->
												<div class="text-column col-md-12 col-sm-12 col-xs-12">
													<div class="inner">
														<!--Heading Title-->
														<div class="sec-title centered"><h2>'.$title_arr[0].' <span class="theme_color">'.$title_arr[1].'</span></h2></div>                                                
														<div class="text-content">'.$description;
													if($id == 36){
														$trusty_infos =  $dbClass->getResultList("select emp_id,designation_name,full_name,photo,contact_no,email,blood_group,remarks  from user_infos  m where is_active_home_page=1 
");	
														foreach ($trusty_infos as $tr_row){
															extract($tr_row);
														
								$content_html .= 		'
														    <div class="team-block col-md-4 col-sm-6 col-xs-12">
																<div class="inner-box">
																	<div class="image">
																		<a href="#"><img src="admin/'.$photo.'" alt="" /></a>
																	</div>
																	<div class="lower-box">
																		<h3><a href="#">'.$full_name.' - <span> '.$designation_name.'</span></a></h3>
																		<div class="text-outer">
																			<div class="text">'.$remarks.'</div>
																		</div>
																	</div>
																</div>
															</div>  
														';
														}														
													}															
								$content_html .= '								
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>									
								';
								$count++;
							}
						?>				
                        <ul class="tab-btns tab-buttons clearfix">
                            <?php echo $li_html; ?>
                        </ul>
                    </div>
                    <!--Column-->
                    <div class="col-md-9 col-sm-12 col-xs-12">
                    	<!--Tabs Container-->
                        <div class="tabs-content">
							<?php echo $content_html; ?>						
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
	
    <!--End Tab Section-->
    
<?php include('includes/footer.php'); ?>  
    
<script>

$(document).ready(function () {
	$('.about').addClass('current');
});

</script>