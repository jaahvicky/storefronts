/**
 * Methys File Uploader (MFU)
 * ==========================
 * Version 2.0.1.J
 * Original Author: Benjamin Gardiner
 * 
 * --------------------------
 * Update History
 * ==============
 * v2.0.2 - Oct 2015
 * - updated for laravel 5 project
 * - customized for flightclub
 * 
 * v2.0.1.J - Feb 2015
 * - Updated to use ChatPages Java Controller
 * - Added mfu-token parameter.
 * - Changed to use ChatPages json error response.
 * 
 * v2.0.0 - Feb 2015
 * - Refactored to more manageable code with simpler data tags
 * - Added optional image resizing
 * - Added optional mime-type limits
 * - Added path overriding
 * - Added default html injection for window
 * - Added logger support
 * 
 * 
 * Data Tags
 * =========
 * 
 * data-mfu			= true				- use on file input that must use MFU.
 * data-mfu-route	= [route to upload] - required if default route is not specified in window html.
 * data-mfu-path	= [path to upload]	- optional. Default is 'uploads'
 * data-mfu-token	= [token]			- optional. Can be used for token passing for auth validation.
 * data-mfu-mimes	= [comma seperated mime types] - what mime types to allow (note that controller will also restrict)
 * data-mfu-resize	= [width,height]	- Image resize options (if supported in controller).
 *										- height is optional. If either width/height is set to zero
 *										- then the resize will base off the other value.
 * 
 * data-mfu-trigger = [file-input name] - a/div/button/etc that will trigger MFU window to open.
 * 
 * data-mfu-value   = [response type]   - update an element with file value (input/img)
 * data-mfu-imagebackground = [response type] - update the css background-image value for this element.
 * data-mfu-classes = [class names]		- update class. 2 classes seperated by pipe (|).
 * data-mfu-text    = [response type]   - update html content for element with value.
 * 
 * Example
 * =======
 * 
 * Compact:
 * <input type='file' name='image_md' value='' data-mfu='true' data-mfu-route='/uploadfile/'/>
 * <input type='hidden' name='image_md' data-mfu-value='url' />
 * <img src='' data-mfu-source='image_md' data-mfu-value='fullUrl' data-mfu-trigger='image_md'/>
 * <a href='#' class='btn btn-primary' data-mfu-trigger='image_md'>Upload Image</a>
 * 
 * Description:
 * #3 File Input
 * - name is used to link all elements together as well as for submitting value in the form.
 * - data-mfu is required to make everything work.
 * - data-mfu-route tells it what url to upload to.
 * <input type='file' name='image_md' value='' data-mfu='true' data-mfu-route='/uploadfile/'/>
 * #2 hidden input for storing value.  
 * - "name" should match #1
 * - data-mfu-value='url' means use the "url" value returned from uploading
 * (e.g. using 'filename' could result in a value of 'abc.png', 'url' would result in 'uploads/abc.png'.
 * <input type='hidden' name='image_md' data-mfu-value='url' />
 * #3 a visible image showing uploaded file.
 * - data-mfu-source should equal the 'name' of #1.
 * - data-mfu-value=fullurl means use the full url for the image source.
 * - data-mfu-trigger means clicking this element will open the upload window
 * <img src='' data-mfu-source='image_md' data-mfu-value='fullUrl' data-mfu-trigger='image_md'/>
 * #4 button for opening upload window
 * - data-mfu-trigger should equal the 'name' of #1
 * <a href='#' class='btn btn-primary' data-mfu-trigger='image_md'>Upload Image</a>
 * 
 * 
 * TODO:
 * =====
 * - Add mime-type restrictions
 * - Add loader
 */
(function ($) {
	var logger = $.methys.Logger("FILEUPLOAD");
	var eventDispatcher = $.methys.eventDispatcher;
	
	var inputs = [];
	var defaultWindow;
	var debug = true; //Enable to see debug info in console
	var DEFAULT_UPLOAD_PATH = 'uploads';

	var DOM = {
		ATTR: {
			DEFAULT_IMAGE: 'data-mfu-remove'
		},
		SELECTORS: {
			REMOVE_BUTTON: '*[data-mfu-remove]' 
		},
		EVENTS: {
		}
	};

	$(function () {
		//Initializations

		//Init MFU
		if (mfu.init()) {
			$(DOM.SELECTORS.REMOVE_BUTTON).on('click', mfu.remove);
			mfu.initInputs();
			mfu.initTriggers();
		}

		$.methys.eventDispatcher.on('fc-init-fileupload', function() {
			mfu.initInputs();
			mfu.initTriggers();
		})

	});

	function formEscapeName(string) {
		return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
	}

	var mfu = (function () {
		var pub = {};
		var loader = null;

		pub.init = function () {
			//Check that jquery plugins are loaded
			if (typeof $.fn.fileupload === 'undefined') {
				logger.err("jquery.fileupload.js plugin not loaded");
				return false;
			}
			
			if (!pub.initWindow()) {
				return false;
			}

			return true;
		};

		/**
		 * Initializes the upload window.  If window cannot be initialized then
		 * file uploader will not work.
		 * @returns {Boolean}
		 */
		pub.initWindow = function () {
			logger.debug("Initializing window");
			defaultWindow = $('#mfu-window-default');
			if (defaultWindow.length === 0) {
				//Insert default html
				defaultWindow = $(defaultWindowHtml);
				logger.info("Window for fileuploads not found. Using default.");
			}

			logger.debug("Window initialized successfully");
			return true;
		};

		pub.remove = function(e) {
			e.preventDefault();
			
			var button = $(this);
			var defaultImage = button.attr(DOM.ATTR.DEFAULT_IMAGE);
			var inputs = button.closest('.form-group').find('input[type=hidden]');
			var images = button.closest('.form-group').find('.fc-fileupload-image');
			
			if (inputs.length > 0) {
				logger.debug('resetting input');
				for (var i=0; i<inputs.length; i++) {
					$(inputs[i]).val('');
					$(inputs[i]).trigger('change');
				}
			}
			
			if (images.length > 0) {
				logger.debug('resetting images');
				for (var i=0; i<images.length; i++) {
					$(images[i]).css('background-image', 'url('+defaultImage+')');
                                        $(images[i]).closest('.form-group').removeClass('has-image');
				}
			}
			
			button.hide();
		};

		pub.initInputs = function () {
			var fileinputs = $('input[type=file][data-mfu=true]');
			logger.debug("found " + fileinputs.length + " mfu file inputs");

			for (var i = 0; i < fileinputs.length; i++) {
				var fileinput = $(fileinputs[i]);
				var inputname = fileinput.attr('name');

				var triggers = $('*[data-mfu-trigger=' + formEscapeName(inputname) + ']');
				if (triggers.length === 0) {
					logger.warn("Unable to find trigger for fileinput name=" + inputname);
					continue;
				}

				var imageResize = typeof fileinput.attr('data-mfu-resize') === 'undefined' ? null : fileinput.attr('data-mfu-resize');
				var mimes = typeof fileinput.attr('data-mfu-mimes') === 'undefined' ? null : fileinput.attr('data-mfu-mimes');
				var path = typeof fileinput.attr('data-mfu-path') === 'undefined' ? DEFAULT_UPLOAD_PATH : fileinput.attr('data-mfu-path');
				var route = typeof fileinput.attr('data-mfu-route') === 'undefined' ? null : fileinput.attr('data-mfu-route');
				var token = typeof fileinput.attr('data-mfu-token') === 'undefined' ? null : fileinput.attr('data-mfu-token');
				//remove fileinput from form.
				fileinput.remove();
                                
				inputs.push({
					name: inputname,
					triggers: triggers,
					resize: imageResize,
					mimes: mimes,
					path: path,
					route: route,
					token: token
				});
			}
		};

		pub.initTriggers = function () {
			for (var i = 0; i < inputs.length; i++) {
				inputs[i].triggers.on('click', pub.showUpload);
			}
		};

		/*
		 * Show fileupload window popup
		 */
		pub.showUpload = function () {
			logger.debug(typeof $.fileupload);
			var window = defaultWindow.clone();
			var background = $('<div class="mfu-window-background"></div>');
			var progressBar = $(window.find('.mfu-progressbar'));
			var browseTriggers = window.find('*[data-mfu-action=browse]');
			var fileInput = window.find('input[type=file]');
			var closeTriggers = window.find('*[data-mfu-action=close]');
			var trigger = $(this);
			loader = window.find('.overlay');
                        
			//Validate window
			if (browseTriggers.length === 0) {
				logger.warn("Upload Window - no 'browse' trigger found. Check html.");
			}

			if (fileInput.length === 0) {
				logger.err("Upload Window - no file input found.  Check html.");
				return;
			}

			if (fileInput.length > 1) {
				logger.err("Upload Windows - more than 1 file input found.  Check html.");
				return;
			}

			var sourceName = $(this).attr('data-mfu-trigger');

			window.attr('id', '').hide(); //Remove window id.
			background.hide();

			//Add window and background to page.
			$('body').append(window);
			$('body').append(background);
			
			window.fadeIn();
			background.fadeIn();

			//Add events for window
			background.on('click', function () {
				window.fadeOut(null, function() {
					window.remove();
				});
				background.fadeOut(null, function() {
					background.remove();
				});
			});
			
			if (closeTriggers.length > 0) {
				$(closeTriggers).on('click', function () {
					window.remove();
					background.remove();
				});
			}

			browseTriggers.on('click', function () {
				fileInput.click();
			});

			var input = pub.getInputByName(trigger.attr('data-mfu-trigger'));
			var formData = {
				path: input.path,
				accept: ''
			};

			//Verify Route
			var route = window.find('form').attr('action');
			if (input.route === null && route === '') {
				logger.err("No route has been defined.");
				return;
			} else if (input.route !== null) {
				route = input.route;
			}
			window.find('form').attr('action', route);
			logger.info("Using route " + route);

			//Check if mime data should be passed			
			if (input.mimes !== null) {
				formData.mimeTypes = input.mimes;
			}

			//Check if image resize data should be passed
			if (input.resize !== null) {
				formData.imageResize = input.resize;
			}

			//Add token if specified.
			if (input.token !== null) {
				formData._token = input.token;
			}
                        
			//Set ajax fileupload properties.
			logger.debug(typeof $.fileupload);
			fileInput.fileupload({
				dataType: 'json',
				dropZone: window,
				formData: formData,
				submit: function (e, data) {
					logger.info("Starting upload");
					progressBar.css('width', '0%');
					browseTriggers.hide();
					background.off('click'); // prevent for closing box while uploading
					pub.hideErrors(window);
				},
				progressall: function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 10);
					progressBar.css('width', progress + '%');
					if (progress > 95) {
						//Fade in loader so that processing of image is catered for.
						loader.fadeIn();
					}
				},
				done: function (e, data) {
					logger.info("Upload completed.");
					logger.obj(data.result);

					if (typeof (data.result.errors) !== 'undefined') {
						//errors exist.
						logger.warn("Error uploading: " + data.result.error);
						pub.showError(data.result.error, window);
						background.on('click', function () {
							window.remove();
							background.remove();
						});
						return;
					} else if (typeof data.result.errorURL !== 'undefined') {
						logger.warn("Error uploading: " + data.result.errorURL);
						pub.showError(data.result, window);
						background.on('click', function () {
							window.remove();
							background.remove();
						});
						return;
					}

					//set values
					pub.updateAll(sourceName, data.result);
					trigger.trigger('mfu-complete', data.result);
					window.remove();
					background.remove();

				},
				fail: function (e, data) {
					logger.err("Ajax error encountered");
					if (debug) {
						logger.obj(data.jqXHR);
						//logger.obj(data.jqXHR.responseText);
					}

					pub.showError("An unknown error was encountered.", window);
					browseTriggers.show();

					background.on('click', function () {
						window.remove();
						background.remove();
					});
				},
				complete: function() {
					loader.fadeOut();
				}
			});

		};

		pub.getInputByName = function (name) {
			for (var i = 0; i < inputs.length; i++) {
				if (inputs[i].name === name) {
					return inputs[i];
				}
			}
			return false;
		};

		pub.updateAll = function (inputName, data) {
			pub.updateInputs(inputName, data);
			pub.updateImages(inputName, data);
			pub.updateClasses(inputName, data);
			pub.updateText(inputName, data);
		};

		pub.updateInputs = function (inputName, data) {
			var inputs = $('input[name=' + formEscapeName(inputName) + '][data-mfu-value]');
			for (var i = 0; i < inputs.length; i++) {
				logger.info("Updating input value");
				var valueType = $(inputs[i]).attr('data-mfu-value');
				$(inputs[i]).attr('value', pub.getValue(valueType, data));
				$(inputs[i]).trigger('change');
			}
		};

		pub.updateImages = function (inputName, data) {
			//update direct images
			var images = $('img[data-mfu-source=' + formEscapeName(inputName) + '][data-mfu-value]');
			for (var i = 0; i < images.length; i++) {
				logger.info("Updating an image source");
				var valueType = $(images[i]).attr('data-mfu-value');
				$(images[i]).attr('src', pub.getValue(valueType, data));
			}

			//update background-image css
			var images = $('*[data-mfu-source=' + formEscapeName(inputName) + '][data-mfu-imagebackground]');
			for (var i = 0; i < images.length; i++) {
				logger.info("Updating background-image");
				var valueType = $(images[i]).attr('data-mfu-imagebackground');
				$(images[i]).css('background-image', 'url(' + pub.getValue(valueType, data) + ')');
				$(images[i]).closest('.form-group').find(DOM.SELECTORS.REMOVE_BUTTON).show();
                                $(images[i]).closest('.form-group').addClass('has-image');
			}
		};

		pub.updateClasses = function (inputName, data) {
			var divs = $('*[data-mfu-source=' + formEscapeName(inputName) + '][data-mfu-classes]');
			for (var i = 0; i < divs.length; i++) {
				logger.info("Updating element class");
				var classNames = $(divs[i]).attr('data-mfu-classes').split('|');
				if (classNames.length > 1) {
					$(divs[i]).removeClass(classNames[1]); //remove fail class
				}
				$(divs[i]).addClass(classNames[0]);
			}
		};

		pub.updateText = function (inputName, data) {
			var divs = $('*[data-mfu-source=' + formEscapeName(inputName) + '][data-mfu-text]');
			for (var i = 0; i < divs.length; i++) {
				logger.info("Updating element text");
				var valueType = $(divs[i]).attr('data-mfu-text');
				$(divs[i]).html(pub.getValue(valueType, data));
			}
		};

		pub.getValue = function (valueName, data) {
			if (!(valueName in data)) { //key doesn't exist
				logger.warn("A key requested ('" + valueName + "') for updating the value of an element is not valid.");
				return false;
			}

			return data[valueName];
		};

		pub.formEscapeName = function (string) {
			return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
		};

		pub.showError = function (message, window) {
			window.find('.mfu-errors > p').html(message);
			window.find('*[data-mfu-show=error]').show();
		};

		pub.hideErrors = function (window) {
			window.find('.mfu-errors').hide();
		};



		return pub;
	}());



	var methods = (function () {
		var pub = {};



		pub.test = function () {
			if ($(this).attr('data-methys-fileupload-resize-width')) {
				var width = $(this).attr('data-methys-fileupload-resize-width');
				fileInput.after($('<input type="hidden" name="width" value="' + width + '">'));
				console.log('added width');
			}

			/* Accepted formats */
			var format = $(this).attr('data-methys-fileupload-format');
			if (typeof format !== 'undefined') {
				var mimesImages = 'image/jpeg|image/pjpeg|image/png|image/gif';
				var mimesApplications = 'application/pdf|application/msword';
				var mimesVideos = 'video/mp4';
				var mimes = mimesImages; // mimes images by default
				if (format === 'video') {
					mimes = mimesVideos;
				} else if (format === 'application') {
					mimes = mimesApplications + '|' + mimesImages;
				}
				var acceptedMimes = mimes.split('|');
				var accept = '';
				acceptedMimes.forEach(function (el) {
					accept += el + ',';
				});
				fileInput.attr('accept', accept);
			}
			/* End accepted formats */

		};
	}());

	var defaultWindowHtml =
			"<div id='mfu-window-default2' class='mfu-window' style='display: none;'>" +
			"	<div class='mfu-dropzone'>" +
			"		<span>" +
			"			<img alt='Drag your file here' src='data:image/png;base64,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' />" +
			"		</span>" +
			"	</div>" +
			"	<div class='mfu-progressbar-container'>" +
			"		<div class='mfu-progressbar'></div>" +
			"	</div>" +
			"	<div class='mfu-errors callout callout-danger' style='display: none;' data-mfu-show='error'>" +
			"		<h4>Unable to upload file</h4>" +
			"		<p></p>" +
			"	</div>	" +
			"	<button class='btn btn-block btn-default' data-mfu-show='error' data-mfu-action='close' style='display: none;'>Ok</button>" +
			"	<div class='mfu-browse'>" +
			"		<a href='#' data-mfu-action='browse' class='btn btn-primary btn-block'>Browse</a>" +
			"	</div>" +
			"	<div class='mfu-form'>" +
			"		<form method='POST' action='' accept-charset='UTF-8' enctype='multipart/form-data'>" +
			"			<input name='file' type='file'>" +
			"			<input name='' />" +
			"			<input type='submit' value='upload'>" +
			"		</form>" +
			"	</div>" +
			"	<div class='overlay' style='display: none;'>" +
            "		<i class='fa fa-spinner fa-spin'></i>" +
            "	</div>" +
			"</div>";

})(jQuery);