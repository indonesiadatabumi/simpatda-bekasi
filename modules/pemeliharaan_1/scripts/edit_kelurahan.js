
var updateData = function() {
	var options = { 
		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/kelurahan/update",
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: function(response) {
			if (response.status == true) {				
				$("#tbl_kelurahan").flexReload();
				showNotification(response.msg);
				setTimeout($("#div_dialog_post").dialog('close'), 500);
				$("input[name=id]").val('');
			} else
				showWarning(response.msg);
		},
		error: function() {
			alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
		}
	}; 
	
	$("#frm_edit_kelurahan").ajaxSubmit(options);	
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