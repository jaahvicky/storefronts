/* 
 * Methys Console Logger
 * =====================
 * Version 1.0.1
 * Original Author: Benjamin Gardiner
 * --------------------------
 * 
 * Description
 * ===========
 * The methys logger gives enhanced control over logging messages to the console.
 * debug/info/warn/err methods are available for sending messages and will be coloured accordingly.
 * Tags are available for easily identifying logging from different entities.
 * If a browser does not support the console.log command it will silently handle the logs.
 * 
 * Update History
 * ==============
 * v1.0.1 - Mar 2015
 * - Added automatic logging of objects if passed
 * 
 * v1.0.0 - Feb 2015
 * - Created
 * 
 * 
 * 
 * TODO:
 * =====
 * - Add handling of objects in regular log messages
 * 
 * 
 * Usage
 * =====
 * 
 * One can call a logger method directly from the jquery namespace (simple logging)
 * or a new Logger class can be instantiated with a tag allowing for easy seperation
 * of logging between different classes/pages/methods/etc.
 * 
 * Simple Logging:
 * ---------------
 * $.methys.log.info("sample message");
 * $.methys.log.err("sample message");
 * jQuery.methys.log.err("sample message");
 * 
 * Output: 
 * [INFO ][GENERAL] sample message
 * [ERROR][GENERAL] sample message
 * [ERROR][GENERAL] sample message
 * 
 * Advanced Logging:
 * -----------------
 * var logger = $.methys.Logger("CUSTOM TAG");
 * logger.info("sample message");
 * 
 * Output: [INFO ][CUSTOM TAG] sample message
 * 
 * Logging Objects:
 * ----------------
 * var o = { id: 5, name: "test" };
 * $.methys.log.obj(o);
 * 
 * Output will render object based on how the browser handles objects.
 * 
 * 
 * Setting Log Level Output:
 * -------------------------
 * LEVEL_ALL | LEVEL_DEBUG | LEVEL_INFO | LEVEL_WARN | LEVEL_ERR
 * 
 * $.methys.log.setLogLevel($.methys.log.LEVEL_WARN); //sets log level for general logger
 * or
 * logger.setLogLevel(logger.LEVEL_WARN); //sets log level for custom logger.
 * 
 * Output: Sets minimum log level to Warning.  Only warnings and error logs will display.
 */

(function ($) {
	//Add class to methys namespace
	if (typeof $.methys === 'undefined') {
		$.methys = {};
	}

	$.methys.Logger = function (tag) {
		var pub = {};
		var obj = null;

		//Log levels
		pub.LEVEL_ALL = 0;
		pub.LEVEL_DEBUG = 1;
		pub.LEVEL_INFO = 2;
		pub.LEVEL_WARN = 3;
		pub.LEVEL_ERR = 4;

		pub.SHOW_LINE = false; //Displays file + line number for code that called logger.

		//Minimum log level to display
		pub.minLevel = pub.LEVEL_ALL;

		pub.setLogLevel = function (level) {
			pub.minLevel = parseInt(level);
		};

		function log(message, meta) {
			if (typeof console !== 'undefined' && typeof console.log !== 'undefined') {
				var line = getLineNumber();
				if (pub.SHOW_LINE) {
					console.log(line);
				}
				console.log(message, meta);
			}
		}

		function getLineNumber() {
			try {
				var stackTrace = new Error().stack;
				var stack = stackTrace.split("\n");
				//find first line that does not include this file
				for (var i = 1; i < stack.length; i++) {
					if (stack[i].indexOf('methys.logger') !== -1) {
						continue;
					}

					var index = stack[i].indexOf('(');
					return stack[i].substr(index);
				}
				return null;
			} catch (error) {
				return null;
			}
		}

		pub.debug = function (message) {
			if (pub.minLevel > pub.LEVEL_DEBUG)
				return;

			prepare(message, 'DEBUG', tag, '#72AB60');
		};

		pub.info = function (message) {
			if (pub.minLevel > pub.LEVEL_INFO)
				return;

			prepare(message, 'INFO ', tag, '#0000ff');
		};

		pub.warn = function (message) {
			if (pub.minLevel > pub.LEVEL_WARN)
				return;
			prepare(message, 'WARN ', tag, '#DE9000');
		};

		pub.err = function (message) {
			if (pub.minLevel > pub.LEVEL_ERR)
				return;
			prepare(message, 'ERROR', tag, '#ff0000');
		};

		pub.obj = function (obj) {
			log(obj);
		};

		function isObject(data) {
			if (typeof data === 'object' || typeof data === 'function') {
				return true;
			}
			return false;
		}

		function prepare(message, level, tag, color) {
			var meta = 'color: ' + color;

			if (isObject(message)) {
				log(message);
			} else {
				var data = '%c [' + level + '][' + tag + '] ' + message;
				log(data, meta);
			}
		}

		return pub;
	};

	//Add common logger to namespace
	$.methys.log = $.methys.Logger('GENERAL');

})(jQuery);