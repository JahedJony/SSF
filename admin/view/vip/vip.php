<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(15) != 1){
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
        <h2>VIP List</h2>
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
						<a class="collapse-link-adv" id="toggle_form_adv"><b><small class="text-primary">Advance Search & Report</small> </b><i class="fa fa-chevron-down"></i></a>
					</li>
				</ul>
			</div>
			<div class="x_content adv_cl" id="iniial_collapse_adv">
				<div class="row advance_search_div alert alert-warning">
                    <div class="row">
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Upazilla</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="adv_upazilla" id="adv_upazilla"/> 
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">District</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="adv_district" id="adv_district"/> 
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Division</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="adv_division" id="adv_division"/> 
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Address</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="adv_address" id="adv_address"/> 
						</div>
					</div>
					<br/>
					<div class="row">
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Desgination</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="adv_designation" id="adv_designation"/> 
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">Institution</label>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<input class="form-control input-sm" type="text" name="adv_sch_name" id="adv_sch_name"/> 
						</div>
						<label class="control-label col-md-1 col-sm-2 col-xs-4" style="text-align:right">Active</label>
						<div class="col-md-2 col-sm-2 col-xs-8">
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="1"/> Yes
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="0" /> No
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="2" checked="CHECKED"/> All
						</div>
						<label class="control-label col-md-1 col-sm-2 col-xs-4" style="text-align:right">Health Card</label>
						<div class="col-md-2 col-sm-2 col-xs-8">
							<input type="radio" class="flat_radio" name="health_card_status" id="health_card_status" value="1"/> Yes
							<input type="radio" class="flat_radio" name="health_card_status" id="health_card_status" value="0" /> No
							<input type="radio" class="flat_radio" name="health_card_status" id="health_card_status" value="2" checked="CHECKED"/> All
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
                <select size="1" style="width: 56px;padding: 6px;" id="vip_Table_length" name="vip_Table_length" aria-controls="vip_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="vip_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_vip_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_vip_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="vip_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead>
                <tr class="headings">
					<th class="column-title" width="5%"></th>
                    <th class="column-title" width="10%">Name</th>
                    <th class="column-title" width="20%">Institution</th>
					<th class="column-title" width="10%">Health Card</th>
                    <th class="column-title" width="10%">Date of Birth</th>
                    <th class="column-title" width="10%">NID</th>
					<th class="column-title" width="15%">Address</th>
                    <th class="column-title" width="10%">Email</th>
                    <th class="column-title" width="10%">Contact No</th>
                    <th class="column-title no-link last" width="100"><span class="nobr"></span></th>
                </tr>
            </thead>
            <tbody id="vip_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="vip_table_biv">
            <div class="dataTables_info" id="vip_Table_info">Showing <span id="from_to_limit"></span> of <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="vip_Table_paginate">
            </div> 
        </div>  
    </div>
</div>

<div class="x_panel employee_entry_cl">
    <div class="x_title">
        <h2>VIP Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">
        <br />         		
		<form method="post"  id="vip_form" name="vip_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Full Name<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-12">							
							<input type="text" id="vip_name" name="vip_name" required class="form-control col-lg-12"/>
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Designation</label>
						<div class="col-md-4 col-sm-4 col-xs-12">							
							<input type="text" id="designation" name="designation" required class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-6">Date Of Birth</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input id="dob" name="dob" placeholder="Click To Select Date" class="date-picker form-control col-lg-12" type="text">
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6">National ID</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="nid_no" name="nid_no" required class="form-control col-lg-12" />
						</div>
					</div>                                    
                    <div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6" >Institution Name</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
                            <input type="text" id="school_list" name="school_list" class="form-control col-lg-12" required="required" />
                   			<input type="hidden" id="school_id" name="school_id" required="required" class="form-control col-lg-12" />
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Upazilla</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="upazilla" name="upazilla"  class="form-control col-lg-12" />
						</div>
					</div>                    
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">District</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="district" name="district"  class="form-control col-lg-12" />
						</div>
			        	<label class="control-label col-md-2 col-sm-2 col-xs-6">Division</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="division" name="division"  class="form-control col-lg-12" />
						</div>			
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Address</label>
						<div class="col-md-10 col-sm-10 col-xs-6">
							<input type="text" id="address" name="address"  class="form-control col-lg-12" />
						</div>		
					</div>	
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Email</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="email" name="email"  class="form-control col-lg-12" />
						</div>
                        <label class="control-label col-md-2 col-sm-2 col-xs-6">Contact No</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="mobile_no" name="mobile_no" required class="form-control col-lg-12"/>
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
                    	<label class="control-label col-md-2 col-sm-2 col-xs-6">Health Card No</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
                            <input type="text" id="health_card_no" name="health_card_no" class="form-control col-lg-12" />
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" >Is Active</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="checkbox" id="is_active" name="is_active" checked="checked" class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="ln_solid"></div>
				</div>
				<div class="col-md-3">
					<img src="<?php echo $activity_url ?>images/no_image.png" width="70%" height="70%" class="img-thumbnail" id="vip_img">
					<input type="file" name="vip_image_upload" id="vip_image_upload">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<input type="hidden" id="master_id" name="master_id"/>    
					<button type="submit" id="save_vip_info" class="btn btn-success">Save</button>                    
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

	// icheck for the inputs
	$('#vip_form').iCheck({
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
	// initialize page no to "1" for paging
	var current_page_no=1;	
	load_vip_grid = function load_vip_grid(search_txt){
		$("#search_vip_button").toggleClass('active');		 
		var vip_Table_length =parseInt($('#vip_Table_length').val());
		var name = $("#adv_name").val();	
		var designation = $("#adv_designation").val();	
		var school_name = $("#adv_sch_name").val();		
		var upazilla = $("#adv_upazilla").val();	
		var district = $("#adv_district").val();	
		var division = $("#adv_division").val();	
		var address = $("#adv_address").val();	
		var nid_no = $("#adv_nid").val();	
		var mobile_no = $("#adv_mobile_no").val();	
		var active_status = $("input[name=is_active_status]:checked").val();
		var health_card_status = $("input[name=health_card_status]:checked").val();
		
		$.ajax({
			url: project_url+"controller/vipController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				designation: designation,
				school_name: school_name,
				active_status:active_status,
				health_card_status: health_card_status,
				upazilla:upazilla,
				district:district,
				division:division,
				address:address,
				search_txt: search_txt,
				limit:vip_Table_length,
				page_no:current_page_no
			},
			success: function(data){
				var html = "";
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $user_name; ?>";
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";
					
					if(active_status == 1)   	serach_areas += "Active <br>";
					if(active_status == 0)   	serach_areas += "In-Active <br>";
					
					if(health_card_status == 1) serach_areas += "Health Card Holder<br>";
					if(health_card_status == 0)	serach_areas += "No Health Card<br>";
					
					if(school_name != "")   	serach_areas += "School: "+school_name+"  <br>";					
					if(upazilla != "")   		serach_areas += "Upazilla: "+upazilla+"  <br>";
					if(district != "")   	  	serach_areas += "District: "+district+"  <br>";
					if(division != "")   	  	    serach_areas += "Division: "+division+"  <br>";
					if(designation != "")   		serach_areas += "Designation: "+designation;
					/*<input name="print" type="button" value="Print" id="printBTN" onClick="printpage();" />*/
					
					html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">VIP Information Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
						html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:left">Name</th><th style="text-align:left">Designation</th><th style="text-align:left">School Name</th><th style="text-align:left">Upazilla</th><th style="text-align:left">District</th><th style="text-align:left">Division</th><th style="text-align:left">Address</th><th style="text-align:center">HealthCard</th><th style="text-align:center">NID</th><th style="text-align:center">DOB</th><th style="text-align:center">Mobile</th><th style="text-align:left">Email</th></tr></thead><tbody>';
						
						$.each(data.records, function(i,data){  
							html += "<tr>";				
							html +="<td style='text-align:left'>"+data.name+"</td>";							
							html +="<td style='text-align:left'>"+data.designation+"</td>";							
							html +="<td style='text-align:left'>"+data.school_name+"</td>";
							html +="<td style='text-align:left'>"+data.upazilla+"</td>";
							html +="<td style='text-align:left'>"+data.district+"</td>";
							html +="<td style='text-align:left'>"+data.division+"</td>";
							html +="<td style='text-align:left'>"+data.address+"</td>";
							html +="<td style='text-align:center'>"+data.health_card_no+"</td>";
							html +="<td style='text-align:center'>"+data.nid_no+"</td>";
							html +="<td style='text-align:center'>"+data.dob+"</td>";
							html +="<td style='text-align:center'>"+data.mobile_no+"</td>";
							html +="<td style='text-align:left'>"+data.email+"</td>";
							html += '</tr>';
						});
						html +="</tbody></table>"
					}
					else{
						html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";	
					}
					
					//alert(html)
					WinId = window.open("", "VIP Information Report","width=950,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
				}
				else{
					if(data.entry_status==0){
						$('.employee_entry_cl').hide();
					}
					// for  showing grid's no of records from total no of records 
					show_record_no(current_page_no, vip_Table_length, data.total_records )
					
					var total_pages = data.total_pages;	
					var records_array = data.records;
					$('#vip_Table tbody tr').remove();
					if(!jQuery.isEmptyObject(records_array)){
						// create and set grid table row
						var colums_array=["image*image*"+project_url,"id*identifier*hidden", "name","school_name","health_card_no","dob","nid_no","email","address","mobile_no*center"];			
						// first element is for view , edit condition, delete condition
						// "all" will show /"no" will show nothing
						var condition_array=["","","update_status", "1","delete_status","1"];
						// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
						// cauton: not posssible to use multiple grid in same page					
						create_set_grid_table_row(records_array,colums_array,condition_array,"vip","vip_Table", 0);
						// show the showing no of records and paging for records 
						$('#vip_table_biv').show();					
						// code for dynamic pagination 				
						paging(total_pages, current_page_no, "vip_Table" );					
					}
					// if the table has no records / no matching records 
					else{
						grid_has_no_result("vip_Table",13);
					}
				}
				$("#search_vip_button").toggleClass('active');		
			}
		});	
	}	
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_vip_field").val();
			load_vip_grid(search_txt)
		}
	}	
	// function after click search button 
	$('#search_vip_button').click(function(){
		var search_txt = $("#search_vip_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_vip_grid(search_txt)
		// if there is lot of data and it tooks lot of time please add the below condition
		/*
		if(search_txt.length>3){
			load_vip_grid(search_txt)	
		}
		*/
	});
	//function after press "enter" to search	
	$('#search_vip_field').keypress(function(event){
		var search_txt = $("#search_vip_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_vip_grid(search_txt)
		}
	})
	
	
	$('.date-picker').daterangepicker({
		singleDatePicker: true,
		calender_style: "picker_3",
		locale: {
			  format: 'YYYY-MM-DD',
			  separator: " - ",
		}
	});
	
	/*Auto Suggest*/	
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
	
	$("#adv_sch_name").autocomplete({
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
	
	$("#upazilla, #adv_upazilla ").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getFemaleUpazillas",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3
	});
	
	$("#district, #adv_district").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getFemaleDistricts",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3
	});
	
	$("#division, #adv_division").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "getFemalePosts",
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
	load_vip_grid("");
	//load_school();

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
	var url = project_url+"controller/vipController.php";

	//advance search
	$('#adv_search_button').click(function(){
		load_vip_grid("Advance_search");
	});
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_vip_grid("Print");
	});
	
	// save and update for public post/notice
	$('#save_vip_info').click(function(event){		
		event.preventDefault();
		var formData = new FormData($('#vip_form')[0]);
		formData.append("q","insert_or_update");
		if($.trim($('#vip_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Name","#vip_name");			
		}
		else if($.trim($('#user_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert User Name","#user_name");
		}
		else{
		//	$('#save_vip_info').attr('disabled','disabled');
			$.ajax({
				url: url,
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_vip_info').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_vip_grid("");
						clear_form();
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
	
	// clear function to clear all the form value
	clear_form = function clear_form(){			 
		$('#master_id').val('');
		$("#vip_form").trigger('reset');		
		$('#vip_img').attr("width", "0%");
		$('#vip_img').attr("src",project_url+"images/no_image.png");
		$('#vip_img').attr("width", "70%","height","70%");
		$('#img_url_to_copy').val("");
		$('#vip_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
		$("#vip_form .tableflat").iCheck('uncheck');
		$('#save_vip_info').html('Save');
	}
	
	// on select clear button 
	$('#clear_button').click(function(){
		clear_form();
	});
	
	delete_vip = function delete_vip(vip_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: url,
				type:'POST',
				async:false,
				data: "q=delete_vip&vip_id="+vip_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_vip_grid("");
					}
					else{
						success_or_error_msg('#page_notification_div',"danger","Not Deleted...");						
					}
				 }	
			});
		} 	
	}

	edit_vip = function edit_vip(vip_id){
		//alert("Yes");
		$.ajax({
			url: project_url+"controller/vipController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_vip_details",
				vip_id: vip_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){ 					
						$('#master_id').val(data.id);
						$('#vip_name').val(data.name);
						$('#user_name').val(data.username);
						$('#designation').val(data.designation);
						$('#address').val(data.address);
						$('#mobile_no').val(data.mobile_no);
						$('#school_id').val(data.school_id);
						$('#school_list').val(data.school_name);
						$('#dob').val(data.dob);
						$('#email').val(data.email);
						$('#nid_no').val(data.nid_no);
						$('#upazilla').val(data.upazilla);
						$('#division').val(data.division);
						$('#district').val(data.district);
						$('#health_card_no').val(data.health_card_no);
						
						$('#vip_img').attr("src",project_url+data.image);
						$('#vip_img').attr("width", "70%","height","70%");
						 
						if(data.status==1)
							$('#is_active').iCheck('check'); 
						
						//change button value 
						$('#save_vip_info').html('Update');
						
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