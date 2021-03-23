$(document).ready(function() {
	/*++++++handling view type++++++*/
	$('#grid').click(function() {
		change_view_state('#grid', '#list');
	});
	$('#list').click(function() {
		change_view_state('#list', '#grid');
	});
	/*++++++change view type function++++++*/
	function change_view_state(arg1, arg2) {
		var validate = $(arg1).hasClass('active');
		if(validate == false){
			$(arg2).removeClass('active');
			$(arg1).addClass('active');
			if (arg1 == '#list') {
				$('.search-contents > ul').attr('class', "product-list list-view");
			}
			if (arg1 == '#grid') {
				$('.search-contents > ul').attr('class', "product-list grid-view");
			}
		}
	}

	/*+++++mobile-sort buttons++++*/

	$('.sort').click(function(e) {
		e.preventDefault();
		$('.sort-menu').css('right', '0');
		$('.sort-div-fade').show();
	});

	$('.close-sort').click(function() {
		$('.sort-menu').css('right', '-90%');
		$('.sort-div-fade').hide();
	});
	$('.sort-div-fade').click(function() {
		$('.sort-menu').css('right', '-90%');
		$('.categories-sidebar').css('left', '-100%');
		$(this).hide();
	});

	/*+++++mobile category buttons++++*/
	$('.categories').click(function(e) {
		e.preventDefault();
		$('.categories-sidebar').css('left', '0');
		$('.sort-div-fade').show();
	}); 

	$('.close-cat').click(function() {
		$('.categories-sidebar').css('left', '-100%');
		$('.sort-div-fade').hide();
	});

	/*+++++check box buttons++++*/
	$('input[type="checkbox"]').mousedown(function(){
		$(location).attr('href', $(this).attr('data-url'));
	});

	/*++++ mobile check box +++++*/
	var sortdata = $('input[type="hidden"]').val();
	if (sortdata == 'Newest') {
		$('input[type="checkbox"]').first().prop('checked', true);
		$('input[type="checkbox"]').first().prop('disabled', true);
	}else if(sortdata == 'Highest to lowest price'){
		$('input[type="checkbox"]:eq(1)').prop('checked', true);
		$('input[type="checkbox"]:eq(1)').prop('disabled', true);
	}else{
		$('input[type="checkbox"]').last().prop('checked', true);
		$('input[type="checkbox"]').last().prop('disabled', true);
	}

});