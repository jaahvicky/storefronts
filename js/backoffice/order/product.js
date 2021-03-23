$(function() {

	console.log('product blade fool');
	$( "#product" ).change(function() {
	  console.log( "Handler for .change() called." );
	  $('.item-ele').css('display', 'block');
	});
	
});