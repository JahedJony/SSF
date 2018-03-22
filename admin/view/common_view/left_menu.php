
     <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu">
                <li><a href="index.php"><i class="fa fa-home"></i>Home</a></li>    
		<?php 
		if($user_type  == 1){?>
                <li><a><i class="fa fa-users"></i>User<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="index.php?module=user&view=user">SSF Employee</a></li>
                        <li><a href="index.php?module=student&view=student">Student</a></li>
                        <li><a href="index.php?module=teacher&view=teacher">Teacher</a></li>
                        <li><a href="index.php?module=doctor&view=doctor">Doctor</a></li>
                        <li><a href="index.php?module=diagnostic&view=diagnostic">Diagnostic</a></li>
                        <li><a href="index.php?module=female&view=female">Female</a></li>
                        <li><a href="index.php?module=vip&view=vip">VIP</a></li>
                    </ul>
                </li>
                <li><a href="index.php?module=billinfo&view=billinfo"><i class="fa fa-list-alt "></i>Bill Info</a></li>
                <li><a href="index.php?module=healthKitService&view=healthKitServices"><i class="fa fa-list-alt "></i>Health Kit Services</a></li>
                <li><a href="index.php?module=payment&view=payment"><i class="fa fa-money"></i>Payment</a></li>
                <li><a><i class="fa fa-file-o "></i>Website<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="index.php?module=pages&view=pages">Pages</a></li>
                        <li><a href="index.php?module=notice&view=notice">Notice</a></li>
                        <li><a href="index.php?module=gallary&view=gallary">Gallary</a></li>
                        <li><a href="index.php?module=project&view=project">Project</a></li>
                    </ul>
                </li>            
                <li><a><i class="fa fa-user"></i>Personal<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="index.php?module=personal&view=profile">Profile</a></li>
                        <li><a href="index.php?module=personal&view=contacts">Contacts</a></li>
                    </ul>
                </li>			
                <li><a><i class="fa  fa-cogs"></i>Control Panel <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="index.php?module=cp&view=group_permission">User Group</a></li>
                        <li><a href="index.php?module=cp&view=actions">Web Actions</a></li>
                        <li><a href="index.php?module=cp&view=healthcard">Health Card</a></li>
                        <li><a href="index.php?module=cp&view=school">School/Institute</a></li>
                        <li><a href="index.php?module=cp&view=healthKit">Health Kit</a></li>
                    </ul>
                </li> 	
		<?php
         }
         // doctor or diagnostic
         else  if($user_type  == 2 || $user_type  == 3){?>
         
         		<li><a><i class="fa fa-users"></i>User   <span class="fa fa-chevron-down"></span></a>
                <li><a><i class="fa fa-user"></i>Personal<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="index.php?module=personal&view=profile">Profile</a></li>
                        <li><a href="index.php?module=personal&view=contacts">Contacts</a></li>
                    </ul>
                </li>
                
                <li><a href="index.php?module=billinfo&view=billinfo"><i class="fa fa-list-alt "></i>Bill Info</a></li>
                <li><a href="index.php?module=payment&view=payment"><i class="fa fa-money"></i>Payment</a></li>
        <?php	 
         }
         // Teacher
         else  if($user_type  == 4){?>
                
                <li><a><i class="fa fa-user"></i>Personal<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="index.php?module=personal&view=profile">Profile</a></li>
                        <li><a href="index.php?module=personal&view=contacts">Contacts</a></li>
                    </ul>
                </li>    
                <li><a href="index.php?module=student&view=student"><i class="fa fa-users"></i>Student</a></li>
        <?php	 
         }
         // Student
         else  if($user_type  == 5){?>
                <li><a><i class="fa fa-user"></i>Personal<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="index.php?module=personal&view=profile">Profile</a></li>
                        <li><a href="index.php?module=personal&view=contacts">Contacts</a></li>
                    </ul>
                </li>
        <?php	 
         } 
         // VIP
         else  if($user_type  == 6){?>
                <li><a><i class="fa fa-user"></i>Personal<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="index.php?module=personal&view=profile">Profile</a></li>
                        <li><a href="index.php?module=personal&view=contacts">Contacts</a></li>
                    </ul>
                </li>
        <?php	 
         }
         // Female
         else  if($user_type  == 7){?>
                <li><a><i class="fa fa-user"></i>Personal<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                        <li><a href="index.php?module=personal&view=profile">Profile</a></li>
                        <li><a href="index.php?module=personal&view=contacts">Contacts</a></li>
                    </ul>
                </li>
        <?php	 
         }
        ?>      
				<li><a><i class="fa fa-file-pdf-o"></i>Reports<span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="display: none">
						<li><a href="index.php?module=reports&view=myservice">My Helth Card Services</a></li>
		<?php  if($user_type == 7 || $user_type == 5 || $user_type == 4 || $user_type == 6 || $user_type == 3){?>
						<li><a href="index.php?module=reports&view=myHealthKitService">My Health Kit Service</a></li>
		<?php } ?>
		<?php  if($user_type  == 1 || $user_type == 2 || $user_type == 3){?>
						<li><a href="index.php?module=reports&view=billvspayment">Bill Vs Payment</a></li>
		<?php } 
			if($user_type  == 1 ){?>
						<li><a href="index.php?module=reports&view=helthCardService">Health Card Service</a></li>
						<li><a href="index.php?module=reports&view=myHealthKitService">Health Kit Service History</a></li>
		<?php } ?>

					</ul>
				</li>
				
            </ul>
        </div>
    </div>
