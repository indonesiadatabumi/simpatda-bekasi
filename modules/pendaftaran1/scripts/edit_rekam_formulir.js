/**
 * createEventToolbar
 */
var createEventToolbar = function (){
	$("#btn_view").click(function (){
		// load content
		load_content(GLOBAL_FORMULIR_VARS["view"]);
	});
	
	$("#btn_add").click(function (){
		// load content
		load_content(GLOBAL_FORMULIR_VARS["add"]);
	});
	
	$("#btn_update").click(function () {
		showAuthentication();
	});
};

/**
 * submit form
 * @returns
 */
var updateData = function() {
	//Save di trigger oleh tombol Save, Reply dan Create Ticket
	var showUpdateResponse = function (response, statusText) {
        if(response.status == true) {
           showNotification(response.msg);
        } else {
        	showWarning(response.msg);
        }
	};
	
	var save_options = {
		url : GLOBAL_FORMULIR_VARS["update"],
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: showUpdateResponse	// post-submit callback 
	};
	
	$("#frm_rekam_formulir").ajaxSubmit(save_options);
};

/**
 * completePage
 * @returns
 */
var completePage = function(){
	var isShift = false;
	$(document).keyup(function(e){ if(e.which == 16) isShift=false; });
	
	$("button,input,select,textarea").focus(function() {
		$(this).select();
	});
	
	$("#txt_tgl_kirim").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast"
	});
   	
   	//Data Type Combo (Category - Sub Category - Sub Sub Category)
	$('#txt_kode_camat').chainSelect('#txt_kode_lurah', GLOBAL_MAIN_VARS["BASE_URL"] + "common/get_kelurahan_id",
	{
		before: function(target) {
		},
		after: function(target) {
		}
	});
};

$(document).ready(function() {
	completePage();
	createEventToolbar();
});