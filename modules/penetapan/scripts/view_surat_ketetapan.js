/**
 * document ready function
 */
$(document).ready(function(){
	$("#tbl_menu a").click(function(){
		load_content($(this).attr('id'));
	});
});