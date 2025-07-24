/**
 * completePage
 * @returns
 */
var completePage = function() {
	$('#btn_npwpd').click(function() {
		//showWajibPajak('false');
		showDialog("wajib_pajak/popup_npwpd?status=false", 'Nomor Pokok Wajib Pajak/Retribusi Non Aktif', 1000, 500);
	});
	
	$("#f_date_buka").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#f_date_buka').datepicker('setDate', 'c');
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_save').click(function() {
		if ($('#f_date_buka').val() == '') {
			showWarning('Anda harus mengisi tanggal pembukaan.');
		} else if ($('#wp_wr_id').val() == '') {
			showWarning('Anda harus mengisi kolom NPWPD');
		} else {
			showAuthentication();
		}
	});
	
	$('#btn_view').click(function() {
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/penutupan_wpwr/view");
	});
};

/**
 * submit form
 * @returns
 */
var updateData = function() {
	var showInsertResponse = function (responseText, statusText) {
		data = $.parseJSON(responseText);
        if(data.status == true) {
        	showNotification(data.msg);
        	$("#frm_pembukaan")[0].reset();
        } else {
        	showWarning(data.msg);
        }
	};
	
	var save_options = { 
		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/pembukaan_kembali_wpwr/save",
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: showInsertResponse	// post-submit callback 
	};
	
	$("#frm_pembukaan").ajaxSubmit(save_options);
};

$(document).ready(function(){
	completePage();
	createEventToolbar();
});