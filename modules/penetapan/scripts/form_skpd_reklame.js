/**
 * onCompletePage
 * @returns
 */
var completePage = function() {
	$("input[name=netapajrek_tgl]").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
	$('input[name=netapajrek_tgl]').datepicker('setDate', 'c');
	
	$("input[name=netapajrek_tgl]").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	$("#trigger_spt1").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogGet(GLOBAL_FORM_SKPD_REKLAME_VARS["get_spt"], 'List SPTPD', {'spt_periode' : $("#spt_periode").val(), 
																					'spt_jenis_pajakretribusi' : $("input[name=spt_jenis_pajakretribusi]").val(),
																					'mode' : 'from'}, 900, 500);
		}
	});
	
	$("#trigger_spt2").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogGet(GLOBAL_FORM_SKPD_REKLAME_VARS["get_spt"], 'List SPTPD', {'spt_periode' : $("#spt_periode").val(), 
																					'spt_jenis_pajakretribusi' : $("input[name=spt_jenis_pajakretribusi]").val(),
																					'mode' : 'to'}, 900, 500);
		}
	});
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_save').click(function() {
		var showInsertResponse = function (response, status) {
            if(response.status == true) {
            	showNotification(response.msg);
            	$("#frm_penetapan_skpd_reklame").resetForm();
            	completePage();
            } else {
            	showWarning(response.msg);
            }
		};
		
		var save_options = { 
			url : GLOBAL_FORM_SKPD_REKLAME_VARS["insert_skpd"],
			type : "POST",
			dataType: 'json',
			beforeSubmit: jqform_validate,
			success: showInsertResponse
		};
		
		$("#frm_penetapan_skpd_reklame").ajaxSubmit(save_options);
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_FORM_SKPD_REKLAME_VARS["view_skpd"]);
	});
};

$(document).ready(function() {
	completePage();
	createEventToolbar();
});