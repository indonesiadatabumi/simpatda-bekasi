
/**
 * validateForm
 * @returns
 */
var validateForm = function() {
	var result = false;
	if ($.trim($("#tahun").val()) == "") {
		showWarning( "Anda harus mengisi kolom Tahun Pajak" );
	} else if ($("#tgl_cetak").val() == "") {
		showWarning( "Anda harus mengisi tanggal cetak");
	} else if ($("#spt_jenis_pajakretribusi").val() == "0") {
		showWarning( "Silahkan pilih jenis pajak." );
	} else {
		result = true;
	}
	
	return result;
};

/**
 * completePage
 * @returns
 */
var completePage = function() {
	var dates = $("#tgl_penetapan1, #tgl_penetapan2").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		constrainInput: true,
		duration: "fast",
		beforeShow: function(){
			$('#tgl_penetapan2').datepicker("option", 'minDate', $('#tgl_penetapan1').val());
		},
		onSelect: function( selectedDate ) {
			if (this.id == "tgl_penetapan1") {
				var date_b = $(this).datepicker('getDate');
				date_b.setDate(date_b.getDate()+7);
				$('#tgl_penetapan2').datepicker('setDate', date_b);
				$('#tgl_penetapan2').datepicker("option", 'minDate', selectedDate);
			}
		}
   	});
	
	$("#tgl_cetak, #txt_tgl_cetak").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
	$('#tgl_penetapan1, #tgl_penetapan2, #tgl_cetak, #txt_tgl_cetak').datepicker('setDate', 'c');
	
	$("#tgl_penetapan1, #tgl_penetapan2").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
};

var selectedPajak = function() {
	if ($("#spt_jenis_pajakretribusi").val() == "4") {
		$("#ket_reklame").show();
	} else {
		$("#ket_reklame").hide();
	}
};

$(document).ready(function() {
	$("#accordion").accordion();
	
	selectedPajak();
	completePage();
	
	$("#spt_jenis_pajakretribusi").change(function() {
		selectedPajak();
	});
	
	$("#btn_cetak").click(function() {
		if (validateForm()) {
			tandatangan = $("input[name=tandatangan]:checked").val() == '1' ? '1' : '0';
				
			camat = ($("#wp_wr_kd_camat").val()!==undefined ? $("#wp_wr_kd_camat").val() : "0");
			
			url = GLOBAL_DAFTAR_SURAT_KETETAPAN_VARS["cetak"] +
					"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&bulan=" + $('#bulan').val() +
					"&tahun=" + $('#tahun').val() +
					"&tanggal=" + $('#tanggal').val() +
					"&keterangan_spt=" + $('#keterangan_spt').val() +
					'&wp_wr_kd_camat=' + camat +
					'&tandatangan=' + tandatangan +
					"&mengetahui=" + $('#ddl_mengetahui').val() +
					"&diperiksa=" + $('#ddl_pemeriksa').val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak]").val() +
					"&fontsize=" + $("#fontsize").val() +
					"&linespace=" + $("#linespace").val();
			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
	
	
	$("#btn_cetak_excel").click(function() {
		if (validateForm()) {
			tandatangan = $("input[name=tandatangan]:checked").val() == '1' ? '1' : '0';
				
			$camat = ($("#wp_wr_kd_camat").val()!==undefined ? $("#wp_wr_kd_camat").val() : "0");
			
			url = GLOBAL_DAFTAR_SURAT_KETETAPAN_VARS["cetak_excel"] +
					"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&bulan=" + $('#bulan').val() +
					"&tahun=" + $('#tahun').val() +
					"&tanggal=" + $('#tanggal').val() +
					"&keterangan_spt=" + $('#keterangan_spt').val() +
					'&wp_wr_kd_camat=' + $camat +
					'&tandatangan=' + tandatangan +
					"&mengetahui=" + $('#ddl_mengetahui').val() +
					"&diperiksa=" + $('#ddl_pemeriksa').val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak]").val() +
					"&fontsize=" + $("#fontsize").val() +
					"&linespace=" + $("#linespace").val();
			
			$.download(url, 'filename=daftar_ketetapan&format=xls');
			return false;
		}
	});
	
	$("#btn_cetak2").click(function() {
		if ($("#ddl_jenis_pajak").val() == "0") {
			showWarning( "Silahkan pilih jenis pajak." );
		} else if ($("#tgl_penetapan1").val() == "" || $("#tgl_penetapan2").val() == "") {
			showWarning( "Silahkan masukkan tanggal penetepan" );
		} else {
			tandatangan = $("input[name=tandatangan2]:checked").val() == '1' ? '1' : '0';
			
			$camat = ($("#ddl_camat").val()!==undefined ? $("#ddl_camat").val() : "0");
			
			url = GLOBAL_DAFTAR_SURAT_KETETAPAN_VARS["cetak_via_tanggal"] +
					"?spt_jenis_pajakretribusi=" + $('#ddl_jenis_pajak').val() +
					"&tgl_penetapan1=" + $('#tgl_penetapan1').val() +
					"&tgl_penetapan2=" + $('#tgl_penetapan2').val() +
					"&keterangan_spt=" + $('#ddl_keterangan_spt').val() +
					'&wp_wr_kd_camat=' + $camat +
					'&tandatangan=' + tandatangan +
					"&mengetahui=" + $('#ddl_mengetahui2').val() +
					"&diperiksa=" + $('#ddl_pemeriksa2').val() +
					"&tgl_cetak=" + $("input[name=txt_tgl_cetak]").val();
			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});

	$("#btn_cetak_excel2").click(function() {
		if ($("#ddl_jenis_pajak").val() == "0") {
			showWarning( "Silahkan pilih jenis pajak." );
		} else if ($("#tgl_penetapan1").val() == "" || $("#tgl_penetapan2").val() == "") {
			showWarning( "Silahkan masukkan tanggal penetepan" );
		} else {
			tandatangan = $("input[name=tandatangan2]:checked").val() == '1' ? '1' : '0';
			
			$camat = ($("#ddl_camat").val()!==undefined ? $("#ddl_camat").val() : "0");
			
			url = GLOBAL_DAFTAR_SURAT_KETETAPAN_VARS["cetak_excel_via_tanggal"] +
					"?spt_jenis_pajakretribusi=" + $('#ddl_jenis_pajak').val() +
					"&tgl_penetapan1=" + $('#tgl_penetapan1').val() +
					"&tgl_penetapan2=" + $('#tgl_penetapan2').val() +
					"&keterangan_spt=" + $('#ddl_keterangan_spt').val() +
					'&wp_wr_kd_camat=' + $camat +
					'&tandatangan=' + tandatangan +
					"&mengetahui=" + $('#ddl_mengetahui2').val() +
					"&diperiksa=" + $('#ddl_pemeriksa2').val() +
					"&tgl_cetak=" + $("input[name=txt_tgl_cetak]").val();
			
			$.download(url, 'filename=daftar_ketetapan_via_tanggal&format=xls');
			return false;
		}
	});
});