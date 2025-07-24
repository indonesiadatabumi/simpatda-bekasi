
 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_update").click(function (){
 		var options = { 
    		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/anggaran/update",
    		type : "POST",
    		dataType: 'json',
    		beforeSubmit: jqform_validate,	// pre-submit callback 
			success: function(response) {
				if (response.status == true) {
					$("#tbl_anggaran").flexReload();
					showNotification(response.msg);
					$("input[name=id]").val('');
				} else
					showWarning(response.msg);
			},
			error: function() {
				alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
			}
		}; 
		
		$("#frm_edit_anggaran").ajaxSubmit(options);
 	});
 	
 	$("#btn_close").click(function() {
 		$("#div_dialog_box").dialog('close');
 	});
 };
 
$(document).ready(function(){
	createEventToolbar();
});