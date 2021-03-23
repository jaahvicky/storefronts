/**
 * Methys Event Dispatcher
 * =======================
 * Version 1.0.0
 * Original Author: Benjamin Gardiner
 * --------------------------
 * 
 * Used for handling custom events.
 * 
 * Default behaviour is basic as follows:
 * 
 * Listen:
 * $($.methys.eventDispatcher).on('my-custom-event', function());
 * 
 * Trigger event:
 * $($.methys.eventDispatcher).trigger('my-custom-event', params);
 * 
 */
(function ($) {
	//Add class to methys namespace
	if (typeof $.methys === 'undefined') {
		$.methys = {};
	}

	$.methys.eventDispatcher = $(function () {
		var pub = {};

		return pub;
	});

})(jQuery);


