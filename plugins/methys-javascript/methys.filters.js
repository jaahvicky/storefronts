(function ($) {
	var logger = $.methys.Logger("FILTER");
	var eventDispatcher = $.methys.eventDispatcher;

	var DOM = {
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

	var CONST = {
	};

	$(function () {
		$(DOM.SELECTORS.DROPDOWN_TOGGLE).on('changed', tasks.dropdownChanged);
		$(DOM.SELECTORS.INPUT_SEARCH_GROUP).on('keyup', DOM.SELECTORS.INPUT_SEARCH_GROUP_TEXT, tasks.inputSearchKeypress);
		
		$(DOM.SELECTORS.INPUT_SEARCH_GROUP).on('click', DOM.SELECTORS.INPUT_SEARCH_GROUP_BUTTON, tasks.inputSearch);
		tasks.initInputSearch();
	});

	var tasks = (function () {
		var pub = {};

		pub.initInputSearch = function() {
			var inputGroups = $(DOM.SELECTORS.INPUT_SEARCH_GROUP);
			for (var i=0; i<inputGroups.length; i++) {
				var inputGroup = $(inputGroups[i]);
				var inputText = inputGroup.find(DOM.SELECTORS.INPUT_SEARCH_GROUP_TEXT);
				var resetButton = $('<i class="fa fa-times-circle" data-methys-filter-reset="true"></i>');
				var inputAddon = inputGroup.find('.input-group-addon');
				
				//Create cancel button
				resetButton.addClass('fc-reset-button');
				
				if (inputText.val() === '') {
					resetButton.hide();
				}
				
				
				// logger.debug(inputAddon.outerWidth());
				
				//Append to group
				inputAddon.after(resetButton);
				
				//set position
				resetButton.css('right', '45px');
				resetButton.css('top', (inputText.outerHeight() - resetButton.outerHeight())/2);
				
				//add click handler
				resetButton.on('click', pub.resetInputGroup);
				
			}
		};

		pub.resetInputGroup = function() {
			logger.debug('reset');
			var inputGroup = $(this).closest(DOM.SELECTORS.INPUT_SEARCH_GROUP);
			var inputText = inputGroup.find(DOM.SELECTORS.INPUT_SEARCH_GROUP_TEXT);
			inputText.val('');
			submitFilters();
		};

		pub.inputSearchKeypress = function (e) {
			if (e.which === 13) {
				pub.inputSearch();
				return;
			}
			
			pub.inputSearchRefresh($(this));
		};
		
		/**
		 * Shows/Hides reset button
		 */
		pub.inputSearchRefresh = function(inputText) {
			if (inputText.val() === '') {
				logger.debug('hiding');
				inputText.closest(DOM.SELECTORS.INPUT_SEARCH_GROUP).find(DOM.SELECTORS.INPUT_SEARCH_RESET).fadeOut();
			} else {
				logger.debug('showing');
				inputText.closest(DOM.SELECTORS.INPUT_SEARCH_GROUP).find(DOM.SELECTORS.INPUT_SEARCH_RESET).fadeIn();
			}
		};

		pub.inputSearch = function () {
			logger.debug('searching');

			submitFilters();
		};

		pub.dropdownChanged = function () {
			submitFilters();
		};

		function submitFilters() {
			var container = $(DOM.SELECTORS.CONTAINER);
			var data = {};
			var url = container.attr(DOM.ATTR.CONTAINER_URL);

			// add opacity to data table body
			$('.dataTable tbody').addClass('opacity');
			
			//find input search groups
			data = dataSearchGroups(data);
            //find dropdowns
			data = dataDropdowns(data);

			logger.debug(data);

			//submit filters
			$.ajax({
				url: url,
				type: 'POST',
				data: {filters: data},
				success: function (data, textStatus, jqXHR) {
					logger.obj(data);
					// window.location.href = window.location.href; //refresh page
					//logger.obj(data);
					console.log(data);
					location.reload(true);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					// logger.obj(jqXHR.responseText);
					console.log(jqXHR.responseText);
				}
			});
		}

		function dataSearchGroups(data) {
			var sGroups = $(DOM.SELECTORS.INPUT_SEARCH_GROUP);
			for (var i = 0; i < sGroups.length; i++) {
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

		return pub;
	}());

})(jQuery);