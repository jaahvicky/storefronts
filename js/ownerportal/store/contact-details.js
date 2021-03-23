/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    
    $().ownaivalidator({});

    $('#sp-contact-details #phone').on('input', function() {
        $(this).val($(this).val().replace(/\s/g, ''));
    });
    
});
