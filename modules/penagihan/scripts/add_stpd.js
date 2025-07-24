/**
 * showDialog form
 * @param url
 * @param width
 * @param height
 * @returns
 */
var showDialogStpd = function(url, title, data, width, height) {
	$("body").append("<div id='div_dialog_stpd'></div>");
	$("#div_dialog_stpd").html(GLOBAL_MAIN_VARS["progress_indicator"]);
	$("#div_dialog_stpd").dialog({
		bgiframe: true,
		autoOpen: true,
		resizable: false,
		width: width,
		height: height,
		modal: true,
		position: 'center',
		close: function(event, ui) 
        { 
            $(this).dialog('close');
        }
	});
	
	if (url != '') {
		$.get(GLOBAL_MAIN_VARS["BASE_URL"] + url, data, 
			function(htm){
				$("#div_dialog_stpd").html(htm);
		},"html");
	}
};

var ldmonth = function(obj) {
	var T=obj.value;  
	var D=new Date();    
	var dt=T.split("-");  
	D.setFullYear(dt[2]);  //alert("__1_>"+D.toString());  
	D.setMonth(dt[1]-1); // alert("__2_>"+D.toString());  
	D.setDate("32");   
	var ldx = 32-D.getDate(); 
	var m=D.getMonth();
	if (m == "0") m="12"; 
	if (m<10) m="0"+m;
	var ldo = ldx +"-"+ m +"-"+ dt[2]; //D.getFullYear();
	if (ldo != "NaN-NaN-NaN") {
		$('input[name=spt_periode_jual2]').val(ldo);
	} else {
		$('input[name=spt_periode_jual2]').val('');
	}
};

/**
 * onCompletePage
 * @returns
 */
var completePage = function() {
	$("input[name=tgl_proses]").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
	$('input[name=tgl_proses]').datepicker('setDate', 'c');
	
	$("input[name=tgl_proses]").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	$("#trigger_spt1").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogStpd("penagihan/stpd/get_spt", 'List SPT', { 
																					'jenis_pajak' : $("#jenis_pajak").val(),
																					'bulan_realisasi' : $("#bulan_realisasi").val(),
																					'tahun_realisasi' : $("#tahun_realisasi").val()
																			}, 900, 500);
		}
	});	
	
	$("#trigger_rek").click(function() {
		showDialog("rekening/popup_rekening?koderek=" + $("#korek").val(), 'Kode Rekening', 800, 500);
	});
	
	$("#jenis_pajak").change(function() {
		getNextNomor();
	});
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_save').click(function() {
		var showInsertResponse = function (response) {
            if(response.status == true) {
            	showNotification(response.msg);
            	resetState();
            	$("#stpd_table").flexReload();
            	getNextNomor();
            } else {
            	showWarning(response.msg);
            }
		};
		
		var save_options = { 
			url : GLOBAL_MAIN_VARS["BASE_URL"] + "penagihan/stpd/insert",
			type : "POST",
			dataType: 'json',
			beforeSubmit: jqform_validate,
			success: showInsertResponse,
			error: function() {
				alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
			} 
		};
		
		$("#frm_add_stpd").ajaxSubmit(save_options);
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "penagihan/stpd/");
	});
};


var resetState = function() {
	$('#spt_nomor').val("");
	$("input[name=setorpajret_id]").val("");
	$("#wp_wr_id").val("");
	$("#wp_wr_kode_pajak").val("");
	$("#wp_wr_golongan").val("");
	$("#wp_wr_jenis_pajak").val("");
	$("#wp_wr_no_registrasi").val("");
	$("#wp_wr_kode_camat").val("");
	$("#wp_wr_kode_lurah").val("");
	$("#wp_wr_nama").val("");
	$("#wp_wr_almt").val("");
	$("#bunga").val("");
	$("#setorpajret_periode_jual1").val("");
	$("#setorpajret_periode_jual2").val("");
	$("#setorpajret_tgl_bayar").val("");
	$("#setorpajret_jlh_bayar").val("");
	$("#bulan_pengenaan").val("");
	$("#spt_pajak").val("");
};

/**
 * get next nomor
 * @returns
 */
var getNextNomor = function() {
	$.post(GLOBAL_MAIN_VARS['BASE_URL'] + 'penagihan/stpd/get_next_nomor', {
		periode : $("#periode").val(),
		jenis_pajak : $("#jenis_pajak").val()
	}, 
		function(data) {
		  $('#stpd_nomor').val(data);
	});
};

$(document).ready(function() {
	completePage();
	createEventToolbar();
	getNextNomor();
});