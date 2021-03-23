
(function ($) {
	var logger = $.methys.Logger("MODALS");
	var eventDispatcher = $.methys.eventDispatcher;

	var DOM = {
		ATTR: {
			MODAL: 'data-modal'
		},
		SELECTORS: {
			MODAL: 'a[data-modal]',
			DISMISS: '*[data-dismiss]'
		}
	};

	$(function () {
		$('body').on('click', DOM.SELECTORS.MODAL, tasks.openModal);
		$('body').on('click', DOM.SELECTORS.DISMISS, tasks.dismissModal);
	});

	var tasks = (function () {
		var pub = {};

		pub.openModal = function (e) {
			e.preventDefault();

			var form_id = $(this).attr('id');
			var url = $(this).attr('href');
			
			var modal = $('<div class="modal fade"></div>').modal({ show: false});
			modal.load(url, function(response, status, xhr) {
				if (xhr.status === 401) {
					//refresh page - authentication has expired.
					window.location = window.location;
				}

				if (form_id == 'modal-form-files') {
					$.methys.eventDispatcher.trigger('fc-init-fileupload');
				}
			});

			$('body').append(modal);
			modal.modal('show');
			modal.on('hidden.bs.modal', pub.removeModal);
		};
		
		pub.dismissModal = function(e) {
			e.preventDefault();
			$(this).closest('.modal').modal('hide');
		};
		
		pub.removeModal = function(e) {
			$(this).remove();
		};

		return pub;
	}());

})(jQuery);



