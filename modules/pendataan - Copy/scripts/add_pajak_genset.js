/**
 * get next nomor sptpd
 * @returns
 */
var getNextNomor = function() {
	$.ajax({
		type : "POST",
		url : GLOBAL_MAIN_VARS["NEXT_NO_SPTPD"],
		data : "spt_periode=" + $('#spt_periode').val() + 
				"&spt_jenis_pajakretribusi=" + $('input[name=spt_jenis_pajakretribusi]').val(),
		success: function(msg){
			if (msg.length > 0) {
				$('#spt_no_register').val(msg);
			}
		}
	});
};

/**
 * getPengenaan
 * @returns
 */
var getPengenaan = function(objSptPajak, objDasarPengenaan, objPersen) {
	if ($('#' + objPersen).val() == "" && $('#' + objPersen).val() == 0) {
		var pajak = Math.round((unformatCurrency($('#' + objSptPajak).val()) * 1));
	} else {
		var pajak = Math.round((unformatCurrency($('#' + objSptPajak).val()) * 1)* (100 / ($('#' + objPersen).val() * 1)));
	}
	
	$('#'+objDasarPengenaan).val(formatCurrency(pajak));
};

/**
 * check npwpd
 * @returns
 */
var findNPWPD = function() {
	$(".npwpd").blur(function() {
		$.ajax({
			type: "POST",
			url: GLOBAL_MAIN_VARS["BASE_URL"] + "wajib_pajak/get_wp_by_npwpd",
			dataType: "json",
			data: {
				wp_wr_kode_pajak: $("#wp_wr_kode_pajak").val(),
				wp_wr_golongan: $("#wp_wr_golongan").val(),
				wp_wr_jenis_pajak: $("#wp_wr_jenis_pajak").val(),
				wp_wr_no_registrasi: $("#wp_wr_no_registrasi").val(),
				wp_wr_kode_camat: $("#wp_wr_kode_camat").val(),
				wp_wr_kode_lurah: $("#wp_wr_kode_lurah").val(),
				kodus: $("input[name=kodus_id]").val()
			},
			success: function(response) {
                if(response.status==false)
                {
                    $("#wp_wr_id").val('');
                	$("#wp_wr_nama").val('');
                	$("#wp_wr_almt").val(''); 
                	$("#wp_wr_lurah").val('');
                	$("#wp_wr_camat").val(''); 
                	$("#wp_wr_kabupaten").val('');
                    showWarning(response.msg);
                }
                if(response.status==true)
                {
                	$("#wp_wr_id").val(response.data.wp_wr_id);
                	$("#wp_wr_nama").val(response.data.wp_wr_nama);
                	$("#wp_wr_almt").val(response.data.wp_wr_almt); 
                	$("#wp_wr_lurah").val(response.data.wp_wr_lurah);
                	$("#wp_wr_camat").val(response.data.wp_wr_camat); 
                	$("#wp_wr_kabupaten").val(response.data.wp_wr_kabupaten);
                }
            }
		});
	});
};

/**
 * findKodeRekening pajak
 * @returns
 */
var findKodeRekening = function() {
	$(".rekening").blur(function() {
		$.ajax({
			type: "POST",
			url: GLOBAL_MAIN_VARS["BASE_URL"] + "rekening/find_rekening",
			dataType: "json",
			data: {
				korek: $("#korek").val(),
				korek_rincian: $("#korek_rincian").val(),
				korek_sub1: $("#korek_sub1").val()
			},
			success: function(response) {
				if(response.status==true)
                {
                	$("#spt_kode_rek").val(response.data.korek_id);
                	$("#korek_rincian").val(response.data.jenis);
                	$("#korek_sub1").val(response.data.klas);
                	$("#korek_nama").val(response.data.korek_nama);
                	$("#korek_persen_tarif").val(response.data.korek_persen_tarif);
                }
				else
                {
					$("#spt_kode_rek").val('');
					$("#korek_rincian").val('');
                	$("#korek_sub1").val('');
                	$("#korek_nama").val('');
                	$("#korek_persen_tarif").val('');
                    showWarning(response.msg);
                }
            }
		});
	});
};


/**
 * onCompletePage
 * @returns
 */
var completePage = function() {	
	$('#btn_reset_spt').click(function(){
		$('#spt_nomor').val('');
	});
	$('#wp_wr_kode_pajak').autotab({ target: 'wp_wr_golongan', format: 'text' });
	$('#wp_wr_golongan').autotab({ target: 'wp_wr_jenis_pajak', format: 'numeric' });
	$('#wp_wr_jenis_pajak').autotab({ target: 'wp_wr_no_registrasi', format: 'numeric' });
	$('#wp_wr_no_registrasi').autotab({ target: 'wp_wr_kode_camat', format: 'numeric', previous: 'wp_wr_gol' });
	$('#wp_wr_kode_camat').autotab({ target: 'wp_wr_kode_lurah', format: 'numeric', previous: 'wp_wr_no_urut' });
	$('#wp_wr_kode_lurah').autotab({ target: 'fDate', format: 'numeric', previous: 'wp_wr_kd_camat' });
	
	$('#btn_npwpd').click(function() {
		showDialog("wajib_pajak/get_wp_sptpd/" + $("input[name=kodus_id]").val(), 'Nomor Pokok Wajib Pajak/Retribusi', 1000, 500);
	});
	
	$("#trigger_rek").click(function() {
		showDialog(GLOBAL_PAJAK_GENSET_VARS["get_rekening"]+"?koderek=" + $("#korek").val(), 'Kode Rekening', 800, 500);
	});
	
	$("#spt_tgl_proses, #spt_tgl_entry").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#spt_tgl_proses, #spt_tgl_entry').datepicker('setDate', 'c');
	
	$("#spt_tgl_proses, #spt_tgl_entry, #fDate, #tDate").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	var dates = $("#fDate, #tDate").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		constrainInput: true,
		duration: "fast",
		beforeShow: function(){
			$("#ui-datepicker-div").css("zIndex", 99999);
			
			if ( $.browser.msie && $.browser.version == "6.0") {
				setTimeout(function() {
					$('#ui-datepicker-div').css('position', "absolute");
					$('#ui-datepicker-div').bgiframe();
				}, 10);
			}
		},
		onSelect: function( selectedDate ) {
			if (this.id == "fDate") {
				ldmonth(this);
			}
		}
   	});
	
	$("#korek_persen_tarif").change(function() {
		getPengenaan('spt_pajak','spt_nilai','korek_persen_tarif');
	});
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
 * function to focus the input
 * @returns
 */
var focusInput = function() {
	$("#spt_no_register").focus();
	
	var isShift = false;
	$(document).change(function(e){ if(e.which == 16) isShift=false; });
	
	$("input[type=text],input[type=radio],input[type=checkbox],select").keypress(function(e) {
		if(e.which == 16) isShift=true;
		if ((e.which==13 || e.which==9) && isShift == false) {
			if (this.name == "spt_no_register" ) { $('input[name=spt_tgl_proses]').focus(); return false;}
			else if (this.name == "spt_tgl_proses" ) $('input[name=spt_tgl_entry]').focus();
			else if (this.name == "spt_tgl_entry" ) $('input[name=spt_periode]').focus();
			else if (this.name == "spt_periode" ) $('input[name=wp_wr_golongan]').focus();
			else if (this.name == "wp_wr_golongan" ) $('input[name=wp_wr_jenis_pajak]').focus();
			else if (this.name == "wp_wr_jenis_pajak" ) $('input[name=wp_wr_no_registrasi]').focus();
			else if (this.name == "wp_wr_no_registrasi" ) $('input[name=wp_wr_kode_camat]').focus();
			else if (this.name == "wp_wr_kode_camat" ) $('input[name=wp_wr_kode_lurah]').focus();
			else if (this.name == "wp_wr_kode_lurah") $('select#spt_jenis_pemungutan').focus();
			else if (this.name == "spt_jenis_pemungutan" ) $('input[name=spt_periode_jual1]').focus();
			else if (this.name == "spt_periode_jual1" || this.name == "spt_periode_jual2") {
				$('input[name=spt_pajak]').focus();
			}
			else if (this.name == "korek" ) $('input[name=korek_rincian]').focus();
			else if (this.name =="korek_rincian" ) $('input[name=korek_sub1]').focus();
			else if (this.name == "korek_sub1" ) $('input[name=spt_pajak]').focus();
			else if (e.which==9) return true;
			return false;
		}
	});

	$("button,input,select,textarea").focus(function() {
		$(this).select();
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
            	$("#frm_add_sptpd_genset").resetForm();
            	getNextNomor();
            	completePage();
            } else {
            	showWarning(response.msg);            	
            }
            $('#btn_save').one("click", submitForm);
		};
		
		var save_options = { 
			url : GLOBAL_PAJAK_GENSET_VARS["insert_sptpd"],
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
		
		$("#frm_add_sptpd_genset").ajaxSubmit(save_options);
	};
	
	$('#btn_save').one("click", function() {
		submitForm();
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_PAJAK_GENSET_VARS["view_sptpd"]);
	});
};

var getRekeningGenset = function() {
	$.post(GLOBAL_PAJAK_GENSET_VARS["rekening_genset"], {
					korek : $("input[name=korek]").val(),
					korek_rincian : "01", korek_sub1 : "00"}, function(response) {
		$('#spt_kode_rek').val(response.data['korek_id']);
		$('#korek_rincian').val(response.data['jenis']);
		$('#korek_sub1').val(response.data['klas']);		
		$('#korek_nama').val(response.data['korek_nama']);
	}, 'json');
};

$(document).ready(function() {
	getNextNomor();
	getRekeningGenset();
	completePage();
	findNPWPD();
	findKodeRekening();
	createEventToolbar();
	focusInput();
});