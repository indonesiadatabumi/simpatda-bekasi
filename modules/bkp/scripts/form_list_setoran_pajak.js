/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$("#btn_cetak_sspd").click(function(){
		url = GLOBAL_LIST_SETOR_PAJAK_VARS["sspd"] +
				"?spt_periode=" + $('#periode_spt').val() +
				"&spt_nomor=" + $('#nomor_spt').val() +
				"&spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
				"&setorpajret_jenis_ketetapan=" + $('#setorpajret_jenis_ketetapan').val() +
				"&tanggal_setor=" + $('#tanggal_setor').val() +
				"&penyetor=" + $('#penyetor').val() +
				"&jenis_setoran=" + $("#jenis_setoran").val();
		
		var html = '<iframe id="sspd" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		
		$("input[name=cetak]").val("1");
		return false;
	});
	
	$("#btn_cetak_sts").click(function(){
		/*
		url = GLOBAL_LIST_SETOR_PAJAK_VARS["sts"] + "?setoran_id=" + $("input[name=setor_id]").val();
		var html = '<iframe id="sspd" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		
		return false;
		*/
		// load content
		$("#content_panel").slideUp('fast').slideDown('slow');
		
		$("#content_panel").load(GLOBAL_LIST_SETOR_PAJAK_VARS["cetak_sts"], {
			setoran_id : $("input[name=setor_id]").val(), 
			cart : "0",
			jenis_pajak : $("input[name=spt_jenis_pajakretribusi]").val()
		});
	});
	
	$("#btn_cetak_sts_tampung").click(function() {
		$(this).attr('disabled', 'disabled');
		$.post(GLOBAL_LIST_SETOR_PAJAK_VARS["cetak_sts_cart"], function(data) {
			$("#btn_cetak_sts_tampung").removeAttr('disabled');
			if (data.status == true) {				
				$("#content_panel").slideUp('fast').slideDown('slow');
				
				$("#content_panel").load(GLOBAL_LIST_SETOR_PAJAK_VARS["cetak_sts"], {
					cart : "1",
					jenis_pajak : $("input[name=spt_jenis_pajakretribusi]").val()
				});
			} else {
				showWarning(data.msg);
			}
		}, "json");
	});
	
	/**
	 * submitForm sspd
	 */
	var submitForm = function() {
		var showInsertResponse = function (response, status) {
			if(response.status == true) {
            	$("input[name=setor_id]").val(response.setor_id);
            	//$("#txt_no_bukti").val("NO. BUKTI : " + response.no_bukti).slideDown('slow');
            	resetButton();
            	showNotification(response.msg);
            	
            	$("#btn_cetak_sts_tampung").show("slow");
    			$("#btn_empty").slideDown("slow");
            	$("#btn_cetak_sts").slideDown("slow");
            	$("#btn_tampung").slideDown("slow");
            	$("#btn_setor").removeAttr('disabled');
            } else {
            	showWarning(response.msg);
            	$(this).removeAttr("disabled");
            }
			
			$('#btn_setor').one("click", submitForm);
		};
		
		var save_options = { 
			url : GLOBAL_LIST_SETOR_PAJAK_VARS["setor_pajak"],
			dataType : "json",
			type : "POST",
			beforeSubmit: function(arr, $form, options) { 
				validate = jqform_validate(arr, $form, options);
				if(!validate)	$('#btn_setor').one("click", submitForm);
				return validate;
			},
			success: showInsertResponse,
			error: function(){
                alert("Terjadi kesalahan pada aplikasi. Silahkan menghubungi administrator");
            }
		};
		
		$("#frm_list_setoran_pajak").ajaxSubmit(save_options);
	};
	
	$('#btn_setor').one("click", function() {
		submitForm();
	});
	
	var submitTampung = function() {
		$.post(GLOBAL_LIST_SETOR_PAJAK_VARS["add_cart"], { 
			setor_id: $("input[name=setor_id]").val(), 
			jenis_pajak: $("input[name=spt_jenis_pajakretribusi]").val(),
			total_pajak: unformatCurrency($("#txt_setoran").val())
		}, function(data){
	 		if (data.status == true) {
				showNotification(data.msg);
			} else {
				showWarning(data.msg);
			}
	 		$('#btn_tampung').one("click", submitTampung);
		}, "json");
	};
	
	$('#btn_tampung').one("click", function() {
		submitTampung();
	});
	
	
	var submitEmpty = function() {
		$.post(GLOBAL_LIST_SETOR_PAJAK_VARS["empty_cart"], { }, function(data){
			if (data.status == true) {
				$("#btn_cetak_sts_tampung").hide();
				$("#btn_empty").hide();
				
				showNotification(data.msg);
			} else {
				showWarning(data.msg);
			}
		}, "json");
		$('#btn_empty').one("click", submitEmpty);
	};
	
	$("#btn_empty").one("click", function() {
		submitEmpty();
	});
	
	//button view list
	$("#btn_cancel").click(function() {
		//load content panel
		load_content(GLOBAL_LIST_SETOR_PAJAK_VARS["cancel"]);
	});
};

var resetButton = function() {
	if($("input[name=setor_id]").val() != "" || $("input[name=spt_pen_id]").val() == "") {
		$("#btn_cetak_sspd").hide();
		$("#btn_cetak_sts").show();
		$('#btn_setor').hide();
	} else {
		$("#btn_cetak_sspd").show();
		$("#btn_cetak_sts").hide();
		$('#btn_setor').show();
	}
};

/**
 * check cart
 * @returns
 */
var checkCart = function() {
	$.post(GLOBAL_LIST_SETOR_PAJAK_VARS["cetak_sts_cart"], { }, function(data) {
		if (data.status == true) {
			$("#btn_cetak_sts_tampung").show();
			$("#btn_empty").show();
			
		} else {
			$("#btn_cetak_sts_tampung").hide();
			$("#btn_empty").hide();
		}
	}, "json");
};

/**
 * on complete page
 * @returns
 */
var compeletePage = function() {
	$("#jenis_setoran").change(function() {
		if ($(this).val() == "2") {
			$("#txt_setoran").val($("#txt_pokok_pajak").val());
		} else {
			pokok_pajak = unformatCurrency($("#txt_pokok_pajak").val()) * 1;
			denda = unformatCurrency($("#txt_denda").val()) * 1;
			$("#txt_setoran").val(formatCurrency(pokok_pajak + denda));
		}
	});
};

$(document).ready(function() {
	createEventToolbar();
	resetButton();
	checkCart();
	compeletePage();
});