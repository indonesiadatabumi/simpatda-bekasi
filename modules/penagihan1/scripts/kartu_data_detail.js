
$(document).ready(function()
{
	/*
	$.get(GLOBAL_MAIN_VARS["BASE_URL"] + "penagihan/kartu_data_wp/deskripsi?spt_periode="+$("#spt_periode").val()+"&wp_id="+$("input[name=wp_id]").val(), 
		function(data) {
		  $('#grafik').html(data);
	});
	*/
	$("#grafik").attr('src', GLOBAL_MAIN_VARS["BASE_URL"] + "penagihan/kartu_data_wp/deskripsi?spt_periode="+$("#spt_periode").val()+"&wp_id="+$("input[name=wp_id]").val());
	
	$('#btn_cari').click(
		function(){
			
			var showInsertResponse = function (response) {
				$("#grafik").attr('src', GLOBAL_MAIN_VARS["BASE_URL"] + "penagihan/kartu_data_wp/deskripsi?spt_periode="+$("#spt_periode").val()+"&wp_id="+$("input[name=wp_id]").val());
			};
			
			var save_options = { 
				url : GLOBAL_MAIN_VARS["BASE_URL"],
				type : "POST",
				success: showInsertResponse,
				error: function() {
					alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
				} 
			};
			
			$("#frm_data_spt").ajaxSubmit(save_options);
		}
	);
	
	$("#btn_cetak").click(function() {
		alert('cetak');
	});
});
