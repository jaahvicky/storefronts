$(document).ready(function($) {

	// Product page

	// If product is out of stock, remove the qty

	if($('.product-container .product-details-wrapper .product-out-of-stock').length > 0) {
		$('.product-details-wrapper').addClass('out-of-stock');
	}

	$('.out-of-stock .product-qty').remove();


	$('#product-img-modal').on('shown.bs.modal', function () {
		// run every time the image changes, first one should be 1 by default
 	 	productImagesModal();
	});

	$('#product-img-modal').on('hide.bs.modal', function () {
		
		// show the other navigation icons
		$('#gallery .bx-prev').show();
		$('#gallery .bx-next').show();
 	 	
	});

	$('#gallery .bx-viewport').on('click', function(e) {

		if ($(window).width() < 1025) { //   1024px ipad pro
			$('#product-img-modal').modal('toggle');
		}

	});


    // if a user clicks on a tier 1 or tier 2 category link, do not close the dropdown
    $('.categories-sidebar a.category-item').on('click', function(e) {
        $('.categories-sidebar .primary.dropdown').addClass('visible');
        $('.categories-sidebar .primary.dropdown > ul.dropdown-menu > li.dropdown-submenu').addClass('visible');
        $('.categories-sidebar .primary.dropdown > ul.dropdown-menu > li.dropdown-submenu > ul.dropdown-menu').addClass('visible');
    });

	/* Cart page */

	$(".shopping-cart [disabled='disabled']").on('click', function(e) {
		e.preventDefault();
		return false;
	});

	//if ($('.cart-products-wrapper.empty-cart').length > 0) {
	//	$('#empty-cart-modal').modal();
	//}

	/* GENERAL **/

	$('.header-cart-wrapper .header-cart-icon a.empty-cart').on('click', function(e) {
		e.preventDefault();
		return $('#empty-cart-modal').modal();
	});

	$('.number-toggle').on('click', function(e) {
		e.preventDefault();
		if($(this).hasClass('show-nr')) {
			$(this).html('Show Full Number');
			$(this).prev('.number-toggle-dest').html('***');
			$(this).removeClass('show-nr');
		} else {
			$(this).html('Hide Full Number');
			$(this).prev('.number-toggle-dest').html($(this).next('.seller-phone-no').html() + ' ');
			$(this).addClass('show-nr');
		}
	}); 



});

function productImagesModal() {

	// hide the other navigation icons
	$('#gallery .bx-prev').hide();
	$('#gallery .bx-next').hide();

	$("#carousel-product-images").swiperight(function() {  
      $("#carousel-product-images").carousel('prev');  
    });  
	$("#carousel-product-images").swipeleft(function() {  
	  $("#carousel-product-images").carousel('next');  
	});  
	
	var activeImg = $('.bx-pager a.active img').attr('src');

	//depends on dimensions passed
	activeImg = activeImg.replace('-60-60', '');
	 	
	$('#carousel-product-images .carousel-inner .item').removeClass('active');
	$('#carousel-product-images .carousel-inner').find("[data-img='" + activeImg + "']").addClass('active');

}