
var updateData = function() {
	var options = { 
		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/kode_rekening/update",
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: function(response) {
			if (response.status == true) {
				$("#div_dialog_post").dialog('close');
				$("#frm_edit_kode_rekening").resetForm();
				$("#tbl_kode_rekening").flexReload();					
				showNotification(response.msg);
			} else
				showWarning(response.msg);
		},
		error: function() {
			alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
		}
	}; 
	
	$("#frm_edit_kode_rekening").ajaxSubmit(options);	
};

$(document).ready(function(){
	$("#korek_kategori").change(function() {
		if ($(this).val() != "") {
			$.post(GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/kode_rekening/get_korek_kategori", { ref_kakorek_id: $(this).val() }, 
				function(response) {
					$("#korek_tipe").val(response.ref_kakorek_tipe);
					$("#korek_kelompok").val(response.ref_kakorek_kelompok);
			   }, "json");
		} else {
			$("#korek_tipe").val('');
			$("#korek_kelompok").val('');
		}
	});
	
	$("#btn_update").click(function (){
		showAuthentication();
 	});
 	
 	$("#btn_close_edit").click(function() {
 		$("#div_dialog_post").dialog('close');
 	});
});