
var popupRefSelf = function(id) {
	showDialog("pendataan/hasil_pemeriksaan/get_setoran_wp/?wp_id=" + $("input[name=wp_wr_id]").val() 
												+ "&korek_id=" + $("#lhp_kode_rek").val()
												+ "&row_id=" + id
												, 'Daftar Setoran WP', 1000, 500);
};

/**
 * to calculate
 * @returns
 */
var calcTotal = function() {
	var i=0;
	$('#total_pajak').val("");
	var rowCount = $('#detailTable tr').length;
	
	while ( i <= rowCount) {
		try {
			var pajak = unformatCurrency($('#total_pajak').val()) * 1 + unformatCurrency($('#jumlah_pajak'+i).val()) * 1;
			$('#total_pajak').val(pajak);
		} catch (ex) { }
		i++;
		$('#total_pajak').val(formatCurrency($('#total_pajak').val()));
	}
};

var calcPengenaan = function(n) {
	persen_tarif = $('#korek_persen_tarif').val();
	pengenaan = (100/persen_tarif) * $('#pajak_terhutang'+n).val();
	
	$('#lhp_dt_dsr_pengenaan'+n).val(formatCurrency(pengenaan));
	calcKreditPajak(n);
};

var calcTerhutang = function(n) {
	if ($('#lhp_dt_tarif_persen'+n).val() == '') 
		persen_tarif = $('#korek_persen_tarif').val();
	else 
		persen_tarif = $('#lhp_dt_tarif_persen'+n).val();
	
	$('#pajak_terhutang'+n).val(unformatCurrency($('#lhp_dt_dsr_pengenaan'+n).val()) * persen_tarif / 100);
	$('#pajak_terhutang'+n).val(formatCurrency($('#pajak_terhutang'+n).val()));
	calcKreditPajak(n);
};

var calcKreditPajak = function(n) {
	$('#kredit_pajak'+n).val(unformatCurrency($('#lhp_dt_setoran'+n).val()) * 1 + unformatCurrency($('#lhp_dt_kompensasi'+n).val()) * 1 + 
			unformatCurrency($('#lhp_dt_kredit_pjk_lain'+n).val()) * 1);
	$('#kredit_pajak'+n).val(formatCurrency($('#kredit_pajak'+n).val()));
	calcPokokPajak(n);
};

var calcPokokPajak = function(n) {
	$('#pokok_pajak'+n).val(unformatCurrency($('#pajak_terhutang'+n).val()) * 1 - unformatCurrency($('#kredit_pajak'+n).val()) * 1);
	$('#pokok_pajak'+n).val(formatCurrency($('#pokok_pajak'+n).val()));
	calcBunga(n);
};

var calcBunga = function(n) {
	date1 = $("#lhp_tgl_periksa").val();
	date2 = $("#lhp_dt_periode1"+n).val();
	pokok = $("#pokok_pajak"+n).val();

	$.ajax({
		type : "POST",
		url : GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/hasil_pemeriksaan/check_bunga",
		data : "date1="+ date1 + "&date2=" + date2 + "&pokok=" + pokok + "&n=" + n,
		beforeSend: function(){
		},
		success: function(msg){
			$('#lhp_dt_bunga' + n).attr('value', formatCurrency(msg));
			if (msg.length > 0) {
				$('#callSelf').html(msg);
				calcSanksi(n);
			}
		}
	});
};

var calcSanksi = function(n) {
	$('#sanksi'+n).val(unformatCurrency($('#lhp_dt_bunga'+n).val()) * 1 - unformatCurrency($('#lhp_dt_kenaikan'+n).val()) * 1);
	$('#sanksi'+n).val(formatCurrency($('#sanksi'+n).val()));
	calcJumlahPajak(n);
};

var calcJumlahPajak = function(n) {
	$('#jumlah_pajak'+n).val(unformatCurrency($('#pokok_pajak'+n).val()) * 1 + unformatCurrency($('#sanksi'+n).val()) * 1);
	$('#jumlah_pajak'+n).val(formatCurrency($('#jumlah_pajak'+n).val()));
	calcTotal();
};

var addCalendar = function(id) {
	var dates = $("#lhp_dt_periode1" + id + ", #lhp_dt_periode2" + id).datepicker({
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
			if (this.id == "lhp_dt_periode1" + id) {
				ldmonth(this, "lhp_dt_periode2" + id);
			}
			checkPeriode(id);
		}
   	});
	
	$("#lhp_dt_periode1" + id + ", #lhp_dt_periode2" + id).change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	var ldmonth = function(obj, objPeriod) {
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
			$("#"+objPeriod).val(ldo);
		} else {
			$("#"+objPeriod).val('');
		}
	};
	
	var checkPeriode = function(n) {
		var rowCount = $('#detailTable tr').length;
		var id = rowCount - 3;
		
		for (k=0;k<=id;k++) {
			try {
				if ($('#lhp_dt_periode1'+k).val() == $('#lhp_dt_periode1'+n).val() && $('#lhp_dt_periode2'+k).val() == $('#lhp_dt_periode2'+n).val() && k!=n) {
					showWarning('Periode yang sama sudah digunakan. Mohon pilih periode yang lain!');
					$('#lhp_dt_periode1'+n).val('');
					$('#lhp_dt_periode2'+n).val('');
					$('#lhp_dt_setoran'+n).val('');
					$('#lhp_dt_tarif_persen'+n).val('');
					$('#lhp_dt_id_spt'+n).val('');
					return false;
				}
			} 
			catch (ex) {
			}
		}
	};
}

/**
 * addForm field
 * @returns
 */
var addFormField = function() {
	var rowCount = $('#detailTable tr').length;
	var id = rowCount - 3;
	/*
	counter = 0;
	while (counter < 40) {
		if ($('#row_detail' + id).length == 0) {
			break;
		} else {
			id++;
		}
		counter++;
	}
	*/
	rowField = appendRowField(id);	
	
	$("#detailTable").append(rowField);
	addCalendar(id);
};

var appendRowField = function(id) {
	var rowField = 
		'<tr class="row0" id="row_detail'+ id +'">'+
			'<td valign="top">'+
			'<input type="button" size="2" class="refSelf" value="..." onclick="popupRefSelf('+ id +')">'+
			'</td>'+
			'<td valign="top">'+
			'<input type="hidden" name="lhp_dt_tarif_persen[]" id="lhp_dt_tarif_persen'+ id +'" value="">'+
			'<input type="hidden" name="lhp_dt_id[]" id="lhp_dt_id'+ id +'">'+
	
			'<input type="text" name="lhp_dt_periode1[]" class="mandatory" id="lhp_dt_periode1'+ id +'" size="10"   />'+
			'</td>'+
			'<td valign="top">'+
			'<input type="text" name="lhp_dt_periode2[]" class="mandatory" id="lhp_dt_periode2'+ id +'" size="10"  />'+
			'</td>'+
			'<td align="right" valign="top">'+
			'<input type="text" name="lhp_dt_dsr_pengenaan[]" id="lhp_dt_dsr_pengenaan'+ id +'" onblur="calcTerhutang('+ id +');this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" class="numerics" size="17" value=""  style="text-align:right;"/>'+
			'</td>'+
			'<td align="right" valign="top">'+
			'<input type="text" name="pajak_terhutang[]" id="pajak_terhutang'+ id +'" class="inputbox" size="17" value="" onblur="calcPengenaan('+ id +');this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);"  style="text-align:right;" />'+
			'</td>'+
			'<td align="right" valign="top">'+
			'Setoran : '+
			'<input type="text" name="lhp_dt_setoran[]" id="lhp_dt_setoran'+ id +'" class="inputbox" size="17" value="" style="text-align:right;" onkeyout="calcKreditPajak('+ id +');" onchange="calcKreditPajak('+ id +');" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" /><br>'+
			'Kompensasi : '+
			'<input type="text" name="lhp_dt_kompensasi[]" id="lhp_dt_kompensasi'+ id +'" class="numerics" size="17" value="" onkeyout="calcKreditPajak('+ id +');" onchange="calcKreditPajak('+ id +');" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;"/><br>'+
			'Lain-lain : '+
			'<input type="text" name="lhp_dt_kredit_pjk_lain[]" id="lhp_dt_kredit_pjk_lain'+ id +'" class="numerics" size="17" value="" onkeyout="calcKreditPajak('+ id +');" onchange="calcKreditPajak('+ id +');" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;" /><br><hr>'+
			'Total : '+
			'<input type="text" name="kredit_pajak[]" id="kredit_pajak'+ id +'" class="inputbox" size="17" value="" readonly="true" style="text-align:right;"/>'+
	
			'<td align="right" valign="top">'+
			'<input type="text" name="pokok_pajak[]" id="pokok_pajak'+ id +'" class="inputbox" size="17" value="" readonly="true" style="text-align:right;"/>'+
			'</td>'+
	
			'<td align="right" valign="top">'+
			'Bunga : '+
			'<input type="text" name="lhp_dt_bunga[]" id="lhp_dt_bunga'+ id +'" class="inputbox" size="17" value="" style="text-align:right;" onkeyout="calcSanksi('+ id +');" onchange="calcSanksi('+ id +');" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" /><br>'+
			'Kenaikan : '+
			'<input type="text" name="lhp_dt_kenaikan[]" id="lhp_dt_kenaikan'+ id +'" class="inputbox" size="17" value="" style="text-align:right;" onkeyout="calcSanksi('+ id +');" onchange="calcSanksi('+ id +');" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" /><br><hr>'+
			'Total : '+
			'<input type="text" name="sanksi[]" id="sanksi'+ id +'" class="inputbox" size="17" value="" readonly="true" style="text-align:right;"/>'+
			'</td>'+
	
			'<td align="right" valign="top">'+
			'<input type="text" name="jumlah_pajak[]" id="jumlah_pajak'+ id +'" class="inputbox" size="17" value="" readonly="true" style="text-align:right;"/>'+
			'</td>' +
			'<td><a href="#" onClick="removeFormField(\'#row_detail' + id + '\');calcTotal();return false;">Hapus</a></td>'+
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
	$("input[name=btn_add_detail]").click(function() {
		if ($("#wp_wr_id").val() == "" || $("#korek_persen_tarif").val() == "") {
			showWarning('Pilih WP dan kode rekening terlebih dahulu');
		} else {
			addFormField();
		}
	});
	
	var rowCount = $('#detailTable tr').length;
	var id = rowCount - 3;
	for ( var row = 0; row < id; row++) {
		addCalendar(row);
	}
	
	$('#wp_wr_kode_pajak').autotab({ target: 'wp_wr_golongan', format: 'text' });
	$('#wp_wr_golongan').autotab({ target: 'wp_wr_jenis_pajak', format: 'numeric' });
	$('#wp_wr_jenis_pajak').autotab({ target: 'wp_wr_no_registrasi', format: 'numeric' });
	$('#wp_wr_no_registrasi').autotab({ target: 'wp_wr_kode_camat', format: 'numeric', previous: 'wp_wr_gol' });
	$('#wp_wr_kode_camat').autotab({ target: 'wp_wr_kode_lurah', format: 'numeric', previous: 'wp_wr_no_urut' });
	$('#wp_wr_kode_lurah').autotab({ target: 'lhp_no_periksa', format: 'numeric', previous: 'wp_wr_kode_camat' });
	
	$('#btn_npwpd').click(function() {
		showDialog("wajib_pajak/popup_npwpd/?status=true", '', 1000, 500);
	});	
	
	$("#trigger_rek").click(function() {
		showDialog(GLOBAL_LHP_VARS["get_rekening"], 'Kode Rekening', 800, 500);
	});
	
	$("#lhp_tgl, #lhp_tgl_periksa").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#lhp_tgl, #lhp_tgl_periksa').datepicker('setDate', 'c');
	
	$("#lhp_tgl, #lhp_tgl_periksa").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
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
 * submit form
 * @returns
 */
var updateData = function() {
	var showUpdateResponse = function (response, status) {
        if(response.status == true) {
        	showNotification(response.msg);
        } else {
        	showWarning(response.msg);
        }
	};
	
	var save_options = { 
		url : GLOBAL_LHP_VARS["update"],
		type : "POST",
		dataType: 'json',
		beforeSubmit: jqform_validate,
		success: showUpdateResponse
	};
	
	$("#frm_edit_lhp").ajaxSubmit(save_options);
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_update').click(function() {
		showAuthentication();
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_LHP_VARS["view"]);
	});
	
	//button add
	$("#btn_add").click(function() {
		load_content(GLOBAL_LHP_VARS["insert"]);
	});
};

/**
 * ready function
 */
$(document).ready(function() {
	completePage();
	findNPWPD();
	findKodeRekening();
	createEventToolbar();
});