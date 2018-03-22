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
                <h1>Our Gallery</h1>
                <ul class="bread-crumb">
                	<li><a href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>Gallery</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->
    
    <!--Project Section-->
    <section class="project-section">
    	<div class="auto-container">
			
            <!--Sortable Gallery-->
            <div class="mixitup-gallery">
            
                <!--Filter-->
                <div class="filters clearfix">
                    <ul class="filter-tabs filter-btns">
                        <?php
							$album_info =  $dbClass->getResultList("select * from image_album ");																								
							foreach ($album_info as $row){
								extract($row);
								echo '<li class="filter active" data-role="button"><a href="gallary.php?album='.$album_name.'">'.$album_name.'</a></li>';
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
                                        <a href="../web_project/admin/document/gallary_attachment/<?php echo $attachment; ?>" class="option-btn lightbox-image" data-fancybox-group="gallery-two"><span class="flaticon-cross-2"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php
					}
					$error_html= '';
					if(empty($attachemnt_info))
						$error_html =
							'<div>
								<div style="text-align:center">
									<h2>There is no image in this album.</h2>
								</div>
							</div>';
					echo $error_html;		
				?>		
                </div>
                
            </div>
            
      	</div>
    </section>
   
   <?php include('includes/footer.php'); ?> 

<script>

$(document).ready(function () {
	$('.gallary').addClass('current');
});

</script>
