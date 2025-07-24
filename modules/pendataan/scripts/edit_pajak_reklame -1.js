var add_detail_row = function(){

    var $tbody = $('#ads-detail-tbody'), $lc_tbody = $('#ads-detail-tbody > tr:last-child'), $n_rows = $('#n_detail_rows');

    var last_row_id = $lc_tbody.attr('id');
    
    x = last_row_id.split('-');
    last_order = x[1];
    new_order = parseInt(last_order)+1;

    new_row = "<tr id='row-"+new_order+"'><td class='outsets' valign='top'><table><tr><td class='key'>Jenis Reklame</td>"+
    	      "<td><select name='spt_dt_korek"+new_order+"' id='spt_dt_korek"+new_order+"' onchange=\"load_ads_assess_panel("+new_order+")\" class='inputbox mandatory'></select><input type='hidden' name='txt_korek"+new_order+"'/></td></tr>";
    new_row += "<tr><td class='key'>Area</td><td><input type='radio' name='area"+new_order+"' id='area"+new_order+"_1' value='1' onchange=\"execute_area_function("+new_order+")\" checked='checked' />&nbsp;Outdoor&nbsp;&nbsp;"+
			   "<input type='radio' name='area"+new_order+"' id='area"+new_order+"_2' onchange=\"execute_area_function("+new_order+")\" value='2' />&nbsp;Indoor</td></tr><tr><td class='key'>Naskah / Judul</td><td>"+
			   "<textarea cols='30' rows='2' name='txt_judul"+new_order+"' id='txt_judul"+new_order+"' class='inputbox mandatory' style='text-transform: uppercase;'></textarea></td></tr>";
	new_row += "<tr><td class='key'>Lokasi Pasang</td><td><textarea class='inputbox' name='txt_lokasi_pasang"+new_order+"' id='txt_lokasi_pasang"+new_order+"' cols='30' rows='2' style='text-transform: uppercase;'></textarea></td></tr>"+
			   "<tr><td class='key'>Perda Lama</td><td><input type='checkbox' name='chb_perda_lama"+new_order+"' id='chb_perda_lama"+new_order+"' onclick=\"execute_old_govregulation("+new_order+")\" value='1'>Ya</input></td></tr>";
	new_row += "<tr><td colspan='2' align='center'><input type='button' value='Hapus Detail' onclick=\"if(confirm('Anda yakin akan menghapus detail tersebut?')) {delete_detail_row("+new_order+")}\"/></td></tr>";
	new_row += "</table></td><td id='detail_nsr"+new_order+"' valign='top'></td></tr>";
    

    $n_rows.val(new_order);
    $tbody.append(new_row);
    insertOptionRekening('spt_dt_korek'+new_order);

};

var insertOptionRekening = function(idSelect) {
	$.get(GLOBAL_PAJAK_REKLAME_VARS["get_rekening"], { koderek : $("input[name=korek]").val() }, function(data){
		var option = "";
		option += "<option value=''>--</option>";
		if (data.total!=undefined && data.total>0){
			$.each(data.list, function(id, obj){
				if (GLOBAL_SESSION_VARS["USER_SPT_CODE"] == "10" ) {
					if (obj.value.substring(1, 12) != '4.1.1.04.02') {
						option += "<option value='"+ obj.key +"'>"+ obj.value +"</option>";
					}
				} else {
					if (obj.value.substring(1, 12) == '4.1.1.04.02') {
						option += "<option value='"+ obj.key +"'>"+ obj.value +"</option>";
					}
				}				
			});
		}
		$("#" + idSelect).append(option);
	}, "json");
};

var insertKelasJalan = function(row_number) {
	$.get(GLOBAL_PAJAK_REKLAME_VARS["get_kelas_jalan"], function(data){
		var option = "";
		option += "<option value=''>--</option>";
		if (data.total!=undefined && data.total>0){
			$.each(data.list, function(id, obj){
				option += "<option value='"+ obj.key +"'>"+ obj.value +"</option>";
			});
		}
		$("#kelas_jalan"+row_number).append(option);
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
var getNilaiKelasJalan = function(row_number) {
	if ($("#kelas_jalan"+row_number+" :selected").val() == "") {
		$("input[name=txt_luas"+row_number+"], input[name=txt_jumlah"+row_number+"], input[name=txt_jangka_waktu"+row_number+"]").val("");
	}
	
	$.get(GLOBAL_PAJAK_REKLAME_VARS["get_nilai_kelas_jalan"], { 
			rekening : $("#spt_dt_korek"+row_number).val(),
			kelas_jalan_id : $("#kelas_jalan"+row_number).val()
	}, function(data){
		if (data != null) {
			$("#txt_nilai_kelas_jalan"+row_number).val(formatCurrency(data.nilai));
			(data.luas != undefined) ? $("input[name=txt_luas"+row_number+"]").val(data.luas) : $("input[name=txt_luas"+row_number+"]").val("1");
			(data.jumlah != undefined) ? $("input[name=txt_jumlah"+row_number+"]").val(data.jumlah) : $("input[name=txt_jumlah"+row_number+"]").val("1");
			(data.jangka_waktu != undefined) ? $("input[name=txt_jangka_waktu"+row_number+"]").val(data.jangka_waktu) : $("input[name=txt_jangka_waktu"+row_number+"]").val("1");
		}
		
		calcNSR(row_number);
	}, "json");
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
		$('#'+objSptPajak).val(formatCurrency(Math.ceil(pajak/100)*100));
	}
};

var calcNSR = function(row_number) {
	var nsr = ($("#txt_luas"+row_number).val() * 1) * ($("#txt_jumlah"+row_number).val() * 1) * ($("#txt_jangka_waktu"+row_number).val() * 1) * ($('#txt_nilai_kelas_jalan'+row_number).val().toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'') * 1);
	if ($("input[name=area"+row_number+"]:checked").val() == "2")
		nsr = nsr * 0.5;
	
	$('#txt_nsr'+row_number).val(formatCurrency(Math.round(nsr)));
	
	var jumlah_pajak = 0;
	jumlah_pajak = nsr * (($("#spt_dt_persen_tarif"+row_number).val() * 1) / 100);
	
	$('#spt_sub_pajak'+row_number).val(formatCurrency(Math.ceil(parseInt(jumlah_pajak) / 100) * 100));

	calcTotalPajak();
};

var calcTotalPajak = function(){

	var n_rows = $('#n_detail_rows').val(), $spt_pajak = $('#spt_pajak');

	var total_tax = 0;

    for(i=1;i<=n_rows;i++){
        $sub_tax = $('#spt_sub_pajak'+i);
        if($sub_tax.length){
            sub_tax = gnv($sub_tax.val());
            sub_tax = replaceall(sub_tax,'.','');
            total_tax += parseFloat(sub_tax);
        }
    }
    
    total_tax = formatCurrency(total_tax);

    $spt_pajak.val(total_tax);

}

/**
 * to calculate
 * @returns
 */
var calcPajak = function(row_number) {
	
	var nilai = 0;
	luas = $("#txt_luas"+row_number).val() * 1;
	jumlah = $("#txt_jumlah"+row_number).val() * 1;
	jangka_waktu = $("#txt_jangka_waktu"+row_number).val() * 1;
	nilai_tarif = $('#txt_nilai_tarif'+row_number).val().toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'') * 1;
	persen = ($("#spt_dt_persen_tarif"+row_number).val() * 1) / 100;
	durasi = $("#txt_durasi"+row_number).val()/15;
	teater = $("#txt_teater"+row_number).val() * 1;
	
	var no_rekening = $("#spt_dt_korek"+row_number+" :selected").text().substring(1, 12); 
	if (no_rekening == "4.1.1.04.06") {
		nilai = luas * jangka_waktu * nilai_tarif;
	} else if (no_rekening == "4.1.1.04.07" || no_rekening == "4.1.1.04.08" || no_rekening == "4.1.1.04.11") {
		nilai = jumlah * nilai_tarif;
		persen = null;
	} else if (no_rekening == "4.1.1.04.03" || no_rekening == "4.1.1.04.04") {
		nilai = luas * nilai_tarif;
	} else if (no_rekening == "4.1.1.04.05") {
		nilai = luas * jangka_waktu * nilai_tarif;
	} else if (no_rekening == "4.1.1.04.10") {
		durasi = parseInt($("#txt_durasi"+row_number).val() / 15);
		nilai = durasi * ($('#txt_nilai_tarif'+row_number).val().toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'') * 1);
		persen = null;
	} else if (no_rekening == "4.1.1.04.09") {
		durasi = parseInt($("#txt_durasi"+row_number).val() / 15);
		nilai = durasi * teater * jumlah * jangka_waktu * ($('#txt_nilai_tarif'+row_number).val().toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'') * 1);
	}
	
	if ($("input[name=area"+row_number+"]:checked").val() == "2")
		nilai = nilai * 0.5;
	
	$("input[name=txt_nsr"+row_number+"]").val(nilai);
	
	if (persen != null) {		
		$('#spt_sub_pajak'+row_number).val(formatCurrency(Math.ceil(nilai * persen / 100) * 100));
	} else {		
		$('#spt_sub_pajak'+row_number).val(formatCurrency(Math.ceil(nilai / 100) * 100));
	}

	calcTotalPajak();
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
	//insertOptionRekening('spt_dt_korek');
	
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
	
	$("#spt_dt_korek").change(function(){
		var spt_dt_korek = $("#spt_dt_korek :selected");
		var no_rekening = spt_dt_korek.text().substring(1, 12); 
		$("#detail_nsr").html(row_jenis_reklame(no_rekening));
		
		if (no_rekening == "4.1.1.04.01" || no_rekening == "4.1.1.04.02" || no_rekening == "4.1.1.04.12") {
			$("#row_persen_tarif").show();
			$("#spt_dt_persen_tarif").val(spt_dt_korek.val().split(",")[1]);
			insertKelasJalan();
		} else {
			$("#row_persen_tarif").hide();
			$("#spt_dt_persen_tarif").val("");
			tarif_dasar = spt_dt_korek.val().split(",")[2];
			$("#txt_nilai_tarif").val(formatCurrency(tarif_dasar));
		}
		
		$("#spt_pajak").val(formatCurrency("0"));
		$("input[name=txt_korek]").val(no_rekening);
	});
	
	$("input[name=area]").change(function(){
		no_rekening = $("#spt_dt_korek :selected").text().substring(1, 12); 
		if (no_rekening == "4.1.1.04.01" || no_rekening == "4.1.1.04.02" || no_rekening == "4.1.1.04.12") {
			calcNSR();
		} else {
			calcPajak();
		}
	});
	
	$("#chb_perda_lama").click(function() {
		if ($("#chb_perda_lama").is(":checked")) {
			$("#spt_pajak").removeAttr("readonly");
		} else {
			$("#spt_pajak").attr("readonly", "readonly");
			$("#spt_pajak").val(formatCurrency("0"));
		}
	});
	
	getDataReklame();
};

/**
 * get data reklame and insert into input
 * @returns
 */
var getDataReklame = function() {

	var n_detail_rows = $('#n_detail_rows').val();

	for(i=1;i<=n_detail_rows;i++){
		
		var no_rekening = $("#spt_dt_korek"+i+" :selected").text().substring(1, 12);
		$("#detail_nsr"+i).html(row_jenis_reklame(no_rekening,i));
		
		$('input[name=txt_korek'+i+']').val(no_rekening);
		
		if (no_rekening == "4.1.1.04.01" || no_rekening == "4.1.1.04.02" || no_rekening == "4.1.1.04.12") {
			$("#row_persen_tarif"+i).show();
		} else {
			$("#row_persen_tarif"+i).hide();
		}
		
		insertKelasJalan(i);
		completeFieldFormValue(i,no_rekening);
	}
	
};

var completeFieldFormValue = function (row_number,no_rekening){

	$.getJSON(GLOBAL_PAJAK_REKLAME_VARS["detail_reklame"], { spt_dt_id : $("input[name=spt_dt_id"+row_number+"]").val() }, function(data){

		if (data.total !== undefined && data.total > 0) {			

			$("input[name=sptrek_id"+row_number+"]").val(data.list.sptrek_id);
			$("#txt_judul"+row_number).val(data.list.sptrek_judul);
			$("#txt_lokasi_pasang"+row_number).val(data.list.sptrek_lokasi);
			$("#area"+row_number).val(data.list.sptrek_area);
			
			timeout = setTimeout(function() {
						if (no_rekening == "4.1.1.04.01" || no_rekening == "4.1.1.04.02") {
							$("#txt_luas"+row_number).val(data.list.sptrek_luas);
							$("#txt_jumlah"+row_number).val(data.list.sptrek_jumlah);
							$("#txt_jangka_waktu"+row_number).val(data.list.sptrek_lama_pasang);
							$("#txt_nilai_kelas_jalan"+row_number).val(formatCurrency(data.list.sptrek_nilai_tarif));
							$("#txt_nsr"+row_number).val(formatCurrency(data.list.sptrek_nsr));
							$("#spt_dt_persen_tarif"+row_number).val(data.list.sptrek_tarif_pajak);
							$("#kelas_jalan"+row_number).val(data.list.sptrek_id_klas_jalan);
						} else if(no_rekening == "4.1.1.04.05") {
							$("#txt_luas"+row_number).val(data.list.sptrek_luas);
							$("#txt_jangka_waktu"+row_number).val(data.list.sptrek_lama_pasang);
							$("#txt_nilai_tarif"+row_number).val(formatCurrency(data.list.sptrek_nilai_tarif));
							$("#txt_nsr"+row_number).val(data.list.sptrek_nsr);
							$("#spt_dt_persen_tarif"+row_number).val(data.list.sptrek_tarif_pajak);
						} else if (no_rekening == "4.1.1.04.06") {
							$("#txt_jumlah"+row_number).val(data.list.sptrek_jumlah);
							$("#txt_jangka_waktu"+row_number).val(data.list.sptrek_lama_pasang);
							$("#txt_nilai_tarif"+row_number).val(formatCurrency(data.list.sptrek_nilai_tarif));
							$("#txt_nsr"+row_number).val(data.list.sptrek_nsr);
							$("#spt_dt_persen_tarif"+row_number).val(data.list.sptrek_tarif_pajak);
						} else if (no_rekening == "4.1.1.04.07" || no_rekening == "4.1.1.04.08" || no_rekening == "4.1.1.04.11" || no_rekening == "4.1.1.04.05") {
							$("#txt_jumlah"+row_number).val(data.list.sptrek_jumlah);
							$("#txt_nilai_tarif"+row_number).val(formatCurrency(data.list.sptrek_tarif_pajak));
						} else if (no_rekening == "4.1.1.04.03" || no_rekening == "4.1.1.04.04") {
							$("#txt_luas"+row_number).val(data.list.sptrek_luas);
							$("#txt_nilai_tarif"+row_number).val(formatCurrency(data.list.sptrek_tarif_pajak));
						} else if (no_rekening == "4.1.1.04.10") {
							$("#txt_durasi"+row_number).val(data.list.sptrek_durasi);
							$("#txt_nilai_tarif"+row_number).val(formatCurrency(data.list.sptrek_tarif_pajak));
						} else if (no_rekening == "4.1.1.04.09") {
							$("#txt_jumlah"+row_number).val(data.list.sptrek_jumlah);
							$("#txt_teater"+row_number).val(data.list.sptrek_teater);
                            $("#txt_durasi"+row_number).val(data.list.sptrek_durasi);
							$("#txt_jangka_waktu"+row_number).val(data.list.sptrek_lama_pasang);
							$("#txt_nilai_tarif"+row_number).val(formatCurrency(data.list.sptrek_nilai_tarif));
							$("#spt_dt_persen_tarif"+row_number).val(data.list.sptrek_tarif_pajak);
						} else if (no_rekening == "4.1.1.04.12") {
							$("#txt_luas"+row_number).val(data.list.sptrek_luas);
							$("#txt_jumlah"+row_number).val(data.list.sptrek_jumlah);
							$("#txt_jangka_waktu"+row_number).val(data.list.sptrek_lama_pasang);
							$("#txt_nilai_kelas_jalan"+row_number).val(formatCurrency(data.list.sptrek_nilai_tarif));
							$("#txt_nsr"+row_number).val(formatCurrency(data.list.sptrek_nsr));
							$("#spt_dt_persen_tarif"+row_number).val(data.list.sptrek_tarif_pajak);
							$("#kelas_jalan"+row_number).val(data.list.sptrek_id_klas_jalan);
						}
						
						$('#spt_sub_pajak'+row_number).val(formatCurrency(data.list.spt_dt_pajak));
						
					}, '500');
		}
	});
}

var load_ads_assess_panel = function(row_number){
		
	var spt_dt_korek = $("#spt_dt_korek"+row_number+" :selected");
	var no_rekening = spt_dt_korek.text().substring(1, 12); 
	$("#detail_nsr"+row_number).html(row_jenis_reklame(no_rekening,row_number));
	
	arr_spt_korek = spt_dt_korek.val().split(",");
	
	if (no_rekening == "4.1.1.04.01" || no_rekening == "4.1.1.04.02" || no_rekening == "4.1.1.04.12") {
		$("#row_persen_tarif"+row_number).show();
		$("#spt_dt_persen_tarif"+row_number).val(arr_spt_korek[1]);
		insertKelasJalan(row_number);
	} else {
		$("#row_persen_tarif"+row_number).hide();
		$("#spt_dt_persen_tarif"+row_number).val(arr_spt_korek[1]);
		$("#txt_nilai_tarif"+row_number).val(formatCurrency(arr_spt_korek[2]));
	}
	
	$("#spt_pajak").val(formatCurrency("0"));
	$("input[name=txt_korek"+row_number+"]").val(no_rekening);

}

var execute_area_function = function(row_number){
	no_rekening = $("#spt_dt_korek"+row_number+" :selected").text().substring(1, 12); 
	if (no_rekening == "4.1.1.04.01" || no_rekening == "4.1.1.04.02" || no_rekening == "4.1.1.04.12") {
		calcNSR(row_number);
	} else {
		calcPajak(row_number);
	}
}

var execute_old_govregulation = function(row_number){
	if ($("#chb_perda_lama"+row_number).is(":checked")) {
		$("#spt_pajak").removeAttr("readonly");
	} else {
		$("#spt_pajak").attr("readonly", "readonly");
		$("#spt_pajak").val(formatCurrency("0"));
	}
}

var row_jenis_reklame = function(no_rekening,row_number) {
	var rowField = "";
	
	if (no_rekening == "4.1.1.04.01" || no_rekening == "4.1.1.04.02") {
		rowField = 
			'<table><tr>'+
				'<td class="key">Kelas Jalan</td>' +
				'<td>'+
					'<select name="kelas_jalan'+row_number+'" id="kelas_jalan'+row_number+'" class="inputbox" ' +
						'onchange="getNilaiKelasJalan('+row_number+');">' +
					'</select>'+
				'</td></tr>'+
				'<tr>'+
					'<td class="key">Luas</td>' +
					'<td><input type="text" name="txt_luas'+row_number+'" id="txt_luas'+row_number+'" class="inputbox" size="5" onchange="calcNSR('+row_number+');"> M<sup>2</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Jumlah</td>' +
					'<td><input type="text" name="txt_jumlah'+row_number+'" id="txt_jumlah'+row_number+'" class="inputbox" size="5" onchange="calcNSR('+row_number+');"> Buah</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Jangka Waktu</td>' +
					'<td><input type="text" name="txt_jangka_waktu'+row_number+'" id="txt_jangka_waktu'+row_number+'" class="inputbox" size="5" onchange="calcNSR('+row_number+');"> Hari</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Besaran Nilai KJ</td>' +
					'<td><input type="text" name="txt_nilai_kelas_jalan'+row_number+'" id="txt_nilai_kelas_jalan'+row_number+'" class="inputbox" size="10" readonly="true" style="text-align:right;"></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key" style="color:#8BCF40">Nilai Sewa Reklame (NSR)</td>' +
					'<td>Rp.&nbsp;<input type="text" name="txt_nsr'+row_number+'" id="txt_nsr'+row_number+'" value="0" style="text-align:right" readonly="readonly" /></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Tarif Pajak</td>' +
					'<td><input type="text" name="spt_dt_persen_tarif'+row_number+'" id="spt_dt_persen_tarif'+row_number+'" class="inputbox" size="2" value=""  readonly="true" style="text-align:right;"/> %</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Pajak</td>' +
					'<td>Rp.&nbsp;<input type="text" name="spt_sub_pajak'+row_number+'" id="spt_sub_pajak'+row_number+'" class="inputbox" value="" style="text-align:right;" readonly/></td>' +
				'</tr>' +
			'</table>';
	} else if (no_rekening == "4.1.1.04.05") {
		rowField = 
			'<table>'+
				'<tr>'+
					'<td class="key">Luas</td>' +
					'<td><input type="text" name="txt_luas'+row_number+'" id="txt_luas'+row_number+'" class="inputbox" size="8" onchange="calcPajak('+row_number+');"> M<sup>2</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Lama Pemasangan</td>' +
					'<td><input type="text" name="txt_jangka_waktu'+row_number+'" id="txt_jangka_waktu'+row_number+'" class="inputbox" size="8" onchange="calcPajak('+row_number+');"> Hari</td>' +
				'</tr>' +				
				'<tr>'+
					'<td class="key">Nilai Tarif</td>' +
					'<td>' +
						'<input type="text" name="txt_nilai_tarif'+row_number+'" id="txt_nilai_tarif'+row_number+'" class="inputbox" size="10" readonly="true" style="text-align:right;">'+
						'<input type="hidden" name="txt_nsr'+row_number+'" value=""' +
					'</td>' +
				'</tr>' +
				'<tr>' +
					'<td class="key">Tarif Pajak</td>' +
					'<td><input type="text" name="spt_dt_persen_tarif'+row_number+'" id="spt_dt_persen_tarif'+row_number+'" class="inputbox" size="2" value="" readonly="true" style="text-align:right;"/> %</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Pajak</td>' +
					'<td>Rp.&nbsp;<input type="text" name="spt_sub_pajak'+row_number+'" id="spt_sub_pajak'+row_number+'" class="inputbox" value="" style="text-align:right;" readonly/></td>' +
				'</tr>' +
			'</table>';
	} else if (no_rekening == "4.1.1.04.06") {
		rowField = 
			'<table>'+
				'<tr>'+
					'<td class="key">Jumlah Peragaan</td>' +
					'<td><input type="text" name="txt_jumlah'+row_number+'" id="txt_jumlah'+row_number+'" class="inputbox" size="5" onchange="calcPajak('+row_number+');" onblur="calcPajak('+row_number+');"></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Lama Pemasangan</td>' +
					'<td><input type="text" name="txt_jangka_waktu'+row_number+'" id="txt_jangka_waktu'+row_number+'" class="inputbox" size="5" onchange="calcPajak('+row_number+');" onblur="calcPajak('+row_number+');"> Hari</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Nilai Tarif</td>' +
					'<td>' +
						'<input type="text" name="txt_nilai_tarif'+row_number+'" id="txt_nilai_tarif'+row_number+'" class="inputbox" size="15" readonly="true" style="text-align:right;">'+
						'<input type="hidden" name="txt_nsr'+row_number+'" value=""' +
					'</td>' +
				'</tr>' +
				'<tr>' +
					'<td class="key">Tarif Pajak</td>' +
					'<td><input type="text" name="spt_dt_persen_tarif'+row_number+'" id="spt_dt_persen_tarif'+row_number+'" class="inputbox" size="2" value="" readonly="true" style="text-align:right;"/> %</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Pajak</td>' +
					'<td>Rp.&nbsp;<input type="text" name="spt_sub_pajak'+row_number+'" id="spt_sub_pajak'+row_number+'" class="inputbox" value="" style="text-align:right;" readonly/></td>' +
				'</tr>' +
			'</table>';
	} else if (no_rekening == "4.1.1.04.07" || no_rekening == "4.1.1.04.08" || no_rekening == "4.1.1.04.11") {
		rowField = 
			'<table>'+
				'<tr>'+
					'<td class="key">Jumlah Peragaan</td>' +
					'<td><input type="text" name="txt_jumlah'+row_number+'" id="txt_jumlah'+row_number+'" class="inputbox" size="5" onchange="calcPajak('+row_number+');" onblur="calcPajak('+row_number+');"></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Tarif</td>' +
					'<td><input type="text" name="txt_nilai_tarif'+row_number+'" id="txt_nilai_tarif'+row_number+'" class="inputbox" size="16" readonly="true" style="text-align:right;"></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Pajak</td>' +
					'<td>Rp.&nbsp;<input type="text" name="spt_sub_pajak'+row_number+'" id="spt_sub_pajak'+row_number+'" class="inputbox" value="" style="text-align:right;" readonly/></td>' +
				'</tr>' +
			'</table>';
	} else if (no_rekening == "4.1.1.04.03" || no_rekening == "4.1.1.04.04") {
		rowField = 
			'<table>'+
				'<tr>'+
					'<td class="key">Luas</td>' +
					'<td><input type="text" name="txt_luas'+row_number+'" id="txt_luas'+row_number+'" class="inputbox" size="8" onchange="calcPajak('+row_number+');" onblur="calcPajak('+row_number+');"></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Tarif</td>' +
					'<td><input type="text" name="txt_nilai_tarif'+row_number+'" id="txt_nilai_tarif'+row_number+'" class="inputbox" size="10" readonly="true" style="text-align:right;"></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Pajak</td>' +
					'<td>Rp.&nbsp;<input type="text" name="spt_sub_pajak'+row_number+'" id="spt_sub_pajak'+row_number+'" class="inputbox" value="" style="text-align:right;" readonly/></td>' +
				'</tr>' +
			'</table>';
	} else if (no_rekening == "4.1.1.04.10") {
		rowField = 
			'<table>'+
				'<tr>'+
					'<td class="key">Durasi</td>' +
					'<td><input type="text" name="txt_durasi'+row_number+'" id="txt_durasi'+row_number+'" class="inputbox" size="6" onchange="calcPajak('+row_number+');" onblur="calcPajak('+row_number+');"></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Tarif</td>' +
					'<td><input type="text" name="txt_nilai_tarif'+row_number+'" id="txt_nilai_tarif'+row_number+'" class="inputbox" size="10" readonly="true" style="text-align:right;"> Per 15 menit</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Pajak</td>' +
					'<td>Rp.&nbsp;<input type="text" name="spt_sub_pajak'+row_number+'" id="spt_sub_pajak'+row_number+'" class="inputbox" value="" style="text-align:right;" readonly/></td>' +
				'</tr>' +
			'</table>';
	} else if (no_rekening == "4.1.1.04.09") {
		rowField = 
			'<table>'+
				'<tr>'+
					'<td class="key">Jumlah Studio</td>' +
					'<td><input type="text" name="txt_teater'+row_number+'" id="txt_teater'+row_number+'" class="inputbox" size="8" onchange="calcPajak('+row_number+');"> theater</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Jumlah Tayang</td>' +
					'<td><input type="text" name="txt_jumlah'+row_number+'" id="txt_jumlah'+row_number+'" class="inputbox" size="5" onchange="calcPajak('+row_number+');" onblur="calcPajak('+row_number+');"> kali</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Lama Penayangan</td>' +
					'<td><input type="text" name="txt_jangka_waktu'+row_number+'" id="txt_jangka_waktu'+row_number+'" class="inputbox" size="8" onchange="calcPajak('+row_number+');"> hari</td>' +
				'</tr>' +
                '<tr>'+
					'<td class="key">Durasi</td>' +
					'<td><input type="text" name="txt_durasi'+row_number+'" id="txt_durasi'+row_number+'" class="inputbox" size="6" onchange="calcPajak('+row_number+');" onblur="calcPajak('+row_number+');"> detik</td>' +
				'</tr>' +				
				'<tr>'+
					'<td class="key">Tarif</td>' +
					'<td><input type="text" name="txt_nilai_tarif'+row_number+'" id="txt_nilai_tarif'+row_number+'" class="inputbox" size="10" readonly="true" style="text-align:right;"> Per 15 detik</td>' +
					'<input type="hidden" name="txt_nsr" value=""' +
				'</tr>' +
				'<tr>' +
					'<td class="key">Tarif Pajak</td>' +
					'<td><input type="text" name="spt_dt_persen_tarif'+row_number+'" id="spt_dt_persen_tarif'+row_number+'" class="inputbox" size="2" value="" readonly="true" style="text-align:right;"/> %</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Pajak</td>' +
					'<td>Rp.&nbsp;<input type="text" name="spt_sub_pajak'+row_number+'" id="spt_sub_pajak'+row_number+'" class="inputbox" value="" style="text-align:right;" readonly/></td>' +
				'</tr>' +
			'</table>';
	} else if (no_rekening == "4.1.1.04.12") {
		rowField = 
			'<table><tr>'+
				'<td class="key">Kelas Jalan</td>' +
				'<td>'+
					'<select name="kelas_jalan'+row_number+'" id="kelas_jalan'+row_number+'" class="inputbox" ' +
						'onchange="getNilaiKelasJalan('+row_number+');">' +
					'</select>'+
				'</td></tr>'+
				'<tr>'+
					'<td class="key">Luas</td>' +
					'<td><input type="text" name="txt_luas'+row_number+'" id="txt_luas'+row_number+'" class="inputbox" size="5" onchange="calcNSR('+row_number+');"> M<sup>2</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Jumlah</td>' +
					'<td><input type="text" name="txt_jumlah'+row_number+'" id="txt_jumlah'+row_number+'" class="inputbox" size="5" onchange="calcNSR('+row_number+');"> Buah</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Jangka Waktu</td>' +
					'<td><input type="text" name="txt_jangka_waktu'+row_number+'" id="txt_jangka_waktu'+row_number+'" class="inputbox" size="5" onchange="calcNSR('+row_number+');"> Hari</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Besaran Nilai KJ</td>' +
					'<td><input type="text" name="txt_nilai_kelas_jalan'+row_number+'" id="txt_nilai_kelas_jalan'+row_number+'" class="inputbox" size="10" readonly="true" style="text-align:right;"></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key" style="color:#8BCF40">Nilai Sewa Reklame (NSR)</td>' +
					'<td>Rp.&nbsp;<input type="text" name="txt_nsr'+row_number+'" id="txt_nsr'+row_number+'" value="0" style="text-align:right" readonly="readonly" /></td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Tarif Pajak</td>' +
					'<td><input type="text" name="spt_dt_persen_tarif'+row_number+'" id="spt_dt_persen_tarif'+row_number+'" class="inputbox" size="2" value=""  readonly="true" style="text-align:right;"/> %</td>' +
				'</tr>' +
				'<tr>'+
					'<td class="key">Pajak</td>' +
					'<td>Rp.&nbsp;<input type="text" name="spt_sub_pajak'+row_number+'" id="spt_sub_pajak'+row_number+'" class="inputbox" value="" style="text-align:right;" readonly/></td>' +
				'</tr>' +
			'</table>';
	}
	
	return rowField;
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
			else if (this.name == "spt_periode" ) $('select[name=spt_jenis_pemungutan]').focus();
			else if (this.name == "spt_jenis_pemungutan" ) $('input[name=wp_wr_nama]').focus();
			else if (this.name == "wp_wr_nama" ) $('textarea[name=wp_wr_almt]').focus();
			else if (this.name == "wp_wr_almt" ) $('input[name=spt_periode_jual1]').focus();
			else if (this.name == "spt_periode_jual1" ) $('#spt_dt_korek').focus();
			else if (this.name == "spt_dt_korek") $('#txt_judul').focus();
			else if (this.name == "txt_judul" ) $('textarea[name=txt_lokasi_pasang]').focus();
			
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
        	$("#pajak_reklame_table").flexReload();
        	showNotification(response.msg);
        	$("input[name=id]").val('');
        } else {
        	showWarning(response.msg);
        }
	};
	
	var save_options = { 
		url : GLOBAL_PAJAK_REKLAME_VARS["update_sptpd"],
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,
		success: showUpdateResponse
	};
	
	$("#frm_edit_reklame").ajaxSubmit(save_options);
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

var replaceall = function(str,replace,with_this)
{    
    var str_hasil ="";
    
    for(var i=0;i<str.length;i++)
    {
        if (str[i] == replace)        
            var temp = with_this;        
        else      
            var temp = str[i];
        
        str_hasil += temp;
    }
    var result = str_hasil.toString();

    return result;
}

var gnv = function(val,default_val)
{
  	default_val = (typeof(default_val)!='undefined'?default_val:'0');
    return (val==''?default_val:val);
}

$(document).ready(function() {
	completePage();
	findNPWPD();
	createEventToolbar();
	focusInput();
});
