/**
 * completePage
 * @returns
 */
var completePage = function() {
	var dates = $("#tgl_entry1, #tgl_entry2").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		constrainInput: true,
		duration: "fast",
		beforeShow: function(){
			$('#tgl_entry2').datepicker("option", 'minDate', $('#tgl_entry1').val());
		},
		onSelect: function( selectedDate ) {
			if (this.id == "tgl_entry1") {
				var date_b = $(this).datepicker('getDate');
				date_b.setDate(date_b.getDate()+7);
				$('#tgl_entry2').datepicker('setDate', date_b);
				$('#tgl_entry2').datepicker("option", 'minDate', selectedDate);
			}
		}
   	});
	
	$("#tgl_cetak, #tgl_cetak_spt").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
	$('#tgl_entry1, #tgl_entry2, #tgl_cetak, #tgl_cetak_spt').datepicker('setDate', 'c');
	
	$("#tgl_entry1, #tgl_entry2").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
};


var selectedStatus = function() {
	if ($("#spt_jenis_pajakretribusi").val() == "2") {
		$("#jenis_restoran").show();
	} else {
		$("#jenis_restoran").hide();
	}
};

var selectedStatusmp = function() {
	if ($("#spt_jenis_pajak_entry").val() == "2") {
		$("#jenis_restoranmp").show();
	} else {
		$("#jenis_restoranmp").hide();
	}
};

$(document).ready(function() {
	$("#accordion").accordion();
	
	completePage();
	selectedStatus();
	selectedStatusmp();
	
	$("#spt_jenis_pajakretribusi").change(function() {
		selectedStatus();
	});
	
	$("#spt_jenis_pajak_entry").change(function() {
		selectedStatusmp();
	});
	
	$("#btn_cetak").click(function(){
		if($("#spt_periode").val() == "") {
			showWarning('Silahkan masukkan periode SPT');
		} else if($("#spt_jenis_pajakretribusi").val() == "0") {
			showWarning('Silahkan pilih jenis pajak');
		} else {
			//cetak_wp = $("input[name=cetak_wp]:checked").val() == '1' ? '1' : '0';
			
			$jenis_restoran = ($('#jenis_pajak_restoran').val()!==undefined?$('#jenis_pajak_restoran').val() : "0");
			
			url = GLOBAL_SPTPD_VARS["cetak"] +
					"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&jenis_pajak_restoran=" + $jenis_restoran +
					"&sistem_pemungutan=" + $('#sistem_pemungutan').val() +
					"&tgl_cetak=" + $('#tgl_cetak').val() +
					"&kecamatan=" + $('#kecamatan').val() + 
					"&masa_pajak=" + $("#masa_pajak").val() +
					"&tahun=" + $("#spt_periode").val() +
					"&daftar_spt=" + $("#ddl_daftar").val() +
					"&mengetahui=" + $("#ddl_mengetahui").val() +
					"&diperiksa=" + $("#ddl_pemeriksa").val();
			
			var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
	
	$("#btn_cetak_xls").click(function() {
		if($("#spt_periode").val() == "") {
			showWarning('Silahkan masukkan periode SPT');
		} else if($("#spt_jenis_pajakretribusi").val() == "0") {
			showWarning('Silahkan pilih jenis pajak');
		} else {
			$jenis_restoran = ($('#jenis_pajak_restoran').val()!==undefined?$('#jenis_pajak_restoran').val() : "0");			
			
			url = GLOBAL_SPTPD_VARS["cetak_xls"] +
						"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
						"&jenis_pajak_restoran=" + $jenis_restoran +
						"&sistem_pemungutan=" + $('#sistem_pemungutan').val() +
						"&tgl_cetak=" + $('#tgl_cetak').val() +
						"&kecamatan=" + $('#kecamatan').val() + 
						"&masa_pajak=" + $("#masa_pajak").val() +
						"&tahun=" + $("#spt_periode").val() +
						"&daftar_spt=" + $("#ddl_daftar").val() +
						"&mengetahui=" + $("#ddl_mengetahui").val() +
						"&diperiksa=" + $("#ddl_pemeriksa").val();
			
			$.download(url, 'filename=daftar_spt&format=xls');
			return false;
		}
	});
	
	
	$("#btn_cetak_entry").click(function() {
		if($("#spt_jenis_pajak_entry").val() == "0") {
			showWarning('Silahkan pilih jenis pajak');
		} else if ($("#tgl_entry1").val() == "" || $("#tgl_entry2").val() == "") {
			showWarning('Silahkan masukkan tanggal entry pendataan SPT');
		} else {
			tandatangan = $("input[name=tandatangan_entry]:checked").val() == '1' ? '1' : '0';			
			$jenis_restoran = ($('#jenis_pajak_restorantgl').val()!==undefined?$('#jenis_pajak_restorantgl').val() : "0");
			
			url = GLOBAL_SPTPD_VARS["cetak_via_tgl_entry"] +
						"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajak_entry').val() +
						"&jenis_pajak_restoran=" + $jenis_restoran + 
						"&tgl_cetak=" + $('#tgl_cetak_spt').val() +
						"&kecamatan=" + $('#kecamatan_entry').val() + 
						"&tgl_entry1=" + $("#tgl_entry1").val() +
						"&tgl_entry2=" + $("#tgl_entry2").val() +
						"&tandatangan=" + tandatangan +
						"&mengetahui=" + $("#ddl_mengetahui_entry").val() +
						"&diperiksa=" + $("#ddl_pemeriksa_entry").val();
			
			var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
});