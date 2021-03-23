/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    
    $(".colorpicker-component").colorpicker({
        align: 'left',
        horizontal: true
    });
    
    $("#color-reset-primary").click(function() {
        $("#colorpicker-primary").data('colorpicker').setValue("#009eff");
    });
    
    $("#color-reset-secondary").click(function() {
        $("#colorpicker-secondary").data('colorpicker').setValue("#22d497");
    });
    
});