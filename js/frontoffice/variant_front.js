/* Copyright (c) 2017 Methys Digital
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of Methys Digital.
 * ("Confidential Information"). You shall not disclose such
 * Confidential Information and shall use it only in accordance with
 * the terms of the license agreement you entered into with Methys Digital.
 *
 * @author Anthony Galagade <galagadea@gmail.com>
 */

(function () {
    'use strict';

    var variant = {
    	data: JSON.parse($('#variantvalues').val()),
    	variant_values:[],
    	check:function(data) {
			var respond = {};
			if(data.f_select != ''){
				this.simplify();
				var variant_match = null;
				$.each(this.variant_values, function(i, val){
					if(val.value == data.f_select && val.option_value == data.s_select){
						variant_match = val;
					}
				});
				if(variant_match != null){
					if(variant_match.available == 0 || variant_match.hidden == 1 || variant_match.delete == 1){
						respond ={
							status: false,
							message:'The product is out of stock',
						};
					}else{
						respond = { 
							status: true,
						};
					}

				}else{
					respond ={
							status: false,
							message:'Combination mismatch',
					};
				}
			}else{
				respond ={
					status: false,
					message:'Please select first option',
				};
			}
			return respond;
			
		},
		simplify:function(){
			var data_val = [];
			$.each(this.data.data_values, function(i, value){
				$.each(value.options, function(id, option){
					data_val.push({'id':i, 'value': value.value, 'option_value': option.value, 'available': option.options.available, 'delete': option.options.delete,'hidden': option.options.hidden});
			    });
			});
			this.variant_values = data_val;
		},
		

    };
    $('.variant_error').hide();
    $('select.variant_select_0').on('change',function(){
    	$('.variant_error').hide();
    });
    $('select.variant_select_1').on('change',function(){
    	$('.variant_error').hide();
    	var response = variant.check({
    		f_select: $('select.variant_select_0').val(),
    		s_select: $(this).val()
    	});
    	if(response.status == false){
    		$(this).val('');
    		$('.variant_error').html(response.message);
    		$('.variant_error').show();
    	}
    });
    
})();


