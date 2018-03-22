<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];


if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($user_type != 1 && $user_type != 4){
?> 
	<div class="x_panel">
		<div class="alert alert-danger" align="center">You Don't Have permission of this Page.</div>
	</div>
	<?php 
} 
else{
	$user_name = $_SESSION['user_name'];
	?>

<div class="x_panel">
    <div class="x_title">
        <h2>Student List</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
    	<div id="page_notification_div" class="text-center" style="display:none"></div>
		
		<!-- Advance Search Div-->
		<div class="x_panel">
			<div class="row">
				<ul class="nav navbar-right panel_toolbox">
					<li>
						<a class="collapse-link-adv" id="toggle_form_adv"><small class="text-primary">Advance Search & Report</small> <i class="fa fa-chevron-down"></i></a>
					</li>
				</ul>
			</div>
			<div class="x_content adv_cl" id="iniial_collapse_adv">
				<div class="row advance_search_div alert alert-warning">
					<div class="row">
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Name</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="std_name" id="std_name"/> 
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">School</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="sch_name" id="sch_name"/> 
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Class</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="std_class" id="std_class"/> 
						</div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Address</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="std_address" id="std_address"/> 
						</div>
					</div>
					<br/>
					<div class="row">
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Teacher</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="tch_name" id="tch_name"/>
                             <input class="form-control input-sm" type="hidden" name="tch_id" id="tch_id"/>
						</div>
                        <label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Zilla</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="std_zilla" id="std_zilla"/> 
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Upazilla</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="std_upazilla" id="std_upazilla"/> 
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Division</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="std_division" id="std_division"/> 
						</div>
                    </div>
                    <br/>
					<div class="row">
						<label class="control-label col-md-1 col-sm-2 col-xs-4" style="text-align:right">Active</label>
						<div class="col-md-4 col-sm-4 col-xs-8">
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="1"/> Yes
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="0" /> No
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="2" checked="CHECKED"/> All
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-4" style="text-align:right">Health Card</label>
						<div class="col-md-5 col-sm-4 col-xs-8">
							<input type="radio" class="flat_radio" name="is_hcrd_issued" id="is_hcrd_issued" value="Yes"/> Yes
							<input type="radio" class="flat_radio" name="is_hcrd_issued" id="is_hcrd_issued" value="No" /> No
							<input type="radio" class="flat_radio" name="is_hcrd_issued" id="is_hcrd_issued" value="All" checked="CHECKED"/> All
						</div>
					</div>
					<br/>
					<div class="col-md-12" style="text-align:center">					
						<button type="button" class="btn btn-info" id="adv_search_button"><i class="fa fa-lg fa-search"></i></button>
						<button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"></i></button>
					</div>
				</div> 
			</div>
		</div>
		<!-- Adnach search end -->		
    	<div class="dataTables_length">
        	<label>Show 
                <select size="1" style="width: 56px;padding: 6px;" id="student_Table_length" name="student_Table_length" aria-controls="student_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                 </select> 
                 Student
             </label>
         </div>
         <div class="dataTables_filter" id="student_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_student_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_student_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="student_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead>
                <tr class="headings">
					<th class="column-title" width="5%"></th>
                    <th class="column-title" width="15%">Name</th>
                    <th class="column-title" width="15%">School Name</th>
                    <th class="column-title" width="10%">Class</th>
                    <th class="column-title" width="10%">Roll no</th>
                    <th class="column-title" width="10%">Health Card</th>
                    <th class="column-title" width="10%">Britti No</th>                    
                    <th class="column-title" width="">Address</th>
                    <th class="column-title" width="10%">Mobile No</th>
                    <th class="column-title no-link last" width="100"><span class="nobr"></span></th>
                </tr>
            </thead>            
            <tbody id="student_table_body" class="scrollable">             
                
            </tbody>
        </table>
        </div>
        <div id="student_table_biv">
            <div class="dataTables_info" id="student_Table_info">Showing <span id="from_to_limit"></span> of <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="student_Table_paginate">
            </div> 
        </div>  
    </div>
</div>

<div class="x_panel employee_entry_cl">
    <div class="x_title">
        <h2>Student Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">
        <br />             

		<form method="post" id="student_form" name="student_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Full Name<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-12">							
							<input type="text" id="student_name" name="student_name" required class="form-control col-lg-12"/>
						</div>
                        <label class="control-label col-md-2 col-sm-2 col-xs-6">Age</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="age" name="age" class="form-control col-lg-12" />
						</div>
					</div>
					<div class="form-group">
                   		<label class="control-label col-md-2 col-sm-2 col-xs-6" >School Name<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="school_list" name="school_list" class="form-control col-lg-12" required="required" />
                   			<input type="hidden" id="school_id" name="school_id" required="required" class="form-control col-lg-12" />
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" >Class<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="class_name" name="class_name" class="form-control col-lg-12" />
						</div>
					</div>
					<div class="form-group">
                    	<label class="control-label col-md-2 col-sm-2 col-xs-6">Class Roll No<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="class_roll_no" name="class_roll_no" required class="form-control col-lg-12" />
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Bitti/Upobitti ID<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="identy_no" name="identy_no" class="form-control col-lg-12" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Mobile No</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="mobile_no" name="mobile_no" class="form-control col-lg-12"/>
						</div>						
                        <label class="control-label col-md-2 col-sm-2 col-xs-6">Upazilla</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="upazilla" name="upazilla"  class="form-control col-lg-12" />
						</div>						
					</div>
                    <div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Zilla</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="zilla" name="zilla"  class="form-control col-lg-12" />
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Division</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="division" name="division"  class="form-control col-lg-12" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Address</label>
						<div class="col-md-10 col-sm-10 col-xs-12">							
							<input type="text" id="address" name="address" class="form-control col-lg-12"/>
						</div>
					</div>					
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">User Name<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="user_name" name="user_name" required class="form-control col-lg-12"/>
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Password</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="password" id="password" name="password" class="form-control col-lg-12"/>
						</div>
					</div>
                    <div class="form-group">
                    	<label class="control-label col-md-2 col-sm-2 col-xs-6" >Health Card No</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="health_card_no" name="health_card_no" class="form-control col-lg-12" <?php if($user_type==4) echo "readonly"; ?> />
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" >Is Active<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="checkbox" id="is_active" checked="checked" name="is_active" checked="checked" class="form-control col-lg-12"/>
						</div>
					</div>		
					<div class="ln_solid"></div>
				</div>
				<div class="col-md-3">
					<img src="<?php echo $activity_url ?>images/no_image.png" width="70%" height="70%" class="img-thumbnail" id="student_img">
					<input type="file" name="student_image_upload" id="student_image_upload">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<input type="hidden" id="master_id" name="master_id"/>    
					<button type="submit" id="save_student_info" class="btn btn-success">Save</button>                    
					<button type="button" id="clear_button" class="btn btn-primary">Clear</button>                         
				</div>
				 <div class="col-md-7 col-sm-7 col-xs-12">
					<div id="form_submit_error" class="text-center" style="display:none"></div>
				 </div>
			</div>
		</form>  
    </div>
</div>
<?php
	} 
?>
<script src="js/customTable.js"></script> 
<script>
//------------------------------------- general & UI  --------------------------------------
/*
develped by @momit
=>load grid with paging
=>search records
*/
$(document).ready(function () {	
	
	// close form submit section onload page
	var x_panel = $('#iniial_collapse').closest('div.x_panel');
	var button = $('#iniial_collapse').find('i');
	var content = x_panel.find('div.x_content');
	content.slideToggle(200);
	(x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
	(x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
	button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
	setTimeout(function () {
		x_panel.resize();
	}, 50);

	// collaps button function
	$('.collapse-link').click(function () {
		var x_panel = $(this).closest('div.x_panel');
		var button = $(this).find('i');
		var content = x_panel.find('div.x_content');
		content.slideToggle(200);
		(x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
		(x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
		button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
		setTimeout(function () {
			x_panel.resize();
		}, 50);
	})
	
	// close form submit section onload page
	var x_panel = $('#iniial_collapse_adv').closest('div.x_panel');
	var button = $('#iniial_collapse').find('i');
	var content = x_panel.find('div.x_content');
	content.slideToggle(200);
	(x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
	(x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
	button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
	setTimeout(function () {
		x_panel.resize();
	}, 50); 
	
	// collaps button function
	$('.collapse-link-adv').click(function (){
		var x_panel = $(this).closest('div.x_panel');
		var button = $(this).find('i');
		var content = x_panel.find('div.x_content');
		content.slideToggle(200);
		(x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
		(x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
		button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
		setTimeout(function () {
			x_panel.resize();
		}, 50);
	}) 

		
	// icheck for the inputs
	$('#student_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});	
	
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});
	
});
<!-- ------------------------------------------end --------------------------------------->


//------------------------------------- grid table codes --------------------------------------
/*
develped by @momit
=>load grid with paging
=>search records
*/
$(document).ready(function () {	

	var user_type = "<?php echo $user_type; ?>";
	// initialize page no to "1" for paging
	var current_page_no=1;	
	load_student_grid = function load_student_grid(search_txt){
		$("#search_student_button").toggleClass('active');		 
		var student_Table_length =parseInt($('#student_Table_length').val());
		var std_name 	= $("#std_name").val();	
		var sch_name 	= $("#sch_name").val();
		var std_address = $("#std_address").val();	
		var std_class   = $("#std_class").val();	
		var std_upazilla= $("#std_upazilla").val();	
		var std_zilla   = $("#std_zilla").val();	
		var std_division= $("#std_division").val();	
		var tch_id      = $("#tch_id").val();	
		var tch_name    = $("#tch_name").val();	
		
		var std_active_status = $("input[name=is_active_status]:checked").val(); 	
		var is_hcrd_issued = $("input[name=is_hcrd_issued]:checked").val();
				
		$.ajax({
			url: project_url+"controller/studentController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
					  q: "grid_data",
			  std_name : std_name,
			  sch_name : sch_name,
		is_hcrd_issued : is_hcrd_issued,
			 std_class : std_class,
		   std_address : std_address,
		   std_upazilla: std_upazilla,
			std_zilla  : std_zilla,
		 std_division  : std_division,
	 std_active_status : std_active_status,
				tch_id : tch_id,
			  tch_name : tch_name,
			search_txt : search_txt,
				 limit : student_Table_length,
			   page_no :current_page_no			   
			},
			success: function(data){
				var html = "";
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $user_name; ?>";
				
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";
					if(std_active_status == 1)   serach_areas += "Active <br>";
					if(std_active_status == 0)   serach_areas += "In-Active <br>";
					if(is_hcrd_issued == 1)      serach_areas += "Health Card Holder <br>";
					if(is_hcrd_issued == 0)      serach_areas += "No Health Card <br>";
					if(sch_name != "")   	     serach_areas += "School: "+sch_name+"  <br>";	
					if(tch_name != "")   	     serach_areas += "Teacher: "+tch_name+"  <br>";	
					if(std_class != "")   	     serach_areas += "Class: "+std_class+"  <br>";					
					if(std_upazilla != "")       serach_areas += "Upazilla: "+std_upazilla+"  <br>";
					if(std_zilla != "")   	     serach_areas += "Zilla: "+std_zilla+"  <br>";
					if(std_division != "")       serach_areas += "Division: "+std_division;
					/*<input name="print" type="button" value="Print" id="printBTN" onClick="printpage();" />*/
					if(user_type == 1)	  printed_by_type = "(Admin)";	
					else if(user_type == 4) printed_by_type = "(Teacher)";	
										
					html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">Student Information Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+printed_by_type+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
						html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:left">Name</th><th style="text-align:left">School Name</th><th style="text-align:center">Age</th><th style="text-align:left">Class</th><th style="text-align:center">Class Roll</th><th style="text-align:center">Health Card No</th><th style="text-align:center">Bitti/Upobitti ID</th><th style="text-align:center">Mobile No</th><th style="text-align:left">Address</th></tr></thead><tbody>';
						
						$.each(data.records, function(i,data){  
							html += "<tr>";				
							html +="<td style='text-align:left'>"+data.name+"</td>";
							html +="<td style='text-align:left'>"+data.school_name+"</td>";
							html +="<td style='text-align:center'>"+data.age+"</td>";
							html +="<td style='text-align:left'>"+data.class+"</td>";
							html +="<td style='text-align:center'>"+data.class_roll_no+"</td>";
							html +="<td style='text-align:center'>"+data.health_card_no+"</td>";
							html +="<td style='text-align:center'>"+data.identy_no+"</td>";
							html +="<td style='text-align:center'>"+data.mobile_no+"</td>";
							html +="<td style='text-align:left'>"+data.address+"</td>";
							html += '</tr>';
						});
						html +="</tbody></table>"
					}
					else{
						html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";	
					}
					WinId = window.open("", "Student Report","width=950,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
				}
				else{
					if(user_type != 4 && user_type != 1){
						$('.employee_entry_cl').hide();
					}
					// for  showing grid's no of records from total no of records 
					show_record_no(current_page_no, student_Table_length, data.total_records )
					
					var total_pages = data.total_pages;	
					var records_array = data.records;
					$('#student_Table tbody tr').remove();					
					if(!jQuery.isEmptyObject(records_array)){
						// create and set grid table row
						var colums_array=["image*image*"+project_url,"id*identifier*hidden", "name","school_name","class","class_roll_no","health_card_no","identy_no","address","mobile_no*center"];
						// first element is for view , edit condition, delete condition
						// "all" will show /"no" will show nothing
						var condition_array=["","","all", "","delete_status","1"];
						// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );

						// cauton: not posssible to use multiple grid in same page					
						create_set_grid_table_row(records_array,colums_array,condition_array,"student","student_Table", 0);
						// show the showing no of records and paging for records 
						$('#student_table_biv').show();					
						// code for dynamic pagination 				
						paging(total_pages, current_page_no, "student_Table" );					
					}
					// if the table has no records / no matching records 
					else{
						grid_has_no_result("student_Table",10);
					}
				}
				$("#search_student_button").toggleClass('active');				
			}
		});	
	}
	
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_student_field").val();
			load_student_grid(search_txt)
		}
	}	
	// function after click search button 
	$('#search_student_button').click(function(){
		var search_txt = $("#search_student_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_student_grid(search_txt)
		// if there is lot of data and it tooks lot of time please add the below condition
		/*
		if(search_txt.length>3){
			load_student_grid(search_txt)	
		}
		*/
	});
	//function after press "enter" to search	
	$('#search_student_field').keypress(function(event){
		var search_txt = $("#search_student_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_student_grid(search_txt)
		}
	})
	

	$("#school_list").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getSchools",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3,
        select: function(event, ui) { 
			var job_id = ui.item.id;
			$('#school_id').val(job_id);
		}
	});
	
	
	$("#tch_name").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getTeachers",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3,
        select: function(event, ui) { 
			var tch_id = ui.item.id;
			$('#tch_id').val(tch_id);
		}
	});
	
	$("#sch_name").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getSchoolNames",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3
	});
	$("#upazilla, #std_upazilla ").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getStudentUpazillas",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3
	});
	$("#zilla, #std_zilla").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getStudentZillas",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3
	});
	
	$("#division, #std_division").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getStudentDivisions",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3
	});	
	
	$("#health_card_no").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getUnusedCards",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3,
	});



	// load data initially on page load with paging
	load_student_grid("");
});


<!-- ------------------------------------------end --------------------------------------->


<!-- -------------------------------Form related functions ------------------------------->

/*
develped by @momit
=>form submition for add/edit
=>clear form
=>load data to edit
=>delete record
=>view 
*/
$(document).ready(function () {		
	var url = project_url+"controller/studentController.php";

	// save and update for public post/notice
	$('#save_student_info').click(function(event){		
		event.preventDefault();
		var formData = new FormData($('#student_form')[0]);
		formData.append("q","insert_or_update");
		if($.trim($('#student_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Name","#student_name");			
		}
		else if($.trim($('#class_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Class Name","#class_name");
		}
		else if($.trim($('#school_list').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert School Name","#school_list");
		}
		else if($.trim($('#identy_no').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Bitti/Upobitti No","#identy_no");
		}
		else if($.trim($('#user_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert User Name","#user_name");
		}
		else{
		//	$('#save_student_info').attr('disabled','disabled');
			$.ajax({
				url: url,
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_student_info').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && (data==1 || data==2)){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_student_grid("");
						clear_form();
					}
					else if($.isNumeric(data)==true && data==3){
						success_or_error_msg('#form_submit_error',"danger","You are not authorized to save a student");			
					}
					else{
						if(data == "img_error")
							success_or_error_msg('#form_submit_error',"danger",not_saved_msg_for_img_ln);
						else	
							success_or_error_msg('#form_submit_error',"danger","Not Saved...");												
					}
				 }	
			});
		}	
	})	
	//advance search
	$('#adv_search_button').click(function(){
		load_student_grid("Advance_search");
	});
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_student_grid("Print");
	});
	
	
	// clear function to clear all the form value
	clear_form = function clear_form(){			 
		$('#master_id').val('');
		$('#school_id').val('');
		$("#student_form").trigger('reset');		
		$('#student_img').attr("width", "0%");
		$('#student_img').attr("src",project_url+"images/no_image.png");
		$('#student_img').attr("width", "70%","height","70%");
		$('#img_url_to_copy').val("");
		$('#student_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
		$("#student_form .tableflat").iCheck('uncheck');
		$('#save_student_info').html('Save');
	}
	
	// on select clear button 
	$('#clear_button').click(function(){
		clear_form();
	});
	
	delete_student = function delete_student(student_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: url,
				type:'POST',
				async:false,
				data: "q=delete_student&student_id="+student_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_student_grid("");
					}
					else{
						success_or_error_msg('#page_notification_div',"danger","Not Deleted...");						
					}
				 }	
			});
		} 	
	}

	edit_student = function edit_student(student_id){
		$.ajax({
			url: project_url+"controller/studentController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_student_details",
				student_id: student_id
			},
			success: function(data){				
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){ 					
						$('#master_id').val(data.id);
						$('#student_name').val(data.name);
						$('#user_name').val(data.username);
						$('#address').val(data.address);
						$('#class_name').val(data.class);
						$('#age').val(data.age);
						$('#identy_no').val(data.identy_no);
						$('#health_card_no').val(data.health_card_no);
						$('#mobile_no').val(data.mobile_no);
						$('#school_id').val(data.school_id);
						$('#school_list').val(data.school_name);
						$('#upazilla').val(data.upazilla);
						$('#zilla').val(data.zilla);
						$('#division').val(data.division);
						$('#class_roll_no').val(data.class_roll_no);					
						$('#student_img').attr("src",project_url+data.image);
						$('#student_img').attr("width", "70%","height","70%");						 
						if(data.status==1)
							$('#is_active').iCheck('check'); 
						
						//change button value 
						$('#save_student_info').html('Update');
						
						// to open submit post section
						if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
							$( "#toggle_form" ).trigger( "click" );						
					});
				}
			}	
		});		
	}	 		
});


<!-- ------------------------------------------end --------------------------------------->
</script>