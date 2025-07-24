var tabContent = function() {
	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTabjQ = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTabjQ).fadeIn(); //Fade in the active content
		return false;
	});
};

var createEventToolbar = function() {
	$("input[name=btn_realisasi]").click(function() {
		denda = $("#denda_realisasi:checked").val() == '1' ? '1' : '0';
		
		$.download(GLOBAL_MAIN_VARS["BASE_URL"] + "pembukuan/buku_kendali/cetak_realisasi" + 
				"?jenis_pajak_realisasi=" + $("select[name=jenis_pajak_realisasi]").val() +
				"&f_bulan_realisasi=" + $("#f_bulan_realisasi").val() + 
				"&f_tahun_realisasi=" + $("#f_tahun_realisasi").val() +
				"&t_bulan_realisasi=" + $("#t_bulan_realisasi").val() +
				"&t_tahun_realisasi=" + $("#t_tahun_realisasi").val() +
				"&status_spt_realisasi=" + $("#status_spt_realisasi").val() +
				"&camat_id_realisasi=" + $("#camat_id_realisasi").val() +
				"&denda_realisasi=" + denda,
			'filename=realisasi&format=xls');
		return false;
	});
	
	$("input[name=btn_kendali]").click(function() {
		denda = $("#denda_kendali:checked").val() == '1' ? '1' : '0';
		
		$.download(GLOBAL_MAIN_VARS["BASE_URL"] + "pembukuan/buku_kendali/cetak_kendali" + 
				"?jenis_pajak_kendali=" + $("select[name=jenis_pajak_kendali]").val() +
				"&f_bulan_kendali=" + $("#f_bulan_kendali").val() + 
				"&f_tahun_kendali=" + $("#f_tahun_kendali").val() +
				"&t_bulan_kendali=" + $("#t_bulan_kendali").val() +
				"&t_tahun_kendali=" + $("#t_tahun_kendali").val() +
				"&status_spt_kendali=" + $("#status_spt_kendali").val() +
				"&camat_id_kendali=" + $("#camat_id_kendali").val() +
				"&denda_kendali=" + denda,
			'filename=buku_kendali&format=xls');
		return false;
	});
};

$(document).ready(function() {
	tabContent();
	createEventToolbar();
});