<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($user_type == 2 && $user_type == 3){
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
        <h2>Health Card Service Report</h2>
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
					<div class="row">						
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
						<button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"></i> Show Report</button>
					</div>
				</div> 
			</div>
		</div>
		<!-- Adnach search end -->	
 
    </div>
</div>

<?php
	} 
?>

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
	
	var user_type= "<?php echo $user_type; ?>";
	load_bill_grid = function load_bill_grid(){		
		var start_date = $("#start_date").val();	
		var end_date = $("#end_date").val();	
		var ad_type = $("input:radio[name=ad_type]:checked").val();	
		var selected_doc_diag_value = $("#ad_payment_select option:selected").val();
		var selected_doc_diag_text = $("#ad_payment_select option:selected").text();
		
		$.ajax({
			url: project_url+"controller/reportController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "my_service_record",
				start_date: start_date,
				end_date: end_date,
				ad_type: ad_type,
				selected_doc_diag_value: selected_doc_diag_value,
				selected_doc_diag_text: selected_doc_diag_text,
			},
			success: function(data) {
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $_SESSION['user_name']; ?>";
				var html = "";
				var total_amount = 0;
				var discount_amount = 0;
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
		});	
	}

});

// advance data
$(document).ready(function () {	
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_bill_grid();
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


</script>