/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {

	console.log('store.js');
	$( "#store" ).change(function() {
	  console.log( "Handler for .change() called." );
	  $('.cat-ele').css('display', 'block');
	});
});