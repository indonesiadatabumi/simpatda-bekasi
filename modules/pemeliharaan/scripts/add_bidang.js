
 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_save").click(function (){
 		var options = { 
    		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/bidang/insert",
    		type : "POST",
    		dataType: 'json',
    		beforeSubmit: jqform_validate,	// pre-submit callback 
			success: function(response) {
				$("#frm_add_bidang").resetForm();
				$("#tbl_bidang").flexReload();	
				if (response.status == true)
					showNotification(response.msg);
				else
					showWarning(response.msg);
			}
		}; 
		
		$("#frm_add_bidang").ajaxSubmit(options);
 	});
 	
 	$("#btn_close").click(function() {
 		$("#div_dialog_box").dialog('close');
 	});
 };
 
$(document).ready(function(){
	createEventToolbar();
});