/* 
 * Ownai Validator
 * =====================
 * Version 1.0.0
 * Original Author: Kevin van Zyl
 * --------------------------
 * 
 * Description
 * ===========
 * Ownai validator does client side validation on fields where some other rule must be implemented
 * when a field is either valid or invalid. 
 * For example when an email field is invalid then disable a checkbox
 * 
 * Usage
 * =====
 * 
 * Zim Phone: Add data-methys-valid='phone-zim' to the input
 * Email: Add data-methys-valid='email' to the input
 * 
 * Initialise like this:
 *  
 *  $(function() {
        $().ownaivalidator({
            store_contact_details_email: {
                whenTrue: function() {$('#preference_email').removeAttr('disabled')},
                whenFalse: function() {$('#preference_email').attr('disabled', true)}
            }
        });
    });
 * 
 */

(function ($) {
    
    $.fn.ownaivalidator = function(rules) {

	var DOM = {
            ATTR: {
                DATA_METHYS_VALID: 'data-methys-valid',
                CLASS_HAS_ERROR: "has-error"
            },
            SELECTORS: {
                INPUTS: '*[data-methys-valid]',
                FORM_GROUP: ".form-group"
            },
            EVENTS: {
            }
	};

	var CONST = {
            TYPE_ZIM_PHONE: "phone-zim",
            TYPE_EMAIL: "email"
	};
        
	$(function () {
            tasks.init();
	});

	var tasks = (function () {
            var pub = {};

            pub.init = function() {
                
                var inputs = $(DOM.SELECTORS.INPUTS);
                for (var i = 0; i < inputs.length; i++) {
                    pub.initEvent(inputs[i]);
                    pub.validate(inputs[i]);
                }
            };
            
            pub.initEvent = function(el) {
                
                $(el).on('input', function() {
                    $(this).val($(this).val().replace(/\s/g, ''));
                    pub.validate(el);
                });
            };
            
            pub.validate = function(el) {
                
                var valid = pub.checkValid(el);

                if (!valid) {
                    $(el).closest(DOM.SELECTORS.FORM_GROUP).addClass(DOM.ATTR.CLASS_HAS_ERROR);
                }
                else {
                    $(el).closest(DOM.SELECTORS.FORM_GROUP).removeClass(DOM.ATTR.CLASS_HAS_ERROR);
                }
                
                return valid;
            };
            
            pub.checkValid = function(el) {
                
                var validType = $(el).attr(DOM.ATTR.DATA_METHYS_VALID);
                var valid = false;
                
                if (validType === CONST.TYPE_ZIM_PHONE) {
                    valid = pub.checkZimPhone(el);
                }
                else if (validType === CONST.TYPE_EMAIL) {
                    valid = pub.checkEmail(el);
                }
                
                pub.doRule(el, valid);
                
                return valid;
            };
            
            pub.doRule = function(el, valid) {
                
                var id = $(el).attr('id');
                
                if (rules[id]) {
                    if (valid && rules[id].whenTrue) {
                        rules[id].whenTrue();
                    }
                    if (!valid && rules[id].whenFalse) {
                        rules[id].whenFalse();
                    }
                }
            }
            
            pub.checkZimPhone = function(el) {
                
                var phone = $(el).val();
                if (phone.length > 0) {
                    var pattern = /^\(?([7][7|8]\d{1})\)?[- ]?(\d{3})[- ]?(\d{3})$/;  
                    return pattern.test(phone); 
                }
                return true;
            };
            
            pub.checkEmail = function(el) {
                
                var email = $(el).val();
                if (email.length > 0) {
                    var pattern = /^([\w-\.\W]+@([\w-]+\.)+[\w-]{2,63})?$/;
                    return pattern.test(email);
                }
                return false;
            };

            return pub;
        }());
        
    }

})(jQuery);