<div class="nav-outer clearfix">
	<!-- Main Menu -->
	<nav class="main-menu">
		<div class="navbar-header">
			<!-- Toggle Button -->    	
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		
		<div class="navbar-collapse collapse clearfix">
			<ul class="navigation clearfix">
				<li class="index" ><a href="index.php">Home</a>
				<li class="about"><a href="about.php">About Us</a></li>
				<li class="service"><a href="services.php">Services</a></li>
				<li class="dropdown project"><a href="#">Projects</a>
					<ul>
					<?php
						$event_info =  $dbClass->getResultList("select id, title from project order by id desc");	
						foreach ($event_info as $row){
							extract($row);
							echo '<li><a href="project-details.php?project='.$row['title'].'">'.$row['title'].'</a></li>';
						}
					?>						
					</ul>
				</li>
				<li class="gallary"><a href="gallary.php">Gallary</a></li>
				<li class="news"><a href="news.php">News</a></li>
				<li class="events"><a href="events.php">Events</a></li>
				<li class="contact"><a href="contact.php">Contact</a></li>
			 </ul>                                   
		</div>
	</nav>
	<!-- Main Menu End-->
	
	<!--Search Box-->
	<div class="search-box-outer">
		<div class="dropdown">
			<button class="search-box-btn dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-search"></span></button>
			<ul class="dropdown-menu pull-right search-panel" aria-labelledby="dropdownMenu3">
				<li class="panel-outer">
					<div class="form-container">
						<form method="post" action="">
							<div class="form-group">
								<input type="search" name="field-name" value="" placeholder="Search Here" required>
								<button type="submit" class="search-btn"><span class="fa fa-search"></span></button>
							</div>
						</form>
					</div>
				</li>
			</ul>
		</div>
	</div>
	
</div>