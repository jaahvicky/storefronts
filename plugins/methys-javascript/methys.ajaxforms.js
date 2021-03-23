/**
 * Methys Ajax Forms
 * =================
 * Version 1.1.0
 * Original Author: Benjamin Gardiner
 * --------------------------
 * 
 */
(function ($) {
	var logger;
	var defaultLoader = $('<div class="overlay" data-maf-loader="true" style="display: none;"><i class="fc-icon fc-icon-loader-md"></i></div>');

	var DOM = {
		ATTR: {
		},
		SELECTORS: {
			FORM: 'form[data-maf]',
			CONTAINER: '*[data-maf-container]',
			LOADER: '.loader-overlay',
			FORM_SECTION_LOYALTY: '.form-section-loyalty',
			SECTION_LOYALTY_SUCCESS: '.section-loyalty-success',
			FORM_INPUT_ID: 'input[name=id_loyalty]',
			FORM_INPUT_VERSION: 'input[name=version_loyalty]',
			FORM_SECTION_REQUESTS: '.form-section-requests',
			SUBMIT_REQUEST: '#requestSubmit',
			MYBOOKING_DETAILS_CONTAINER: '#mybooking-details-container',
			EXPANDABLE: '*[data-fcexpandable]',
			FAQ_QUESTIONS_DIV: '#faq-category-questions',
			FAQ_QUESTIONS_DIV_INNER: '#faq-category-questions-inner',
			LUGGAGE_DETAILS: '#luggage-details',
			DIV_TICKET_NO: '#ticket-no',

		}
	};

	$(function () {
		//Init Logger
		initLogger();

		//Init
		if (tasks.init()) {
			$(document).on('submit', DOM.SELECTORS.FORM, tasks.submitForm);
		}

	});

	var tasks = (function () {
		var pub = {};
		var refreshCheckCount = 0;
		var refreshCheckUrl;
		var refreshCheckDelay = 5000;
		var refreshCheckTimeout = 300000; //timeout in milliseconds
		var refreshForm;

		pub.init = function () {
			return true;
		};

		pub.clearValidations = function (form) {
			form.find('.form-group, .input-group').removeClass('has-error');
			form.find('.help-block').html('');

			form.find('.alert-danger').fadeOut();
		};

		pub.showValidation = function (form, errors) {
			for (var property in errors) {
				property = formEscapeName(property); //escape name in case of special chars

				if (property === 'form') {
					var errorContainer = form.find('.alert-danger');
					if (errorContainer.length > 0) {
						errorContainer.html(errors[property]);
						errorContainer.fadeIn();
					}
					continue;
				}

				var input = form.find('*[name=' + property + ']');
				if (input.length === 0) { //no input found
					logger.warn("no input found for validations:" + property);
					continue;
				}

				//Add validation message
				input.closest('.form-group, .input-group').addClass('has-error');
				input.closest('.form-group').find('.help-block').html(errors[property]);

				//Add handler to clear validation on changes
				input.off('change', removeValidationOnChange); //remove any existing handlers.
				input.on('change', removeValidationOnChange);

				if (errors[property] == 'The email has already been taken.') {
					$('#errors').show();
					$('#errors').addClass('alert alert-danger').text("This user already exists.");
				}

				if (errors['curr_password'] || errors['new_password'] || errors['confirm_password']) {
					$('#errors').show();
					var pwd_errors = '';

					if (errors['curr_password']) {
						pwd_errors += errors['curr_password'] + "\n";
					}
					if (errors['new_password'] || errors['confirm_password']) {
						pwd_errors += errors['new_password'] + "\n";
					}

					$('#errors').addClass('alert alert-danger').text(pwd_errors);
				}
				else {
					$('#errors').hide();
				}
			}

			if ($('.has-error').length > 0) {
				if (!form.closest('*[data-maf-container=true]').hasClass('widget-newsletter')) { // Take out scroll for search loader
					$('html, body').animate({
						scrollTop: ($('.has-error').first().offset().top - 300)
					}, 3000);
				}
			}

			var email_errors = errors['contact\[email\]'];
			if (email_errors)
			{
				$('.help-block-div').show();
				var err = '';
				for (var i = 0; i < email_errors.length; i++) {
					err += email_errors[i];
				}
				form.find('.help-block').text(err);
			}

		};



		function removeValidationOnChange() {
			var input = $(this);
			input.closest('.form-group, .input-group').removeClass('has-error');
			if (input.attr('type') === 'radio') {
				//remove validation on other radio buttons
				var n = input.attr('name');
				$('input[name=' + n + ']').closest('.form-group, .input-group').removeClass('has-error');
			}
			//$('#errors').hide(); //.removeClass('alert alert-danger');
			input.off('change', removeValidationOnChange);
		}

		pub.showLoader = function (element, instant) {
			var loader;
			var container;

			container = element.closest(DOM.SELECTORS.CONTAINER);
			loader = container.find('[data-maf-loader]');

			if (loader.length === 0) {
				loader = defaultLoader.clone();
				container.append(loader);
			}

			if (typeof instant !== 'undefined' && instant) {
				loader.show();
			} else {
				loader.fadeIn();
			}
		};

		pub.hideLoader = function (form) {
			form.closest(DOM.SELECTORS.CONTAINER).find('[data-maf-loader]').fadeOut();
			hideFCLoader();
		};

		function hideFCLoader() {
			var loader = $(DOM.SELECTORS.LOADER);
			if (loader.length > 0 && loader.is(':visible')) {
				loader.fadeOut();
			}
		}

		pub.showSuccess = function (form, data) {
//			var callout = $('<div class="callout callout-success"><h4></h4><p></p></div>');
//			callout.find('h4').html(data.title);
//			callout.find('p').html(data.message);
//			callout.hide();
//			form.closest('.box-body').prepend(callout);
//			callout.fadeIn('slow').delay(1000).fadeOut('slow');

			//form.closest('.box').find('.box-header').addClass('success');


		};

		function refreshCheck() {
			if (refreshCheckCount * refreshCheckDelay > refreshCheckTimeout) {
				logger.err('Refresh Check timed out!');
				return;
			}
			$.ajax({
				url: refreshCheckUrl,
				type: 'GET',
				success: function (data, textStatus, jqXHR) {
					logger.obj(data);

					if (typeof data.errors !== 'undefined') { //validations
						//show validation errors
						pub.showValidation(refreshForm, data.errors);
						pub.hideLoader(refreshForm);
					} else if (typeof data.redirect !== 'undefined') { //redirect
						window.location = data.redirect;
						return;
					} else if (typeof data.noSeats !== 'undefined') {
						$(document).find('#no-seats-div').show();
						pub.hideLoader(refreshForm);
						return;
					} else if (typeof data.status !== 'undefined') {
						//pending
						setTimeout(refreshCheck, refreshCheckDelay);
					} else {
						//unknown response.
						logger.err('Unhandled response.');
						logger.err(data);
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					logger.obj(jqXHR.responseText);
					pub.hideLoader();
				}
			});
		}

		pub.submitForm = function (e) {
			e.preventDefault();

			var form = $(this);
			var data = form.serializeArray();
			var url = form.attr('action');
			var method = form.attr('method');

			pub.showLoader(form);
			pub.clearValidations(form);

			$.ajax({
				url: url,
				type: method,
				data: data,
				success: function (data, textStatus, jqXHR) {
					logger.obj(data);

					if (typeof data.error !== 'undefined') { //errors
						pub.showValidation(form, data.error);

					} else if (typeof data.errors !== 'undefined') { //validations
						pub.showValidation(form, data.errors);
						//custom handling of an error.
						if (typeof data['error-type'] !== 'undefined' && data['error-type'] === 'newsletter') {
							form.parent().parent().find('.widget-newsletter-description').fadeOut();
						}

					} else if (typeof data.success !== 'undefined' && data.success === true) { //success
						pub.showSuccess(form, data);
						
					} else if (typeof data.showDiv !== 'undefined') {
						$(document).find(data.showDiv).show();
						
					} else if (typeof data.lightbox !== 'undefined') { //lightbox
						logger.warn('no lighbox to show response');

					} else if (typeof data.redirect !== 'undefined') { //redirect
						window.location = data.redirect;

					} else if (typeof data.newtab !== 'undefined') { //open in new tab
						window.open(data.newtab, '_blank');

					} else if (typeof data.callback !== 'undefined') { //callback
						data.callback();

					} else if (typeof data.reloadUrl !== 'undefined') { //reload content of block
						pub.loadPartial(form, data.reloadUrl);

						return; //don't hide loader
					} else if (typeof data.refresh !== 'undefined' && (data.refresh === true || data.refresh === 'true')) { //Refresh current page
						window.location.reload();

					} else if (typeof data.refreshCheckRoute !== 'undefined') {
						refreshCheckCount = 0;
						refreshCheckUrl = data.refreshCheckRoute;
						refreshForm = form;
						setTimeout(refreshCheck, refreshCheckDelay);
						return; //don't allow loader to be hidden.

					} else if (typeof data.expandLoyaltyForm !== 'undefined') {
						/*Specifically for adding a loyalty no */
						$(DOM.SELECTORS.FORM_INPUT_ID).val(data.booking_id);
						$(DOM.SELECTORS.FORM_INPUT_VERSION).val(data.univ_version);
						$(DOM.SELECTORS.FORM_SECTION_LOYALTY).slideDown();

					} else if (typeof data.expandTicketNo !== 'undefined') {
						/*Specifically for adding a loyalty no */
						var array = data.tickets;
 
						if (array.length > 0) {

							var html = '<p><b> Your ticket number';
							if (array.length > 1) {
								html += 's'; //plural
							}
							html += ': </b> <br>';
							for (var i = 0; i < array.length; i++) {
								html += array[i] + '<br>';
							}
							html += '</p>';
						} else {
							var html = '<p><b> You do not have a ticket number yet. </b></p>';
						}

						$(DOM.SELECTORS.DIV_TICKET_NO).html(html);

					} else if (typeof data.expandLuggageDetails !== 'undefined') {
						/*Specifically for adding a loyalty no */
						$(DOM.SELECTORS.LUGGAGE_DETAILS).slideDown();
						$(DOM.SELECTORS.LUGGAGE_DETAILS).load(data.url, function () {
							$(DOM.SELECTORS.LUGGAGE_DETAILS).slideDown('slow');
						});
						
					} else if (typeof data.submitLoyaltyForm !== 'undefined') {
						var section = $(DOM.SELECTORS.SECTION_LOYALTY_SUCCESS);
						if (data.submitLoyaltyForm == true) {
							section.html('<h3> Success! </h3><p> We have added your loyalty number. </p>');
						} else {
							section.html('<p> You have already added a loyalty number for this flight. </p>');
						}

					} else if (typeof data.expandRequestsForm !== 'undefined') {
						/*Specifically for change booking page: show request form after validation */
						$(DOM.SELECTORS.FORM_SECTION_REQUESTS).slideDown(800);

					} else if (typeof data.submitRequestsForm !== 'undefined') {
						/*Specifically for change booking page: show success after submit */
						$(DOM.SELECTORS.SUBMIT_REQUEST).replaceWith('<h2>Your request was sent successfully!</h2>');

					} else if (typeof data.expandMyBooking !== 'undefined') {
						/*Specifically for My Booking page */
						$(DOM.SELECTORS.MYBOOKING_DETAILS_CONTAINER).fadeOut(200, function () {
							$(DOM.SELECTORS.MYBOOKING_DETAILS_CONTAINER).load(data.url, function () {
								$(DOM.SELECTORS.MYBOOKING_DETAILS_CONTAINER).fadeIn(200, function () {
								});
							});
						});

					} else if (typeof data.expandFaqArticles !== 'undefined') {
						$(DOM.SELECTORS.FAQ_QUESTIONS_DIV).load(data.url, function () {
							$(DOM.SELECTORS.FAQ_QUESTIONS_DIV_INNER).slideDown('slow');
						});

					} else {
						//unknown response.
						logger.err('Unhandled response.');
					}

					if (!form.closest('*[data-maf-container=true]').hasClass('widget-newsletter')) { //So that the whole search loader doesn't close when submitting newletter form
						pub.hideLoader(form);
					} else if (typeof data.errors !== 'undefined') {
						form.closest('*[data-maf-container=true]').find('.overlay').hide();
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					logger.err("Error submitting form: " + errorThrown);
					logger.obj(jqXHR.responseText);

					var response = $.parseJSON(jqXHR.responseText);

					var validations = {'form': 'Unable to submit'};
					if (typeof (response.error) !== 'undefined') {
						var errors = response.error;
						var e = '<div>' + errors.type + '</div><div>' +
								'<div>msg: ' + errors.message + '</div>' +
								'<div>file: ' + errors.file + '</div>' +
								'<div>line: ' + errors.line + '</div>';
						validations = {'form': e};
					}

					showValidations(form, validations);
					pub.hideLoader(form);
				},
				complete: function (jqXHR, textStatus) {

				}
			});
		};

		pub.loadPartial = function (form, url) {
			var container = form.closest('*[data-maf-container=true]');
			$.get(url, function (data) {
				var box = $(data);
				pub.showLoader(box, true);
				container.replaceWith(box);
				if (!form.closest('*[data-maf-container=true]').hasClass('widget-newsletter')) { //So that the whole search loader doesn't close when submitting newletter form
					pub.hideLoader(box);
				}
			});
		};

		pub.expandToggle = function () {
			var el = $(this);
			var container = el.parent().parent().find(DOM.SELECTORS.EXPANDABLE_CONTAINER);
			if (container.length == 0) {
				var container = el.parent().parent().find(DOM.SELECTORS.EXPANDABLE_SUBCONTAINER);
			}

			if (container.is(':visible')) {
				el.removeClass('fc-icon-minus-dark').addClass('fc-icon-plus-dark');
				container.slideUp();
			} else {
				el.removeClass('fc-icon-plus-dark').addClass('fc-icon-minus-dark');
				container.slideDown();
			}
		};


		return pub;
	}());

	function formEscapeName(string) {
		return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
	}

	function initLogger() {
		if (typeof $.methys !== 'undefined' && typeof $.methys.Logger !== 'undefined') {
			logger = $.methys.Logger('MAF');
		} else {
			logger = defaultLogger;
			logger.info('Using built-in logger.');
		}
	}

	var defaultLogger = (function () {
		var pub = {};
		var tag = "MAF";

		function log(message, meta) {
			if (typeof console !== 'undefined' && typeof console.log !== 'undefined') {
				console.log(message, meta);
			}
		}

		pub.info = function (message) {
			log('%c [INFO ][' + tag + '] ' + message, 'color: #00f');
		};

		pub.warn = function (message) {
			log('%c [WARN ][' + tag + '] ' + message, 'color: #DE9000');
		};

		pub.err = function (message) {
			log('%c [ERROR][' + tag + '] ' + message, 'color: #f00');
		};

		pub.obj = function (obj) {
			log(obj);
		};

		return pub;
	}());

	if(window.location.pathname == '/admin/dashboard' || '/index.php/admin/dashboard'){
		$('.read-notification').on('click', function(e){
			e.preventDefault();
			$.ajax({
			  method: 'POST',
			  url: 'ajax-last-activity',
			  data: {'_token': $('meta[name="csrf-token"]').attr('content')},
			}).done(function( da ) {
			    console.log( da );
			    $('.read-number').html('0');
			    $('.order-number').css('display', 'none');
			});

		}); //end onclick
	}
	
})(jQuery);

