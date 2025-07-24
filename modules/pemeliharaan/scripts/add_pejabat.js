
 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_save").click(function (){
 		var options = { 
    		url : GLOBAL_MASTER_PEJABAT_VARS["save"],
    		type : "POST",
    		dataType: 'json',
    		beforeSubmit: jqform_validate,	// pre-submit callback 
			success: function(response) {
				$("#frm_add_pejabat").resetForm();
				if (response.status == true)
					showNotification(response.msg);
				else
					showWarning(response.msg);
			}
		}; 
		
		$("#frm_add_pejabat").ajaxSubmit(options);
 	});
 	
 	$("#btn_close_add").click(function() {
 		$("#div_dialog_box").dialog('close');
 	});
 };
 
$(document).ready(function(){
	createEventToolbar();
});