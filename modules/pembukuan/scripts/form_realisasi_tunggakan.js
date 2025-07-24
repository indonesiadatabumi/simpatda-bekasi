
var selectedStatus = function() {
	if ($("#jenis_pajak").val() == "4" || $("#jenis_pajak").val() == "8") {
		$("#status_spt").val("1");
		$("#jenis_restoran").hide();
		$("#daftar_cetak").hide();
	} else {
		if ($("#jenis_pajak").val() == "2") {
			$("#jenis_restoran").show();
		} else {
			$("#jenis_restoran").hide();
		}
		$("#daftar_cetak").show();
		$("#status_spt").val("8");
	}
};

$(document).ready(function() {
	selectedStatus();
	
	$("#jenis_pajak").change(function() {
		selectedStatus();
	});
	
	$("input[name=cetak]").click(function() {
		if ($("select[name=jenis_restoran]").length > 0) {
			jenis_restoran = $("select[name=jenis_restoran]").val();
		} else {
			jenis_restoran = 0;
		}
		
		$.download("../pembukuan/daftar_rekapitulasi/cetak" + 
				"?jenis_pajak=" + $("select[name=jenis_pajak]").val() +
				"&jenis_restoran=" + jenis_restoran +	
				"&bulan_masa_pajak=" + $("#bulan_masa_pajak").val() + 
				"&tahun_masa_pajak=" + $("#tahun_masa_pajak").val() +
				"&status_spt=" + $("#status_spt").val() +
				"&jenis_daftar=" + $("#jenis_daftar").val() +
				"&camat_id=" + $("#camat_id").val(),
			'filename=daftar_rekapitulasi&format=xls');
		return false;
	});	
});