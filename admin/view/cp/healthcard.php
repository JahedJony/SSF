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
        <h2>Health Card</h2>
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
				<div class="row advance_search_div">
                    <div class="row alert alert-warning">
						<label class="control-label col-md-1 col-sm-2 col-xs-4">Active</label>
						<div class="col-md-5 col-sm-4 col-xs-8">
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="Active"/> Yes
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="In-active" /> No
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="All" checked="CHECKED"/> All
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-4">Health Card</label>
						<div class="col-md-4 col-sm-4 col-xs-8">
							<input type="radio" class="flat_radio" name="health_card_status" id="health_card_status" value="Unavailable"/> Used
							<input type="radio" class="flat_radio" name="health_card_status" id="health_card_status" value="Available" /> Available
							<input type="radio" class="flat_radio" name="health_card_status" id="health_card_status" value="All" checked="CHECKED"/> All
						</div>
						<br/><br/>
						<div class="col-md-12" style="text-align:center">					
							<button type="button" class="btn btn-info" id="adv_search_button"><i class="fa fa-lg fa-search"></i></button>
                            <button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"></i></button>
						</div>
					</div>
				</div> 
			</div>
		</div>
		<!-- Advance search end -->
		
    	<div class="dataTables_length">
        	<label>Show 
                <select size="1" style="width: 56px;padding: 6px;" id="healthcard_Table_length" name="healthcard_Table_length" aria-controls="healthcard_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="healthcard_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_healthcard_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_healthcard_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="healthcard_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead >
                <tr class="headings">
                    <th class="column-title" width="30%">Health Card</th>
                    <th class="column-title" width="20%">Availability</th>
                    <th class="column-title" width="">Assigned To</th>
                    <th class="column-title" width="10%">Status</th> 
					<th class="column-title no-link last" width="10%"><span class="nobr"></span></th>	
                </tr>
            </thead>
            <tbody id="healthcard_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="healthcard_Table_div">
            <div class="dataTables_info" id="healthcard_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="healthcard_Table_paginate">
            </div> 
        </div>  
    </div>
</div>

<div class="x_panel activity_entry_cl">
    <div class="x_title">
        <h2>Health Card Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">		
		<form method="POST"  id="healthcard_form" name="healthcard_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="col-md-12">	
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="name">Health Card</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="healthcard_no" name="healthcard_no" class="form-control col-lg-12"/>
						</div>
					</div>				
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6" for="name">Is Active</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="checkbox" id="is_active" name="is_active" class="form-control col-lg-12" checked="checked"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							 <input type="hidden" id="healthcard_id" name="healthcard_id" />    
							 <button  type="submit" id="save_healthcard" class="btn btn-success">Save</button>                    
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
	$('#healthcard_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});	
		
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});
	
});
<!-- ------------------------------------------end --------------------------------------->
$(document).ready(function () {	
	var current_page_no=1;	
	load_healthcards = function load_healthcards(search_txt){
		$("#search_healthcard_button").toggleClass('active');
		var healthcard_Table_length = parseInt($('#healthcard_Table_length').val());
		var active_status = $("input[name=is_active_status]:checked").val(); 	
		var health_card_status = $("input[name=health_card_status]:checked").val();	
		$.ajax({
			url: project_url+"controller/healthcardController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				search_txt: search_txt,
				active_status: active_status,
				health_card_status: health_card_status,
				limit:healthcard_Table_length,
				page_no:current_page_no
			},
			success: function(data) {
				$('#healthcard_no').val(data.set_healthcard_no);
				var html = "";
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $user_name; ?>";
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";

					/*<input name="print" type="button" value="Print" id="printBTN" onClick="printpage();" />*/
					
					html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">Health Card Information Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
						html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:left">Health Card No</th><th style="text-align:left">Availability</th><th style="text-align:left">Assigned To</th><th style="text-align:left">Status</th></tr></thead><tbody>';
						
						$.each(data.records, function(i,data){  
							html += "<tr>";				
							html +="<td style='text-align:left'>"+data.card_no+"</td>";							
							html +="<td style='text-align:left'>"+data.availability+"</td>";
							html +="<td style='text-align:left'>"+data.assigned_to+"</td>";
							html +="<td style='text-align:left'>"+data.active_status+"</td>";
							html += '</tr>';
						});
						html +="</tbody></table>"
					}
					else{
						html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";	
					}
					
					//alert(html)
					WinId = window.open("", "Health Card Report","width=950,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
				}
				else{
					// for  showing grid's no of records from total no of records 
					show_record_no(current_page_no, healthcard_Table_length, data.total_records )
					
					var total_pages = data.total_pages;	
					var records_array = data.records;
					$('#healthcard_Table tbody tr').remove();
					if(!jQuery.isEmptyObject(records_array)){
						// create and set grid table row
						var colums_array=["id*identifier*hidden","card_no","availability","assigned_to","active_status"];
						// first element is for view , edit condition, delete condition
						// "all" will show /"no" will show nothing
						var condition_array=["","","all", "","",""];
						// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
						// cauton: not posssible to use multiple grid in same page					
						create_set_grid_table_row(records_array,colums_array,condition_array,"healthcard","healthcard_Table", 0);
						// show the showing no of records and paging for records 
						$('#healthcard_Table_div').show();					
						// code for dynamic pagination 				
						paging(total_pages, current_page_no, "healthcard_Table" );					
					}
					// if the table has no records / no matching records 
					else{
						grid_has_no_result( "healthcard_Table",8);
					}
				}
				$("#search_healthcard_button").toggleClass('active');
			}
		});	
	}
	
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_healthcard_field").val();
			load_healthcards(search_txt)
		}
	}	
	
	// function after click search button 
	$('#search_healthcard_button').click(function(){
		var search_txt = $("#search_healthcard_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_healthcards(search_txt);		
	});
	
	//function after press "enter" to search	
	$('#search_healthcard_field').keypress(function(event){
		var search_txt = $("#search_healthcard_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_healthcards(search_txt)
		}
	})

	// load data initially on page load with paging
	load_healthcards("");

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
		load_healthcards("Advance_search");
	});
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_healthcards("Print");
	});
	
	//insert healthcard
	$('#save_healthcard').click(function(event){  
		event.preventDefault();
		var formData = new FormData($('#healthcard_form')[0]);
		formData.append("q","insert_or_update");
		//validation 
		if($.trim($('#healthcard_no').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Insert Health Card Number","#healthcard_no");			
		}
		else{
			$.ajax({
				url: project_url+"controller/healthcardController.php",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_healthcard').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						clear_form();
						load_healthcards("");
					}
				 }	
			});
			
		}	
	})
	
	//edit healthcard
	edit_healthcard = function edit_healthcard(healthcard_id){
		$.ajax({
			url: project_url+"controller/healthcardController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_healthcard_details",
				healthcard_id: healthcard_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){
						//alert(data.status)
						var master_id = data.id;
						$('#healthcard_no').val(data.card_no);
						$('#healthcard_id').val(data.id);
						if(data.status==1){
							$('#is_active').iCheck('check');
						}
						if(data.status==0){
							$('#is_active').iCheck('uncheck');
						}
						$('#save_healthcard').html('Update');
						// to open submit post section
						if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
						$( "#toggle_form" ).trigger( "click" );	
					});				
				}
			}
		});	
	}
	
	clear_form = function clear_form(){			 
		$('#healthcard_id').val('');
		$("#healthcard_form").trigger('reset');
		$('#healthcard_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
		$('#save_healthcard').html('Save');
	}
	
	$('#clear_button').click(function(){
		clear_form();
		load_healthcards("");
	});
	
});





</script>