/**
 * jquery ready function
 */
$(document).ready(function() {
	$("#tbl_menu a").click(function (){
		var menu_id = $(this).attr("id");
		
		load_content(menu_id);
	});
});