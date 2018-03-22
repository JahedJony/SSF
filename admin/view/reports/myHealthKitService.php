<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];
$user_id = $_SESSION['user_id'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($user_type == 2 && $user_type == 3){
?> 
	<div class="x_panel">
		<div class="alert alert-danger" align="center">You Don't Have permission of this Page.</div>
	</div>
	<?php 
} 
else{	
$health_card_no = $dbClass->get_health_card_no($user_type, $user_id);
?>
<div class="x_panel">
    <div class="x_title">
        <h2>My Health Kit Service Info</h2>
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
						<a class="collapse-link-adv" id="toggle_form_adv"><small class="text-primary">Search & Report</small> <i class="fa fa-chevron-down"></i></a>
					</li>
				</ul>
			</div>
			<div class="x_content adv_cl" id="iniial_collapse_adv">
				<div class="row advance_search_div alert alert-warning">	
					<div class="row">
						<label class="control-label col-md-2 col-sm-1 col-xs-12" style="text-align:right">Health Card<span class="required">*</span></label>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<input id="ad_health_card" name="ad_health_card"  class="form-control input-sm" type="text" <?php if($user_type != 1) echo 'readonly'; ?>/>
						</div>
						
						<label class="control-label col-md-1 col-sm-1 col-xs-12" style="text-align:right">From</label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input id="start_date" name="start_date" placeholder="Click To Select Date" class="date-picker form-control col-md-6 col-xs-12 input-sm" type="text" />
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-12" style="text-align:right">To</label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input id="end_date" name="end_date" placeholder="Click To Select Date" class="date-picker form-control col-md-6 col-xs-12 input-sm" type="text" />
						</div>					
					</div>					
					<br/>
					<div class="row">
						<div class="col-md-7" style="text-align:right">					
							<button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"> Show Report</i></button>
						</div>
						<div class="col-md-5" style="text-align:center" id="form_submit_error"></div>
					<div>	
				</div> 
			</div>
		</div>
		<!-- Adnach search end -->	
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
	var ad_health_card = "<?php echo $health_card_no; ?>";
	//if(user_type==1) ad_health_card = '';
	$('#ad_health_card').val(ad_health_card);
	
	load_my_healthKit_service_grid = function load_my_healthKit_service_grid(search_txt){	 
		var start_date = $("#start_date").val();	
		var end_date = $("#end_date").val();	
		ad_health_card = $('#ad_health_card').val();
		var ad_service_center_id = 0;
		if($.trim($('#ad_health_card').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Enter Health Card No","#ad_health_card");			
		}
		else{		
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
					end_date: end_date,
					limit:10000,
					page_no:current_page_no
				},
				success: function(data) {
					var todate = "<?php echo date("Y-m-d"); ?>";
					var user_name =  "<?php echo $_SESSION['user_name']; ?>";
					var html = "";
					
					if($.trim(search_txt) == "Print"){
						var serach_areas= "";
						
						if(start_date && end_date !='')   serach_areas += "Date: "+start_date+" to "+end_date+ "<br>";				
						if(ad_health_card!=''){            
							if(!jQuery.isEmptyObject(data.records)){							
								serach_areas += "Health Card: "+ad_health_card+" <br/>";
								serach_areas += "Name : "+data.records[0].patient_name+" <br/>";
								serach_areas += "Address : "+data.records[0].address+" <br/>";	
								
								html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">My Health Kit Service Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'<br/> Total Services: '+data.total_records+'</small></th></tr></table>';
								
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
								html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Shastho Shikkha Foundation</h2><h4 style="text-align:center">My Female Service Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table><table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><tr><td><h4 style="text-align:center">There is no data.</h4></td></tr></table>';
							}
						}
						WinId = window.open("", "My Health Kit Service Report","width=950,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
						WinId.document.open();
						WinId.document.write(html);
						WinId.document.close();
					}			
				}
			});	
		}	
	}
	 		

	//print advance search data
	$('#adv_search_print').click(function(){
		load_my_healthKit_service_grid("Print");
	});

});


<!-- ------------------------------------------end --------------------------------------->
</script>