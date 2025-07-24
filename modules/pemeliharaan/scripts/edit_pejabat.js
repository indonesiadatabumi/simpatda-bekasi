
var updateData = function() {
	var options = { 
		url : GLOBAL_MASTER_PEJABAT_VARS["update"],
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: function(response) {
			$("#frm_edit_pejabat").resetForm();
			if (response.status == true)
				showNotification(response.msg);
			else
				showWarning(response.msg);
		}
	}; 
	
	$("#frm_edit_pejabat").ajaxSubmit(options);
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_update").click(function (){
 		showAuthentication();
 	});
 	
 	$("#btn_close_edit").click(function() {
 		$("#div_dialog_post").dialog('close');
 	});
 };
 
$(document).ready(function(){
	createEventToolbar();
});