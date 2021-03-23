(function ($) {
	var logger = $.methys.Logger("PAGINATOR");
	var eventDispatcher = $.methys.eventDispatcher;

	var DOM = {
		ATTR: {
			RECORDS_PER_PAGE: 'rpp'
		},
		SELECTORS: {
			RECORDS_PER_PAGE: 'select[data-pagination=rpp]'
		},
		EVENTS: {
		}
	};

	var CONST = {
	};

	$(function () {
		$(DOM.SELECTORS.RECORDS_PER_PAGE).on('change', tasks.recordsPerPage);
	});

	var tasks = (function () {
		var pub = {};

		/**
		 * Changes the RecordsPerPage value on a list
		 * @returns {undefined}
		 */
		pub.recordsPerPage = function () {
			var rpp = $(this).find(':selected').val();

			var url = window.location.href;
			url = replaceUrlParam(url, 'rpp', rpp); //update rpp value
			url = replaceUrlParam(url, 'page', 0); //change page to 0
			window.location.href = url;
		};

		function replaceUrlParam(url, paramName, paramValue) {
			var pattern = new RegExp('(' + paramName + '=).*?(&|$)');
			var newUrl = url;
			if (url.search(pattern) >= 0) {
				newUrl = url.replace(pattern, '$1' + paramValue + '$2');
			}
			else {
				newUrl = newUrl + (newUrl.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue;
			}
			return newUrl;
		}

		return pub;
	}());

})(jQuery);