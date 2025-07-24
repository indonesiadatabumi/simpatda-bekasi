
var updateData = function() {
	var options = { 
		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/satuan_kerja/update",
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: function(response) {
			if (response.status == true) {
				$("#div_dialog_post").dialog('close');
				$("#tbl_satuan_kerja").flexReload();
				showNotification(response.msg);
			} else
				showWarning(response.msg);
		},
		error: function() {
			alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
		}
	}; 
	
	$("#frm_edit_skpd").ajaxSubmit(options);	
};
	
 /**
  * createEventToolbar
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