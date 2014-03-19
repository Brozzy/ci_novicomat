$(document).ready(function(){
	var $rf = false;
	$("#regForm").hide();
	$( "#regDiv" ).click(function() {
		if( !$rf ) {
	       	$("#regForm").slideDown("fast", function() {});
	       	$rf = true;
		} else {
	       	$("#regForm").slideUp("fast", function() {});
			$rf=false;
		}
	});
});