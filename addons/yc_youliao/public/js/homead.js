jQuery(function() {
		//Set the popup window to center
		var COOKIE_NAME = "mode";
		if( $.cookie(COOKIE_NAME)){
			$("#indexheadpopup").hide();
		}else{
		   var winH = $(window).height();
		   var winW = $(window).width();
		  $("#indexheadpopup").css({'padding-top': winH/2-$("#popupimg").text()/2,'left': winW/2-$("#indexheadpopup").width()/2 });
	        $("#indexheadpopup").slideDown(1000, function() {
	        setTimeout("ClearIndexHeadPopup()", '10000');
	        });
	      $.cookie(COOKIE_NAME,"mode", {path: '/', expires: 1});
		}
    });
function ClearIndexHeadPopup() {
	     $('#indexheadpopup').hide();
	        
}