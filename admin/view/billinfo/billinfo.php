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
        <h2>Bill Info</h2>
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
                <select size="1" style="width: 56px;padding: 6px;" id="bill_Table_length" name="bill_Table_length" aria-controls="bill_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="bill_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_bill_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_bill_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="bill_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead>
                <tr class="headings">
					<th class="column-title" width="5%"></th>
                    <th class="column-title" width="15%">Health Card No</th>
                    <th class="column-title" width="20%">Billed By Name</th>
                    <th class="column-title" width="20%">Billed For</th>
                    <th class="column-title" width="20%">Total Amount</th>
                    <th class="column-title" width="20%">Discount Amount</th>
                    <th class="column-title no-link last"  width="100"><span class="nobr"></span></th>
                </tr>
            </thead>
            <tbody id="bill_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="bill_Table_div">
            <div class="dataTables_info" id="bill_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="bill_Table_paginate">
            </div> 
        </div>  
    </div>
</div>

<div class="x_panel employee_entry_cl">
    <div class="x_title">
        <h2>Bill Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">
        <br /> 	
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Health Card  No<span class="required">*</span></label>           
			<div class="input-group col-md-10 col-sm-10 col-xs-12">
				<input type="text" id="search_by_identy_no" name="search_by_identy_no" required class="form-control col-lg-12" />
				<span class="input-group-btn">
					<button  type="button" id="identy_search_btn" class="btn btn-primary" >
					 <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw  has-spinner"></i></span>
						 <i class="fa fa-search">Search by Identy No</i>
					</button>
				</span>
			</div> 
			<div class="">
				<div id="search_error" class="text-center" style="display:none"></div>
			</div>
		</div>	   
		<form method="post" id="bill_form" name="bill_form" enctype="multipart/form-data" class="form-horizontal form-label-left">
		<div class="row" id="patient_div">
			<div class="x_title">
				<h2>Patient Info</h2>
				<div class="clearfix"></div>
			</div>
			<div class="col-md-10 col-xs-8" >
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Patient  Name</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input id="patient_name" name="patient_name" class="form-control col-md-6 col-xs-12" disabled type="text" />
						<input id="bill_health_card_no" name="bill_health_card_no" class="form-control col-md-6 col-xs-12" type="hidden" />
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Address</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input id="address" name="address" class="form-control col-md-6 col-xs-12" disabled type="text" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Age / DOB</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input id="age" name="age" class="form-control col-md-6 col-xs-12" disabled type="text" />
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Mobile No</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input id="mobile_no" name="mobile_no" class="form-control col-md-6 col-xs-12" disabled type="text" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Identy No</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input id="identy_no" name="identy_no" class="form-control col-md-6 col-xs-12" disabled type="text" />
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Health Card No</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input id="health_card_no" name="health_card_no" class="form-control col-md-6 col-xs-12" disabled type="text" />
					</div>
				</div>
			</div>
			<div class="col-md-2 col-xs-4">
				<img src="<?php echo $activity_url ?>images/no_image.png" class="img-thumbnail" id="patient_img">
			</div>
		</div>	
		<div class="ln_solid"></div>
		<div class="x_title">
			<h2>Bill Info</h2>
			<div class="clearfix"></div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-6">Bill Date<span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<input id="bill_date" name="bill_date" placeholder="Click To Select Date" class="date-picker form-control col-md-6 col-xs-12" required="" type="text" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-6">Total Amount<span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<input id="total_amount" name="total_amount" class="form-control col-md-6 col-xs-12" required="" type="number" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-6">Discount Amount<span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<input id="discount_amount" name="discount_amount" class="form-control col-md-6 col-xs-12" required="" type="number" />
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<img src="<?php echo $activity_url ?>images/no_image.png" width="70%" height="70%" class="img-thumbnail" id="bill_img">
				<input type="file" name="bill_image_upload" id="bill_image_upload">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<input type="hidden" id="master_id" name="master_id"/>    
				<button type="submit" id="save_bill_info" class="btn btn-success">Save</button>                    
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
	$('#bill_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
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
	var user_type= "<?php echo $user_type; ?>";
	load_bill_grid = function load_bill_grid(search_txt){
		$("#search_bill_button").toggleClass('active');		 
		var bill_Table_length =parseInt($('#bill_Table_length').val());
		var start_date = $("#start_date").val();	
		var end_date = $("#end_date").val();	
		var ad_type = $("input:radio[name=ad_type]:checked").val();	
		var selected_doc_diag_value = $("#ad_payment_select option:selected").val();
		var selected_doc_diag_text = $("#ad_payment_select option:selected").text();
		
		$.ajax({
			url: project_url+"controller/billController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				search_txt: search_txt,
				start_date: start_date,
				end_date: end_date,
				ad_type: ad_type,
				selected_doc_diag_value: selected_doc_diag_value,
				selected_doc_diag_text: selected_doc_diag_text,
				limit:bill_Table_length,
				page_no:current_page_no
			},
			success: function(data) {
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $_SESSION['user_name']; ?>";
				var html = "";
				var total_amount = 0;
				var discount_amount = 0;
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";
					
					if(start_date && end_date !='')                  serach_areas += "Date: "+start_date+" to "+end_date+ "<br>";
				 	if(ad_type == 2 && selected_doc_diag_value == 0) serach_areas += "All Doctor <br>";
					if(ad_type == 3 && selected_doc_diag_value == 0) serach_areas += "All Diagnostic <br>";
					if(ad_type == 2 && selected_doc_diag_value != 0) serach_areas += "Name: "+selected_doc_diag_text+" <br>";
					if(ad_type == 3 && selected_doc_diag_value != 0) serach_areas += "Name: "+selected_doc_diag_text; 					
					
					html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">Bill Information Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
						html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:left;  padding:2px">Patient Name</th><th style="text-align:left;  padding:2px">Patient Type</th><th style="text-align:center;  padding:2px">Health Card</th><th style="text-align:center;  padding:2px">Bill Date</th><th style="text-align:right;  padding:2px">Total Amount</th><th style="text-align:right;  padding:2px">Discount Amount</th><th style="text-align:left;  padding:2px">Billed By</th></tr></thead><tbody>';
						
						$.each(data.records, function(i,data){  
							total_amount += parseFloat(data.total_amount);
							discount_amount += parseFloat(data.discount_amount);
							html += "<tr>";				
							html +="<td style='text-align:left; padding:2px'>"+data.billed_for+"</td>";
							html +="<td style='text-align:left;  padding:2px'>"+data.billed_for_type_name+"</td>";
							html +="<td style='text-align:center;  padding:2px'>"+data.health_card_no+"</td>";
							html +="<td style='text-align:center;  padding:2px'>"+data.bill_date+"</td>";
							html +="<td style='text-align:right;  padding:2px'>"+data.total_amount+"</td>";
							html +="<td style='text-align:right;  padding:2px'>"+data.discount_amount+"</td>";
							html +="<td style='text-align:left;  padding:2px'>"+data.billed_by_name+" ("+data.billed_by_type_name+")</td>";
							html += '</tr>';
						});
							html += "<tr>";				
							html +="<td colspan='4' style='text-align:right; padding:2px'><b>Total Amount</b></td>";
							html +="<td style='text-align:right; padding:2px'><b>"+total_amount.toFixed(2)+"<b/></td>";
							html +="<td style='text-align:right; padding:2px'><b>"+discount_amount.toFixed(2)+"<b/></td>";
							html +="<td style='text-align:center; padding:2px' colspan='2'></td>";
							html += '</tr>';
						html +="</tbody></table>"
					}
					else{
						html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";	
					}
					WinId = window.open("", "Bill Report","width=950,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
				}
				else{
					if(user_type != 2 && user_type != 3){
						$('.employee_entry_cl').hide();
					}
					// for  showing grid's no of records from total no of records 
					show_record_no(current_page_no, bill_Table_length, data.total_records )
					
					var total_pages = data.total_pages;	
					var records_array = data.records;
					$('#bill_Table tbody tr').remove();
					$("#search_bill_button").toggleClass('active');
					if(!jQuery.isEmptyObject(records_array)){
						// create and set grid table row
						var colums_array=["bill_image*image*"+project_url,"id*identifier*hidden","health_card_no", "billed_by_name","billed_for","total_amount","discount_amount"];
						// first element is for view , edit condition, delete condition
						// "all" will show /"no" will show nothing
						var condition_array=["","","update_status", "1","delete_status","1"];
						// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
						// cauton: not posssible to use multiple grid in same page					
						create_set_grid_table_row(records_array,colums_array,condition_array,"bill","bill_Table", 0);
						// show the showing no of records and paging for records 
						$('#bill_Table_div').show();					
						// code for dynamic pagination 				
						paging(total_pages, current_page_no, "bill_Table" );					
					}
					// if the table has no records / no matching records 
					else{
						grid_has_no_result("bill_Table",8);
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
			var search_txt = $("#search_bill_field").val();
			load_bill_grid(search_txt)
		}
	}	
	// function after click search button 
	$('#search_bill_button').click(function(){
		var search_txt = $("#search_bill_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_bill_grid(search_txt)
		// if there is lot of data and it tooks lot of time please add the below condition
		/*
		if(search_txt.length>3){
			load_bill_grid(search_txt)	
		}
		*/
	});
	//function after press "enter" to search	
	$('#search_bill_field').keypress(function(event){
		var search_txt = $("#search_bill_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_bill_grid(search_txt)
		}
	})
	// load data initially on page load with paging
	load_bill_grid("");
	
	if(user_type==1) $('#doc_diag_row').removeClass('hide');
});

// advance data
$(document).ready(function () {	
	//click advance button perform
	$('#adv_search_button').click(function(){
		load_bill_grid("Advance_search");
	});
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_bill_grid("Print");
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
		}
		else if(type == 3){
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
	var url = project_url+"controller/billController.php";

	// save and update for public post/notice
	$('#save_bill_info').click(function(event){		
		event.preventDefault();
		var formData = new FormData($('#bill_form')[0]);
		formData.append("q","insert_or_update");
		if($.trim($('#patient_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Select Name","#patient_name");			
		}
		else if($.trim($('#bill_date').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Select Bill Date","#start_date"); 
		}
		else if($.trim($('#total_amount').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Amount","#total_amount"); 
		}
		else if($.trim($('#discount_amount').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Discount Amount","#discount_amount"); 
		}
		else{
			$('#save_bill_info').attr('disabled','disabled');
			$.ajax({
				url: url,
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_bill_info').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_bill_grid("");
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
		$('#bill_health_card_no').val('');
		$("#bill_form").trigger('reset');		
		$('#bill_img').attr("width", "0%");
		$('#search_by_identy_no').val('');
		$('#bill_img').attr("src","http://localhost/web_project/admin/images/no_image.png");
		$('#bill_img').attr("width", "70%","height","70%");
		$('#img_url_to_copy').val("");
		$('#bill_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
		$("#bill_form .tableflat").iCheck('uncheck');
		$('#save_bill_info').html('Save');
		$('#patient_div').hide();
	}
	
	$('#patient_div').hide();
	
	//search by identy no
	$('#identy_search_btn').click(function(){
		var identy_no = $('#search_by_identy_no').val();
		if($.trim($('#search_by_identy_no').val()) == ""){
			success_or_error_msg('#search_error','danger',"Please Input Identy No Correctly.","#search_by_identy_no");			
		}
		else{
			$.ajax({
				url: project_url+"controller/billController.php",
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "get_patient_details",
					health_card_no: identy_no
				},
				success: function(data){
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#search_error','danger',"Wrong Identy No. Please Input Correct Health Card No.","#identy_no");
					}
					else{
						$('#patient_div').show();
						if(!jQuery.isEmptyObject(data.records)){
							$.each(data.records, function(i,data){ 						
								$('#bill_health_card_no').val(data.health_card_no);
								$('#patient_name').val(data.name);
								$('#mobile_no').val(data.mobile_no);
								$('#identy_no').val(data.identy_no);
								$('#health_card_no').val(data.health_card_no);
								$('#age').val(data.age);
								$('#address').val(data.address);
								$('#patient_img').attr("src",project_url+data.image);;			
							});
						}
					}
				}	
			});
		}	
	});
	
	// on select clear button 
	$('#clear_button').click(function(){
		clear_form();
	});
	
	delete_bill = function delete_bill(bill_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: url,
				type:'POST',
				async:false,
				data: "q=delete_bill&bill_id="+bill_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_bill_grid("");
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

	edit_bill = function edit_bill(bill_id){
		$.ajax({
			url: project_url+"controller/billController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_bill_details",
				bill_id: bill_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.bill_info)){
					var master_bill_info = data.bill_info;
					$('#master_id').val(master_bill_info.id);
					$('#bill_date').val(master_bill_info.bill_date);
					$('#total_amount').val(master_bill_info.total_amount);
					$('#discount_amount').val(master_bill_info.discount_amount);
					$('#bill_img').attr("src",project_url+master_bill_info.bill_image);
					$('#bill_img').attr("width", "100%"); 			
				}
				if(!jQuery.isEmptyObject(data.patient_info)){
						var master_patient_info = data.patient_info;
						$('#bill_health_card_no').val(master_patient_info.health_card_no);
						$('#patient_name').val(master_patient_info.name);
						$('#mobile_no').val(master_patient_info.mobile_no);
						$('#identy_no').val(master_patient_info.identy_no);
						$('#health_card_no').val(master_patient_info.health_card_no);
						$('#age').val(master_patient_info.age);
						$('#mobile_no').val(master_patient_info.mobile_no);
						$('#address').val(master_patient_info.address);
						$('#class').val(master_patient_info.class);
						$('#patient_img').attr("src",project_url+master_patient_info.image);	
				}
				$('#patient_div').show();
				//change button value 
				$('#save_bill_info').html('Update');
				
				// to open submit post section
				if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
					$( "#toggle_form" ).trigger( "click" );	
			}	
		});		
	}	 		
});


<!-- ------------------------------------------end --------------------------------------->
</script>