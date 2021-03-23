/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// swap the make and model for testing
function swapArrayElements(attr, indexA, indexB) {
    var temp = attr[indexA];
    attr[indexA] = attr[indexB];
    attr[indexB] = temp;

    return attr;
}

$(function() {
    $('.variant').hide();
    var categoryId = $("#category").find(":selected").attr("data-category-id");
    populateAttributeFields(categoryId);
    showVariants(categoryId);
    $('#productForm').trigger('attributeFieldsPopulated');
        
    $("#category").on('change', function() {
        var categoryId = $(this).find(":selected").attr("data-category-id");
        populateAttributeFields(categoryId);
        $(".year-select option:first").remove();
        showVariants(categoryId);
    });
    
    function populateAttributeFields(categoryId) {
        
        //Clear the meta div
        $("#attributes").empty();
        
        var attr = attributes[categoryId];
        
        if (typeof attr !== "undefined") {

            for (var i = 0; i < attr.length; i++) {

                var attr_name = attr[i].name;
                var attr_id   = attr[i].id;
                var type      = $.trim(attr[i].type.toUpperCase());

                var formGroup = $("<div>").addClass('form-group').appendTo("#attributes");
                var label = $('<label>').attr('for', "subcat-"+ attr_id).html(attr_name);

                if (type === "DROPDOWN") {

                    var select = '';
                    
                    if(attr_name !== 'Make'){

                        label.appendTo(formGroup);

                    }

                    if(attr_name == 'Make'){

                        formGroup.addClass('make-form');

                        select = $('<select>').addClass('form-control').attr('name', "subcat-"+attr_id).attr('id', "make_cat_attr").prop('required',true).attr('onchange', "onchangeMake(this.options[this.selectedIndex].value)").appendTo(formGroup);
                        label.insertBefore($('#make_cat_attr'));
                         
                    }else if(attr_name == 'Model'){

                        formGroup.addClass('model-form');

                        select = $('<select>').addClass('form-control').attr('name', "subcat-"+attr_id).attr('id', "model_cat_attr").appendTo(formGroup);
                        setModelData(attributeValueProduct[attr_id]);

                    }else{
                        if(attr_name == 'Year'){
                            select = $('<select>').addClass('form-control year-select').attr('name', "subcat-"+attr_id).appendTo(formGroup);
                        } else {
                            select = $('<select>').addClass('form-control').attr('name', "subcat-"+attr_id).appendTo(formGroup);
                        }
                    }
                    

                    if(attr_name !== 'Model') {
                       
                        if(attr_name == 'Year'){
                            delete attr[i].options[0];
                            attr[i].options[1] = '';
                        }
                        for (var j = 0; j < attr[i].options.length; j++) {

                            var option = $("<option>").attr('value', attr[i].options[j]).text(attr[i].options[j]);

                            if (attributeValueProduct[attr_id] === attr[i].options[j]) {
                                option.attr('selected', true);
                            }

                            if( (attr_name == 'Year') && (parseInt(attr[i].options[j]) <= 1980 )){
                                if( (attr[i].options[j] != '') ){
                                    $(".year-select option:first").after(option);
                                }
                                
                            } else {
                                if( (attr[i].options[j] != '')  ){
                                    select.append(option);
                                } else {
                                    console.log(attr[i].options[j]);
                                }
                            }
                              
                        }
                        
                    }
                    
                }
                else if (type === "CHECKBOX") {
                    
                    var checkbox = $('<input>').attr('name', "subcat-"+attr_id).attr('type', 'checkbox').appendTo(formGroup);
                    $('<span>').html("&nbsp;").appendTo(formGroup);
                    
                    if (typeof attributeValueProduct[attr_id] !== "undefined" && attributeValueProduct[attr_id] === "1") {
                        
                        checkbox.attr("checked", true);
                    }
                    
                    label.appendTo(formGroup);
                }
                else {
                    
                    label.appendTo(formGroup);
                    
                    var textbox = $('<input>').attr('name', "subcat-"+attr_id).attr('type', 'text').addClass('form-control').appendTo(formGroup);
                    if (typeof attributeValueProduct[attr_id] !== "undefined" && attributeValueProduct[attr_id] != "") {
                        textbox.val(attributeValueProduct[attr_id]);
                    }
                }
            } // end foreach


            if($('.form-group.make-form').length > 0) {
                $('<option selected="selected" value="">Please select a make</option>').prependTo('#make_cat_attr');
                $(".form-group.make-form").prependTo("#attributes");

                if($('.form-group.model-form').length > 0) {
                    $('.form-group.model-form').insertAfter('.form-group.make-form');
                }
            }

        }
    }

    function showVariants(categoryId){
        if(categoryId > 0){
            $('.variant').show();
        }
        
    }

    function setModelData(value) {

       if(typeof value !== "undefined"){
            var parrent = 0;
            $.each(attributes_child, function(i, val){
                if(value == val.value){
                    parrent = val.parent_id;
                }
            });
            $.each(attributes_child, function(i, val){
                if(parrent == val.parent_id){
                    var option = $("<option>").attr('value', val.value).text(val.value);
                    if(value == val.value){
                       option.attr('selected', true); 
                    }
                    $("#model_cat_attr").append(option);
                }
            });
       }
         
    }

});
