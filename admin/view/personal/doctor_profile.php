

<div class="x_content">
	<div class="x_panel employee_profile">
		<div class="x_title">
			<h2>Personal Information (<?php echo $user_type_name; ?>)</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content" id="iniial_collapse">
			<br />     
			<form method="emp"  id="doctor_update_form" name="doctor_info_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
				<div class="row">
					<div class="col-md-9">	
						<div class="form-group" id="is_active_home_page_div">
							<label class="control-label col-md-2 col-sm-2 col-xs-6">Active Home Page</label>
							<div class="col-md-4 col-sm-4 col-xs-6" id="home_checkbox">				
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12">Full Name</label>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<input type="text" id="doc_name" name="doc_name" required class="form-control col-lg-12" readonly="readonly"/>
							</div>	
							<label class="control-label col-md-2 col-sm-2 col-xs-6">User Name</label>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<input type="text" id="user_name" name="user_name" class="form-control col-lg-12" readonly="readonly"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-6">Speciality</label>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<input type="text" id="speciality" name="speciality" required class="form-control col-lg-12" readonly="readonly"/>
							</div>	
							<label class="control-label col-md-2 col-sm-2 col-xs-6">Address</label>
							<div class="col-md-4 col-sm-4 col-xs-6"> 
								<input type="text" id="address" name="address" class="form-control col-lg-12" readonly="readonly"/>
							</div>
						</div>					
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-6">Email</label>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<input type="email" id="email" name="email" class="form-control col-lg-12" readonly="readonly"/>
							</div>
							<label class="control-label col-md-2 col-sm-2 col-xs-6">Mobile No</label>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<input type="text" id="mobile_no" name="mobile_no" class="form-control col-lg-12" readonly="readonly"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<small style="color:red" >
									(If you need to change the password then choose a new password in <B>New Password</B> field.)
								</small>
							</div>
						</div>					
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-6">Old Password</label>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<input type="password" id="old_password" name="old_password" class="form-control col-lg-12"/>
							</div>
							<label class="control-label col-md-2 col-sm-2 col-xs-6">New Password</label>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<input type="password" id="new_password" name="new_password" class="form-control col-lg-12"/>
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<button  type="submit" id="save_doc_info" class="btn btn-success">Update</button>                                        
							</div>
							 <div class="col-md-8 col-sm-8 col-xs-12">
								<div id="form_submit_error" class="text-center" style="display:none"></div>
							 </div>
						</div>
					</div>
					<div class="col-md-3">
						<input type="hidden" id="img_url_to_copy" name="img_url_to_copy"/>
						<img src="" class="img-thumbnail" id="doc_img">
					</div>
				</div>
			</form> 
		</div>
	</div>
</div>	
	
<script src="js/customTable.js"></script> 


<script>

//------------------------------------- general & UI  --------------------------------------
	
	
$(document).ready(function () {	
	load_doc_profile = function load_doc_profile(){
		$('#is_active_home_page_div').hide();
		$.ajax({
			url: project_url+"controller/doctorController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_doctor_details_personal",
				doctor_id: "<?php echo $_SESSION['user_id']; ?>"
			},
			success: function(data){ 
				$('#doc_name').val(data.records.name);
				$('#user_name').val(data.records.username);
				$('#speciality').val(data.records.speciality);
				$('#address').val(data.records.address);	
				$('#email').val(data.records.email);
				$('#mobile_no').val(data.records.mobile_no);
				$('#doc_img').attr("src",project_url+data.records.image);
				$('#doc_img').attr("width", "70%","height","70%");
				if(data.records.is_active_home_page==1){
					$('#is_active_home_page_div').show();
					$('#home_checkbox').html("<i class='fa fa-check-square fa-2x' aria-hidden='true'></i>");
				}	
			}
		});
	}
	
	load_doc_profile("");
	
	var url = project_url+"controller/doctorController.php";
	$('#save_doc_info').click(function(event){		
		event.preventDefault();
		var formData = new FormData($('#doctor_update_form')[0]);
		formData.append("q","update_information");
		if($.trim($('#old_password').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Your Password!","#old_password");			
		}
		else{	
			$.ajax({
				url: url,
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_doc_info').removeAttr('disabled','disabled');
					if(data>0){
						success_or_error_msg('#form_submit_error',"success","Updated Successfully");
						$('#old_password').val('');
						$('#new_password').val('');
						load_doc_profile("");
					}
					else{
						success_or_error_msg('#form_submit_error',"danger","Old Password Does Not Match...");
						$('#old_password').val('');
						$('#new_password').val('');
					}  
				}	
			});
		}	
	})
				
});
</script>