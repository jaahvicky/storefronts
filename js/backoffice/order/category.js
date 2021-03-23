/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    
    var categoryId = $("#category").find(":selected").attr("data-category-id");
    // populateAttributeFields(categoryId);
    // $('#productForm').trigger('attributeFieldsPopulated');
        
    $("#category").on('change', function() {
        //$('.product-option').remove();
        $('#product option:first').nextAll().remove();
        $('.cat-warning').css('display', 'none');
        $('.cat-overlay').css('display', 'block');
        $('#category').attr('disabled', 'disabled');
        var categoryId = $(this).find(":selected").attr("data-category-id");
        var storeId = $('#store').find(":selected").val();
        console.log(categoryId);
        //populateAttributeFields(categoryId);
        populateProductFields(categoryId, storeId);
    });

    function populateProductFields(categoryId, storeId) {

        // Set-up FormData
        var formData = {
            categoryId: categoryId,
            storeId: storeId,
            _token: $("input[name*='_token']").val(),

        };

        console.log(formData);

        $.ajax({
          url: "/index.php/admin/order/getproducts",
          data: formData,
          method: "POST",
          
        }).done(function( data ) {
            console.log(data);
            $('.cat-overlay').css('display', 'none');
            $('#category').removeAttr('disabled');
            if(data.prod_str == ''){
                $('.product-option').remove();
                $('.cat-warning').css('display', 'block');
                $('.prod-ele').css('display', 'none');
                $("[prod-str='prod']").after(data.prod_str);
            } else {
                $('.prod-ele').css('display', 'block');
                $("[prod-str='prod']").after(data.prod_str);
            }
            
        });
    }
    
});
