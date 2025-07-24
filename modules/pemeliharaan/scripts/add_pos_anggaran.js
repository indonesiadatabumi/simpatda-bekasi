
$(document).ready(function(){	
	$("#btn_insert").click(function (){
		var options = { 
    		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/pos_anggaran/insert",
    		type : "POST",
    		dataType: 'json',
    		beforeSubmit: jqform_validate,	// pre-submit callback 
			success: function(response) {
				if (response.status == true) {
					$("#frm_add_pos_anggaran").resetForm();
					$("#tbl_pos_anggaran").flexReload();					
					showNotification(response.msg);
				} else
					showWarning(response.msg);
			},
			error: function() {
				alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
			}
		}; 
		
		$("#frm_add_pos_anggaran").ajaxSubmit(options);
 	});
 	
 	$("#btn_close_add").click(function() {
 		$("#div_dialog_box").dialog('close');
 	});
});