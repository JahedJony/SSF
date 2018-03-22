
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
                <h1>Services</h1>
                <ul class="bread-crumb">
                	<li><a href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>Services</li>
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
							$about_us_info =  $dbClass->getResultList("select id, menu, title, description from web_menu where parent_menu_id=16");	
							$count = 0;
							foreach ($about_us_info as $row){
								extract($row);
								if($count == 0){		$class = "active-btn";  $content_class = "active-tab"; }
								else 			{		$class = "";			$content_class = "";			}

								$li_html .= ' <li data-tab="#about_'.$id.'" class="tab-btn '.$class.'"><span class="icon flaticon-recycling-water"></span>'.$title.'</li>';		
								$title_arr = explode(' ',trim($title), 2);
								$title_arr_count = count($title_arr);
								if($title_arr_count>1)
									$title_array = '<div class="sec-title centered"><h2>'.$title_arr[0].' <span class="theme_color">'.$title_arr[1].'</span></h2></div>';
								else
									$title_array = '<div class="sec-title centered"><h2><span class="theme_color">'.$title.'</span></h2></div>'; 
								
								$content_html .= '								
									<div class="tab  '.$content_class.'" id="about_'.$id.'">
										<div class="content">
											<div class="row clearfix">
												<!--Text Column-->
												<div class="text-column col-md-12 col-sm-12 col-xs-12">
													<div class="inner">
														<!--Heading Title-->
														'.$title_array.'                                                
														<div class="text-content">'.$description.'</div>
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
	$('.service').addClass('current');
});

</script>