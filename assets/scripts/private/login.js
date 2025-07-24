/**
 * Show warning
 */
var showWarning = function (message, period){
	$("#warning span.text").text(message);
	$("#warning").slideDown("slow").animate({opacity: 1.0}, (period!==undefined?period:2000)).slideUp("slow");
	$('#username').focus();
};

var onPost = function (data){
	console.log(data)
	if ($.trim(data) == "success") {    
		//window.top.location.assign("landing");  //redirects to landing controller  
		$(location).attr('href',GLOBAL_MAIN_VARS["BASE_URL"]);
	} else {  
		//$('#message').text(data); //print the appropriate error message on the page.  
		$("#username").val("");
		$("#password").val("");
		$("#username").focus();
		showWarning(data);
	}  
};

var login = function () {
	$.post("login", {
	txt_username : $('#username').val(),  
	txt_password : $('#password').val()
  },   
	function(data) {  
		onPost(data);  
	});
};

/**
 * If DOM is ready
 */
$(document).ready(function(){
	// focus
	$("#username").focus();
	// set event handler
	$("#username, #password").keypress(function(e){
		if (e.which==13){
			login();
			return false;
		}
	});
	$("#login").click(function(){
		login();
		return false;
	});	
});