

/**
 * submit form
 * @returns
 */
var updateData = function() {
	var showUpdateResponse = function (response, status) {
        if(response.status == true) {
        	showNotification(response.msg);
        } else {
        	showWarning(response.msg);
        }
	};
	
	var save_options = { 
		url : GLOBAL_PEMDA_VARS["edit"],
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,
		success: showUpdateResponse
	};
	
	$("#frm_pemda").ajaxSubmit(save_options);
};

/**
  * Form button
  */
 var createEventToolbar = function (){
 	$("#btn_edit").click(function (){ 		
 		if (showAuthentication() == "success")
 			updateData();
 	});
 };
 

$(document).ready(function(){
	createEventToolbar();
});