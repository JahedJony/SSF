<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($user_type != 1){
?> 
	<div class="x_panel">
		<div class="alert alert-danger" align="center">You Don't Have permission of this Page.</div>
	</div>
	<?php 
} 
else{	
$service_list = $dbClass->get_service_list();
?>
<div class="x_panel">
    <div class="x_title">
        <h2>Health Kit Service Info</h2>
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
						<label class="control-label col-md-1 col-sm-1 col-xs-12" style="text-align:right">Service Center</label>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<input id="ad_service_center" name="ad_service_center" class="form-control input-sm" type="text" />
							<input id="ad_service_center_id" name="ad_service_center_id" type="hidden" />
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-12" style="text-align:right">Health Card</label>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<input id="ad_health_card" name="ad_health_card"  class="form-control input-sm" type="text" />
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-12" style="text-align:right">From</label>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<input id="start_date" name="start_date" placeholder="Click To Select Date" class="date-picker form-control col-md-6 col-xs-12 input-sm" type="text" />
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-12" style="text-align:right">To</label>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<input id="end_date" name="end_date" placeholder="Click To Select Date" class="date-picker form-control col-md-6 col-xs-12 input-sm" type="text" />
						</div>						
					</div>					
					<br/>
					<div class="row">
						<div class="col-md-6" style="text-align:right">					
							<button type="button" class="btn btn-info" id="adv_search_button"><i class="fa fa-lg fa-search"></i></button>
							<button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"></i></button>
						</div>
						<div class="col-md-6" style="text-align:center">
							<div id="ad_submit_error" class="text-center" style="display:none"></div>
						</div>
					</div>
				</div> 
			</div>
		</div>
		<!-- Adnach search end -->	
		
    	<div class="dataTables_length">
        	<label>Show 
                <select size="1" style="width: 56px;padding: 6px;" id="healthKitServices_Table_length" name="healthKitServices_Table_length" aria-controls="healthKitServices_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="healthKitServices_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_healthKitServices_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_healthKitServices_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="healthKitServices_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead>
                <tr class="headings">
                    <th class="column-title" width="20%">Health Card No</th>
                    <th class="column-title" width="20%">Patient Name</th>
                    <th class="column-title" width="30%">Service Date</th>
                    <th class="column-title" width="30%">Service Center</th>
                    <th class="column-title no-link last"  width="100"><span class="nobr"></span></th>
                </tr>
            </thead>
            <tbody id="healthKitServices_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="healthKitServices_Table_div">
            <div class="dataTables_info" id="healthKitServices_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="healthKitServices_Table_paginate">
            </div> 
        </div>  
    </div>
</div>

<div class="x_panel employee_entry_cl">
    <div class="x_title">
        <h2>New Service</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">
        <br /> 
		<form method="post" id="healthKit_service_form" name="healthKit_service_form" enctype="multipart/form-data" class="form-horizontal form-label-left">	
			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-12">Health Card  No<span class="required">*</span></label>           
				<div class="input-group col-md-10 col-sm-10 col-xs-12">
					<input type="text" id="search_by_health_card_no" name="search_by_health_card_no" required class="form-control col-lg-12" />
					<span class="input-group-btn">
						<button  type="button" id="identy_search_btn" class="btn btn-primary" >
						 <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw  has-spinner"></i></span>
							 <i class="fa fa-search"> Search by Health Card No</i>
						</button>
					</span>
				</div> 
				<div class="">
					<div id="search_error" class="text-center" style="display:none"></div>
				</div>
			</div>	   
			<div class="row" id="patient_div">
				<div class="x_title">
					<h2>Patient Info</h2>
					<div class="clearfix"></div>
				</div>
				<div class="col-md-10 col-xs-8" >
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Name</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input id="patient_name" name="patient_name" class="form-control col-md-6 col-xs-12" disabled type="text" />
							<input id="healthKit_health_card_no" name="healthKit_health_card_no" class="form-control col-md-6 col-xs-12" type="hidden" />
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
				<h2>Service Info</h2>
				<div class="clearfix"></div>
			</div>
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Venue</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input id="service_center" name="service_center" class="form-control col-md-6 col-xs-12" type="text" />
						<input id="service_center_id" name="service_center_id" class="form-control col-md-6 col-xs-12" type="hidden" />
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Service Date</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input id="service_date" name="service_date" placeholder="Click To Select Date" class="date-picker form-control col-md-6 col-xs-12 input-sm" type="text" />
					</div>
				</div>
			</div>
			<table class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
				<thead>
					<tr>
						<th class="column-title" width="30%">Service Name</th>
						<th class="column-title" width="20%">Result</th>
						<th class="column-title">Details</th>
					</tr>
				</thead>
				<tbody class="scrollable">  
				<?php foreach($service_list as $key=>$value){
					echo "<tr>
							<td class='column-title'><input type='text' readonly value='".$value['service_name']."' id='service_name_".$value['id']."' class='form-control'/><input type='hidden' name='service_id[]' id='service_id_".$value['id']."' value='".$value['id']."'/></td>
							<th class='column-title'><input type='text' name='service_results[]' id='service_result_".$value['id']."' class='form-control'/></th>
							<th class='column-title'><input type='text' name='service_details[]' id='service_details_".$value['id']."' class='form-control'/></th>
						</tr>"; 
				}	?>            		 
				</tbody> 
			</table>
			
			<div class="form-group">
				<div class="col-md-7 col-sm-6 col-xs-12" style="text-align:right">
					<input type="hidden" id="master_id" name="master_id"/>       
					<button type="submit" id="save_button" class="btn btn-success">Save</button>                    
					<button type="button" id="clear_button" class="btn btn-primary">Clear</button>                         
				</div>
				<div class="col-md-5 col-sm-5 col-xs-12">
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
	$('#healthKit_service_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});	
	
	/*Auto Suggest*/	
	$("#service_center, #ad_service_center").autocomplete({
        search: function() {
        },
        source: function(request, response) {
            $.ajax({
                url: project_url+'controller/autosuggests.php',
                dataType: "json",
                type: "post",
				async:false,
                data: {
                    q: "allServiceCenter",
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3,
        select: function(event, ui) { 
			var id = ui.item.id;
			$('#service_center_id, #ad_service_center_id').val(id);
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
	
	load_healthKitServices_grid = function load_healthKitServices_grid(search_txt){
		$("#search_healthKitServices_button").toggleClass('active');		 
		var healthKitServices_Table_length =parseInt($('#healthKitServices_Table_length').val());
		var start_date = $("#start_date").val();	
		var end_date = $("#end_date").val();	
		var ad_health_card = $("#ad_health_card").val();
		var ad_service_center = $("#ad_service_center").val();
		if(ad_service_center == '') $("#ad_service_center_id").val(0);
		var ad_service_center_id = $("#ad_service_center_id").val();
		
		$.ajax({
			url: project_url+"controller/healthKitController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "healthKitService_grid_data",
				search_txt: search_txt,
				start_date: start_date,
				ad_health_card: ad_health_card,
				ad_service_center_id: ad_service_center_id,
				ad_service_center: ad_service_center,
				end_date: end_date,
				limit:healthKitServices_Table_length,
				page_no:current_page_no
			},
			success: function(data) {
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $_SESSION['user_name']; ?>";
				var html = "";
				
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";					
					if(start_date && end_date !='')   serach_areas += "Date: "+start_date+" to "+end_date+ "<br>";	
					if(ad_service_center_id !=0) serach_areas += "Service Center: "+ad_service_center+" <br/>";	
					if(ad_health_card!=''){            
						if(!jQuery.isEmptyObject(data.records)){							
							serach_areas += "Health Card: "+ad_health_card+" <br/>";
							serach_areas += "Name : "+data.records[0].patient_name+" <br/>";
							serach_areas += "Address : "+data.records[0].address+" <br/>";	
							
							html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">Female Service Information Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'<br/> Total Services: '+data.total_records+'</small></th></tr></table>';
							
							html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:left; padding:2px"  width="20%">Service Date</th><th style="text-align:left; padding:2px" width="30%" >Service Center</th><th style="text-align:center; padding:2px" colspan="3">Services Result Details</th></tr></thead><tbody>';
							$.each(data.records, function(i,data){  
								html += "<tr>";				
								html +="<td style='text-align:left; padding:2px'>"+data.service_date+"</td>";
								html +="<td style='text-align:left; padding:2px'>"+data.service_center_name+"</td>";
								html +="<td style='text-align:left; padding:2px' colspan='3'>";
								var service_infos = data.service_details;
								var service_infos_arr = service_infos.split(',');
								var subhtml = "<table  border='1px' style='margin-top:10px;border-collapse:collapse; width:100%'>";
								$.each(service_infos_arr, function(i,single_service_infos){ 
									var single_service_infos_arr = single_service_infos.split('```');
										subhtml += "<tr>";				
										subhtml +="<td style='text-align:left; padding:2px' width='30%'  >"+single_service_infos_arr[0]+"</td>";
										subhtml +="<td style='text-align:center; padding:2px' width='30%'  >"+single_service_infos_arr[1]+"</td>";
										subhtml +="<td style='text-align:left; padding:2px' >"+single_service_infos_arr[2]+"</td>";
										subhtml += "</tr>";
								})
								subhtml += "</table>";
								html += subhtml+"</td>";
								html += '</tr>';
							});
							html +="</tbody></table>"
						}
						else{
							html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";	
						}
					}
					else{					
						html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">Female Service Information Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
						
						if(!jQuery.isEmptyObject(data.records)){
							html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th width="10%"  style="text-align:center; padding:2px">Health Card</th><th width="20%"  style="text-align:left; padding:2px">Name</th><th style="text-align:left; padding:2px"  width="10%">Service Date</th><th style="text-align:left; padding:2px" width="20%" >Service Center</th><th style="text-align:center; padding:2px" colspan="3">Services Result Details</th></tr></thead><tbody>';
							$.each(data.records, function(i,data){  
								html += "<tr>";				
								html +="<td style='text-align:center; padding:2px'>"+data.health_card_no+"</td>";
								html +="<td style='text-align:left; padding:2px'>"+data.patient_name+"</td>";
								html +="<td style='text-align:left; padding:2px'>"+data.service_date+"</td>";
								html +="<td style='text-align:left; padding:2px'>"+data.service_center_name+"</td>";
								html +="<td style='text-align:left; padding:2px' colspan='3'>";
								var service_infos = data.service_details;
								var service_infos_arr = service_infos.split(',');
								var subhtml = "<table  border='1px' style='margin-top:10px;border-collapse:collapse; width:100%'>";
								$.each(service_infos_arr, function(i,single_service_infos){ 
									var single_service_infos_arr = single_service_infos.split('```');
										subhtml += "<tr>";				
										subhtml +="<td style='text-align:left; padding:2px' width='30%'  >"+single_service_infos_arr[0]+"</td>";
										subhtml +="<td style='text-align:center; padding:2px' width='30%'  >"+single_service_infos_arr[1]+"</td>";
										subhtml +="<td style='text-align:left; padding:2px' >"+single_service_infos_arr[2]+"</td>";
										subhtml += "</tr>";
								})
								subhtml += "</table>";
								html += subhtml+"</td>";
								html += '</tr>';
							});
							html +="</tbody></table>"
						}
						else{
							html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";	
						}
					}
					WinId = window.open("", "Female Service Report","width=950,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
				}
				else{
					// for  showing grid's no of records from total no of records 
					show_record_no(current_page_no, healthKitServices_Table_length, data.total_records )
					
					var total_pages = data.total_pages;	
					var records_array = data.records;
					$('#healthKitServices_Table tbody tr').remove();
					if(!jQuery.isEmptyObject(records_array)){
						// create and set grid table row
						var colums_array=["id*identifier*hidden","health_card_no","patient_name", "service_date","service_center_name"];
						// first element is for view , edit condition, delete condition
						// "all" will show /"no" will show nothing
						var condition_array=["","","update_status", "1","delete_status","1"];
						// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
						// cauton: not posssible to use multiple grid in same page					
						create_set_grid_table_row(records_array,colums_array,condition_array,"healthKitServices","healthKitServices_Table", 0);
						// show the showing no of records and paging for records 
						$('#healthKitServices_Table_div').show();					
						// code for dynamic pagination 				
						paging(total_pages, current_page_no, "healthKitServices_Table" );					
					}
					// if the table has no records / no matching records 
					else{
						grid_has_no_result("healthKitServices_Table",8);
					}	
				}
				$("#search_healthKitServices_button").toggleClass('active');
			}
		});		
	}
	
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_healthKitServices_field").val();
			load_healthKitServices_grid(search_txt)
		}
	}	
	
	// function after click search button 
	$('#search_healthKitServices_button').click(function(){
		var search_txt = $("#search_healthKitServices_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_healthKitServices_grid(search_txt)
		// if there is lot of data and it tooks lot of time please add the below condition
		/*
		if(search_txt.length>3){
			load_healthKitServices_grid(search_txt)	
		}
		*/
	});
	
	//function after press "enter" to search	
	$('#search_healthKitServices_field').keypress(function(event){
		var search_txt = $("#search_healthKitServices_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_healthKitServices_grid(search_txt)
		}
	})
	
	// load data initially on page load with paging
	load_healthKitServices_grid("");

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
	var url = project_url+"controller/healthKitController.php";

	// save and update for public post/notice
	$('#save_button').click(function(event){		
		event.preventDefault();
		var formData = new FormData($('#healthKit_service_form')[0]);
		formData.append("q","insert_or_update_healthKit_service");
		if($.trim($('#search_by_health_card_no').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Enter Health Card No","#search_by_health_card_no");			
		}
		else if($.trim($('#service_center_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Select Service Center","#service_center"); 
		}
		else if($.trim($('#service_date').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Select Date","#service_date"); 
		}
		else{
			$('#save_button').attr('disabled','disabled');
			$.ajax({
				url: url,
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_button').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && data == "1"){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_healthKitServices_grid("");
						clear_form();
					}
					else if(data == "2"){
						success_or_error_msg('#form_submit_error',"success","Update Successfully");
						load_healthKitServices_grid("");
						clear_form();																
					}
					else{
						success_or_error_msg('#form_submit_error',"danger","Not Saved...");	
					}
				 }	
			});
		}	
	})
	
	// clear function to clear all the form value
	clear_form = function clear_form(){			 
		$('#master_id').val('');
		$('#healthKit_health_card_no').val('');
		$("#healthKit_service_form").trigger('reset');		
		$('#search_by_health_card_no').val('');
		$('#healthKit_service_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
		$("#healthKit_service_form .tableflat").iCheck('uncheck');
		$('#save_button').html('Save');
		$('#patient_div').hide();
	}
	
	$('#patient_div').hide();
	
	//search by identy no
	$('#identy_search_btn').click(function(){
		var identy_no = $('#search_by_health_card_no').val();
		if($.trim($('#search_by_health_card_no').val()) == ""){
			success_or_error_msg('#search_error','danger',"Please Input Identy No Correctly.","#search_by_health_card_no");			
		}
		else{
			$.ajax({
				url: project_url+"controller/healthKitController.php",
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "healthKit_details_info",
					health_card_no: identy_no
				},
				success: function(data){
					if(data.records == 'null'){
						success_or_error_msg('#search_error','danger',"Wrong Identy No. Please Input Correct Health Card No.","#identy_no");
					}
					else{
						$('#patient_div').show();
						if(!jQuery.isEmptyObject(data.records)){
							$.each(data.records, function(i,data){ 						
								$('#healthKit_health_card_no').val(data.health_card_no);
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
	
	delete_healthKitServices = function delete_healthKitServices(healthKitServices_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: url,
				type:'POST',
				async:false,
				data: "q=delete_healthKitServices&healthKitServices_id="+healthKitServices_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_healthKitServices_grid("");
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

	edit_healthKitServices = function edit_healthKitServices(healthKitServices_id){
		$.ajax({
			url: project_url+"controller/healthKitController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_healthKitServices_details",
				healthKitServices_id: healthKitServices_id
			},
			success: function(data){
				$('#master_id').val(healthKitServices_id);
				if(!jQuery.isEmptyObject(data.service_info)){
					var master_info = data.service_info;
					$('#service_center_id').val(master_info.service_center_id);
					$('#service_center').val(master_info.service_center_name);	
					$('#service_date').val(master_info.service_date);		

					var service_infos = master_info.service_details;
					var service_infos_arr = service_infos.split(',');
					
					$.each(service_infos_arr, function(i,single_service_infos){ 
						var single_service_infos_arr = single_service_infos.split('```');
						$('#service_id_'+single_service_infos_arr[3]).val(single_service_infos_arr[3]);
						$('#service_name_'+single_service_infos_arr[3]).val(single_service_infos_arr[0]);
						$('#service_result_'+single_service_infos_arr[3]).val(single_service_infos_arr[1]);
						$('#service_details_'+single_service_infos_arr[3]).val(single_service_infos_arr[2]);
					})
				}
				
				if(!jQuery.isEmptyObject(data.patient_info)){
					$.each(data.patient_info, function(i,master_info){ 
						$('#search_by_health_card_no').val(master_info.health_card_no);
						$('#healthKit_health_card_no').val(master_info.health_card_no);
						$('#patient_name').val(master_info.name);
						$('#mobile_no').val(master_info.mobile_no);
						$('#identy_no').val(master_info.identy_no);
						$('#health_card_no').val(master_info.health_card_no);
						$('#age').val(master_info.age);
						$('#mobile_no').val(master_info.mobile_no);
						$('#address').val(master_info.address);
						$('#class').val(master_info.class);
						$('#patient_img').attr("src",project_url+master_info.image);	
					});	
				}
				
				$('#patient_div').show();
				//change button value 
				$('#save_button').html('Update');
				
				// to open submit post section
				if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
					$( "#toggle_form" ).trigger( "click" );	
			}	
		});		
	}	 		

	//click advance button perform
	$('#adv_search_button').click(function(){
		load_healthKitServices_grid("Advance_search");
	});
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_healthKitServices_grid("Print")
	});

});


<!-- ------------------------------------------end --------------------------------------->
</script>