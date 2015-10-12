$(document).ready(function(){
	var contentHeight = function() {
		var _height = $(window).height();
		$('#nav-panel').height(_height);
	}
	window.onresize = contentHeight;
	contentHeight();

})