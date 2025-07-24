/**
 * getNextNomor
 * @returns
 */
var getNextNomor = function() {
	$.ajax({
		type : "GET",
		url : GLOBAL_FORMULIR_VARS["next_no_formulir"],
		success: function(data){
			if (data.length > 0) {
				$('#txt_no_formulir').val(data);
			}
		}
	});
};

/**
 * createEventToolbar
 */
var createEventToolbar = function (){
	$("#btn_view").click(function (){
		// load content
		load_content(GLOBAL_FORMULIR_VARS["view"]);
	});
	
	
	var submitForm = function() {
		//Save di trigger oleh tombol Save, Reply dan Create Ticket
		var showInsertResponse = function (response, statusText) {
            if(response.status == true) {
               $("#frm_rekam_formulir").resetForm();
               showNotification(response.msg);
               getNextNomor();
            } else {
            	showWarning(response.msg);
            }
            $('#btn_save').one("click", submitForm);
		};
		
		var save_options = {
			url : GLOBAL_FORMULIR_VARS["save"],
			type : "POST",
			dataType: 'json',
			beforeSubmit: function(arr, $form, options) { 
				validate = jqform_validate(arr, $form, options);
				if(!validate)	$('#btn_save').one("click", submitForm);
				return validate;
			},	// pre-submit callback 
			success: showInsertResponse,	// post-submit callback 
			error: function(){
                alert("Terjadi kesalahan pada aplikasi. Silahkan menghubungi administrator");
            }
		};
		
		$("#frm_rekam_formulir").ajaxSubmit(save_options);
	};
	
	$("#btn_save").one("click", function() {
		submitForm();
	});
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
	$('#txt_tgl_kirim').datepicker('setDate', 'c');
	
	$('#txt_next_nomor').click(function(){ getNextNomor(); });	
   	
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
	getNextNomor();
	completePage();
	createEventToolbar();
});