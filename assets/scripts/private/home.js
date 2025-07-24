$(document).ready(function() {
	$(".icon a").click(function(){
		// get page id
		var menu_id = $(this).attr("href");
		
		if (menu_id != "#") {
			if (menu_id.substr(0, 5) == "popup") {
				if (menu_id == "popup_pendataan/objek_pajak/popup_jenis_pajak") {
					showDialog(menu_id.substr(6), 'Jenis Pajak', 800, 500);
				} else if (menu_id == "popup_pendataan/kartu_data/jenis_pajak") {
					showDialog(menu_id.substr(6), 'Kartu Data', 800, 500);
				}
			} else
				load_content(menu_id);
		}
		
		return false;
	});
});