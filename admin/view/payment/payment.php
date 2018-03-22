<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($user_type != 1 && $user_type != 2 && $user_type != 3){
?> 
	<div class="x_panel">
		<div class="alert alert-danger" align="center">You Don't Have permission of this Page.</div>
	</div>
	<?php 
} 
else{
	?>

<div class="x_panel">
    <div class="x_title">
        <h2>Payment Info</h2>
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
						<label class="control-label col-md-4 col-sm-1 col-xs-12" style="text-align:right">From</label>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<input id="start_date" name="start_date" placeholder="Click To Select Date" class="date-picker form-control col-md-6 col-xs-12 input-sm" type="text" />
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-12" style="text-align:right">To</label>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<input id="end_date" name="end_date" placeholder="Click To Select Date" class="date-picker form-control col-md-6 col-xs-12 input-sm" type="text" />
						</div>						
					</div>
					<br/>
					<div class="row hide" id="doc_diag_row">						
						<label class="control-label col-md-3 col-sm-1 col-xs-6" style="text-align:right">Type<span class="required">*</span></label>
						<div class="col-md-3 col-sm-2 col-xs-6">
							<input type="radio" class="flat_radio" name="ad_type" id="ad_type" value="2"/> Doctor
							<input type="radio" class="flat_radio" name="ad_type" id="ad_type" value="3" /> Diagnostic
							<input type="radio" class="flat_radio" name="ad_type" id="ad_type" value="0" checked="CHECKED"/> All
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6" style="text-align:right">List</label>
						<div class="col-md-3 col-sm-4 col-xs-6">
							<select size="1" style="width:100%; padding: 6px;" id="ad_payment_select" name="ad_payment_select" class="form-control input-sm">
								
							 </select>
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
                <select size="1" style="width: 56px;padding: 6px;" id="payment_Table_length" name="payment_Table_length" aria-controls="payment_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="payment_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_payment_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_payment_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="payment_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead>
                <tr class="headings">
                    <th class="column-title" width="20%">Payment To</th>
                    <th class="column-title" width="20%">Payment Date</th>
                    <th class="column-title" width="20%">Amount</th>
                    <th class="column-title" width="15%">Status</th>
                    <th class="column-title" width="20%">Paid By</th>
                    <th class="column-title no-link last"  width="100"><span class="nobr"></span></th>
                </tr>
            </thead>
            <tbody id="payment_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="payment_Table_div">
            <div class="dataTables_info" id="payment_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="payment_Table_paginate">
            </div> 
        </div>  
    </div>
</div>

<div class="x_panel employee_entry_cl">
    <div class="x_title">
        <h2>Payment Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">
        <br />    
		<form method="post" id="payment_form" name="payment_form" enctype="multipart/form-data" class="form-horizontal form-label-left">
		<div class="row">
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-6">Type<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-6">
					Doctor <input type="radio" name="payment_type" id="doctor_type" checked="checked" value="2"/> 
					Diagnostic <input type="radio" name="payment_type" id="diagnostic_type" value="3"/> 
				</div>
			</div>
			<div class="form-group" id="payment_type_div">
				<label class="control-label col-md-3 col-sm-3 col-xs-6">Payment To<span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<select size="1" style="width:100%; padding: 6px;" id="payment_select" name="payment_select">
						
					 </select>
                     <div class="alert alert-info" id="details_div"></div>
				</div>	 
			</div>
		</div>
		<div class="form-group" id="payment_type_div">
				<label class="control-label col-md-3 col-sm-3 col-xs-6">Payment Amount <span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-6">
                     <input type="text" id="total_payment_amount" name="total_payment_amount" required="required" />
				</div>	 
			</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6"></label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input type="hidden" id="master_id" name="master_id"/>    
				<button type="submit" id="save_payment_info" class="btn btn-success">Save</button>                    
				<button type="button" id="clear_button" class="btn btn-primary">Clear</button>                         
			</div>
            <label class="control-label col-md-3 col-sm-3 col-xs-6"></label>
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
	
		//datepicker
	$('.date-picker').daterangepicker({
		singleDatePicker: true,
		calender_style: "picker_3",
		locale: {
			  format: 'YYYY-MM-DD',
			  separator: " - ",
		}
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
	var user_type= "<?php echo $user_type; ?>";
	load_payment_grid = function load_payment_grid(search_txt){
		$("#search_payment_button").toggleClass('active');		 
		var payment_Table_length =parseInt($('#payment_Table_length').val());
		var start_date = $("#start_date").val();	
		var end_date = $("#end_date").val();	
		var ad_type = $("input:radio[name=ad_type]:checked").val();		
		var selected_doc_diag_value = $("#ad_payment_select option:selected").val();
		var selected_doc_diag_text = $("#ad_payment_select option:selected").text();
		
		$.ajax({
			url: project_url+"controller/paymentController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				search_txt: search_txt,
				start_date: start_date,
				end_date: end_date,
				selected_doc_diag_value: selected_doc_diag_value,
				selected_doc_diag_text: selected_doc_diag_text,
				ad_type: ad_type,
				limit:payment_Table_length,
				page_no:current_page_no
			},
			success: function(data) {
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $_SESSION['user_name']; ?>";
				var html = "";
				var total_amount = 0;
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";
					
				 	if(start_date && end_date !='')                  serach_areas += "Date: "+start_date+" to "+end_date+ "<br>";
				 	if(ad_type == 2 && selected_doc_diag_value == 0) serach_areas += "All Doctor <br>";
					if(ad_type == 3 && selected_doc_diag_value == 0) serach_areas += "All Diagnostic <br>";
					if(ad_type == 2 && selected_doc_diag_value != 0) serach_areas += "Name: "+selected_doc_diag_text+" <br>";
					if(ad_type == 3 && selected_doc_diag_value != 0) serach_areas += "Name: "+selected_doc_diag_text; 					
					
					html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">Payment Information Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
						html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:left; padding:2px">Payment To</th><th style="text-align:center;  padding:2px">Payment Date</th><th style="text-align:right;  padding:2px">Payment Amount</th><th style="text-align:center;  padding:2px">Status</th><th style="text-align:left;  padding:2px">Paid By</th></tr></thead><tbody>';
						$.each(data.records, function(i,data){ 
							total_amount += parseFloat(data.amount);	
							html += "<tr>";				
							html +="<td style='text-align:left; padding:2px'>"+data.payment_to_end+"</td>";
							html +="<td style='text-align:center; padding:2px'>"+data.payment_date+"</td>";
							html +="<td style='text-align:right; padding:2px'>"+data.amount+"</td>";
							html +="<td style='text-align:center; padding:2px'>"+data.payment_status+"</td>";
							html +="<td style='text-align:left; padding:2px'>"+data.paid_by+"</td>";
							html += '</tr>';
						});
							html += "<tr>";				
							html +="<td colspan='2' style='text-align:right; padding:2px'><b>Total Payment</b></td>";
							html +="<td style='text-align:right; padding:2px'><b>"+total_amount.toFixed(2)+"<b/></td>";
							html +="<td style='text-align:center; padding:2px' colspan='2'></td>";
							html += '</tr>';
						html +="</tbody></table>"
					}
					else{
						html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";	
					}
					WinId = window.open("", "Payment Report","width=950,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
				}
				else{
					if(user_type != 1){
						$('.employee_entry_cl').hide();
					}
					// for  showing grid's no of records from total no of records 
					show_record_no(current_page_no, payment_Table_length, data.total_records )
					
					var total_pages = data.total_pages;	
					var records_array = data.records;
					$('#payment_Table tbody tr').remove();
					$("#search_payment_button").toggleClass('active');
					if(!jQuery.isEmptyObject(records_array)){
						// create and set grid table row
						var colums_array=["id*identifier*hidden", "payment_to_end","payment_date","amount","payment_status","paid_by"];
						// first element is for view , edit condition, delete condition
						// "all" will show /"no" will show nothing
						var condition_array=["","","update_status", "1","delete_status","1"];
						// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
						// cauton: not posssible to use multiple grid in same page					
						create_set_grid_table_row(records_array,colums_array,condition_array,"payment","payment_Table", 0);
						// show the showing no of records and paging for records 
						$('#payment_Table_div').show();					
						// code for dynamic pagination 				
						paging(total_pages, current_page_no, "payment_Table" );					
					}
					// if the table has no records / no matching records 
					else{
						grid_has_no_result("payment_Table",8);
					}	
				}		
			}
		});	
	}
	
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_payment_field").val();
			load_payment_grid(search_txt)
		}
	}	
	// function after click search button 
	$('#search_payment_button').click(function(){
		var search_txt = $("#search_payment_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_payment_grid(search_txt)
		// if there is lot of data and it tooks lot of time please add the below condition
		/*
		if(search_txt.length>3){
			load_payment_grid(search_txt)	
		}
		*/
	});
	//function after press "enter" to search	
	$('#search_payment_field').keypress(function(event){
		var search_txt = $("#search_payment_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_payment_grid(search_txt)
		}
	})
	// load data initially on page load with paging
	load_payment_grid("");
	
	if(user_type==1) $('#doc_diag_row').removeClass('hide');
	
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
	var url = project_url+"controller/paymentController.php";

	// save and update for public post/notice
	$('#save_payment_info').click(function(event){		
		event.preventDefault();
		var formData = new FormData($('#payment_form')[0]);
		formData.append("q","insert_or_update");
		
		if($.trim($('#payment_select').val()) == 0){
			success_or_error_msg('#form_submit_error','danger',"Please Select Doctor or Diagnostic","#payment_select");			
		}
		else if($('#total_payment_amount').length == 0){
			success_or_error_msg('#form_submit_error','danger',"Please Select Bill","#start_date"); 
		}
		else{
			$('#save_payment_info').attr('disabled','disabled');
			$.ajax({
				url: url,
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_payment_info').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_payment_grid("");
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
	
	$('#adv_search_button').click(function(){
		load_payment_grid("Advance_search");
	});
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_payment_grid("Print");
	});
	
	//disabled advance type dropdown on page load 
	$('#ad_payment_select').after().html('<option value="0">Select.....</option>');
	$('#ad_payment_select').attr('disabled',true);	
	
	//Change details advance type on click  
	$("[name='ad_type']").click(function(){ 
		var ad_type = $(this).val();
		load_ad_data(ad_type);
	}) 
	
	//load advance dropdown data on page load
	load_ad_data = function load_ad_data(type){
		$('#ad_payment_select').attr('disabled',false);
		if(type == 2){
			$.ajax({
				url: project_url+"controller/paymentController.php",
				dataType: "json",
				type: "post",
				async:false,
				data:{
					q: "view_doctor",
				},
				success: function(data) {
					var option_html = '';	
					if(!jQuery.isEmptyObject(data.records)){
						$.each(data.records, function(i,data){  
							option_html += '<option value="'+data.id+'">'+data.name+'</option>';
						});
						$('#ad_payment_select').after().html('<option value="0">Select Doctor</option>'+option_html);
					}
				}
				
			});
		}else if(type == 3){
			$.ajax({
				url: project_url+"controller/paymentController.php",
				dataType: "json",
				type: "post",
				async:false,
				data:{
					q: "view_diagnostic",
				},
				success: function(data) {
					var option_html = '';	
					if(!jQuery.isEmptyObject(data.records)){
						$.each(data.records, function(i,data){  
							option_html += '<option value="'+data.id+'">'+data.name+'</option>';
						});
						$('#ad_payment_select').after().html('<option value="0">Select Diagnostic</option>'+option_html);
					}
				}
				
			});
		}
		else{
			$('#ad_payment_select').after().html('<option value="0">Select.....</option>');
			$('#ad_payment_select').attr('disabled',true);
		}
	}
	
	$("[name='payment_type']").click(function(){ 
		clear_details_div();
		var type = $(this).val();
		load_type_data(type);
	}) 
	
	$('#details_div').hide();
	
	//load dropdown data on page load
	load_type_data = function load_type_data(type){
		if(type == 2){
			$.ajax({
				url: project_url+"controller/paymentController.php",
				dataType: "json",
				type: "post",
				async:false,
				data:{
					q: "view_doctor",
				},
				success: function(data) {
					var option_html = '';	
					if(!jQuery.isEmptyObject(data.records)){
						$.each(data.records, function(i,data){  
							option_html += '<option value="'+data.id+'">'+data.name+'</option>';
						});
						$('#payment_select').after().html('<option value="0">Select Doctor</option>'+option_html);
					}
				}
				
			});
		}
		else{
			$.ajax({
				url: project_url+"controller/paymentController.php",
				dataType: "json",
				type: "post",
				async:false,
				data:{
					q: "view_diagnostic",
				},
				success: function(data) {
					var option_html = '';	
					if(!jQuery.isEmptyObject(data.records)){
						$.each(data.records, function(i,data){  
							option_html += '<option value="'+data.id+'">'+data.name+'</option>';
						});
						$('#payment_select').after().html('<option value="0">Select Diagnostic</option>'+option_html);
					}
				}
				
			});
		}
	}
	
	// load doctor details 
	load_doctor_details = function load_doctor_details(){
		//var type = $('#payment_type').val();	
		$.ajax({
			url: project_url+"controller/paymentController.php",
			dataType: "json",
			type: "post",
			async:false,
			data:{
				q: "view_doctor",
			},
			success: function(data) {
				var option_html = '';	
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){  
						option_html += '<option value="'+data.id+'">'+data.name+'</option>';
					});
					$('#payment_select').after().html('<option value="0">Select Doctor</option>'+option_html);
				}
			}
			
		});
	}
	
	clear_details_div = function clear_details_div(){
		$('#details_div').html("");
		$('#details_div').hide();
	}
	
	$("#payment_select").change(function(){
		$('#details_div').html("");
		if($("[name='payment_type']:checked").val()==2){
			if($("#payment_select").val() != 0){
				$.ajax({
					url: project_url+"controller/paymentController.php",
					dataType: "json",
					type: "post",
					async:false,
					data:{
						q: "view_doctor_details",
					   id: $("#payment_select").val()
					},
					success: function(data){
						if(!jQuery.isEmptyObject(data.records)){
							$.each(data.records, function(i,data){  
								details_html = "<strong>"+data.name+'</strong> ('+data.speciality+') <br>'+data.address+" , Mb:"+data.mobile_no;
								$('#details_div').html(details_html);
							});
						}
						$('#details_div').show();
					}
				});
			}	
		}
		else{
			if($("#payment_select").val() != 0){
				$.ajax({
					url: project_url+"controller/paymentController.php",
					dataType: "json",
					type: "post",
					async:false,
					data:{
						q: "view_diagnostic_details",
						id: $("#payment_select").val()
					},
					success: function(data){
						if(!jQuery.isEmptyObject(data.records)){
							$.each(data.records, function(i,data){
								details_html ="<strong>"+data.name+'</strong> <br>'+data.contact_person_name+' <br>'+data.address+" , Mb:"+data.mobile_no;								
								$('#details_div').html(details_html);
							});
						}
						$('#details_div').show();
					}
				});
			}	
		}		
		
	});
	
	// clear function to clear all the form value
	clear_form = function clear_form(){			 
		$('#id').val('');
		$('#master_id').val('');
		$("#payment_form").trigger('reset');
		
		$('#save_payment_info').html('Save');
		clear_details_div();
		load_doctor_details();
	}
	
	// on select clear button 
	$('#clear_button').click(function(){
		clear_form();
	});
	
	delete_payment = function delete_payment(payment_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: url,
				type:'POST',
				async:false,
				data: "q=delete_payment&payment_id="+payment_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_payment_grid("");
					}
					else if($.trim(data) == 2){
						success_or_error_msg('#page_notification_div',"danger","This dont have Permission");
					}
					else{
						success_or_error_msg('#page_notification_div',"danger","Not Deleted...");						
					}
				 }	
			});
		} 	
	}

	edit_payment = function edit_payment(payment_id){
		$.ajax({
			url: project_url+"controller/paymentController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_payment_details",
				payment_id: payment_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){ 								
						$('#master_id').val(data.id);
						$('input[name=payment_type][value="'+data.payment_to_type+'"]').prop('checked', 'checked');						
						if(data.payment_to_type == 2){
							$.ajax({
								url: project_url+"controller/paymentController.php",
								dataType: "json",
								type: "post",
								async:false,
								data:{
									q: "view_doctor",
								},
								success: function(data) {
									var option_html = '';	
									if(!jQuery.isEmptyObject(data.records)){
										$.each(data.records, function(i,data){  
											option_html += '<option value="'+data.id+'">'+data.name+'</option>';
										});
										$('#payment_select').after().html('<option value="0">Select Doctor</option>'+option_html);
									}
								}
								
							});
						}
						else{
							$.ajax({
								url: project_url+"controller/paymentController.php",
								dataType: "json",
								type: "post",
								async:false,
								data:{
									q: "view_diagnostic",
								},
								success: function(data) {
									var option_html = '';	
									if(!jQuery.isEmptyObject(data.records)){
										$.each(data.records, function(i,data){  
											option_html += '<option value="'+data.id+'">'+data.name+'</option>';
										});
										$('#payment_select').after().html('<option value="0">Select Diagnostic</option>'+option_html);
									}
								}
								
							});
						}						
						$('#payment_select').val(data.payment_to);
						$('#total_payment_amount').val(data.amount);

						//change button value 
						$('#save_payment_info').html('Update');
						
						// to open submit post section
						if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
							$( "#toggle_form" ).trigger( "click" );						
					});
				}
			}	
		});		
	}	 		
	
	//load doctor details on page load
	load_doctor_details();
});


<!-- ------------------------------------------end --------------------------------------->
</script>