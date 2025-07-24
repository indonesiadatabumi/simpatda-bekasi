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
			showDialogGet(GLOBAL_FORM_SKPD_VARS["get_spt"], 'List SKPD', {'spt_periode' : $("#spt_periode").val(), 
																					'spt_jenis_pajakretribusi' : $("#spt_jenis_pajakretribusi").val(),
																					'mode' : 'from'}, 900, 500);
		}
	});
	
	$("#trigger_spt2").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogGet(GLOBAL_FORM_SKPD_VARS["get_spt"], 'List SKPD', {'spt_periode' : $("#spt_periode").val(), 
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
	var submitForm = function() {
		var showInsertResponse = function (response, status) {
            if(response.status == true) {
            	showNotification(response.msg);
            	$("#frm_penetapan_skpd").resetForm();
            	completePage();
            } else {
            	showWarning(response.msg);
            }
            
            $('#btn_save').one("click", submitForm);
		};
		
		var save_options = { 
			url : GLOBAL_FORM_SKPD_VARS["insert_skpd"],
			type : "POST",
			dataType: 'json',
			beforeSubmit: function(arr, $form, options) { 
				validate = jqform_validate(arr, $form, options);
				if(!validate)	$('#btn_save').one("click", submitForm);
				return validate;
			},
			success: showInsertResponse,
			error: function(){
                alert("Terjadi kesalahan pada aplikasi. Silahkan menghubungi administrator");
            }
		};
		
		$("#frm_penetapan_skpd").ajaxSubmit(save_options);
	};
	
	$('#btn_save').one("click", function() {
		submitForm();
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_FORM_SKPD_VARS["view_skpd"]);
	});
};

$(document).ready(function() {
	completePage();
	createEventToolbar();
});