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
     
    var methysAngular = angular.module('SyncData', []); 
    methysAngular.config(function($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    });
    methysAngular.controller('SyncController', SyncController);
    SyncController.$inject = ['$window', '$scope'];
    function SyncController($window, $scope) {
    	 var atr = this;
    	 atr.deleteItem = deleteItem;
    	 atr.rowData = [];
    	 atr.SyncItem = SyncItem;
    	 atr.getAllData = getAllData;
    	 atr.bulkSync = bulkSync;
    	 atr.checked = checked;
    	 atr.selected = [];
    	initController();
 		function initController() {
           getAllData({'data':[]}, false);
 			
        }

        function checked($event, item){
        	//console.log(item);
        	var checkbox = $event.target;
        	if(checkbox.checked){
        		//console.log(atr.selected);
        		atr.selected.push(item);
        		//console.log(atr.selected);
        	}else{
        		
        		$.each(atr.selected, (i,v)=>{
        				
        			if(keyExists('id', v)){
        				console.log(i,v.id, item.id);
        				if(v.id == item.id){
        					atr.selected.splice(i,1);
        				}
        			}
        			
        		});
        		
        	}
        	
        }
        $scope.isEmpty = function (obj) {
		    for (var i in obj) if (obj.hasOwnProperty(i)) return false;
		    return true;
		};
        function keyExists(key, search) {
		    if (!search || (search.constructor !== Array && search.constructor !== Object)) {
		        return false;
		    }
		    for (var i = 0; i < search.length; i++) {
		        if (search[i] === key) {
		            return true;
		        }
		    }
		    return key in search;
		}
        function deleteItem(id){
        	var formData = {
            deleteId: id,
            _token: $("input[name*='_token']").val(),

	        };

	        $('#load-modal').modal('show');
	        $('.loading-migrate').animate({ width: '90%' }, 'slow');
	        

	        $.ajax({
	          url: "delete/migration",
	          data: formData,
	          method: "POST",
	          
	        }).done(function( data ) {
	            console.log(data);
	            reload();
	            $('#load-modal').modal('hide');
	            
	        });
        }
        function SyncItem(item){
        	if(item.status_id == 0){
	        	var formData = {
	            	id: item.id,
	            	_token: $("input[name*='_token']").val(),

		        };

		        $('#load-modal').modal('show');
		        $('.loading-migrate').animate({ width: '90%' }, 'slow');

		        $.ajax({
		          url: "sync/migration",
		          data: formData,
		          method: "POST",
		          
		        }).done(function( data ) {
		            console.log(data);
		            reload();
		            $('#load-modal').modal('hide');

		            
		        });
	        }else{
	        	console.log('cant sync');
	        }
        }
        function reload(){
        	atr.rowData = [];
	         $.ajax({
	          url: "items/migration",
	          method: "GET",
	          
	        }).done(function( data ) {
			 	console.log(data);
			 	getAllData(data, true);
			});
    	}
        function bulkSync(){

        	$('.non-selector').hide();
        	$('#load-modal').modal('show');
	        $('.loading-migrate').animate({ width: '90%' }, 'slow');
	        var items = atr.selected;
	        var actioner = $("input[name='actioner']:checked").val();
	        var url = "bulk/" + actioner;
	       // console.log(url, items);
	        console.log(items.length);
	        if(items.length > 0){
	             var formData = {
	                items: items,
	                _token: $("input[name*='_token']").val()

	            };

	            $.ajax({
	              url: url,
	              data: formData,
	              method: "POST",
	              
	            }).done(function( data ) {
	                console.log(data);
	                atr.selected = [];
	                reload();
	                $('#load-modal').modal('hide');
	                if(actioner == 'sync'){
	                	$('.non-selector').html(data.message+' item(s) have been synchronised').show();
	                }else{
	                	$('.non-selector').html(data.message+' item(s) have been deleted').show();
	                }
	                
	                 setTimeout(function(){  $('.non-selector').hide().html(''); }, 5000);   
	                
	            });
	        } else {
	            $('#load-modal').modal('hide');
	            $('.non-selector').show();
	        }

        }
    	function getAllData(data, status){
    		

    		var items =[];
    		$.each(data.data, function(i,item){
		    	
		        items.push(item);
		         
			});

			atr.rowData = items;
			
			if(status){
				$scope.$apply();
			}
			
			
    	}
    	
		$window.getAllData = atr.getAllData;
		
    }
    
    
	
       
})();
