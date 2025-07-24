/**
 * document ready
 */
$(document).ready(function(){
	$('#username').focus();
	
	$("#tutup").click(function () {
		$('#password').attr('value','');
		$('#username').attr('value','');
		$("#div_authentication").dialog('close');
	});
	
	$("#btn_submit").click(function(){
		authorizeUser();
	});
	
	$("form input").keypress(function (e) {
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
			authorizeUser();
		}
	});
	
	var authorizeUser = function() {
		$.ajax({
			type : "POST",
			url : GLOBAL_MAIN_VARS["authentication"],
			data : "username="+$('#username').val()+ "&password="+ $('#password').val(),
			success: function(msg) {
				if (msg == "success") {
					if (GLOBAL_MAIN_VARS["action_authenticate"] == "update") {
						updateData();
					} else if (GLOBAL_MAIN_VARS["action_authenticate"] == "delete") {
						deleteData();
					}
					
					$("#div_authentication").dialog('close');
				}
				else {
					alert("Maaf Nama User atau Password Salah atau Nama User Bukanlah Administrator!!");
					$('#password').attr('value','');
					$('#username').attr('value','');
					$('#username').focus();
				}
			}
		});
		return false;
	};
});