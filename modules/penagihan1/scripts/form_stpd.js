/**
 * showDialog form
 * @param url
 * @param width
 * @param height
 * @returns
 */
var showDialogPenetapan = function(url, title, data, width, height) {
	$("body").append("<div id='div_dialog_box'></div>");
	$("#div_dialog_box").html(GLOBAL_MAIN_VARS["progress_indicator"]);
	$("#div_dialog_box").dialog({
		bgiframe: true,
		autoOpen: true,
		resizable: false,
		width: width,
		height: height,
		modal: true,
		position: 'center',
		open : function() {
            $('#div_dialog_box').dialog( "option" , "title" , title);
		}
	});
	
	if (url != '') {
		$.get(GLOBAL_MAIN_VARS["BASE_URL"] + url, data, 
			function(htm){
				$("#div_dialog_box").html(htm);
		},"html");
	}
};

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
			showDialogPenetapan(GLOBAL_FORM_STPD_VARS["get_spt"], 'List SPTPD', {'spt_periode' : $("#spt_periode").val(), 
																					'spt_jenis_pajakretribusi' : $("#spt_jenis_pajakretribusi").val(),
																					'mode' : 'from'}, 900, 500);
		}
	});
	
	$("#trigger_spt2").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogPenetapan(GLOBAL_FORM_STPD_VARS["get_spt"], 'List SPTPD', {'spt_periode' : $("#spt_periode").val(), 
																					'spt_jenis_pajakretribusi' : $("#spt_jenis_pajakretribusi").val(),
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
            	$("#frm_penetapan_stpd").resetForm();
            	completePage();
            } else {
            	showWarning(response.msg);
            }
		};
		
		var save_options = { 
			url : GLOBAL_FORM_STPD_VARS["insert"],
			type : "POST",
			dataType: 'json',
			beforeSubmit: jqform_validate,
			success: showInsertResponse
		};
		
		$("#frm_penetapan_stpd").ajaxSubmit(save_options);
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_FORM_STPD_VARS["view"]);
	});
};

$(document).ready(function() {
	completePage();
	createEventToolbar();
});