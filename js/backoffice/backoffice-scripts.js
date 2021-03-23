$(document).ready( function() {
	
	var error_block = $('.form-group.has-error').first();
	
	if (error_block.length > 0) {
		$('html, body').animate({
			scrollTop: error_block.offset().top 
		}, 2000);
	}
});