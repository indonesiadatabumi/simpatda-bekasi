var insertOptionRekening = function(idSelect) {
	$.get(GLOBAL_PAJAK_HIBURAN_VARS["get_rekening"], { koderek : $("input[name=korek]").val() }, function(data){
		var option = "";
		option += "<option value=''>--</option>";
		if (data.total!=undefined && data.total>0){
			$.each(data.list, function(id, obj){
				option += "<option value='"+ obj.key +"'>"+ obj.value +"</option>";
			});
		}
		$("#" + idSelect).append(option);
	}, "json");
};

/**
 * check kode rekening is exist
 * @param n
 * @returns
 */
var checkKorek = function(id) {
	var i = $('#detailTable tr').length - 3;
	for (k=1;k<=i;k++) {
		try {
			if (document.getElementById('spt_dt_korek'+k).value == document.getElementById('spt_dt_korek'+id).value && k!=id) {
				showWarning('Kode Rekening yang sama sudah terpilih. Mohon pilih kode rekening lainnya!');
				$('#spt_dt_korek'+id).val('');
				$('#spt_dt_korek'+id).focus();
				return false;
			}
		} catch (ex) {
		}
	}
};

/**
 * parsing string by comma
 * @param arr
 * @returns
 */
var parseComma = function(arr) {
	if (arr == "") arr = ',';
	var myString = new String(arr);
	var myStringList = myString.split(','); // split on commas
	return myStringList;
};

/**
 * get tarif by rekening
 * @returns
 */
var getTarif = function(objPersen, obTarifDasar, val) {
	$('#' + objPersen).val(parseComma(val)[1]);
};

/**
 * getPajak
 * @returns
 */
var getPajak = function(objSptPajak, objPersen, objDasarPengenaan, objTarifDasar, objJumlahPajak) {
	if ($('#' + objJumlahPajak).val() != "" && $('#' + objTarifDasar).val() != "" && $('#' + objPersen).val() != "" && $('#' + objDasarPengenaan).val() != "") {
		tarifDasar = unformatCurrency($("#"+objTarifDasar).val());
		persenTarif = unformatCurrency($('#'+objPersen).val());
		var pajak = Math.round(tarifDasar * persenTarif  / 100);
		$('#'+objTarifDasar).val(formatCurrency($('#'+objTarifDasar).val()));
		$('#'+objSptPajak).val(formatCurrency(pajak));
	}
};

/**
 * to calculate
 * @returns
 */
var calc1 = function() {
	var nilai="";
	var i=1;
	$('#spt_pajak').val("");
	var rowCount = $('#detailTable tr').length;
	while ( i <= rowCount ) {
		try {
			var pajak = ($('#spt_pajak').val().toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'') * 1) + ($("#spt_dt_pajak"+i+"").val().toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'') * 1);
			$('#spt_pajak').val(pajak);
		} catch (ex) { }
		i++;
		$('#spt_pajak').val(formatCurrency($('#spt_pajak').val()));
	}
};

/**
 * addForm field
 * @returns
 */
var addFormField = function() {
	var rowCount = $('#detailTable tr').length;
	var id = rowCount - 2;
	counter = 0;
	while (counter < 40) {
		if ($('#row_detail' + id).length == 0) {
			break;
		} else {
			id++;
		}
		counter++;
	}
	rowField = appendRowField(id);	
	
	insertOptionRekening('spt_dt_korek'+id);
	$("#detailTable").append(rowField);
};

var appendRowField = function(id) {
	var rowField = 
		'<tr class="row0" id="row_detail'+ id +'" >'+
			'<td>'+
				'<input type="hidden" name="spt_dt_id[]" value="">' +
				'<select name="spt_dt_korek[]" id="spt_dt_korek'+ id +'" style="width: 300px" class="inputbox" ' +
					'onchange=" checkKorek('+ id +'); getTarif (\'spt_dt_persen_tarif'+ id +'\',\'spt_dt_tarif_dasar'+ id +'\',this.value); ' +
					'getPajak(\'spt_dt_pajak'+ id +'\',\'spt_dt_persen_tarif'+ id +'\',\'spt_dt_dasar_pengenaan'+ id +'\',\'spt_dt_tarif_dasar'+ id +'\',\'spt_dt_jumlah'+ id +'\');'+
					'calc1();">' +
				'</select>'+
			'</td>'+
			'<td>'+
				'<input type="text" name="spt_dt_dasar_pengenaan[]" id="spt_dt_dasar_pengenaan'+ id +'" class="inputbox" size="16" value="" onchange="getPajak(\'spt_dt_pajak'+ id +'\',\'spt_dt_persen_tarif'+ id +'\',\'spt_dt_dasar_pengenaan'+ id +'\',\'spt_dt_dasar_pengenaan'+ id +'\',\'spt_dt_jumlah'+ id +'\');calc1();" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;" autocomplete="off"/>'+
			'</td>'+
			'<td align="right">'+
				'<input type="text" name="spt_dt_persen_tarif[]" id="spt_dt_persen_tarif'+ id +'" class="inputbox" size="2" value=""  readonly="true" style="text-align:right;"/>'+
			'</td>'+
			'<td align="right">'+
				'<input type="text" name="spt_dt_pajak[]" id="spt_dt_pajak'+ id +'" class="inputbox" size="16" value="" readonly="true" style="text-align:right;"/></td>'+
			'<td><a href="#" onClick="removeFormField(\'#row_detail' + id + '\');calc1();return false;">Hapus</a></td>'+
		'</tr>';
	
	return rowField;
};

/**
 * removeFormField tr
 * @returns
 */
var removeFormField = function(id) {
	var x=window.confirm('Anda yakin akan menghapus detail tersebut?');
	if (x)
		return $(id).remove();
	else
	return;
};

/**
 * onCompletePage
 * @returns
 */
var completePage = function() {
	$('#btn_add_detail').click(function() {
		addFormField();
	});
	
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
	
	$("#spt_tgl_proses, #spt_tgl_entry").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
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
				$('#btn_add_detail').focus();
			}
			
			else if (e.which==9) return true;
			return false;
		}
	});

	$("button,input,select,textarea").focus(function() {
		$(this).select();
	});
};

/**
 * submit form
 * @returns
 */
var updateData = function() {
	var showUpdateResponse = function (response, status) {
        if(response.status == true) {
        	$("#div_dialog_post").dialog('close');
        	$("#pajak_hiburan_table").flexReload();
        	showNotification(response.msg);
        	$("input[name=id]").val('');
        } else {
        	showWarning(response.msg);
        }
	};
	
	var save_options = { 
		url : GLOBAL_PAJAK_HIBURAN_VARS["update_sptpd"],
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,
		success: showUpdateResponse
	};
	
	$("#frm_edit_sptpd_hiburan").ajaxSubmit(save_options);
};


/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_update').click(function() {
		showAuthentication();
	});
	
	$("#btn_close").click(function() {
 		$("#div_dialog_post").dialog('close');
 	});
};

$(document).ready(function() {
	completePage();
	findNPWPD();
	createEventToolbar();
	focusInput();
});