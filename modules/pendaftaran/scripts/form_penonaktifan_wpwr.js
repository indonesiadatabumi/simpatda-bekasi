var completePage = function() {
	$('#wp_wr_kode_pajak').autotab({ target: 'wp_wr_golongan', format: 'text' });
	$('#wp_wr_golongan').autotab({ target: 'wp_wr_jenis_pajak', format: 'numeric' });
	$('#wp_wr_jenis_pajak').autotab({ target: 'wp_wr_no_registrasi', format: 'numeric' });
	$('#wp_wr_no_registrasi').autotab({ target: 'wp_wr_kode_camat', format: 'numeric', previous: 'wp_wr_gol' });
	$('#wp_wr_kode_camat').autotab({ target: 'wp_wr_kode_lurah', format: 'numeric', previous: 'wp_wr_no_urut' });
	$('#wp_wr_kode_lurah').autotab({ target: 'no_berita', format: 'numeric', previous: 'wp_wr_kd_camat' });
	
	
	$('#btn_npwpd').click(function() {
		showDialog("wajib_pajak/popup_npwpd?status=true", 'Nomor Pokok Wajib Pajak/Retribusi', 1000, 500);
	});
	
	$("#f_date_nonaktif").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#f_date_nonaktif').datepicker('setDate', 'c');
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_save').click(function() {
		if ($('#f_date_nonaktif').val() == '') {
			showWarning('Anda harus mengisi tanggal penonaktifan.');
		} else if ($('#wp_wr_id').val() == '') {
			showWarning('Anda harus mengisi kolom NPWPD');
		} else {
			showAuthentication();
		}
	});
	
	$('#btn_view').click(function() {
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/penonaktifan_wpwr/view");
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
        	$("#frm_penonaktifan_wp")[0].reset();
        } else {
        	showWarning(data.msg);
        }
	};
	
	var save_options = { 
		url : GLOBAL_NONAKTIF_WP_WR_VARS["add_wpwr_nonaktif"],
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: showInsertResponse	// post-submit callback 
	};
	
	$("#frm_penonaktifan_wp").ajaxSubmit(save_options);
};

$(document).ready(function(){
	completePage();
	createEventToolbar();
});