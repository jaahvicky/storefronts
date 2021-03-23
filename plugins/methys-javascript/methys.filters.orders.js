$(document).ready( function() {

	var DOM = {
		ATTR: {
			CONTAINER_URL: 'data-methys-filter-url',
			REFRESH_URL: 'data-methys-refresh-url'
		},
		SELECTORS: {
			CONTAINER: '*[data-methys-filter=container]',
			DROPDOWN_TOGGLE: '*[data-methys-filter=dropdown-toggle]',
			INPUT_SEARCH_GROUP: '*[data-methys-filter=input-search-group]',
			INPUT_SEARCH_GROUP_TEXT: 'input[type=text]',
			INPUT_SEARCH_GROUP_BUTTON: 'button',
			INPUT_SEARCH_RESET: '*[data-methys-filter-reset]'
		},
		EVENTS: {
		}
	};

	var DOMS = {
		ATTR: {
			CONTAINER_URL: 'data-methys-session-url'
		},
		SELECTORS: {
			CONTAINER: '*[data-methys-ses=container]',
			DROPDOWN_TOGGLE: '*[data-methys-filter=dropdown-toggle]',
			INPUT_SEARCH_GROUP: '*[data-methys-filter=input-search-group]',
			INPUT_SEARCH_GROUP_TEXT: 'input[type=text]',
			INPUT_SEARCH_GROUP_BUTTON: 'button',
			INPUT_SEARCH_RESET: '*[data-methys-filter-reset]'
		},
		EVENTS: {
		}
	};
	
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

	if ($('#order-export-modal .has-error').length > 0) {
		$('#order-export-modal').modal();
	}

	$('#order-export-modal .modal-body input').daterangepicker({
		singleDatePicker: true,
		showDropDowns: true,
		format: 'DD/MM/YYYY'
	});

	// On filter select, add it to the hidden input so that it gets sent with the filters
	$('body').on('click', '.item-order-by', function() {
		$('#order-list .dataTable tbody').addClass('opacity');
		getColumnSortBy($(this));
	});

	// get column sort by and filters
	// get the data and replace the rows
	$('body').on('click', '.order-list-refresh', function() {
		refreshData();
	});

	function getColumnSortBy(elem) {
		
		var data   = [];

		data.push(elem.data('order-name'));

		var desc   = 'fa-sort-amount-desc';
		var asc    = 'fa-sort-amount-asc';

		console.log(data);
		console.log($(elem).attr('class'));

		var current_class = $(elem).find('i');
		if (current_class.hasClass(asc)) {
			removeClasses(asc, desc);
			current_class.removeClass(asc).addClass(desc);
			data.push('desc');
		} else if (current_class.hasClass(desc)) {
			removeClasses(asc, desc);
			current_class.removeClass(desc).addClass(asc);
			data.push('asc');
		} else {
			removeClasses(asc, desc);
			current_class.addClass(asc);
			data.push('asc');
		}

		var input_elem = $('#orderbycolumn');
		if (input_elem.length > 0) {
			input_elem.val(data);
		}

		// submit the filters
		sortFilter();
	}

	function removeClasses(asc,desc) {
		var all_sort = $('th').find('i.order.fa');
		for (var i = 0; i < all_sort.length; i++) 
		{
			if($('th').find('i.order.fa').hasClass('desc'))
			{
				$('th').find('i.order.fa').removeClass('desc');
			}else if($('th').find('i.order.fa').hasClass('asc'))
			{
				$('th').find('i.order.fa').removeClass('asc');
			}
		}
	}

	// get filters
	function sortFilter() {
		var container = $(DOM.SELECTORS.CONTAINER);
		var data = {};
		var url = container.attr(DOM.ATTR.CONTAINER_URL);
		data = dataSearchGroups(data);
		data = dataDropdowns(data);

		//submit filters
		$.ajax({
			url: url,
			type: 'POST',
			data: {filters: data},
			success: function (data, textStatus, jqXHR) {

				location.reload(true); 

			}
		});
	}

	// get column sort by and filters
	// get the data and replace the rows

	function refreshData() {

		$('#order-list .dataTable tbody').addClass('opacity');
		$('#order-list .row-pagination').addClass('opacity');
		$('.order-list-refresh .fa.fa-refresh').addClass('fa-spin');

		var container = $(DOM.SELECTORS.CONTAINER);
		var data = {};
		var url = container.attr(DOM.ATTR.REFRESH_URL);
		
		data = dataSearchGroups(data);
		data = dataDropdowns(data);

		//submit filters
		$.ajax({
			url: url,
			type: 'GET',
			data: {filters: data},
			success: function (data, textStatus, jqXHR) {

				$('#order-list .dataTable tbody').html(data['form_body']);
				$('#order-list .row-pagination' ).html(data['form_pagination']);

				$('#order-list .dataTable tbody').removeClass('opacity');
				$('#order-list .row-pagination').removeClass('opacity');
				$('.order-list-refresh .fa.fa-refresh').removeClass('fa-spin');

			},
			error: function (jqXHR, textStatus, errorThrown) {
				$('#order-list .dataTable tbody').removeClass('opacity');
				$('#order-list .row-pagination').removeClass('opacity');
				$('.order-list-refresh .fa.fa-refresh').removeClass('fa-spin');
				console.log(jqXHR.responseText);
			}
		});
	}

	function dataSearchGroups(data) {
		var sGroups = $(DOM.SELECTORS.INPUT_SEARCH_GROUP);
		for (var i = 0; i < sGroups.length; i++) 
		{
			logger.debug(i);
			var input = $(sGroups[i]).find(DOM.SELECTORS.INPUT_SEARCH_GROUP_TEXT);
			if (input.val() !== '') {
				data[input.attr('name')] = input.val();
			}
		}
		return data;
	}

	function dataDropdowns(data) {
		var dropdowns = $(DOM.SELECTORS.DROPDOWN_TOGGLE);
		for (var i = 0; i < dropdowns.length; i++) {
			var dropdown = $(dropdowns[i]);
			var options = dropdown.find('input[type=checkbox]:checked, input[type=radio]:checked, input[type=hidden]');
			var name = dropdown.find('input:first-child').attr('name');
			name = name.replace('[', '');
			name = name.replace(']', '');
			var values = [];
			for (var j = 0; j < options.length; j++) {
				var val = $(options[j]).val();
				if (val !== '') {
					values.push(val);
				}
			}
			data[name] = values;
		}	

		return data;
	}

	function getOrderSession() {
		var container = $(DOMS.SELECTORS.CONTAINER); 
		var url = container.attr(DOMS.ATTR.CONTAINER_URL);

		$('#order-list .dataTable tbody').addClass('opacity');

		$.ajax({
			url: url,
			type: 'GET',
			data: {ses_name: 'orderByColumn'},
			success: function (data) {

				$('#order-list .dataTable tbody').removeClass('opacity');

				if(data.success == true){
					console.log(data.session.split(','));
					var column = data.session.split(',')[0];
					var ordertype = data.session.split(',')[1];
					$('#orderbycolumn').val(data.session);
					var order = $('th[data-order-name='+column+"]").find('i').addClass('fa-sort-amount-'+ordertype);
				}
			}
		});
	}
	getOrderSession();

});