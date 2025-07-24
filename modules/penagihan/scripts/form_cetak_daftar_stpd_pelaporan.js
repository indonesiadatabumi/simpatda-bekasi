
/**
 * validateForm
 * @returns
 */
var validateForm = function() {
	var result = false;
	if ($.trim($("#tahun").val()) == "") {
		showWarning( "Anda harus mengisi kolom Tahun Pajak" );
	} else if ($("#tgl_cetak").val() == "") {
		showWarning( "Anda harus mengisi Nomor Kohir" );
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
	$("#tgl_cetak, #tgl_penetapan1, #tgl_penetapan2, #tgl_cetak2").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#tgl_cetak').datepicker('setDate', 'c');
};

$(document).ready(function() {
	$("#accordion").accordion();
	completePage();
	
	$("#btn_cetak").click(function() {
		if (validateForm()) {
			tandatangan = $("input[name=tandatangan]:checked").val() == '1' ? '1' : '0';
				
			camat = ($("#camat_id").val()!==undefined ? $("#camat_id").val() : "0");
			
			url = GLOBAL_MAIN_VARS["BASE_URL"] + "penagihan/stpd_pelaporan/pdf_cetak_daftar" +
					"?jenis_pajak=" + $('#jenis_pajak').val() +
					"&bulan=" + $('#bulan').val() +
					"&tahun=" + $('#tahun').val() +
					'&camat_id=' + camat +
					'&tandatangan=' + tandatangan +
					"&mengetahui=" + $('#ddl_mengetahui').val() +
					"&diperiksa=" + $('#ddl_pemeriksa').val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak]").val();
			
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
				
			camat = ($("#camat_id").val()!==undefined ? $("#camat_id").val() : "0");
			
			url = GLOBAL_CETAK_EXCEL_VARS["BASE_URL"] + "penagihan/stpd/excel_cetak_daftar" +
					"?jenis_pajak=" + $('#jenis_pajak').val() +
					"&bulan=" + $('#bulan').val() +
					"&tahun=" + $('#tahun').val() +
					'&camat_id=' + camat +
					'&tandatangan=' + tandatangan +
					"&mengetahui=" + $('#ddl_mengetahui').val() +
					"&diperiksa=" + $('#ddl_pemeriksa').val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak]").val();
			
			$.download(url, 'filename=daftar_stpd&format=xls');
			return false;
		}
	});

	$("#btn_cetak2").click(function() {
		if (validateForm()) {
			tandatangan = $("input[name=tandatangan2]:checked").val() == '1' ? '1' : '0';
				
			camat = ($("#camat_id2").val()!==undefined ? $("#camat_id2").val() : "0");
			
			url = GLOBAL_MAIN_VARS["BASE_URL"] + "penagihan/stpd_pelaporan/pdf_cetak_daftar2" +
					"?jenis_pajak=" + $('#jenis_pajak2').val() +
					"&tgl_penetapan1=" + $('#tgl_penetapan1').val() +
					"&tgl_penetapan2=" + $('#tgl_penetapan2').val() +
					'&camat_id=' + camat +
					'&tandatangan=' + tandatangan +
					"&mengetahui=" + $('#ddl_mengetahui2').val() +
					"&diperiksa=" + $('#ddl_pemeriksa2').val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak2]").val();
			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
	
	$("#btn_cetak_excel2").click(function() {
		if (validateForm()) {
			tandatangan = $("input[name=tandatangan2]:checked").val() == '1' ? '1' : '0';
				
			camat = ($("#camat_id2").val()!==undefined ? $("#camat_id2").val() : "0");
			
			url = GLOBAL_CETAK_EXCEL_VARS["BASE_URL"] + "penagihan/stpd/excel_cetak_daftar2" +
					"?jenis_pajak=" + $('#jenis_pajak2').val() +
					"&tgl_penetapan1=" + $('#tgl_penetapan1').val() +
					"&tgl_penetapan2=" + $('#tgl_penetapan2').val() +
					'&camat_id=' + camat +
					'&tandatangan=' + tandatangan +
					"&mengetahui=" + $('#ddl_mengetahui2').val() +
					"&diperiksa=" + $('#ddl_pemeriksa2').val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak2]").val();
			
			$.download(url, 'filename=daftar_stpd&format=xls');
			return false;
		}
	});
});