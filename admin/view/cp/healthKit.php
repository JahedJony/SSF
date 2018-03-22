<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
$user_name = $_SESSION['user_name'];

?>

<div class="x_panel">
    <div class="x_title">
        <h2>Health Kit</h2>
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
						<a class="collapse-link-adv" id="toggle_form_ad"><b><small class="text-primary">Advance Search & Report</small></b><i class="fa fa-chevron-down"></i></a>
					</li>
				</ul>
			</div>
			<div class="x_content adv_cl" id="iniial_collapse_adv">
				<div class="row advance_search_div alert alert-warning">
					<div class="row">	
						<div class="col-md-6">
							<label class="control-label col-md-8 col-sm-8 col-xs-6"></label>
							<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">All List</label>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<input type="checkbox" id="all_list" name="all_list" checked="checked"/>
							</div>
						</div>
						<div class="col-md-6" style="text-align:left">					
							<button type="button" class="btn btn-info" id="adv_search_button"><i class="fa fa-lg fa-search"></i></button>
                            <button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"></i></button>
						</div>
					</div>
				</div> 
			</div>
		</div>
		<!-- Adnach search end -->
		
    	<div class="dataTables_length">
        	<label>Show 
                <select size="1" style="width: 56px;padding: 6px;" id="health_kit_Table_length" name="health_kit_Table_length" aria-controls="health_kit_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="health_kit_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_health_kit_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_health_kit_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="health_kit_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead >
                <tr class="headings">
                    <th class="column-title" width="30%">ID</th>
                    <th class="column-title" width="60%">NAME</th>
					<th class="column-title no-link last" width="10%"><span class="nobr"></span></th>	
                </tr>
            </thead>
            <tbody id="health_kit_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="health_kit_Table_div">
            <div class="dataTables_info" id="health_kit_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="health_kit_Table_paginate">
            </div> 
        </div>  
    </div>
</div>

<div class="x_panel activity_entry_cl">
    <div class="x_title">
        <h2>Health Kit Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">		
		<form method="POST"  id="health_kit_form" name="health_kit_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="col-md-12">	
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Name<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="name" name="name" class="form-control col-lg-12"/>
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							 <input type="hidden" id="master_id" name="master_id" />    
							 <button  type="submit" id="save_health_kit" class="btn btn-success">Save</button>                    
							 <button type="button" id="clear_button"  class="btn btn-primary">Clear</button>                         
						</div>
						 <div class="col-md-7 col-sm-7 col-xs-12">
							<div id="form_submit_error" class="text-center" style="display:none"></div>
						 </div>
					</div>
				</div>
			</div>
		</form>  
    </div>
</div>

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

	//datepicker
	$('.date-picker').daterangepicker({
		singleDatePicker: true,
		calender_style: "picker_3",
		locale: {
			  format: 'YYYY-MM-DD',
			  separator: " - ",
		}
	});

	// icheck for the inputs
	$('#health_kit_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});	
	
	$('#all_list').iCheck({
		checkboxClass: 'icheckbox_flat-green'
		//radioClass: 'iradio_flat-green'
	});
	
});
<!-- ------------------------------------------end --------------------------------------->
$(document).ready(function () {	
	var current_page_no=1;	
	load_health_kits = function load_health_kits(search_txt){
		$("#search_health_kit_button").toggleClass('active');
		var health_kit_Table_length = parseInt($('#health_kit_Table_length').val());	
		
		$.ajax({
			url: project_url+"controller/healthKitController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "health_kit_grid_data",
				search_txt: search_txt,
				limit:health_kit_Table_length,
				page_no:current_page_no
			},
			success: function(data) {
				var html = "";
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $user_name; ?>";
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";

					/*<input name="print" type="button" value="Print" id="printBTN" onClick="printpage();" />*/
					
					html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">Health Kit Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
						html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:left">School Name</th><th style="text-align:left">School Code</th><th style="text-align:left">Address</th></tr></thead><tbody>';
						
						$.each(data.records, function(i,data){  
							html += "<tr>";				
							html +="<td style='text-align:left'>"+data.service_name+"</td>";							
							html += '</tr>';
						});
						html +="</tbody></table>"
					}
					else{
						html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";	
					}
					
					//alert(html)
					WinId = window.open("", "Health Kit Report","width=950,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
				}
				else{
					// for  showing grid's no of records from total no of records 
					show_record_no(current_page_no, health_kit_Table_length, data.total_records )
					
					var total_pages = data.total_pages;	
					var records_array = data.records;
					$('#health_kit_Table tbody tr').remove();
					
					if(!jQuery.isEmptyObject(records_array)){
						// create and set grid table row
						var colums_array=["id*identifier","service_name"];
						// first element is for view , edit condition, delete condition
						// "all" will show /"no" will show nothing
						var condition_array=["","","all", "","",""];
						// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
						// cauton: not posssible to use multiple grid in same page					
						create_set_grid_table_row(records_array,colums_array,condition_array,"health_kit","health_kit_Table", 0);
						// show the showing no of records and paging for records 
						$('#health_kit_Table_div').show();					
						// code for dynamic pagination 				
						paging(total_pages, current_page_no, "health_kit_Table" );					
					}
					// if the table has no records / no matching records 
					else{
						grid_has_no_result( "health_kit_Table",8);
					}
				}
				$("#search_health_kit_button").toggleClass('active');
			}
		});	
	}
	
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_health_kit_field").val();
			load_health_kits(search_txt)
		}
	}	
	
	// function after click search button 
	$('#search_health_kit_button').click(function(){
		var search_txt = $("#search_health_kit_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_health_kits(search_txt);		
	});
	
	//function after press "enter" to search	
	$('#search_health_kit_field').keypress(function(event){
		var search_txt = $("#search_health_kit_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_health_kits(search_txt)
		}
	})

	// load data initially on page load with paging
	load_health_kits("");
	
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
	
	//advance search
	$('#adv_search_button').click(function(){
		load_health_kits("Advance_search");
	});
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_health_kits("Print");
	});
	
	//insert health_kit
	$('#save_health_kit').click(function(event){  
		event.preventDefault();
		var formData = new FormData($('#health_kit_form')[0]);
		formData.append("q","insert_or_update_healthKit");
		//validation 
		if($.trim($('#name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Insert Health Kit Name","#name");			
		}
		else{
			$.ajax({
				url: project_url+"controller/healthKitController.php",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_health_kit').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_health_kits("");
						clear_form();
					}
				 }	
			});
			
		}	
	})
	
	//edit health_kit
	edit_health_kit = function edit_health_kit(master_id){
		$.ajax({
			url: project_url+"controller/healthKitController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_health_kit_details",
				master_id: master_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){
						//alert(data.status)
						$('#name').val(data.service_name);
						$('#master_id').val(data.id);
						
						$('#save_health_kit').html('Update');
						// to open submit post section
						if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
						$( "#toggle_form" ).trigger( "click" );	
					});				
				}
			}
		});	
	}
	
	clear_form = function clear_form(){			 
		$('#master_id').val('');
		$("#health_kit_form").trigger('reset');
		$('#health_kit_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
		$('#save_health_kit').html('Save');
	}
	
	$('#clear_button').click(function(){
		clear_form();
	});
	
});





</script>