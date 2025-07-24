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

var insertOptionRekening = function(idSelect) {
	$.get(GLOBAL_PAJAK_AIR_VARS["get_rekening"], { koderek : $("input[name=kode_rek]").val() }, function(data){
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
	var i = $('#detailTable tr').length - 4;
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
	if ($('#' + objJumlahPajak).val() != "" && $('#' + objTarifDasar).val() != "" && $('#' + objPersen).val() != "") {
		tarifDasar = unformatCurrency($("#"+objTarifDasar).val());
		persenTarif = unformatCurrency($('#'+objPersen).val());
		var pajak = Math.round(tarifDasar * persenTarif  / 100);
		$('#'+objTarifDasar).val(formatCurrency($('#'+objTarifDasar).val()));
		$('#'+objSptPajak).val(formatCurrency(Math.ceil(pajak/100)*100));
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
	while ( i <= rowCount - 4 ) {
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
	var id = rowCount - 3;
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
				'<select name="spt_dt_korek[]" id="spt_dt_korek'+ id +'" class="inputbox" ' +
					'onchange=" checkKorek('+ id +'); getTarif (\'spt_dt_persen_tarif'+ id +'\',\'spt_dt_tarif_dasar'+ id +'\',this.value); ' +
					'getPajak(\'spt_dt_pajak'+ id +'\',\'spt_dt_persen_tarif'+ id +'\',\'spt_dt_dasar_pengenaan'+ id +'\',\'spt_dt_tarif_dasar'+ id +'\',\'spt_dt_jumlah'+ id +'\');'+
					'calc1();">' +
				'</select>'+
			'</td>'+
			'<td align="right">'+
				'<input type="text" name="spt_dt_jumlah[]" id="spt_dt_jumlah'+ id +'" class="inputbox" size="6" value="" onchange="getPajak(\'spt_dt_pajak'+ id +'\',\'spt_dt_persen_tarif'+ id +'\',\'spt_dt_dasar_pengenaan'+ id +'\',\'spt_dt_dasar_pengenaan'+ id +'\',\'spt_dt_jumlah'+ id +'\');calc1();" style="text-align:right;" autocomplete="off"/>'+
			'</td>'+
			'<td>'+
				'<input type="text" name="spt_dt_dasar_pengenaan[]" id="spt_dt_dasar_pengenaan'+ id +'" class="inputbox" size="12" value="" onchange="getPajak(\'spt_dt_pajak'+ id +'\',\'spt_dt_persen_tarif'+ id +'\',\'spt_dt_dasar_pengenaan'+ id +'\',\'spt_dt_dasar_pengenaan'+ id +'\',\'spt_dt_jumlah'+ id +'\');calc1();" style="text-align:right;" autocomplete="off"/>'+
			'</td>'+
			'<td align="right">'+
				'<input type="text" name="spt_dt_persen_tarif[]" id="spt_dt_persen_tarif'+ id +'" class="inputbox" size="2" value=""  readonly="true" style="text-align:right;"/>'+
			'</td>'+
			'<td align="right">'+
				'<input type="text" name="spt_dt_pajak[]" id="spt_dt_pajak'+ id +'" class="inputbox" size="10" value="" readonly="true" style="text-align:right;"/></td>'+
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
	$('#wp_wr_kode_lurah').autotab({ target: 'no_berita', format: 'numeric', previous: 'wp_wr_kd_camat' });
	
	$('#btn_npwpd').click(function() {
		showDialog("wajib_pajak/get_wp_sptpd/" + $("input[name=kodus_id]").val(), 'Nomor Pokok Wajib Pajak/Retribusi', 1000, 500);
	});
	
	$("#spt_tgl_proses, #spt_tgl_entry")
	/**.datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});**/
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
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_save').click(function() {
		if ($('#f_date_tutup').val() == '') {
			showWarning('Anda harus mengisi tanggal penutupan.');
		} else if ($('#wp_wr_id').val() == '') {
			showWarning('Anda harus mengisi kolom NPWPD');
		} else {
			var showInsertResponse = function (responseText, statusText) {
				data = $.parseJSON(responseText);
	            if(data.status == true) {
	            	showNotification(data.msg);
	            	$("#frm_penutupan_wp")[0].reset();
	            } else {
	            	showWarning(data.msg);
	            }
			};
			
			var save_options = { 
				url : GLOBAL_TUTUP_WP_WR_VARS["add_wpwr_tutup"],
				beforeSubmit: jqform_validate,	// pre-submit callback 
				success: showInsertResponse	// post-submit callback 
			};
			
			$("#frm_penutupan_wp").ajaxSubmit(save_options);
		}
	});
};

$(document).ready(function() {
	getNextNomor();
	completePage();
	createEventToolbar();
});