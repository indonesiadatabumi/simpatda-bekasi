
var updateData = function() {
	var options = { 
		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/jatuh_tempo/update",
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: function(response) {
			if (response.status == true) {
				showNotification(response.msg);
			} else
				showWarning(response.msg);
		},
		error: function() {
			alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
		}
	}; 
	
	$("#frm_jatuh_tempo").ajaxSubmit(options);	
};
 
$(document).ready(function(){
	$("#btn_simpan").click(function (){
 		showAuthentication();
 	});
});