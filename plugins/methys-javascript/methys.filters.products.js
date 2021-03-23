(function ($) {
	var DOM = {
		ATTR: {
			CONTAINER_URL: 'data-methys-cat-url'
		},
		SELECTORS: {
			CONTAINER: '*[data-methys-cat=container]',
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

	var DOML = {
		ATTR: {
			CONTAINER_URL: 'data-methys-filter-url'
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
	
	getSession();
	$('ul.main-cat li').on('click', function(){

		var data = $(this).find('input[type=radio]:checked').val();
		$('.sub-cat').hide();
		$('.sub-cat').find('.dropdown-toggle').html('Any');
		console.log(data);
		if(data !== undefined && data != 'all')
		{
			getsubcategories(data, data);
		}
		 else if(data !== undefined)
		{
		 	submitfilter(data);
		}
	});

	$('ul.sub_cat_list li').on('click', function(){
		var data_selected = $(this).find('input[type=radio]:checked');
		var name = data_selected.context.textContent.trim();
		$('.sub-cat').find('.dropdown-toggle').html(name);
		submitfilter(name, true);
		

	});

	function getsubcategories(data, name){
		var container = $(DOM.SELECTORS.CONTAINER);
		var url = container.attr(DOM.ATTR.CONTAINER_URL);
		for (var i = 0; i < 15; i++) 
		{
			$('ul.sub_cat_list').find('#subCategory'+i).val(i).next('label').html('');
		}
		
		$.ajax({
			url: url,
			type: 'GET',
			data: {category_name: data},
			success: function (data) {
				
				if(data.success == true)
				{
					$.each(data.category, function(i, category)
					{
						if(name == data.category[i].name){
							$('ul.sub_cat_list').find('#subCategory'+i).val(data.category[i].name).attr('checked', true).next('label').html(data.category[i].name);
						}else{
							$('ul.sub_cat_list').find('#subCategory'+i).val(data.category[i].name).next('label').html(data.category[i].name);
						}	
						
							
					});
					$('.sub-cat').show();
				}
			}
		});
	}
	function getSession() {
		var container = $(DOMS.SELECTORS.CONTAINER);
		var url = container.attr(DOMS.ATTR.CONTAINER_URL);
		$('.sub-cat').hide();
		$.ajax({
			url: url,
			type: 'GET',
			data: {ses_name: 'subCategory'},
			success: function (data) {
				
				if(data.success == true){
					$('.sub-cat').find('.dropdown-toggle').html(data.session);
					var categorySe = $('ul.main-cat li').find('input[type=radio]:checked').val();
					if(data.session != 'all'){
						
						getsubcategories(categorySe, data.session);
					}
					
				}else{
					$('.sub-cat').hide();
				}
			}
		});
	}

	function submitfilter(name, cat=false) {
		var container = $(DOML.SELECTORS.CONTAINER);
		var data = {};
		var url = container.attr(DOML.ATTR.CONTAINER_URL);
		data = dataSearchGroups(data);
		data = dataDropdowns(data);
		//munipulate data
		if(cat){
			data.subCategory = [name];
		}
		
		console.log(data);
		$.ajax({
				url: url,
				type: 'POST',
				data: {filters: data},
				success: function (data, textStatus, jqXHR) {
					location.reload(true);

				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(jqXHR.responseText);
				}
			});
	}
	function dataSearchGroups(data) {
		var sGroups = $(DOML.SELECTORS.INPUT_SEARCH_GROUP);
		for (var i = 0; i < sGroups.length; i++) 
		{
			logger.debug(i);
			var input = $(sGroups[i]).find(DOML.SELECTORS.INPUT_SEARCH_GROUP_TEXT);
			if (input.val() !== '') {
				data[input.attr('name')] = input.val();
			}
		}
		return data;
	}
	function dataDropdowns(data) {
		var dropdowns = $(DOML.SELECTORS.DROPDOWN_TOGGLE);
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
	
	$('.order_by').on('click', function(){
		var values = [];
		var ordername = $(this).attr('data-order-name');
		
		values.push(ordername);
		var desc = 'fa-sort-amount-desc';
		var asc = 'fa-sort-amount-asc';
		var current_class = $(this).find('i');
		if(current_class.hasClass(asc)){
			removeClasses(asc,desc);
			current_class.removeClass( asc ).addClass(desc);
			values.push('desc');

		}else if(current_class.hasClass(desc)){
			removeClasses(asc,desc);
		  	current_class.removeClass( desc ).addClass(asc);
		  	values.push('asc');
		}else{
			removeClasses(asc,desc);
		    current_class.addClass(asc);
		    values.push('asc');
		}
		console.log(values);
		$('#orderbyname').val(values);
		console.log($('#orderbyname').val());
		submitfilter();

		
	});
	
	function getOrderSession(){
		var container = $(DOMS.SELECTORS.CONTAINER);
		var url = container.attr(DOMS.ATTR.CONTAINER_URL);
		$.ajax({
			url: url,
			type: 'GET',
			data: {ses_name: 'orderbyname'},
			success: function (data) {
				console.log(data);
				if(data.success == true){
					console.log(data.session.split(','));
					var column = data.session.split(',')[0];
					var ordertype = data.session.split(',')[1];
					$('#orderbyname').val(data.session);
					var order = $('th.order_by.'+column).find('i').addClass('fa-sort-amount-'+ordertype);
				}
			}
		});
	}
	function removeClasses(asc,desc){
		var all_sort = $('th').find('i.order.fa');
		for (var i = 0; i < all_sort.length; i++) 
		{
			if($('th').find('i.order.fa').hasClass(desc))
			{
				$('th').find('i.order.fa').removeClass(desc);
			}else if($('th').find('i.order.fa').hasClass(asc))
			{
				$('th').find('i.order.fa').removeClass(asc);
			}
		}
	}
	getOrderSession();
	
})(jQuery);