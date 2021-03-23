/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function() {
    
    var values = [];
    var changed = false;
   
   $('#productForm').on('attributeFieldsPopulated', function() {
       
       initListeners();
   });
    
    function initListeners() {
        
        $('#productForm').find('*')
        .each(function(index, item) {
            
            var tag = $(this).prop("tagName");
            var name = $(this).attr('name');
            
            if ($.inArray(tag, ["INPUT", "SELECT", "TEXTAREA"]) !== -1 && $(this).attr('type') !== "file" && typeof name !== "undefined") {
                    
                values[name] = ($(this).attr('type') === "radio") ? $('input[name='+name+']:checked', '#productForm').val() : $(this).val();

                $(this).change( function() {
                    
                    if (valuesHaveChanged() === true) {
                        $("#saveButton").prop('disabled', false);
                    }
                    else {
                        $("#saveButton").prop('disabled', true);
                    }
                });
            }
        });
        
    }
    
    function valuesHaveChanged() {
        
        var changed = false;
        
        $('#productForm').find('*')
        .each(function(index, item) {
              
            var tag = $(this).prop("tagName");
            var name = $(this).attr('name');
            
            if ($.inArray(tag, ["INPUT", "SELECT", "TEXTAREA"]) !== -1 && $(this).attr('type') !== "file" && typeof name !== "undefined") {
                
                var value = ($(this).attr('type') === "radio") ? $('input[name='+name+']:checked', '#productForm').val() : $(this).val();
                
                if (value !== values[name]) {
                   
                    changed = true;
                    //Exit out of anonymous function
                    return false;
                }
            }
        });
        
        return changed;
    }
    
});