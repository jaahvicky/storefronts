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

  $(function () {
    /* BOOTSTRAP SLIDER */
    $('.slider').slider();

    /* RANGE SLIDER */
    $("#item_count").ionRangeSlider({
      min: 0,
      max: 10,
      values: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
      type: 'single',
      step: 1,
      postfix: " items",
      prettify: false,
      hasGrid: true,
      onChange: function (obj) {
        //
        console.log("Finished ...");
        $('.buyer-details').css('display', 'block');
        $('#saveButton').removeAttr('disabled');

      }
    });

    /* ADD ORDER FORM SUBMISSION */
    $('#saveButton').click(function(e){
        e.preventDefault();

        var categoryId = $('#category').find(":selected").attr('data-category-id');
        var storeId = $('#store').find(":selected").val();
        var storeId = $('#store').find(":selected").val();

        var formData = $('#orderForm').serializeArray();

        /* validaion */
        //check 

        var store_val = true;
        var category_val = true;
        var product_val = true;
        var item_count_val = true;
        var first_name_val = true;
        var last_name_val = true;
        var buyer_address_line_1_val = true;
        var buyer_city_val = true;
        var buyer_country_val = true;
        var buyer_province_state_val = true;
        var buyer_country_val = true;
        var buyer_postal_code_val = true;
        var buyer_email_val = true;
        var buyer_phone_val = true;
        function validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        var count = 0;
        $('.order-errors-alert').css('display', 'none');
        $('.order-success-alert').css('display', 'none');
        var cur_order = false;
        var route = '/index.php/admin/order/addorder';


        
        $.each( formData, function( i, field ) {
          
          $("#"+field.name+"" ).removeClass('order-error');
          if( (field.value == '') && (field.name != 'order_notes') && (field.name !='buyer_address_line_2')  ){
             $("#"+field.name+"" ).addClass('order-error');
             count++;

          }

          if(field.name == 'cur_order_id'){
            cur_order = true;
          }

          if(field.name == 'buyer_email'){
            var buyer_email = field.value;
            
            if(!validateEmail(buyer_email)){
              $("#"+field.name+"" ).addClass('order-error');
              count++;
            }
          }

          if(field.name == 'first_name'){
            var first_name = field.value;
          }

          if(field.name == 'last_name'){
            var last_name = field.value;
          }

          if(field.name == 'buyer_phone'){
            if(isNaN(field.value)){
              count++;
              $("#"+field.name+"" ).addClass('order-error');
            }
          }

          

        });

        if(count > 0){
            $('.order-errors-alert').css('display', 'block');
            return;
        }

        if(cur_order){
            route = '/index.php/admin/order/updateorder';
        }

        console.log(formData);
        $.ajax({
          url: route,
          data: formData,
          method: "POST",
          
        }).done(function( data ) {
            console.log(data);
            if(data.status == 'success' ){
                console.log(data);
                $('.order-success-alert').css('display', 'block');
                // var first_name = 
               
            } else {
                $('.order-error-alert').css('display', 'block');
            }

            if(data.status_email == 'error' ){

              $('.email-errors-alert').css('display', 'block');
            }

            if(data.status_sms == 'error' ){

              $('.sms-errors-alert').css('display', 'block');
            }
            
        });
    });

  });