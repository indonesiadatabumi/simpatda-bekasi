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
	
	$('#btn_npwpd').click(function() {
		showDialog(GLOBAL_FORM_LHP_VARS["get_wp"], 'List WP', 1000, 500);
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
            	$("#frm_penetapan_lhp").resetForm();
            	completePage();
            } else {
            	showWarning(response.msg);
            }
            $('#btn_save').one("click", submitForm);
		};
		
		var save_options = { 
			url : GLOBAL_FORM_LHP_VARS["insert"],
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
		
		$("#frm_penetapan_lhp").ajaxSubmit(save_options);
	};
	
	$('#btn_save').one("click", function() {
		submitForm();
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_FORM_LHP_VARS["view"]);
	});
};

$(document).ready(function() {
	completePage();
	createEventToolbar();
});