$(document).ready( function() {
	
	var error_block = $('.form-group.has-error').first();
	
	if (error_block.length > 0) {
		$('html, body').animate({
			scrollTop: error_block.offset().top 
		}, 2000);
	}

	// if #order-billing-modal .has-error exists
		// auto load the modal
	if ($('#order-billing-modal .has-error').length > 0) {
		$('#order-billing-modal').modal();
	}

	/**
	 * CITY AND SUBURB AND DELIVERY SELECT FUNCTIONALITY
	 */

	var city_select      = $('.city-select-wrapper select');
	var suburb_select    = $('.suburb-select-wrapper select');
	var delivery_select  = $('select[name=store_delivery]');
	
	var store_type_select = $('select[name=store_type]');

	//  on load
	if (city_select.length > 0) {

		// if city is selected, enable the suburb select
		if(city_select.val()) {

			toggleDisableAndFade(suburb_select, false);

		} else {

			toggleDisableAndFade(suburb_select, true);

		}

		var store_type_select_value = '';
		if (store_type_select.length > 0) {
			store_type_select_value = store_type_select.val();
		}

		// if store type and city is selected, and type is  1 or 2
		// set the delivery to arrange with sellers
		// else set a default select option and disable it
		if (store_type_select_value && city_select.val() ) {

			selectArrangeWithSellers(store_type_select.val(), delivery_select);

		} else {

			delivery_select.html('<option selected="selected">' + 'Select a store delivery method' + '</option>');
			toggleDisableAndFade(delivery_select, true);

		}

	}

	city_select.on('change', function() {

		var city_select_val = $(this).val();

		var suburb_select = $('.suburb-select-wrapper select');
		var delivery_select = $('select[name=store_delivery]');

		var store_type_select_value = '';
		if (store_type_select.length > 0) {
			store_type_select_value = store_type_select.val();
		}

		// if city has a non empty value
		if (city_select_val) {

			ajaxSuburbs(city_select_val, suburb_select);

			// if city is Harare, allow the logistics delivery method(s)
			var logistics = false;
			if (city_select_val == '11') {
				logistics = true;
			}

			// if store type is property or vehicle, only allow Arrange with sellers
			var property_or_vehicle = false;
			if (store_type_select_value == '1' || store_type_select_value == '2') {
				property_or_vehicle = true;
			}

			if (store_type_select_value) {

				// load the delivery methods
				ajaxDeliveryMethods(logistics, property_or_vehicle);

			} else {

				delivery_select.html('<option selected="selected">' + 'Select a store delivery method' + '</option>');
				toggleDisableAndFade(delivery_select, true);

			}

		} else {

			// set a 'select' option and disable suburbs
			suburb_select.html('<option selected="selected">' + 'Select a suburb' + '</option>');
			toggleDisableAndFade(suburb_select, true);

			delivery_select.html('<option selected="selected">' + 'Select a store delivery method' + '</option>');
			toggleDisableAndFade(delivery_select, true);

		}

	});

	/**
	 * STORE TYPE SELECT FUNCTIONALITY
	 */
	
	// make sure that city has a value, so that the store delivery methods are available.
	if (city_select.length > 0 && city_select.val()) {

		// make sure that store type and delivery exists
		if (store_type_select.length > 0 && delivery_select.length > 0) {

			selectArrangeWithSellers(store_type_select.val(), delivery_select);

		}
	}

	store_type_select.on('change', function() {

		var city_select     = $('.city-select-wrapper select');

		var delivery_select  = $('select[name=store_delivery]');
		var store_type_val   = $(this).val();

		if (city_select.length > 0 && delivery_select.length > 0) {

			if(store_type_val && city_select.val()) {

				toggleDisableAndFade(delivery_select, false);

				// if city is Harare, allow the logistics delivery method(s)
				var logistics = false;
				if (city_select.val() == '11') {
					logistics = true;
				}

				// if store type is property or vehicle, only allow Arrange with sellers
				var property_or_vehicle = false;
				if (store_type_val == '1' || store_type_val == '2') {
					property_or_vehicle = true;
				}

				// load the delivery methods
				ajaxDeliveryMethods(logistics, property_or_vehicle);
				
			} else {

				delivery_select.html('<option selected="selected">' + 'Select a store delivery method' + '</option>');
				toggleDisableAndFade(delivery_select, true);

			}

		}

	});

	if( $('#form-change-order-status .form-group').hasClass('has-error') ) {
		$('#cancel-modal').modal();
	}

	if ($('#count_255').length > 0) {
		var text_max = 255;

		var text = $('#count_255').siblings('textarea');
		var text_length = text.val().length;
		var remaining = text_max - text_length;
		$('#count_255').html(remaining + ' chars remaining');

		text.keyup(function() {
			var text_length = text.val().length;
			var remaining = text_max - text_length;

			$('#count_255').html(remaining + ' chars remaining');
		});

	}

});

/**
 * Get suburbs for the related city and attach the options into the select element
 * Other: disable and change the opacity of select, enable and change the opacity on done
 * @param  {string} /int? id    The id of the city         
 * @param  {[type]} select_elem The element of suburb select
 *
 */
function ajaxSuburbs(id, select_elem) {

	var route = '/index.php/getsuburbs/' + id;

	var suburb_select = $('.suburb-select-wrapper select');

	toggleDisableAndFade(suburb_select, true);

	var select_option = '<option selected="selected">' + 'Select a suburb' + '</option>';

	// if id is set, load the suburbs and add it to the suburb select, and enable the options
	// else return only the select a suburb option

	$.ajax({
		
		url: route,
		data: [],
		method: 'GET',

	}).done(
		function(data) {

			var options = select_option + construct_select_options(data, 'name', '');

			select_elem.html(options);

			toggleDisableAndFade(suburb_select, false);
		}
	);

}

/**
 * Go through data as id and name key and construct the options html
 * @param  {array}       data			     Array of objects with id and name key
 * @param  {string}      name  			     Name of options
 * @param  {string}      default_val         The default select option by value, pass empty string for none         
 * @return {string}                          Return the html of options
 */
function construct_select_options(data, name, default_val) {
	var $data = data;
	var options = '';

	$.each(data, function(index, value) {

		var selected = (value.id == default_val) ? 'selected="selected"' : '';
		options += '<option ' + selected + ' value="' + value.id + '">' + value[name] + '</option>';
	
	});
	return options;
}

/**
 * Toggle the disabled state and opacity of an element
 * @param  {HTMLElement}   select_elem The element to affect
 * @param  {boolean}       enable      Toggle 'on' or 'off'
 * @return none
 */
function toggleDisableAndFade(select_elem, enable) {
	if (enable) {
		select_elem.prop('disabled', true);
		select_elem.css('opacity', '0.4');
	} else {
		select_elem.prop('disabled', false);
		select_elem.css('opacity', '1');
	}
}

/**
 * Return the delivery methods and include the logistics option if the selected
 * city is Harare.
 * Set onto the appropriate element
 * @param  boolean        logistics                 Is the logistics option allowed or not
 * @param  boolean        property_or_vehicle       Is the store type ..
 */
function ajaxDeliveryMethods(logistics, property_or_vehicle) {

	var route = '/index.php/getdeliverymethods/' + logistics + '/' + property_or_vehicle;
	var delivery_select = $('select[name=store_delivery]');

	var store_type_select = $('select[name=store_type]');

	toggleDisableAndFade(delivery_select, true);

	var select_option = '<option selected="selected">' + 'Select a store delivery method' + '</option>';
	var default_select_val = "";
	if (property_or_vehicle) {
		select_option = '<option>' + 'Select a store delivery method' + '</option>';
		default_select_val = "2"; // arrange with sellers
	}

	$.ajax({

		url: route,
		data: [],
		method: 'GET',

	}).done(
		function(data) {

			var options = select_option + construct_select_options(data, 'method', default_select_val);

			delivery_select.html(options);

			toggleDisableAndFade(delivery_select, false);


		}
	);

}

/**
 * If the store type is vehicles or property , select delivery option Arrange With sellers
 * @param  {string/int}    store_type        The store type select value
 * @param  {HTMLElement}   delivery_select
 * @return {type}          
 */
function selectArrangeWithSellers (store_type, delivery_select) {

	if (store_type == '1' || store_type == '2') {
		delivery_select.val('2').change();
	}

}