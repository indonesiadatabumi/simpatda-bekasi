
$(document).ready(function(){
	$("#btn_insert").click(function (){
 		var options = { 
    		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/anggaran/insert",
    		type : "POST",
    		dataType: 'json',
    		beforeSubmit: jqform_validate,	// pre-submit callback 
			success: function(response) {
				if (response.status == true) {
					$("#frm_add_anggaran").resetForm();
					$("#tbl_anggaran").flexReload();					
					showNotification(response.msg);
				} else
					showWarning(response.msg);
			},
			error: function() {
				alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
			}
		}; 
		
		$("#frm_add_anggaran").ajaxSubmit(options);
 	});
 	
 	$("#btn_close").click(function() {
 		$("#div_dialog_box").dialog('close');
 	});
});