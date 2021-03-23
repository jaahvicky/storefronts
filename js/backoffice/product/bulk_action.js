/*
 * Copyright (c) 2017 Methys Digital
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of Methys Digital.
 * ("Confidential Information"). You shall not disclose such
 * Confidential Information and shall use it only in accordance with
 * the terms of the license agreement you entered into with Methys Digital.
 *
 * @author Anthony Galagade <galagadea@gmail.com>
 */
(function() {
	'use strict';

	class bulk_action {
		constructor(){
			this.data =[];
				
		}

		add(id){
			console.log(this.data);
			return new Promise((res,rej) => {
				const dt = this.getvalue(id);
				if(!dt){
					this.data.push(id);
					res(this.data) ;
				}else{
					rej([]) ;
				}
		    });
		}

		remove(id){
		  console.log(this.data);
		  return new Promise((res,rej) => {
				const dt = this.getvalue(id);
				if(dt){
					 this.data.splice( $.inArray(id, this.data), 1);
					res(this.data) ;
				}else{
					rej([]) ;
				}
		    });
		}

		getvalue(value){
			const val = $.inArray(value, this.data);
			if(val >= 0){
				return true;
			}else{
				return false;
			}
		}
		update(element,data){
		  element.val(data);
		}
	}
	const bulk = new bulk_action();
	$('.b_check_all').on('click', function(){
		if($(this).is(':checked')){
			console.log('is checked');
			$('td input[type=checkbox]').each(function(){
    			
    			console.log($(this).val());
    			bulk.add($(this).val()).then((val) => {
			  	 	$(this).prop('checked', true);
			  	 	bulk.update($('#selected_ids'), val);
			  	},(err)=>{
			  		console.log('error');
			  	});	
    				
			});

		}else{
			console.log('is notchecked');
			$('td input[type=checkbox]').each(function(){
    			console.log($(this).val());
    			bulk.remove($(this).val()).then((val) => {
    				$(this).prop('checked', false);
    				bulk.update($('#selected_ids'), val);
    			},(err)=>{
			  		console.log('error');
			  	});
			});
		}
	});

	$('.b_check').on('click', function(){
		if($(this).is(':checked')){
			console.log($(this).val());
    		bulk.add($(this).val()).then((val) => {
			  	$(this).prop('checked', true);
			  	bulk.update($('#selected_ids'), val);
			});	
		}else{
			bulk.remove($(this).val()).then((val) => {
				$(this).prop('checked', false);
				bulk.update($('#selected_ids'), val);
			},(err)=>{
			  		console.log('error');
			});
		}
	});

	$('.bulk_radio').on('click', function(){
		$('#selected_action').val($(this).val());
	});
	$('#bulk_action_apply').on('click',function(){
		var action_selected = $('#selected_action').val();
		var selected_ids = $('#selected_ids').val();
		var url = "moderator/modal/bulk/"+action_selected+"/"+selected_ids;
		$(this).attr('href', url);
	});

})();