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
     
    var methysAngular = angular.module('variant', []); 
    methysAngular.config(function($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    }); 
    methysAngular.controller('attribute', Attributes);
    Attributes.$inject = ['$window', '$scope'];
    function Attributes($window, $scope) {
    	 var atr = this;
    	 atr.attributeNames = getAtrributeName;
    	 atr.data = JSON.parse($('#variantvalues').val());
    	 atr.data.data = getAtrributeOrginal
    	 atr.rowData = getAtrributeData;
    	 atr.remove = remove;
    	 atr.outofstock = outofstock;
    	 atr.hide = hide;
    	 atr.available = available;
    	 atr.addAttribute = addAttribute;
    	initController();
 		function initController() {
            getAtrributeName();
            getAtrributeOrginal();
            getAtrributeData();
 			
        }

    	function getAtrributeName(){
    		var names =[];
    		$.each(atr.data.elements, function(i,datid){
		    	$.each(variantdetails, function(id, dat){
		          if(datid.id == dat.id){
		          	names.push({'id': datid.id, 'name': dat.name, 'value': datid.values});
		          }
				});
			});

			if(atr.data.data_values != undefined && atr.data.data_values.length > 0){
				atr.attributeNames = names;
			}else{
				atr.attributeNames = [];
			}

			
    	}
    	function getAtrributeOrginal(){
    		if(atr.data.data_values != undefined){
    			atr.data.data = atr.data.data_values;
    		}else{
    			atr.data.data = [];
    		}
    	}
    	function getAtrributeData(){
    		 var f_row = [];
    		
    		 $.each(atr.data.data_values, function(i, value){
		        $.each(value.options, function(t, option){
		        	if(option.options.delete == 0){
		        		f_row.push({'id':i, 'value': value.value,
		            		'option_value': option.value,
		            		'available': option.options.available,
		            		'delete': option.options.delete,
		            		'hidden': option.options.hidden
		           		});
		        	}
		        		
		        	

		        });   
		    });
    		atr.rowData = f_row;
    	}
		function remove(id){
			var dt = getvalue(id);
			if(!$.isEmptyObject(dt)){
				atr.data.data_values[id].options[0].options.delete = 1;
				updatedata(atr.data);
				
			}
		}

		function outofstock(id){
			var dt = getvalue(id);
			if(!$.isEmptyObject(dt)){
				atr.data.data_values[id].options[0].options.available = 0;
				atr.data = atr.data;
				updatedata(atr.data);
			}	
		}

		function hide(id){
			var dt = getvalue(id);
			if(!$.isEmptyObject(dt)){
				atr.data.data_values[id].options[0].options.hidden = 1;
				atr.data = atr.data;
				updatedata(atr.data);
			}	
		}

		function available(id){
			var dt = getvalue(id);
			if(!$.isEmptyObject(dt)){
				atr.data.data_values[id].options[0].options.available = 1;
				atr.data = atr.data;
				updatedata(atr.data);
			}	
		}

		function getvalue(key){
			if(atr.data.data_values != undefined  && atr.data.data_values.hasOwnProperty(key)){

				return atr.data.data_values[key];
			}else{
				return {};
			}
		}
		function updatedata(data, state=false){
			getAtrributeData();
			getAtrributeName();
			$('#variantvalues').val(JSON.stringify(data))
			if(state){
				$scope.$apply();
			}
			$("#saveButton").prop('disabled', false);
			

		}

		function addAttribute (rm_id, add){
			var variant_dat ={
            	variant_ids: [],
            	data_values: [],
            	elements:[]
        	}
	        var attribute_value = [];
	        var data = JSON.parse($('#variant_ids').val());
	        var original_data = atr.data;
	        $.each(data, function(i, id)
	        {
	            var attr_value = $("#variant_"+id).val();
	            if(attr_value.length > 0)
	            {
	            	variant_dat.variant_ids.push({'id': id});
	            	variant_dat.elements.push({'id': id, 'values':attr_value});
	            	attribute_value.push(attr_value);
	           }
	        });
	        $.each(attribute_value, function(i, value){
	        	if(i % 2 == 0)
	        	{
	        		var values = value.split(",");
	               	$.each(values, function(t, name)
	               	{
	                    var sec_value = attribute_value[i+1];
	                    if(sec_value != undefined)
	                    {
	                        sec_value = sec_value.split(",");
	                        $.each(sec_value, function(s, sname)
	                        {
	                           var data_p = {
	                            'value': name,
	                            'options':[{
	                                'value':sname,
	                                'options':{
	                                 'available':1,
	                                 'hidden':0,
	                                 'delete':0,
	                                }
	                                        
	                            }]};
	                               
	                          	variant_dat.data_values.push(data_p);
	                         });    
	                    }
	                           
	                });
	             }  
	          }); 
	        if(atr.data.data_values !=undefined && atr.data.data_values.length != variant_dat.data_values.length){
	        	var data_to_set = compareData(rm_id, atr.data.data_values, variant_dat.data_values, add);
	        	atr.data.variant_ids = variant_dat.variant_ids
	        	atr.data.data_values = data_to_set;
	        	atr.data.elements = variant_dat.elements;
	            updatedata(atr.data, true);
	        }
	        
       
		}
		function getPosition (id) {
			var position = null
			$.each(atr.data.elements, function(i, dt){
				if(id== dt.id)
				{
					position = i;
				}
			});
			return position;
		}
		function getoldData(original_data){
			var data = [];
			$.each(original_data, function(i, value){
				$.each(value.options, function(id, option){
					data.push({'id':i, 'value': value.value, 'option_value': option.value, 'available': option.options.available, 'delete': option.options.delete,'hidden': option.options.hidden});
				});
			});
			return data;
		}
		function sortRemovedData(rm_id, original_data, up_data){
			var orgdata = [];
			var updata =[];
			var return_data =[];
			
			var word_removed = rm_id.words.split(',');
			var position = getPosition(rm_id.id);
			var oldData_array = getoldData(original_data);
			if(position == 0){
				$.each(word_removed, function(i, dt){
						$.each(oldData_array, function(it, data){
							if(dt == data.value){
							  orgdata.push(data);
							}
							
					});
				});
			}
			if(position == 1){
				$.each(word_removed, function(i, dt){
						$.each(oldData_array, function(it, value){
							if(dt == value.option_value){
							  orgdata.push(value);
							}
						});
				});

			}
			$.each(orgdata, function(it, nw){
		   		var data_p = {
	                'value': nw.value,
	                'options':[{
	                    'value':nw.option_value,
	                    'options':{
	                        'available':nw.available,
	                        'hidden':nw.hidden,
	                        'delete':nw.delete,
	                    }
	                                        
	                }]};
	                               
	            return_data.push(data_p);
		   	});
			return return_data;
		}


		function sortAddedData(rm_id, original_data, up_data){
			var orgdata = [];
			var updata =[];
			var return_data =[];
			var word_removed = rm_id.words.split(',');
			var position = getPosition(rm_id.id);
			var oldData_array = getoldData(original_data);

			if(position == 1){
				$.each(word_removed, function(i, dt){
						$.each(oldData_array, function(it, data){
							if(dt == data.option_value){
							  orgdata.push(data);
							}
							
					});
				});
			}else{
				$.each(original_data, function(i, value){
					$.each(value.options, function(id, option){
					 orgdata.push({'id':i, 'value': value.value, 'option_value': option.value, 'available': option.options.available, 'delete': option.options.delete,'hidden': option.options.hidden});
			    	});
			    });
			}
			$.each(up_data, function(i, value){
				$.each(value.options, function(id, option){
					updata.push({'id':i, 'value': value.value, 'option_value': option.value, 'available': option.options.available, 'delete': option.options.delete,'hidden': option.options.hidden});
			    });
			});
			$.each(updata, function(it, nw){
				 		var data_option = {};
				 		$.each(orgdata, function(i, org){
				 			if((nw.value == org.value) && (nw.option_value == org.option_value)){
				 				data_option ={
				 					'available':org.available,
	                                'hidden':org.hidden,
	                                'delete':org.delete
	                            }
				 			}
				 		});
				 		if(data_option.available != undefined){
				 			var data_p = {
	                            'value': nw.value,
	                            'options':[{
	                                'value':nw.option_value,
	                                'options':{
	                                 'available':data_option.available,
	                                 'hidden':data_option.hidden,
	                                 'delete':data_option.delete,
	                                }
	                                        
	                            }]};
	                               
	                    	return_data.push(data_p);

				 		}else{
				 			var data_p = {
	                            'value': nw.value,
	                            'options':[{
	                                'value':nw.option_value,
	                                'options':{
	                                 'available':1,
	                                 'hidden':0,
	                                 'delete':0,
	                                }
	                                        
	                            }]};
	                               
	                    	return_data.push(data_p);
				 		}
				
			});
			return return_data;
		}
		function compareData(rm_id, original_data, up_data, state) {
			var return_data =[];
			if(state){
				return_data = sortAddedData(rm_id, original_data, up_data);
			}else{
				return_data = sortRemovedData(rm_id, original_data, up_data);
			}
			return return_data;
		}
		$window.add = atr.addAttribute;
		$window.updatetable = atr.updatedata
    }
    
    $(document).keypress(function (e) {
        if (e.which == 13) {
 			return false;
        }
    });
    $('.extra_attribute').hide();
    $('#extra_attribute').on('click', function(){
        if($('.extra_attribute').css('display') == 'none'){
            $('.extra_attribute').show();
            $(this).html('Close variations tab');
        }else{
            $(this).html('Add Variations');
            $('.extra_attribute').hide();
            
        }
    });
    $('.variant_atrribuite').on('itemAdded',function(){
    	console.log('itemAdded');
    	
    	
    	if(document.readyState === 'complete') {
			window.add({
    				id:$(this).attr('data-variant-id'), 
    				words: $(this).val()
    	    }, true);
        }

    });
	$('.variant_atrribuite').on('itemRemoved',function(){
    	console.log('itemRemoved');
    	
    	window.add({
    		id:$(this).attr('data-variant-id'), 
    		words: $(this).val()
    	}, false);

    });
})();
